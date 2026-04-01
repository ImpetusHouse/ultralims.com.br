<?php

namespace App\Http\Controllers\Admin\General\Products;

use App\Http\Controllers\Controller;
use App\Models\General\Products\Category;
use App\Models\General\Products\FilterCategory;
use App\Models\General\Products\Product;
use App\Models\UltraLims\UL_Product_User;
use App\Models\UltraLims\Wishlist;
use Buglinjo\LaravelWebp\Webp;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class ProductController extends Controller{
    public function index(){
        $title = 'Produtos';
        $breadcrumbs = [
            ['url' => route('admin.products.index'), 'title' => $title],
        ];
        $products = Product::all();
        return view('admin.pages.general.products.list', compact('title', 'breadcrumbs', 'products'));
    }

    public function create(){
        $title = 'Criar produto';
        $breadcrumbs = [
            ['url' => route('admin.products.index'), 'title' => 'Produtos'],
            ['url' => route('admin.products.create'), 'title' => $title],
        ];
        $product = new Product();
        $categories = Category::orderBy('title')->get();
        $filterCategories = FilterCategory::orderBy('title')->get();
        return view('admin.pages.general.products.form', compact('title', 'breadcrumbs', 'product', 'categories', 'filterCategories'));
    }

    public function store(Request $request){
        $json = $this->save($request, new Product(), 'store');
        return $json;
    }

    public function edit(Product $product){
        $title = 'Editar produto';
        $breadcrumbs = [
            ['url' => route('admin.products.index'), 'title' => 'Produtos'],
            ['url' => route('admin.products.edit', $product->hash_id), 'title' => $title],
        ];
        $product->url = asset(str_replace('public/', 'storage/', $product->photo));
        $categories = Category::orderBy('title')->get();
        $filterCategories = FilterCategory::orderBy('title')->get();
        return view('admin.pages.general.products.form', compact('title', 'breadcrumbs', 'product', 'categories', 'filterCategories'));
    }

    public function update(Request $request, Product $product){
        $json = $this->save($request, $product, 'update');
        return $json;
    }

    public function destroy(Product $product){
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Produto excluído com sucesso',
        ]);
    }

    public function save($request, $product, $action){
        $validator = Validator::make($request->all(), [
            'categories' => 'required',
            'title' => 'required',
            'description' => 'required',
            'slug' => 'required',
            'status' => 'required'
        ],[
            'categories.required' => 'É obrigatório selecionar ao menos uma categoria',
            'title.required' => 'O título é obrigatório',
            'description.required' => 'O conteúdo é obrigatório',
            'slug.required' => 'A slug é obrigatória',
            'status.required' => 'O status é obrigatório'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        if ($action == 'store'){
            $validator = Validator::make($request->all(), [
                'imagem' => 'required'
            ],[
                'imagem.required' => 'A imagem é obrigatória'
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        DB::beginTransaction();
        try {
            $path = null;
            if($request->has('imagem') && strlen($request->imagem) > 0 && $request->imagem != str_replace('public/', 'storage/', asset($product->photo)) && $request->imagem != 'null'){
                $base64_image = $request->input('imagem'); // your base64 encoded

                $directory = '/products';
                // Verifica se a pasta já existe, se não, cria com permissão 755
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory, 0755, true);
                }

                $folder = 'storage'.$directory;
                $path = $folder.'/'.$request->slug.'_'.date('Ymd_His').'.webp';

                // decode the base64 file
                $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_image));

                // save it to temporary dir first.
                $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
                file_put_contents($tmpFilePath, $fileData);

                // this just to help us get file info.
                $tmpFile = new File($tmpFilePath);

                $file = new UploadedFile(
                    $tmpFile->getPathname(),
                    $tmpFile->getFilename(),
                    $tmpFile->getMimeType(),
                    0,
                    false // Mark it as test, since the file isn't from real HTTP POST.
                );
                $webp = Webp::make($file);
                $webp->save(public_path($path), 100);

                //$storage_service->saveAwsFile($folder, $file, Str::slug($request->client).'.webp');
                $path = str_replace('storage/', 'public/', $path);
            }

            if ($action == 'store'){
                $lastProduct = Product::orderBy('display_order', 'desc')->first();
                if ($lastProduct == null){
                    $display_order = 1;
                }else{
                    $display_order = $lastProduct->display_order + 1;
                }
                $product->display_order = $display_order;
            }

            $product->fill($request->all());
            if ($path != null){
                $product->photo = $path;
            }elseif($request->imagem == 'null'){
                $product->photo = null;
            }
            $product->save();

            // Novo produto - configurar ordem de exibição
            if ($action == 'store') {
                $newDisplayOrders = [];
                foreach ($request->categories as $categoryId) {
                    $highestOrder = DB::table('products_categories_pivot')
                        ->where('category_id', $categoryId)
                        ->max('display_order');
                    $newDisplayOrders[$categoryId] = $highestOrder + 1;
                }
                $product->categories()->sync($newDisplayOrders);
            } else {
                $product->categories()->sync($request->categories);
            }

            $filterCategoryIds = $request->input('filter_categories', []);
            if (!is_array($filterCategoryIds)) {
                $filterCategoryIds = [];
            }
            $product->filterCategories()->sync($filterCategoryIds);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Produto '.($action == 'store' ? 'salvo':'editado').' com sucesso']);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao '.($action == 'store' ? 'salvar':'editar').' produto, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    public function orders(){
        $title = 'Pedidos';
        $breadcrumbs = [
            ['url' => route('admin.products.index'), 'title' => 'Produtos'],
            ['url' => route('admin.products.orders'), 'title' => $title],
        ];
        $orders = UL_Product_User::orderBy('created_at', 'desc')->get();
        return view('admin.pages.general.products.orders', compact('title', 'breadcrumbs', 'orders'));
    }

    public function ordersProduct(Product $product){
        $title = 'Pedidos - '.$product->title;
        $breadcrumbs = [
            ['url' => route('admin.products.index'), 'title' => 'Produtos'],
            ['url' => route('admin.products.ordersProduct', $product->hash_id), 'title' => $title],
        ];
        $orders = UL_Product_User::where('product_id', $product->id)->orderBy('created_at', 'desc')->get();
        return view('admin.pages.general.products.ordersProduct', compact('title', 'breadcrumbs', 'product', 'orders'));
    }

    public function wishlist(){
        $title = 'Lista de desejo';
        $breadcrumbs = [
            ['url' => route('admin.products.index'), 'title' => 'Produtos'],
            ['url' => route('admin.products.wishlist'), 'title' => $title],
        ];
        $wishlist = Wishlist::orderBy('created_at', 'desc')->get();
        return view('admin.pages.general.products.wishlist', compact('title', 'breadcrumbs', 'wishlist'));
    }

    public function wishlistProduct(Product $product){
        $title = 'Lista de desejo - '.$product->title;
        $breadcrumbs = [
            ['url' => route('admin.products.index'), 'title' => 'Produtos'],
            ['url' => route('admin.products.wishlistProduct', $product->hash_id), 'title' => $title],
        ];
        $wishlist = Wishlist::where('product_id', $product->id)->orderBy('created_at', 'desc')->get();
        return view('admin.pages.general.products.wishlistProduct', compact('title', 'breadcrumbs', 'product', 'wishlist'));
    }

    public function getSlug(Request $request){
        $slug = Str::slug($request->title);
        $product = Product::where('slug', $slug)->first();
        if(!$product){
            return response()->json([
                'success' => true,
                'slug' => $slug,
            ]);
        }
        return response()->json([
            'success' => false,
            'suggestion' => date('d-m-Y-H-i').'-'.$slug,
        ]);
    }

    public function order($type){
        if ($type == 'category'){
            $items = Category::orderBy('display_order')->get();
        }elseif ($type == 'product'){
            $items = Category::orderBy('title')->get();
        }elseif ($type == 'products'){
            $items = Product::orderBy('display_order')->get();
        }else{
            return response()->json([
                'sucess' => false,
                'message' => 'Tipo de ordenação inválida, tente novamente'
            ]);
        }
        return response()->json([
            'success' => true,
            'items' => $items,
        ]);
    }

    public function orderType($type, $id){
        if ($type == 'category'){
            $items = Category::orderBy('display_order', 'asc')->get();
        }elseif ($type == 'product'){
            $category = Category::find($id);
            $items = $category->products;
        }elseif ($type == 'products'){
            $items = Product::orderBy('display_order', 'asc')->get();
        }else{
            return response()->json([
                'sucess' => false,
                'message' => 'Tipo de ordenação inválida, tente novamente'
            ]);
        }
        return response()->json([
            'success' => true,
            'items' => $items,
        ]);
    }

    public function saveOrder(Request $request, $type, $id){
        $i = 1;
        if ($type == 'category'){
            foreach ($request->items as $item){
                $category = Category::where('id', $item)->first();
                $category->display_order = $i;
                $category->save();
                $i++;
            }
        }elseif ($type == 'product'){
            foreach ($request->items as $item_id) {
                DB::table('products_categories_pivot')
                    ->where('category_id', $id)
                    ->where('product_id', $item_id)
                    ->update(['display_order' => $i]);
                $i++;
            }
        }else if ($type == 'products'){
            foreach ($request->items as $item){
                $product = Product::where('id', $item)->first();
                $product->display_order = $i;
                $product->save();
                $i++;
            }
        }else{
            return response()->json([
                'sucess' => false,
                'message' => 'Tipo de ordenação inválida, tente novamente'
            ]);
        }
        return response()->json(['success' => true]);
    }
}

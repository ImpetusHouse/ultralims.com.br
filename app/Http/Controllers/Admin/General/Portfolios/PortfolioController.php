<?php

namespace App\Http\Controllers\Admin\General\Portfolios;

use App\Http\Controllers\Controller;
use App\Models\General\Portfolios\Category;
use App\Models\General\Portfolios\Portfolio;
use App\Models\Pages\Page;
use Buglinjo\LaravelWebp\Webp;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class PortfolioController extends Controller {
    public function index(){
        $title = 'Portfólios';
        $breadcrumbs = [
            ['url' => route('admin.portfolios.index'), 'title' => $title],
        ];
        $portfolios = Portfolio::all();
        return view('admin.pages.general.portfolios.list', compact('title', 'breadcrumbs', 'portfolios'));
    }

    public function create(){
        $title = 'Criar portfólio';
        $breadcrumbs = [
            ['url' => route('admin.portfolios.index'), 'title' => 'Portfólios'],
            ['url' => route('admin.portfolios.create'), 'title' => $title],
        ];
        $portfolio = new Portfolio();
        $categories = Category::orderBy('title')->get();
        $pages = Page::orderBy('title')->get();
        return view('admin.pages.general.portfolios.form', compact('title', 'breadcrumbs', 'portfolio', 'categories', 'pages'));
    }

    public function store(Request $request){
        $json = $this->save($request, new Portfolio(), 'store');
        return $json;
    }

    public function edit(Portfolio $portfolio){
        $title = 'Editar portfólio';
        $breadcrumbs = [
            ['url' => route('admin.portfolios.index'), 'title' => 'Portfólios'],
            ['url' => route('admin.portfolios.edit', $portfolio->hash_id), 'title' => $title],
        ];
        $portfolio->url = asset(str_replace('public/', 'storage/', $portfolio->photo));
        $categories = Category::orderBy('title')->get();
        $pages = Page::orderBy('title')->get();
        return view('admin.pages.general.portfolios.form', compact('title', 'breadcrumbs', 'portfolio', 'categories', 'pages'));
    }

    public function update(Request $request, Portfolio $portfolio){
        $json = $this->save($request, $portfolio, 'update');
        return $json;
    }

    public function destroy(Portfolio $portfolio){
        $portfolio->delete();
        return response()->json([
            'success' => true,
            'message' => 'Portfólio excluído com sucesso',
        ]);
    }

    public function save($request, $portfolio, $action){
        $validator = Validator::make($request->all(), [
            'page_id' => 'required',
            'categories' => 'required',
            'title' => 'required',
            'description' => 'required',
            'status' => 'required'
        ],[
            'page_id.required' => 'A página é obrigatória',
            'categories.required' => 'Ao menos uma categoria é obrigatória',
            'title.required' => 'O título é obrigatório',
            'description.required' => 'A descrição é obrigatória',
            'status.required' => 'O status é obrigatório'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        if ($action == 'store'){
            $validator = Validator::make($request->all(), [
                'imagem' => 'required'
            ],[
                'imagem.required' => 'A imagem é obrigatória!'
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        //$storage_service = new \App\Services\StorageService();

        DB::beginTransaction();
        try{
            $path = null;
            if($request->has('imagem') && strlen($request->imagem) > 0 && $request->imagem != str_replace('public/', 'storage/', asset($portfolio->photo)) && $request->imagem != 'null'){
                $base64_image = $request->input('imagem'); // your base64 encoded

                $directory = '/portfolios';
                // Verifica se a pasta já existe, se não, cria com permissão 755
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory, 0755, true);
                }

                $folder = 'storage'.$directory;
                $path = $folder.'/'.Str::slug($request->title).'_'.date('Ymd_His').'.webp';

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
                $lastPortfolio = Portfolio::orderBy('display_order', 'desc')->first();
                if ($lastPortfolio == null){
                    $display_order = 1;
                }else{
                    $display_order = $lastPortfolio->display_order + 1;
                }
                $portfolio->displar_order = $display_order;
            }

            $portfolio->fill($request->input());
            if ($path != null){
                $portfolio->photo = $path;
            }elseif($request->imagem == 'null'){
                $portfolio->photo = null;
            }
            $portfolio->save();

            // Novo portfólio - configurar ordem de exibição
            if ($action == 'store') {
                $newDisplayOrders = [];
                foreach ($request->categories as $categoryId) {
                    $highestOrder = DB::table('portfolios_categories_pivot')
                        ->where('category_id', $categoryId)
                        ->max('display_order');
                    $newDisplayOrders[$categoryId] = $highestOrder + 1;
                }
                $portfolio->categories()->sync($newDisplayOrders);
            } else {
                $portfolio->categories()->sync($request->categories);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Portfólio '.($action == 'store' ? 'criado':'editado').' com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." o portfólio, tente novamente",
                'e' => $e->getMessage()
            ]);
        }
    }

    public function order($type){
        if ($type == 'category'){
            $items = Category::orderBy('display_order')->get();
        }elseif ($type == 'portfolio'){
            $items = Category::orderBy('title')->get();
        }elseif ($type == 'portfolios'){
            $items = Portfolio::orderBy('display_order')->get();
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
        }elseif ($type == 'portfolio'){
            $category = Category::find($id);
            $items = $category->portfolios;
        }elseif ($type == 'portfolios'){
            $items = Portfolio::orderBy('display_order', 'asc')->get();
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
        }elseif ($type == 'portfolio'){
            foreach ($request->items as $item_id) {
                DB::table('portfolios_categories_pivot')
                    ->where('category_id', $id)
                    ->where('portfolio_id', $item_id)
                    ->update(['display_order' => $i]);
                $i++;
            }
        }else if ($type == 'portfolios'){
            foreach ($request->items as $item){
                $portfolio = Portfolio::where('id', $item)->first();
                $portfolio->display_order = $i;
                $portfolio->save();
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

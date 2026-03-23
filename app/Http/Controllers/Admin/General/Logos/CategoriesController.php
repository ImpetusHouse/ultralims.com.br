<?php

namespace App\Http\Controllers\Admin\General\Logos;

use App\Http\Controllers\Controller;
use App\Models\General\Logos\Category;
use App\Models\General\Logos\Logo;
use Buglinjo\LaravelWebp\Webp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index()
    {
        $title = 'Categorias';
        $breadcrumbs = [
            ['url' => route('admin.logosCategories.index'), 'title' => $title],
        ];
        $categories = Category::orderBy('title')->get();
        return view('admin.pages.general.logos.list', compact('title', 'breadcrumbs', 'categories'));
    }

    public function create()
    {
        $title = 'Criar categoria';
        $breadcrumbs = [
            ['url' => route('admin.logosCategories.index'), 'title' => 'Categorias'],
            ['url' => route('admin.logosCategories.create'), 'title' => $title],
        ];
        $logosCategory = new Category();
        return view('admin.pages.general.logos.form', compact('title', 'breadcrumbs', 'logosCategory'));
    }

    public function store(Request $request)
    {
        $logosCategory = new Category();
        $json = $this->save($request, $logosCategory, 'store');
        return $json;
    }

    public function edit(Category $logosCategory)
    {
        $title = 'Editar categoria';
        $breadcrumbs = [
            ['url' => route('admin.logosCategories.index'), 'title' => 'Categorias'],
            ['url' => route('admin.logosCategories.edit', $logosCategory->hash_id), 'title' => $title],
        ];
        return view('admin.pages.general.logos.form', compact('title', 'breadcrumbs', 'logosCategory'));
    }

    public function update(Request $request, Category $logosCategory)
    {
        $json = $this->save($request, $logosCategory, 'update');
        return $json;
    }

    public function destroy(Category $logosCategory)
    {
        $logosCategory->delete();
        return response()->json([
            'success' => true,
            'message' => 'Categoria de logos excluída com sucesso',
        ]);
    }

    public function save($request, $logosCategory, $action){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required'
        ],[
            'title.required' => 'O nome é obrigatório!',
            'status.required' => 'O status é obrigatório!'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        //$storage_service = new \App\Services\StorageService();

        DB::beginTransaction();
        try{
            $logosCategory->fill($request->input());
            $logosCategory->save();

            if (isset($request->logos)){
                foreach ($request->logos as $logo){
                    $folder = 'storage/logos/' . $logosCategory->hash_id;
                    $path = $folder . '/' . Str::slug(pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . date('Ymd_His') . '.webp';

                    if (!file_exists($folder)) {
                        File::makeDirectory(public_path($folder));
                    }

                    $webp = Webp::make($logo);
                    $webp->save(public_path($path), 100);

                    //$storage_service->saveAwsFile($folder, $logo, Str::slug(pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . date('Ymd_His').'.webp');
                    $path = str_replace('storage/', 'public/', $path);

                    Logo::create([
                       'category_id' => $logosCategory->id,
                       'path' => $path
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Categoria de logos '.($action == 'store' ? 'criada':'editada').' com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." categoria de logos",
                'e' => $e->getMessage()
            ]);
        }

    }
}

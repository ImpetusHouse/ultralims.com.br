<?php

namespace App\Http\Controllers\Admin\General\FAQ;

use App\Http\Controllers\Controller;
use App\Models\General\FAQ\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('ajaxJson') && $request->ajaxJson == 'true'){
            $categories = Category::all();
            return response()->json($categories);
        }
    }

    public function save($request, $category, $action){
        DB::beginTransaction();
        try{
            if ($request->display == '0'){
                $display_order = null;
            }
            if ($action == 'store'){
                $display_order = null;
                if ($request->display == 1){
                    $lastCategory = Category::orderBy('display_order', 'desc')->first();
                    if ($lastCategory == null){
                        $display_order = 1;
                    }else{
                        $display_order = $lastCategory->display_order + 1;
                    }
                }
            }

            $category->title  = $request->name;
            $category->display  = $request->display;
            $category->display_order = $display_order ?? $category->display_order;
            $category->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Categoria '.($action == 'store' ? 'criada':'editada').' com sucesso!',
                'category' => $category
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Erro ao '.($action == 'store'? 'salvar':'editar').' categoria!']);
        }
    }

    public function store(Request $request)
    {
        $json = $this->save($request, new Category(), 'store');
        return $json;
    }

    public function update(Request $request, Category $category){
        $json = $this->save($request, $category, 'update');
        return $json;
    }

    public function destroy(Category $category)
    {
        DB::beginTransaction();
        try{
            $category->delete();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Categoria excluída com sucesso!']);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Erro ao excluir categoria!']);
        }
    }

    public function getCategories(){
        $categories = Category::where('display', '1')->orderBy('display_order')->get();
        return response()->json($categories);
    }

    public function displayOrder(Request $request){
        DB::beginTransaction();
        try{
            $i = 1;
            foreach ($request->orderId as $id){
                $category = Category::findOrFail($id);
                $category->display_order = $i;
                $category->save();
                $i++;
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Ordem de exibição editada com sucesso!',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao editar ordem de exibição!".$e->getMessage()
            ]);
        }
    }
}

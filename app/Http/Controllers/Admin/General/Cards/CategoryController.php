<?php

namespace App\Http\Controllers\Admin\General\Cards;

use App\Http\Controllers\Controller;
use App\Models\General\Cards\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller {
    public function index(Request $request)
    {
        if($request->has('ajaxJson') && $request->ajaxJson == 'true'){
            $categories = Category::all();
            return response()->json($categories);
        }
    }

    public function store(Request $request){
        return $this->save($request, new Category(), 'store');
    }

    public function update(Request $request, Category $category){
        DB::beginTransaction();
        if($category->id != $request->id){
            $category = Category::find($request->id);
        }
        return $this->save($request, $category, 'update');
    }

    public function destroy(Category $category, Request $request){
        if($category->id != $request->id){
            $category = Category::find($request->id);
        }
        DB::beginTransaction();
        try{
            $category->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Categoria excluída com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao excluir categoria, tente novamente',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function save($request, $category, $action){
        try{
            $category->title = $request->input('name');
            $category->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Categoria '.($action == 'store' ? 'criada':'editada').' com sucesso',
                'id' => $category->id
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao '.($action == 'store' ? 'salvar':'editar').' categoria, tente novamente',
                'error' => $e->getMessage()
            ]);
        }
    }
}

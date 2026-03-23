<?php

namespace App\Http\Controllers\Admin\General\Products;

use App\Http\Controllers\Controller;
use App\Models\General\Products\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller{
    public function index(Request $request)
    {
        if($request->has('ajaxJson') && $request->ajaxJson == 'true'){
            $categories = Category::all();
            return response()->json($categories);
        }
    }

    public function store(Request $request){
        $title = $request->input('name');
        $lastCategory = Category::orderBy('display_order', 'desc')->first();
        if ($lastCategory == null){
            $display_order = 1;
        }else{
            $display_order = $lastCategory->display_order + 1;
        }
        DB::beginTransaction();
        try{
            Category::create([
                'title' => $title,
                'display_order' => $display_order
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Categoria criada com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar categoria, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, Category $category){
        $title = $request->input('name');
        DB::beginTransaction();
        if($category->id != $request->id){
            $category = Category::find($request->id);
        }
        try{
            $category->update([
                'title' => $title
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Categoria atualizada com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar categoria, tente novamente',
            ]);
        }
    }

    public function destroy(Request $request, Category $category)
    {

        if($category->id != $request->id){
            $category = Category::find($request->id);
        }

        if ($category->products()->count() > 0){
            return response()->json([
                'success' => false,
                'message' => 'Essa categoria não pode ser excluída pois existe um ou mais produtos atrelados a ela',
            ]);
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
                'message' => 'Erro ao excluir categoria, tente novamente',
            ]);
        }
    }
}

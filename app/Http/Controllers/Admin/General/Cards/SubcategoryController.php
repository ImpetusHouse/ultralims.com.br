<?php

namespace App\Http\Controllers\Admin\General\Cards;

use App\Http\Controllers\Controller;
use App\Models\General\Cards\Category;
use App\Models\General\Cards\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller {
    public function index(Request $request){
        if($request->has('ajaxJson') && $request->ajaxJson == 'true'){
            $subcategories = Subcategory::with('category')->get();
            $formattedSubcategories = $subcategories->map(function ($subcategory) {
                return [
                    'id' => $subcategory->id,
                    'title' => $subcategory->title,
                    'category_title' => $subcategory->category->title,
                ];
            });
            return response()->json($formattedSubcategories);
        }
    }

    public function store(Request $request){
        return $this->save($request, new Subcategory(), 'store');
    }

    public function update(Request $request, Subcategory $subcategory){
        DB::beginTransaction();
        if($subcategory->id != $request->id){
            $subcategory = Subcategory::find($request->id);
        }
        return $this->save($request, $subcategory, 'update');
    }

    public function destroy(Subcategory $subcategory, Request $request){
        if($subcategory->id != $request->id){
            $subcategory = Subcategory::find($request->id);
        }
        DB::beginTransaction();
        try{
            $subcategory->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Subcategoria excluída com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao excluir subcategoria, tente novamente',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function save($request, $subcategory, $action){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
        ],[
            'name.required' => 'O título é obrigatório',
            'category_id.required' => 'A categoria é obrigatória',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        try{
            $subcategory->category_id = $request->input('category_id');
            $subcategory->order = Subcategory::where('category_id', $request->category_id)->max('order') + 1;
            $subcategory->title = $request->input('name');
            $subcategory->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Subategoria '.($action == 'store' ? 'criada':'editada').' com sucesso',
                'id' => $subcategory->id
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao '.($action == 'store' ? 'salvar':'editar').' subcategoria, tente novamente',
                'error' => $e->getMessage()
            ]);
        }
    }
}

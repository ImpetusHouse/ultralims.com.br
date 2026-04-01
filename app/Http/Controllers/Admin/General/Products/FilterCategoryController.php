<?php

namespace App\Http\Controllers\Admin\General\Products;

use App\Http\Controllers\Controller;
use App\Models\General\Products\FilterCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('ajaxJson') && $request->ajaxJson == 'true') {
            $categories = FilterCategory::orderBy('title')->get();

            return response()->json($categories);
        }
    }

    public function store(Request $request)
    {
        $title = $request->input('name');
        $lastCategory = FilterCategory::orderBy('display_order', 'desc')->first();
        if ($lastCategory == null) {
            $display_order = 1;
        } else {
            $display_order = $lastCategory->display_order + 1;
        }
        DB::beginTransaction();
        try {
            $filterCategory = FilterCategory::create([
                'title' => $title,
                'display_order' => $display_order,
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Categoria de filtros criada com sucesso',
                'id' => $filterCategory->id,
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar categoria de filtros, tente novamente',
                'e' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, FilterCategory $filter_category)
    {
        $title = $request->input('name');
        DB::beginTransaction();
        if ($filter_category->id != $request->id) {
            $filter_category = FilterCategory::find($request->id);
        }
        try {
            $filter_category->update([
                'title' => $title,
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Categoria de filtros atualizada com sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar categoria de filtros, tente novamente',
            ]);
        }
    }

    public function destroy(Request $request, FilterCategory $filter_category)
    {
        if ($filter_category->id != $request->id) {
            $filter_category = FilterCategory::find($request->id);
        }

        if ($filter_category->products()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Essa categoria de filtros não pode ser excluída pois existe um ou mais produtos atrelados a ela',
            ]);
        }
        DB::beginTransaction();
        try {
            $filter_category->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Categoria de filtros excluída com sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir categoria de filtros, tente novamente',
            ]);
        }
    }
}

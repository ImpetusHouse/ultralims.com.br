<?php

namespace App\Http\Controllers\Admin\General\Testimonials;

use App\Http\Controllers\Controller;
use App\Models\General\Testimonials\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('ajaxJson') && $request->ajaxJson == 'true'){
            $categories = Category::all();
            return response()->json($categories);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = $request->input('name');
        DB::beginTransaction();
        try{
            $category = Category::create([
                'title' => $title
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Categoria criada com sucesso!',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar categoria!',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Category $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
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
                'message' => 'Categoria atualizada com sucesso!',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar categoria!',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Request $request)
    {

        if($category->id != $request->id){
            $category = Category::find($request->id);
        }

        if ($category->testimonials()->count() > 0){
            return response()->json([
                'success' => false,
                'message' => 'Essa categoria não pode ser excluída pois existe uma ou mais publicações atreladas a ela',
            ]);
        }
        DB::beginTransaction();
        try{
            $category->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Categoria excluída com sucesso!',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir categoria!',
            ]);
        }
    }
}

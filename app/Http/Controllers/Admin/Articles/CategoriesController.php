<?php

namespace App\Http\Controllers\Admin\Articles;

use App\Http\Controllers\Controller;
use App\Models\Articles\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesController extends Controller{

    private $cores;
    public function __construct(){
        $this->cores = [
            "#00B4D8",
            "#06D6A0",
            "#2B2D42",
            "#8338EC",
            "#EF233C",
            "#EF476F",
            "#FB5607",
            "#FCA311"
        ];
    }

    public function index(Request $request){
        if($request->has('ajaxJson') && $request->ajaxJson == 'true'){
            $categories = Category::all();
            return response()->json($categories);
        }
    }

    public function store(Request $request){
        $title = $request->input('name');
        $slug = Str::slug($title);
        //find slug in categories
        $categorySlug = Category::where('slug', $slug)->first();
        if($categorySlug){
            $slug = $slug.'-'.date('Y-m-d');
        }

        DB::beginTransaction();

        try{
            Category::create([
                'title' => $title,
                'slug' => $slug,
                'color' => $this->cores[array_rand($this->cores)],
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

    public function update(Request $request, Category $category){
        $title = $request->input('name');
        $slug = Str::slug($title);
        //find slug in categories
        $categorySlug = Category::where('slug', $slug)->where('id', '!=', $category->id)->first();
        if($categorySlug){
            $slug = $slug.'-'.date('Y-m-d');
        }

        DB::beginTransaction();
        if($category->id != $request->id){
            $category = Category::find($request->id);
        }
        try{
            $category->update([
                'title' => $title,
                'slug' => $slug,
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

<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Category;
//use App\Models\Log;
use App\Models\Pages\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('ajaxJson') && $request->ajaxJson == 'true'){
            $categories = Category::orderBy('title')->get();
            return response()->json($categories);
        }
    }

    public function store(Request $request)
    {
        return $this->save(new Category(), $request, 'store');
    }

    public function update(Category $category, Request $request)
    {
        return $this->save($category, $request, 'update');
    }

    public function save($category, $request, $action){
        $title = $request->input('name');
        DB::beginTransaction();
        try{
            $category->title = $title;
            $category->save();
            DB::commit();
            if ($action == 'store'){
                //$this->makeLog('success');
            }else{
                //$this->makeLog('warning');
            }
            return response()->json([
                'success' => true,
                'message' => 'Sessão '.($action == 'store' ? 'criada':'atualizada').' com sucesso!',
                'id' => $category->id
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e,
            ]);
        }
    }

    public function destroy(Category $category, Request $request)
    {
        if($category->id != $request->id){
            $category = Category::find($request->id);
        }
        //$this->makeLog('danger');
        DB::beginTransaction();
        try{
            if (Page::where('category_id', $category->id)->count() == 0){
                $category->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Categoria excluída com sucesso',
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Não é possível excluir essa sessão pois existe mais de uma página atrelada a ela',
                ]);
            }
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir categoria',
            ]);
        }
    }

    public function makeLog($type){
        if ($type == 'success'){
            Log::create([
                'user_id' => Auth::user()->id,
                'type' => $type,
                'text' => '<a href="'.route('admin.users.show', Auth::user()->hash_id).'" class="text-primary">'.Auth::user()->name.' '.Auth::user()->lastname.'</a> criou uma <span class="text-primary">sessão</span>.'
            ]);
        }elseif ($type == 'warning'){
            Log::create([
                'user_id' => Auth::user()->id,
                'type' => $type,
                'text' => '<a href="'.route('admin.users.show', Auth::user()->hash_id).'" class="text-primary">'.Auth::user()->name.' '.Auth::user()->lastname.'</a> editou uma <span class="text-primary">sessão</span>.'
            ]);
        }elseif ($type == 'danger'){
            Log::create([
                'user_id' => Auth::user()->id,
                'type' => $type,
                'text' => '<a href="'.route('admin.users.show', Auth::user()->hash_id).'" class="text-primary">'.Auth::user()->name.' '.Auth::user()->lastname.'</a> excluiu uma <span class="text-primary">sessão</span>.'
            ]);
        }
    }
}

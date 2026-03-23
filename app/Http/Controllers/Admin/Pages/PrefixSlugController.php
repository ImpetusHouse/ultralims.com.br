<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\PrefixSlug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PrefixSlugController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('ajaxJson') && $request->ajaxJson == 'true'){
            $prefixSlugs = PrefixSlug::orderBy('slug')->get();
            return response()->json($prefixSlugs);
        }
    }

    public function store(Request $request)
    {
        return $this->save(new PrefixSlug(), $request, 'store');
    }

    public function update(PrefixSlug $prefixSlug, Request $request)
    {
        return $this->save($prefixSlug, $request, 'update');
    }

    public function save($prefixSlug, $request, $action){
        $title = $request->input('name');
        $slug = Str::slug($title);

        //find slug in categories
        $existPrefix = PrefixSlug::where('slug', $slug)->where('id', '!=', $prefixSlug->id)->first();
        if($existPrefix){
            $slug = $slug.'-'.date('Y-m-d');
        }

        DB::beginTransaction();

        try{
            $prefixSlug->slug = $slug;
            $prefixSlug->save();
            DB::commit();
            if ($action == 'store'){
                //$this->makeLog('success');
            }else{
                //$this->makeLog('warning');
            }
            return response()->json([
                'success' => true,
                'message' => 'Prefixo '.($action == 'store' ? 'criado':'atualizado').' com sucesso!',
                'id' => $prefixSlug->id
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e,
            ]);
        }
    }

    public function destroy(PrefixSlug $prefixSlug, Request $request)
    {

        if($prefixSlug->id != $request->id){
            $prefixSlug = PrefixSlug::find($request->id);
        }
        //$this->makeLog('danger');
        DB::beginTransaction();

        try{
            //if ($prefixSlug->pages->count() == 0){
            if (true){
                $prefixSlug->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Prefixo excluído com sucesso',
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Não é possível excluir esse prefixo pois existe mais de uma página atrelada a ele',
                ]);
            }
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir prefixo',
            ]);
        }
    }
}

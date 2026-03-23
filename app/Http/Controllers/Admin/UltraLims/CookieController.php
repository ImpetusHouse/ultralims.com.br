<?php

namespace App\Http\Controllers\Admin\UltraLims;

use App\Http\Controllers\Controller;
use App\Models\UltraLims\Cookie\UL_Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CookieController extends Controller{
    public function index(){
        $title = 'Cookies';
        $breadcrumbs = [
            ['url' => route('admin.ultralims.cookies.index'), 'title' => $title],
        ];
        $cookies = UL_Cookie::orderBy('title')->get();
        return view('admin.pages.ultralims.cookies.list', compact('title', 'breadcrumbs', 'cookies'));
    }

    public function create(){
        $title = 'Criar cookie';
        $breadcrumbs = [
            ['url' => route('admin.ultralims.cookies.index'), 'title' => 'Cookies'],
            ['url' => route('admin.ultralims.cookies.create'), 'title' => $title],
        ];
        $cookie = new UL_Cookie();
        return view('admin.pages.ultralims.cookies.form', compact('title', 'breadcrumbs', 'cookie'));
    }

    public function store(Request $request){
        return $this->save($request, new UL_Cookie(), 'store');
    }

    public function edit(UL_Cookie $cookie){
        $title = 'Editar cookie';
        $breadcrumbs = [
            ['url' => route('admin.ultralims.cookies.index'), 'title' => 'Cookies'],
            ['url' => route('admin.ultralims.cookies.edit', $cookie->hash_id), 'title' => $title],
        ];
        return view('admin.pages.ultralims.cookies.form', compact('title', 'breadcrumbs', 'cookie'));
    }

    public function update(Request $request, UL_Cookie $cookie){
        return $this->save($request, $cookie, 'update');
    }

    public function destroy(UL_Cookie $cookie){
        $cookie->delete();
        return response()->json([
            'success' => true,
            'message' => 'Cookie excluído com sucesso',
        ]);
    }

    public function save($request, $cookie, $action){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'priority' => 'required',
            'start' => 'required',
            'end' => 'required',
            'status' => 'required',
        ],[
            'title.required' => 'O título é obrigatório',
            'content.required' => 'O conteúdo é obrigatório',
            'priority.required' => 'A prioridade é obrigatória',
            'start.required' => 'É obrigatório informar a data de início',
            'end.required' => 'É obrigatório informar a data final',
            'status.required' => 'O status é obrigatório'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        DB::beginTransaction();
        try{
            $cookie->fill($request->input());
            $cookie->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Cookie '.($action == 'store' ? 'criado':'editado').' com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." o cookie",
                'e' => $e->getMessage()
            ]);
        }
    }
}

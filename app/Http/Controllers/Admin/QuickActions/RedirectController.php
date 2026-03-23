<?php

namespace App\Http\Controllers\Admin\QuickActions;

use App\Http\Controllers\Controller;
use App\Models\QuickActions\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RedirectController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $redirects = Redirect::all();

        $title = "Redirecionamentos";
        $breadcrumbs = [
            ['title' => $title, 'url' => route('admin.redirects.index')],
        ];

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'redirects' => $redirects
        ];
        return view('admin.pages.quickActions.redirects.list', $data);
    }

    public function create(){
        $redirect = new Redirect();

        $title = "Inserir redirecionamento";
        $breadcrumbs = [
            ['title' => "Redicionamentos", 'url' => route('admin.redirects.index')],
            ['title' => $title, 'url' => route('admin.redirects.create')]
        ];

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'redirect' => $redirect
        ];

        return view('admin.pages.quickActions.redirects.form', $data);
    }

    public function store(Request $request){
        $json = $this->save($request, new Redirect(), 'store');
        return $json;
    }

    public function edit(Redirect $redirect){
        $title = "Editar redirecionamento";
        $breadcrumbs = [
            ['title' => "Redirecionamentos", 'url' => route('admin.redirects.index')],
            ['title' => $title, 'url' => route('admin.redirects.edit', $redirect->hash_id)],
        ];

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'redirect' => $redirect
        ];

        return view('admin.pages.quickActions.redirects.form', $data);
    }

    public function update(Request $request, Redirect $redirect){
        $json = $this->save($request, $redirect, 'update');
        return $json;
    }

    public function destroy(Redirect $redirect){
        $redirect->delete();
        return response()->json([
            'success' => true,
            'message' => 'Redirecionamento removido com sucesso!'
        ]);
    }

    public function save($request, $redirect, $action){
        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
            'status' => 'required',
        ],[
            'from.required' => 'O url de redirecionamento é obrigatória!',
            'to.required' => 'A url para onde será redirecionado é obrigatório!',
            'status.required' => 'O status é obrigatório!',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try{
            $redirect->fill($request->input());
            $redirect->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Redirecionamento '.($action == 'store' ? 'criado':'editado').' com sucesso!',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." o redirecionamento!",
                'error' => $e->getMessage()
            ]);
        }
    }
}

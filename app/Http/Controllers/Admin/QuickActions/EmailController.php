<?php

namespace App\Http\Controllers\Admin\QuickActions;

use App\Http\Controllers\Controller;
use App\Models\Settings\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller {
    public function index(){
        $title = 'E-mails';
        $breadcrumbs = [
            ['url' => route('admin.emails.index'), 'title' => $title],
        ];
        $emails = Email::orderBy('title')->get();
        return view('admin.pages.quickActions.emails.list', compact('title', 'breadcrumbs', 'emails'));
    }

    public function create(){
        $title = 'Criar e-mail';
        $breadcrumbs = [
            ['url' => route('admin.emails.index'), 'title' => 'E-mails'],
            ['url' => route('admin.emails.create'), 'title' => $title],
        ];
        $email = new Email();
        return view('admin.pages.quickActions.emails.form', compact('title', 'breadcrumbs', 'email'));
    }

    public function store(Request $request){
        return $this->save($request, new Email(), 'store');
    }

    public function edit(Email $email){
        $title = 'Editar card';
        $breadcrumbs = [
            ['url' => route('admin.emails.index'), 'title' => 'E-mails'],
            ['url' => route('admin.emails.edit', $email->hash_id), 'title' => $title],
        ];
        return view('admin.pages.quickActions.emails.form', compact('title', 'breadcrumbs', 'email'));
    }

    public function update(Request $request, Email $email){
        return $this->save($request, $email, 'update');
    }

    public function destroy(Email $email){
        try {
            $email->delete();
            return response()->json([
                'success' => true,
                'message' => 'E-mail excluído com sucesso',
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir e-mail, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    public function save($request, $email, $action){
        $validator = Validator::make($request->all(), [
            'layout' => 'required',
            'title' => 'required',
            'subject' => 'required',
            'content' => 'required',
            'status' => 'required'
        ],[
            'layout.required' => 'O layout é obrigatório',
            'title.required' => 'O título é obrigatório',
            'subject.required' => 'O assunto é obrigatório',
            'content.required' => 'O conteúdo é obrigatório',
            'status.required' => 'O status é obrigatório'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try{
            $email->fill($request->input());
            $email->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'E-mail '.($action == 'store' ? 'criado':'editado').' com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." e-mail",
                'e' => $e->getMessage()
            ]);
        }
    }
}

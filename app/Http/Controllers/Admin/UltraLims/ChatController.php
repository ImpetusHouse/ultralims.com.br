<?php

namespace App\Http\Controllers\Admin\UltraLims;

use App\Http\Controllers\Controller;
use App\Models\UltraLims\UL_Company_Chat;
use App\Models\UltraLims\UL_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function index(){
        $title = 'Chat (Empresas)';
        $breadcrumbs = [
            ['url' => route('admin.ultralims.chat.index'), 'title' => $title],
        ];

        $companies = UL_User::select('idLaboratorio', 'laboratorio')
            ->groupBy('idLaboratorio', 'laboratorio')
            ->orderBy('laboratorio')
            ->get();

        return view('admin.pages.ultralims.chat.index', compact('title', 'breadcrumbs', 'companies'));
    }

    public function show($id)
    {
        $title = 'Chat (Usuários)';
        $breadcrumbs = [
            ['url' => route('admin.ultralims.chat.index'), 'title' => 'Chat (Empresas)'],
            ['url' => route('admin.ultralims.chat.show', $id), 'title' => $title],
        ];

        $users = UL_User::where('idLaboratorio', $id)->orderBy('tipoUser')->orderBy('user')->get();

        return view('admin.pages.ultralims.chat.show', compact('title', 'breadcrumbs', 'users'));
    }

    public function update(Request $request, $id)
    {
        $user = UL_User::where('id', $id)->first();
        if (!$user){
            return response()->json([
                'success' => false,
                'message' => "Usuário não encontrado, tente novamente",
            ]);
        }

        DB::beginTransaction();
        try{
            $user->chat = isset($request->chat);
            $user->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Usuário salvo com sucesso',
            ]);
        }catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao salvar usuário, tente novamente",
                'e' => $e->getMessage()
            ]);
        }
    }

    public function _store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companies_chat_id' => 'required'
        ],[
            'companies_chat_id.required' => 'É obrigatório selecionar ao menos um laboratório'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try{
            UL_Company_Chat::whereIn('id', $request->companies_chat_id)->update([
                'status' => true
            ]);
            UL_Company_Chat::whereNotIn('id', $request->companies_chat_id)->update([
                'status' => false
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Configuração salva com sucesso',
            ]);
        }catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao salvar configuração, tente novamente",
                'e' => $e->getMessage()
            ]);
        }
    }
}

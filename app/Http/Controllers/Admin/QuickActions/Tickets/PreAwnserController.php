<?php

namespace App\Http\Controllers\Admin\QuickActions\Tickets;

use App\Http\Controllers\Controller;
use App\Models\QuickActions\Tickets\PreAwnser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PreAwnserController extends Controller
{
    public function create()
    {
        $title = "Editar resposta pré-definida";
        $breadcrumbs = [
            ['url' => route('admin.index'), 'title' => 'Painel'],
            ['url' => route('admin.tickets.index'), 'title' => 'Tickets'],
            ['url' => route('admin.tickets.configuration.index'), 'title' => 'Configurações'],
            ['url' => route('admin.tickets.configuration.pre-awnser.create'), 'title' => 'Criar resposta'],
        ];
        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs
        ];
        return view('admin.pages.quickActions.tickets.configuration.preAwnser.create', $data);
    }

    public function store(Request $request)
    {
        if(PreAwnser::create($request->all())){
            Session::flash('success', 'Resposta criada com sucesso');
            return response()->json(['success' => true, 'reload' => true]);
        }else{
            return response()->json(['success' => false, 'message' => 'Erro ao criar resposta']);
        }
    }


    public function edit(PreAwnser $preAwnser)
    {
        $page_title = "Editar resposta pré-definida";
        $breadcrumbs = [
            ['url' => route('admin.index'), 'title' => 'Painel'],
            ['url' => route('admin.tickets.configuration.index'), 'title' => 'Configurações'],
            ['url' => route('admin.tickets.configuration.pre-awnser.edit', $preAwnser->hash_id), 'title' => 'Editar resposta'],
        ];

        $awnser = $preAwnser;
        return view('admin.pages.quickActions.tickets.configuration.preAwnser.edit', compact('page_title', 'breadcrumbs', 'awnser'));
    }


    public function update(Request $request, PreAwnser $preAwnser)
    {
        if($preAwnser->update($request->all())){
            Session::flash('success', 'Resposta modificada com sucesso');
            return response()->json(['success' => true, 'reload' => true]);
        }else{
            return response()->json(['success' => false, 'message' => 'Erro ao modificar resposta']);
        }
    }

    public function destroy(Request $request)
    {
        $awnser = PreAwnser::find($request->id);
        if($awnser->delete()){
            Session::flash('success', 'Resposta removida com sucesso');
            return response()->json(['success' => true, 'reloaded' => true]);
        }else{
            return response()->json(['success' => false, 'message' => 'Erro ao remover resposta']);
        }
    }
}

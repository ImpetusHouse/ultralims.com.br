<?php

namespace App\Http\Controllers\Admin\QuickActions\Tickets;

use App\Http\Controllers\Controller;
use App\Models\QuickActions\Tickets\ReasonsRefusal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReasonsRefusalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $reason = $request->reason;
        $only_adm = $request->only_adm ?? false;

        if(ReasonsRefusal::create([
            'reason' => $reason,
            'only_adm' => $only_adm,
            'show_to' => $request->show_to,
            'is_operator' => $request->is_operator ?? 0
        ])){
            Session::flash('success', 'Motivo criado com sucesso');
            return response()->json([
                'success' => true,
                'reloaded' => true,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro ao criar motivo',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReasonsRefusal  $reasonsRefusal
     * @return \Illuminate\Http\Response
     */
    public function show(ReasonsRefusal $reasonsRefusal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReasonsRefusal  $reasonsRefusal
     * @return \Illuminate\Http\Response
     */
    public function edit(ReasonsRefusal $reasonsRefusal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReasonsRefusal  $reasonsRefusal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReasonsRefusal $reasonsRefusal)
    {
        $reason = $request->reason;
        $only_adm = $request->only_adm ?? false;

        if($reasonsRefusal->update([
            'reason' => $reason,
            'only_adm' => $only_adm,
            'show_to' => $request->show_to,
            'is_operator' => $request->is_operator ?? 0
        ])){
            Session::flash('success', 'Motivo atualizado com sucesso');
            return response()->json([
                'success' => true,
                'reloaded' => true,

            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro ao atualizar motivo',
        ]);
    }


    public function destroy(Request $request)
    {
        $reason = ReasonsRefusal::find($request->id);
        if(!$reason){
            return response()->json([
                'success' => false,
                'message' => 'Motivo de recusa não encontrado',
            ]);
        }

        if($reason->delete()){
            Session::flash('success', 'Motivo removido com sucesso');
            return response()->json([
                'success' => true,
                'reloaded' => true,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro ao remover motivo',
        ]);
    }
}

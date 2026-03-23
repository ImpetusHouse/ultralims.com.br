<?php

namespace App\Http\Controllers\Admin\QuickActions\Tickets;

use App\Http\Controllers\Controller;
use App\Models\QuickActions\Tickets\AutomaticMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AutomaticMessagesController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuickActions\Tickets\AutomaticMessages  $automaticMessages
     * @return \Illuminate\Http\Response
     */
    public function show(AutomaticMessages $automaticMessages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuickActions\Tickets\AutomaticMessages  $automaticMessages
     * @return \Illuminate\Http\Response
     */
    public function edit(AutomaticMessages $automaticMessages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuickActions\Tickets\AutomaticMessages  $automaticMessages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AutomaticMessages $automaticMessages)
    {
        if(!$request->has('autoMessage')){
            return response()->json(['success' => false, 'message' => 'Requisição inválida']);
        }

        $autoMessage = $request->input('autoMessage');

        if(!is_array($autoMessage)){
            return response()->json(['success' => false, 'message' => 'parâmetros de requisição inválida']);
        }

        $msg = $autoMessage;

        $autoMessage = array_map('trim', $autoMessage);
        foreach(array_keys($autoMessage) as $message){
            AutomaticMessages::updateOrCreate(
                ['to' => $message],
                ['message' => $msg[$message] ?? null]
            );
        }

        Session::flash('success', 'Mensagens atualizadas com sucesso');
        return response()->json(['success' => true, 'reload' => true]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuickActions\Tickets\AutomaticMessages  $automaticMessages
     * @return \Illuminate\Http\Response
     */
    public function destroy(AutomaticMessages $automaticMessages)
    {
        //
    }
}

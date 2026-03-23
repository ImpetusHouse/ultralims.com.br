<?php

namespace App\Http\Controllers\Admin\QuickActions\Tickets;


use App\Http\Controllers\Controller;
use App\Mail\userNotificationsMail;
use App\Models\QuickActions\Tickets\AutomaticMessages;
use App\Models\QuickActions\Tickets\Awnser;
use App\Models\QuickActions\Tickets\Client;
use App\Models\QuickActions\Tickets\File;
use App\Models\QuickActions\Tickets\PreAwnser;
use App\Models\QuickActions\Tickets\ReasonsRefusal;
use App\Models\QuickActions\Tickets\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $title = "Tickets";
        $breadcrumbs = [
            [
                'title' => 'Tickets',
                'url' => route('admin.tickets.index')
            ]
        ];
        if(Auth::user()->hasPermissionTo('Ticket Atendente')){
            $tickets = Ticket::where(function ($query){
                $query->where('user_id', null)->orWhere('user_id', Auth::user()->id);
            })->get();

            $tickets = $tickets->merge(Auth::user()->forwardTickets);
            $tickets = $tickets->sortByDesc('id');
        }else{
            $tickets = Ticket::orderBy('id', 'desc')->get();
        }
        $ticketsStatics = $tickets->map(function($r) {
            if($r->status == 'awserving'){
                $r->getLastAwnser = Awnser::where('ticket_id', $r->id)->orderBy('id', 'DESC')->first();
            }
            return $r;
        });
        if(isset($request->filter)){
            if($request->filter == 'operator_awnser' or $request->filter == 'client_awnser'){
                $tickets = $tickets->filter(function($r) use ($request){
                    if($r->status == 'awserving'){
                        $r->getLastAwnser = Awnser::where('ticket_id', $r->id)->orderBy('id', 'DESC')->first();
                    }
                    if(isset($r->getLastAwnser->type) && $r->getLastAwnser->type == 1){
                        if($request->filter == 'operator_awnser'){
                            if($r->getLastAwnser->from == 1){
                                return $r;
                            }
                        }else{
                            if($r->getLastAwnser->from == 0){
                                return $r;
                            }
                        }
                    }elseif(isset($r->getLastAwnser->type) && $r->getLastAwnser->type == 2 && $request->filter == 'operator_awnser'){
                        return $r;
                    }elseif(isset($r->getLastAwnser->type) && $r->getLastAwnser->type == 2 && $request->filter == 'client_awnser'){
                        return $r;
                    }
                });
            }else{
                if(Auth::user()->hasPermissionTo('Ticket Atendente')){
                    $tickets = Ticket::where(function ($query) use ($request) {
                        $query->where([
                            ['status', $request->filter],
                            ['user_id', null]
                        ])->orWhere([
                            ['status', $request->filter],
                            ['user_id', Auth::user()->id]
                        ]);
                    })->orderBy('id', 'desc')->get();
                }else{
                    $tickets = Ticket::where([
                        ['status', $request->filter]
                    ])->orderBy('id', 'desc')->get();
                }
            }
        }


        $tickets = $tickets->map(function($ticket){
            $awnsers = Awnser::where('ticket_id', $ticket->id)->orderBy('created_at', 'desc');
            if($awnsers && $awnsers->count() > 0){
                $ticket->last_awnser_date = $awnsers->first()->created_at ?? null;
            }
            return $ticket;
        });
        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'tickets' => $tickets,
            'ticketsStatics' => $ticketsStatics,
        ];
        return view('admin.pages.quickActions.tickets.index', $data);
    }

    public function create()
    {
        return view('client.pages.quickActions.tickets.form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'title' => 'required',
            'description' => 'required'
        ],[
            'name.required' => 'O nome é obrigatório',
            'phone.required' => 'O telefone/celular é obrigatória',
            'email.required' => 'O e-mail é obrigatório',
            'title.required' => 'O assunto é obrigatório',
            'description.required' => 'A mensagem é obrigatória'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try{
            $client = Client::where('name',  $request->name)->where('phone', preg_replace('/[^0-9]/', '', $request->phone))->where('email', $request->email)->get();
            if($client->count() <= 0){
                $ticketClient = Client::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => preg_replace('/[^0-9]/', '', $request->phone)
                ]);
            }
            $ticket = Ticket::create([
                'type' => $request->type,
                'title' => $request->title,
                'description' => $request->description,
                'client_id' => $ticketClient->id ?? $client[0]->id,
                'status' => 'open',
                'contact_by' => $request->contact_by ?? 'Site',
                'opened_by' => $request->opened_by ?? null
            ]);
            DB::commit();
            $data = [
                'subject' => (env('APP_NAME') == 'AABB-SP' ? 'SAC - AABB São Paulo' : ('Suporte | '.env('APP_NAME')) ),
                'name' => $ticket->client->name,
                'email' => $ticket->client->email,
                'title' => 'Ticket criado',
                'description' => $ticket->description,
                'link' => route('tickets.public.show', $ticket->hash_id),
                'type' => 'ticket'
            ];

            Mail::send(new userNotificationsMail($data));
            Session::flash('success', 'Ticket criado com sucesso');
            return response()->json([
                'success' => true,
                'reloaded' => true,
                'message' => 'Ticket criado com sucesso',
                'ticket' => $ticket,
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar ticket' . $e->getMessage(),
            ]);
        }
    }

    public function show(Ticket $ticket){
        if($ticket->user_id != null && Auth::user()->hasPermissionTo('Ticket Atendente') && $ticket->user_id != Auth::user()->id && !$ticket->users->contains(Auth::user())){
            return redirect()->route('admin.tickets.index');
        }
        $title = "Tickets";
        $breadcrumbs = [
            [
                'title' => 'Tickets',
                'url' => route('admin.tickets.index')
            ],

            [
                'title' => $ticket->title,
                'url' => route('admin.tickets.show', $ticket->id)
            ]
        ];
        $replies = $ticket->awnsers;

        $replies = [];
        foreach ($ticket->awnsers as $awnser){
            if($awnser->awnser_to != null){
                $replies[$awnser->awnser_to][] = $awnser;
            }
        }

        $icons = [
            #Images
            'svg' => '<i class="fas fa-file-image text-primary me-2 fs-2"></i>',
            'png' => '<i class="fas fa-file-image text-primary me-2 fs-2"></i>',
            'jpg' => '<i class="fas fa-file-image text-primary me-2 fs-2"></i>',
            'gif' => '<i class="fas fa-file-image text-primary me-2 fs-2"></i>',
            'bmp' => '<i class="fas fa-file-image text-primary me-2 fs-2"></i>',
            'webp' => '<i class="fas fa-file-image text-primary me-2 fs-2"></i>',

            #Zippes
            'zip' => '<i class="fas fa-file-archive text-primary me-2 fs-2"></i>',
            'rar' => '<i class="fas fa-file-archive text-primary me-2 fs-2"></i>',
            'gz' => '<i class="fas fa-file-archive text-primary me-2 fs-2"></i>',
            '7z' => '<i class="fas fa-file-archive text-primary me-2 fs-2"></i>',
            'tar' => '<i class="fas fa-file-archive text-primary me-2 fs-2"></i>',

            #Docs
            'doc' => '<i class="far fa-file-alt text-primary me-2 fs-2"></i>',
            'docx' => '<i class="far fa-file-alt text-primary me-2 fs-2"></i>',
            'txt' => '<i class="far fa-file-alt text-primary me-2 fs-2"></i>',

            #pdf
            'pdf' => '<i class="fas fa-file-pdf text-primary me-2 fs-2"></i>',

            #Excel
            'xls' => '<i class="fas fa-file-excel text-primary me-2 fs-2"></i>',
            'xlsx' => '<i class="fas fa-file-excel text-primary me-2 fs-2"></i>',
            'csv' => '<i class="fas fa-file-excel text-primary me-2 fs-2"></i>',
            'cls' => '<i class="fas fa-file-excel text-primary me-2 fs-2"></i>',
            'clsx' => '<i class="fas fa-file-excel text-primary me-2 fs-2"></i>',


        ];

        $reasonsTickets = ReasonsRefusal::where('show_to', 'only_ticket')->orWhere('show_to', 'all')->get();
        $preAwnsers = PreAwnser::all();
        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'ticket' => $ticket,
            'replies' => $replies,
            'icons' => $icons,
            'reasonsTickets' => $reasonsTickets,
            'preAwnsers' => $preAwnsers,
            'users' => User::where('id', '!=', Auth::id())->orderBy('name')->orderBy('lastname')->where('status', true)->get()
        ];
        return view('admin.pages.quickActions.tickets.show', $data);
    }

    public function showPublic(Ticket $ticket){
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['client'])){
            $client = $_SESSION['client'];
            $client = Crypt::decrypt($client);
            $now = Carbon::now();
            $expire = Carbon::parse($_SESSION['expire']);

            if(!isset($_SESSION['expire'])){
                return view('client.pages.tickets.auth', compact('ticket'));
            }

            if($now->gt($expire)){
                unset($_SESSION['client']);
                unset($_SESSION['expire']);
                return view('client.pages.tickets.auth', compact('ticket'));
            }

            if(!$ticket){
                return abort(404);
            }

            if($client->id != $ticket->client_id){
                return view('client.pages.tickets.auth', compact('ticket'));
            }

            $replies = $ticket->awnsers;

            $replies = [];
            foreach ($ticket->awnsers as $awnser){
                if($awnser->awnser_to != null){
                    $replies[$awnser->awnser_to][] = $awnser;
                }
            }

            $page_title = 'Ticket - ' . $ticket->title . ' | ' . env('APP_NAME');

            $icons = [
                #Images
                'svg' => '<i class="fas fa-file-image text-primary me-2 fs-2"></i>',
                'png' => '<i class="fas fa-file-image text-primary me-2 fs-2"></i>',
                'jpg' => '<i class="fas fa-file-image text-primary me-2 fs-2"></i>',
                'gif' => '<i class="fas fa-file-image text-primary me-2 fs-2"></i>',
                'bmp' => '<i class="fas fa-file-image text-primary me-2 fs-2"></i>',
                'webp' => '<i class="fas fa-file-image text-primary me-2 fs-2"></i>',

                #Zippes
                'zip' => '<i class="fas fa-file-archive text-primary me-2 fs-2"></i>',
                'rar' => '<i class="fas fa-file-archive text-primary me-2 fs-2"></i>',
                'gz' => '<i class="fas fa-file-archive text-primary me-2 fs-2"></i>',
                '7z' => '<i class="fas fa-file-archive text-primary me-2 fs-2"></i>',
                'tar' => '<i class="fas fa-file-archive text-primary me-2 fs-2"></i>',

                #Docs
                'doc' => '<i class="far fa-file-alt text-primary me-2 fs-2"></i>',
                'docx' => '<i class="far fa-file-alt text-primary me-2 fs-2"></i>',
                'txt' => '<i class="far fa-file-alt text-primary me-2 fs-2"></i>',

                #pdf
                'pdf' => '<i class="fas fa-file-pdf text-primary me-2 fs-2"></i>',

                #Excel
                'xls' => '<i class="fas fa-file-excel text-primary me-2 fs-2"></i>',
                'xlsx' => '<i class="fas fa-file-excel text-primary me-2 fs-2"></i>',
                'csv' => '<i class="fas fa-file-excel text-primary me-2 fs-2"></i>',
                'cls' => '<i class="fas fa-file-excel text-primary me-2 fs-2"></i>',
                'clsx' => '<i class="fas fa-file-excel text-primary me-2 fs-2"></i>',
            ];

            $reasonsTickets = ReasonsRefusal::where('show_to', 'only_ticket')->orWhere('show_to', 'all')->get();
            return view('client.pages.tickets.show', compact('ticket', 'replies', 'icons', 'reasonsTickets', 'page_title'));
        }else{
            return view('client.pages.tickets.auth', compact('ticket'));
        }
    }

    public function edit(Ticket $ticket)
    {
        //
    }

    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json([
            'success' => true,
            'message' => 'Ticket removido com sucesso'
        ]);
    }

    public function setUserTicket(Request $request){
        if($request->has('ticket_id')){
            $ticket = Ticket::find($request->ticket_id);
            if($ticket->user_id != null){
                return response()->json(['error' => 'Ticket já está sendo atendido por outro atendente']);
            }
            $ticket->user_id = Auth::id();
            $ticket->status = 'awserving';

            if($ticket->save()){
                Session::flash('success', 'Você assumiu este ticket com sucesso');
                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false, 'message' => 'Erro ao assumir ticket']);
            }
        }else{
            return response()->json(['error' => 'Ticket não encontrado']);
        }
    }

    public function forward(Request $request){
        DB::beginTransaction();
        try {
            $ticket = Ticket::where('id', $request->ticket_id)->first();
            if ($ticket == null){
                return response()->json(['success' => false, 'Ticket não encontrado']);
            }
            if($ticket->user_id != null && Auth::user()->hasPermissionTo('Ticket Atendente') && $ticket->user_id != Auth::user()->id){
                return response()->json(['success' => false, 'Você não possui permissão para realizar essa ação']);
            }
            $ticket->users()->sync($request->users_id);

            foreach ($ticket->users as $user){
                $awnser = Awnser::create([
                    'ticket_id' => $request->ticket_id,
                    'from' => 0,
                    'user_id' => $user->id,
                    'client_id' => $ticket->client_id,
                    'message' => 'Encaminhado para ' . $user->name . ' ' . $user->lastname,
                    'type' => 3
                ]);

                $data = [
                    'to' => $user->email,
                    'subject' => (env('APP_NAME') == 'AABB-SP' ? 'SAC - AABB São Paulo' : ('Suporte | '.env('APP_NAME')) ),
                    'name' => $ticket->client->name, // Usando apenas o primeiro nome, com capitalização correta
                    'cpf_cnpj' => $ticket->client->cpf_cnpj,
                    'phone' => $ticket->client->phone,
                    'email' => $ticket->client->email,
                    'company_name' => $ticket->client->company_name,
                    'office' => $ticket->client->office,
                    'quantity' => $ticket->client->quantity,
                    'is_member' => $ticket->client->is_member == 1 ? 'Sim':'Não',
                    'member_number' => $ticket->client->member_number,
                    'state' => $ticket->client->state,
                    'city' => $ticket->client->city,
                    'title' => (env('APP_NAME') == 'AABB-SP' ? 'SAC':'Ticket').' encaminhado',
                    'description' => 'Olá '.$user->name.', o '.(env('APP_NAME') == 'AABB-SP' ? 'SAC':'ticket').' foi encaminhado para você por '.Auth::user()->name.'.

                    <b>Assunto do Ticket:</b> '.$ticket->title.'
                    <b>Número do ticket:</b> '.$ticket->id.',
                    <b>Mensagem do ticket:</b> '.$ticket->description,
                    'link' => route('admin.tickets.show', $ticket->hash_id),
                    'type' => 'ticket'
                ];
                try{
                    @Mail::send(new userNotificationsMail($data));
                }catch(\Exception $e){
                    //
                }
            }
            DB::commit();
            return response()->json(['success' => true]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'Falha ao encaminhar ticket, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    public function setStatusTicket(Request $request){
        if($request->status == 'userOut'){
            if($request->has('ticket_id')){

                $ticket = Ticket::find($request->ticket_id);
                $ticket->status = 'open';
                $ticket->user_id = $request->user_id;

                $olderUsers = json_decode($ticket->old_user_id, true) ?? [];
                $olderUsers[] = Auth::id();
                $ticket->old_user_id = json_encode($olderUsers);

                /*if ($request->type != null){
                    $ticket->type = $request->type;
                }*/

                if($ticket->save()){
                    Session::flash('success', 'Status do ticket alterado com sucesso');
                    return response()->json(['success' => true]);
                }else{
                    return response()->json(['success' => false, 'message' => 'Erro ao alterar status do ticket']);
                }
            }else{
                return response()->json(['error' => 'Ticket não encontrado']);
            }
        }


        $allowed = [
            'open',
            'awserving',
            'closed'
        ];

        if(!in_array($request->status, $allowed)){
            return response()->json(['success' => false, 'message' => 'Status inválido']);
        }

        if($request->has('ticket_id')){
            $ticket = Ticket::find($request->ticket_id);
            $ticket->status = $request->status;
            if($request->status == 'closed'){
                if($request->from == 1){
                    $ticket->closed_by = $ticket->user_id;
                    $autoMessage = AutomaticMessages::where('to', 'ticket_end_operator')->first();
                    if(isset($autoMessage->message) && $autoMessage->message != ''){
                        //Envia Mensagem
                        $ticketMessage = Awnser::create([
                            'ticket_id' => $request->ticket_id,
                            'from' => 1,
                            'user_id' => Auth::id(),
                            'client_id' => $ticket->client_id,
                            'message' => $autoMessage->message,
                            'type' => 1,
                        ]);
                    }

                }else{
                    $ticket->closed_by = -1;
                    $autoMessage = AutomaticMessages::where('to', 'ticket_end_client')->first();
                    $issetMessage = false;
                    if (strlen($request->obs) > 0){
                        $message = $request->obs;
                        $issetMessage = true;
                    }else{
                        if(isset($autoMessage->message) && $autoMessage->message != ''){
                            $message = $autoMessage->message;
                            $issetMessage = true;
                        }
                    }
                    if ($issetMessage){
                        $ticketMessage = Awnser::create([
                            'ticket_id' => $request->ticket_id,
                            'from' => 0,
                            'user_id' => $ticket->user_id,
                            'client_id' => $ticket->client_id,
                            'message' => $message,
                            'type' => 1,
                        ]);
                    }
                }

                $data = [
                    'to' => $ticket->client->email,
                    'subject' => (env('APP_NAME') == 'AABB-SP' ? 'SAC - AABB São Paulo' : ('Suporte | '.env('APP_NAME')) ),
                    'name' => $ticket->client->name,
                    'cpf_cnpj' => $ticket->client->cpf_cnpj,
                    'phone' => $ticket->client->phone,
                    'email' => $ticket->client->email,
                    'company_name' => $ticket->client->company_name,
                    'office' => $ticket->client->office,
                    'quantity' => $ticket->client->quantity,
                    'is_member' => $ticket->client->is_member == 1 ? 'Sim':'Não',
                    'member_number' => $ticket->client->member_number,
                    'state' => $ticket->client->state,
                    'city' => $ticket->client->city,
                    'title' => 'Ticket encerrado',
                    'description' => '
                        Prezado '.$ticket->client->name.', informamos que seu Ticket de atendimento número '.$ticket->id.' foi encerrado. Gostaríamos de reforçar nossa satisfação em atendê-lo.
                    ',
                    'type' => 'ticket'
                ];
                try{
                    @Mail::send(new userNotificationsMail($data));
                }catch(\Exception $e){
                    //
                }

                $ticket->refusal_id = $request->reason_refusal_id;
            }

            if($request->status == 'awserving'){

                if($request->from == 1){

                    $ticketMessage = Awnser::create([
                        'ticket_id' => $request->ticket_id,
                        'from' => $request->from,
                        'user_id' => $ticket->user->id ?? null,
                        'client_id' => $ticket->client_id ?? null,
                        'message' => 'Atendimento reaberto pelo atendente '.Auth::user()->name,
                        'type' => 3,
                    ]);

                    $data = [
                        'to' => $ticket->client->email,
                        'subject' => 'Suporte | '.env('APP_NAME'),
                        'name' => $ticket->client->name,
                        'cpf_cnpj' => $ticket->client->cpf_cnpj,
                        'phone' => $ticket->client->phone,
                        'email' => $ticket->client->email,
                        'company_name' => $ticket->client->company_name,
                        'office' => $ticket->client->office,
                        'quantity' => $ticket->client->quantity,
                        'is_member' => $ticket->client->is_member == 1 ? 'Sim':'Não',
                        'member_number' => $ticket->client->member_number,
                        'state' => $ticket->client->state,
                        'city' => $ticket->client->city,
                        'title' => 'Ticket atualizado',
                        'description' => 'Olá '.$ticket->client->name.', o seu atendimento foi reaberto pelo nosso atendente.

                            <b>Assunto do Ticket:</b> '.$ticket->title.'
                            <b>Número do ticket:</b> '.$ticket->id.'
                            '.(env('APP_NAME') != 'AABB-SP' ? '<b>Atendente:</b> '.$ticket->user->name.' '.$ticket->user->lastname : ''),
                        'link' => route('tickets.public.show', $ticket->hash_id),
                        'type' => 'ticket'
                    ];
                    try{
                        @Mail::send(new userNotificationsMail($data));
                    }catch(\Exception $e){
                        //
                    }
                }else{
                    $ticketMessage = Awnser::create([
                        'ticket_id' => $request->ticket_id,
                        'from' => $request->from,
                        'user_id' => $ticket->user->id ?? null,
                        'client_id' => $ticket->client_id ?? null,
                        'message' => 'Atendimento reaberto pelo cliente',
                        'type' => 3,
                    ]);
                }

            }

            DB::beginTransaction();
            try{
                $ticket->save();
                DB::commit();
                Session::flash('success', 'Status do ticket alterado com sucesso');
                return response()->json(['success' => true, 'reloaded' => true]);
            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['success' => false, 'message' => 'Erro ao alterar status do ticket']);
            }

        }else{
            return response()->json(['error' => 'Ticket não encontrado']);
        }
    }

    public function sendMessage(Request $request){
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required',
            'message' => 'required',
            'attach_message' => 'max:10240'
        ],[
            'ticket_id.required' => 'Ticket não encontrado',
            'message.required' => 'Mensagem é obrigatória',
            'attach_message.max' => 'O tamanho máximo do arquivo é 10MB'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $from = $request->from;
        $ticket = Ticket::find($request->ticket_id);

        if($request->has('user_id')){
            if($from == 1){
                $user_id = $request->user_id;
            }else{
                return response()->json(['success' => false, 'message' => 'Solicitação inválida']);
            }
        }

        if($request->has('client_id')){
            if($from == 0){
                $client_id = $request->client_id;
            }else{
                return response()->json(['success' => false, 'message' => 'Solicitação inválida']);
            }
        }

        if($ticket->user_id == null){
           /*if($ticket->old_user_id != null){
                if(in_array(Auth::id(), json_decode($ticket->old_user_id, true))){
                    return response()->json(['success' => false, 'message' => 'Você não pode enviar mensagens para este ticket, pois você já desistiu dele']);
                }
            }*/
            $ticket->status = 'awserving';
            $ticket->user_id = Auth::id();
            $ticket->save();

            if($from == 1){
                $ticketMessage = Awnser::create([
                    'ticket_id' => $request->ticket_id,
                    'from' => $from,
                    'user_id' => $user_id ?? null,
                    'client_id' => $client_id ?? null,
                    'message' => 'O atendente '.Auth::user()->name.' agora é responsável pelo seu atendimento.',
                    'type' => 3,
                ]);
            }
        }

        $message = $request->message;
        $ticketMessage = Awnser::create([
            'ticket_id' => $request->ticket_id,
            'from' => $from,
            'user_id' => $user_id ?? null,
            'client_id' => $client_id ?? null,
            'message' => $message,
        ]);
        if($request->has('attach_message')){
            $files = is_array($request->file('attach_message')) ? $request->file('attach_message') : [$request->file('attach_message')];
            foreach($files as $file){
                $file_name = $file->getClientOriginalName();
                $file_extension = $file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_from = $from;
                $file_ticket_id = $request->ticket_id;
                $file_awnser_id = $ticketMessage->id;

                $file = File::create([
                    'path' => $file->store('public/tickets/files'),
                    'name' => $file_name,
                    'extension' => $file_extension,
                    'size' => $file_size,
                    'from' => $file_from,
                    'ticket_id' => $file_ticket_id,
                    'awnser_id' => $file_awnser_id,
                    'user_id' => $user_id ?? null,
                    'client_id' => $client_id ?? null,
                ]);
            }
        }

        if($from == 1 && $ticket->client->id != null){
            $data = [
                'to' => $ticket->client->email,
                'subject' => (env('APP_NAME') == 'AABB-SP' ? 'SAC - AABB São Paulo' : ('Suporte | '.env('APP_NAME')) ),
                'name' => $ticket->client->name,
                'cpf_cnpj' => $ticket->client->cpf_cnpj,
                'phone' => $ticket->client->phone,
                'email' => $ticket->client->email,
                'company_name' => $ticket->client->company_name,
                'office' => $ticket->client->office,
                'quantity' => $ticket->client->quantity,
                'is_member' => $ticket->client->is_member == 1 ? 'Sim':'Não',
                'member_number' => $ticket->client->member_number,
                'state' => $ticket->client->state,
                'city' => $ticket->client->city,
                'title' => 'Ticket atualizado',
                'description' => 'Olá '.$ticket->client->name.', seu ticket foi respondido.

                    <b>Assunto do Ticket:</b> '.$ticket->title.'
                    <b>Número do ticket:</b> '.$ticket->id.'
                    '.(env('APP_NAME') != 'AABB-SP' ? '<b>Atendente:</b> '.$ticket->user->name.' '.$ticket->user->lastname : ''),
                'link' => route('tickets.public.show', $ticket->hash_id),
                'type' => 'ticket'
            ];
            try{
                @Mail::send(new userNotificationsMail($data));
            }catch(\Exception $e){
                //
            }
        }elseif($from == 0){
            $data = [
                'to' => $ticket->user->email,
                'subject' => (env('APP_NAME') == 'AABB-SP' ? 'SAC - AABB São Paulo' : ('Suporte | '.env('APP_NAME')) ),
                'name' => $ticket->client->name,
                'cpf_cnpj' => $ticket->client->cpf_cnpj,
                'phone' => $ticket->client->phone,
                'email' => $ticket->client->email,
                'company_name' => $ticket->client->company_name,
                'office' => $ticket->client->office,
                'quantity' => $ticket->client->quantity,
                'is_member' => $ticket->client->is_member == 1 ? 'Sim':'Não',
                'member_number' => $ticket->client->member_number,
                'state' => $ticket->client->state,
                'city' => $ticket->client->city,
                'title' => 'Ticket atualizado',
                'description' => 'Olá '.$ticket->user->name.', o usuário respondeu o ticket.

                    <b>Assunto do Ticket:</b> '.$ticket->title.'
                    <b>Número do ticket:</b> '.$ticket->id.'
                    <b>Atendente:</b> '.$ticket->user->name.' '.$ticket->user->lastname,
                'link' => route('tickets.public.show', $ticket->hash_id),
                'type' => 'ticket'
            ];
            try{
                @Mail::send(new userNotificationsMail($data));
            }catch(\Exception $e){
                //
            }
            foreach ($ticket->users as $item){
                $data = [
                    'to' => $item->email,
                    'subject' => (env('APP_NAME') == 'AABB-SP' ? 'SAC - AABB São Paulo' : ('Suporte | '.env('APP_NAME')) ),
                    'name' => $ticket->client->name,
                    'cpf_cnpj' => $ticket->client->cpf_cnpj,
                    'phone' => $ticket->client->phone,
                    'email' => $ticket->client->email,
                    'company_name' => $ticket->client->company_name,
                    'office' => $ticket->client->office,
                    'quantity' => $ticket->client->quantity,
                    'is_member' => $ticket->client->is_member == 1 ? 'Sim':'Não',
                    'member_number' => $ticket->client->member_number,
                    'state' => $ticket->client->state,
                    'city' => $ticket->client->city,
                    'title' => 'Ticket atualizado',
                    'description' => 'Olá '.$item->name.', o usuário respondeu o ticket.

                    <b>Assunto do Ticket:</b> '.$ticket->title.'
                    <b>Número do ticket:</b> '.$ticket->id.'
                    <b>Atendente:</b> '.$ticket->user->name.' '.$ticket->user->lastname,
                    'link' => route('tickets.public.show', $ticket->hash_id),
                    'type' => 'ticket'
                ];
                try{
                    @Mail::send(new userNotificationsMail($data));
                }catch(\Exception $e){
                    //
                }
            }
        }

        if($ticketMessage){
            Session::flash('success', 'Ticket respondido com sucesso');
            return response()->json(['success' => true, 'message' => $ticketMessage]);
        }
        return response()->json(['success' => false, 'message' => 'Erro ao responder ticket']);
    }

    public function deleteMessage(Awnser $awnser){
        $awnser->delete();
        return response()->json([
            'success' => true,
            'message' => 'Resposta removida com sucesso'
        ]);
    }

    public function getPreAwnser(Request $request){
        $awnser = PreAwnser::find($request->id);
        return response()->json(['success' => true, 'message' => $awnser->awnser]);
    }

    public function clientLogin(Request $request, Ticket $ticket){
        //$client = Client::where('email', $request->email)->first();
        $client = $ticket->client;
        if ($client->email != $request->email){
            return response()->json(['success' => false, 'message' => 'Esse e-mail não consta em nossos registros.']);
        }

        if(!isset($_SESSION)){
            session_start();
        }
        $_SESSION['client'] = Crypt::encrypt($client);
        $_SESSION['start'] = time(); // Taking now logged in time.
        // Ending a session in 30 minutes from the starting time.
        $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
        return response()->json(['success' => true]);
    }
}

<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Jobs\SendCrmContact;
use App\Jobs\SendEpicFlowMessage;
use App\Jobs\SendUserNotification;
use App\Models\General\Alerts\Alert;
use App\Models\General\Events\Event;
use App\Models\General\Galleries\Gallery;
use App\Models\General\Magazines\Magazine;
use App\Models\Pages\Page;
use App\Models\QuickActions\Tickets\Client;
use App\Models\QuickActions\Tickets\Ticket;
use App\Models\Settings\Integration;
use App\Models\Settings\LGPD\Lgpd;
use App\Models\User;
use App\Services\EpicFlow;
use App\Services\Jira;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class SiteController extends Controller{
    //CARREGA +20 GALERIAS
    public function galleries (Request $request){
        $galleries = Gallery::where('status', true)->whereHas('photos');
        // Verifica se o parâmetro de busca foi enviado
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = $_GET['search']; // Armazena o termo de busca
            $galleries->where(function($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%");
            });
        }
        $galleries = $galleries->orderBy('date', 'desc')->paginate(20);
        if ($request->ajax()) {
            return view('site.pages.galleries.gallery', compact('galleries'))->render();
        }
    }

    //CARREGA +20 EVENTOS
    public function events(Request $request){
        $events = Event::where('status', true);
        // Verifica se o parâmetro de busca foi enviado
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = $_GET['search']; // Armazena o termo de busca
            $events->where(function($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('content', 'like', "%{$searchTerm}%")
                    ->orWhere('time', 'like', "%{$searchTerm}%")
                    ->orWhere('local', 'like', "%{$searchTerm}%");
            });
        }
        $events = $events->orderBy('date')->paginate(20);
        if ($request->ajax()) {
            return view('site.pages.events.event', compact('events'))->render();
        }
    }

    //CARREGA +20 COMUNICADOS
    public function alerts(Request $request){
        $alerts = Alert::where('status', true);
        // Verifica se o parâmetro de busca foi enviado
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = $_GET['search']; // Armazena o termo de busca
            $alerts->where(function($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }
        $alerts = $alerts->orderBy('display_order')->paginate(20);
        if ($request->ajax()) {
            return view('site.pages.alerts.alert', compact('alerts'))->render();
        }
    }

    //CARREGA +20 REVISTAS
    public function magazines(Request $request){
        $magazines = Magazine::where('status', true);
        // Verifica se o parâmetro de busca foi enviado
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = $_GET['search']; // Armazena o termo de busca
            $magazines->where(function($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%");
            });
        }
        $magazines = $magazines->orderBy('created_at', 'desc')->paginate(20);
        if ($request->ajax()) {
            return view('site.pages.magazines.magazine', compact('magazines'))->render();
        }
    }

    //CARREGA +20 TÓPICOS
    public function topics(Request $request){
        $category = \App\Models\General\Topics\Category::where('id', $request->category_id)->first();
        $topics = $category->topics()->where('status', true);
        // Verifica se o parâmetro de busca foi enviado
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = $_GET['search']; // Armazena o termo de busca
            $topics->where(function($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%");
            });
        }
        $topics = $topics->orderBy('created_at', 'desc')->paginate(20);
        if ($request->ajax()) {
            return view('site.pages.topics.topic', compact('topics'))->render();
        }
    }

    //EXIBE UM EVENTO
    public function event($slug){
        $event = Event::where('slug', $slug)->where('status', true)->first();
        if ($event == null) {
            return redirect()->back();
        }
        $events = Event::where('id', '!=', $event->id)->where('status', true)->where('date', '>=', now())->orderBy('date', 'asc')->limit(6)->get();
        SEOTools::setTitle(env('APP_NAME').' - '.$event->title);
        SEOTools::setDescription(Str::limit(strip_tags(html_entity_decode($event->content)), 157, '...'));
        SEOTools::setCanonical(route('events.show', $slug));
        SEOTools::opengraph()->setType('article');
        SEOTools::opengraph()->setUrl(route('events.show', $slug));
        SEOTools::opengraph()->addImage(asset(str_replace('public/', 'storage/', $event->photo_square)));
        SEOTools::jsonLd()->addImage(asset(str_replace('public/', 'storage/', $event->photo_square)));
        return view('site.pages.general.event', compact('event', 'events'));
    }

    //EXIBE UM COMUNICADO
    public function alert($slug){
        $alert = Alert::where('slug', $slug)->where('status', true)->first();
        if ($alert == null) {
            return redirect()->back();
        }
        $alerts = Alert::where('id', '!=', $alert->id)->where('status', true)->orderBy('created_at', 'desc')->limit(6)->get();
        SEOTools::setTitle(env('APP_NAME').' - '.$alert->title);
        SEOTools::setDescription(Str::limit(strip_tags(html_entity_decode($alert->description)), 157, '...'));
        SEOTools::setCanonical(route('alerts.show', $slug));
        SEOTools::opengraph()->setType('article');
        SEOTools::opengraph()->setUrl(route('alerts.show', $slug));
        SEOTools::opengraph()->addImage(asset(str_replace('public/', 'storage/', $alert->photo)));
        SEOTools::jsonLd()->addImage(asset(str_replace('public/', 'storage/', $alert->photo)));
        return view('site.pages.general.alert', compact('alert', 'alerts'));
    }

    //RECEBE OS DADOS PREENCHIDOS EM UM FORMULÁRIO NO SISTEMA
    public function contato(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'recaptcha-response' => 'required',
        ],[
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'phone.required' => 'O telefone é obrigatório',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        if ($request->email == 'arqkey1904@gmail.com'){
            return response()->json(['success' => true]);
        }

        // Verificação do reCAPTCHA v3
        $integationRecaptcha = Integration::where('title', 'Google Recaptcha')->first();
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $integationRecaptcha->secret,
            'response' => $request->input('recaptcha-response'),
        ]);
        $recaptchaContent = $response->json();
        if(!$recaptchaContent['success'] || $recaptchaContent['score'] <= 0.5) {
            return response()->json(['success' => false, 'message' => 'Falha na verificação do ReCAPTCHA']);
        }


        $page = Page::where('id', $request->page_id)->first();
        if (!$page){
            //return response()->json(['success' => false, 'message' => 'Falha ao enviar formulário, tente novamente', 'e' => 'Página não encontrada']);
        }

        DB::beginTransaction();
        try {
            //Verifica se existe conversões
            $utmSource = Cookie::get('utm_source');
            Cookie::queue(Cookie::forget('utm_source'));
            $utmMedium = Cookie::get('utm_medium');
            Cookie::queue(Cookie::forget('utm_medium'));
            $utmCampaign = Cookie::get('utm_campaign');
            Cookie::queue(Cookie::forget('utm_campaign'));
            //CRIA O TICKET
            $client = Client::create([
                'cpf_cnpj' => $request->cpf_cnpj,
                'name' => mb_convert_case($request->name . (isset($request->lastname) ? ' ' . $request->lastname : ''), MB_CASE_TITLE, "UTF-8"),
                'email' => $request->email,
                'phone' => preg_replace('/[^0-9]/', '', $request->phone),
                'is_member' => (isset($request->is_member) ? $request->is_member : null),
                'member_number' => (isset($request->member_number) ? $request->member_number : null),
                'office' => mb_convert_case($request->office, MB_CASE_TITLE, "UTF-8"),
                'company_name' => mb_convert_case($request->company_name, MB_CASE_TITLE, "UTF-8"),
                'quantity' => $request->quantity,
                'state' => $request->state,
                'city' => $request->city,
            ]);
            $ticket = Ticket::create([
                'type' => 'Fale Conosco',
                'title' => $request->subject ?? (env('APP_NAME') == 'Ultra Lims' ? 'Novo LEAD - Produto '.$page->title:'Novo Ticket'),
                'description' => $request->message ?? 'Contato',
                'client_id' => $client->id,
                'status' => 'open',
                'contact_by' => $request->contact_by ?? 'Site',
                'opened_by' => $request->opened_by ?? null,
                'utm_source' => $utmSource,
                'utm_medium' => $utmMedium,
                'utm_campaign' => $utmCampaign,
            ]);

            //ENVIA O E-MAIL DE CONTATO PARA O CLIENT
            $firstName = mb_convert_case(mb_strtolower(explode(' ', $ticket->client->name)[0], 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
            $data = [
                'to' => $ticket->client->email,
                'layout' => $request->layout,
                'subject' => 'Contato | '.env('APP_NAME'),
                'name' => $firstName, // Usando apenas o primeiro nome, com capitalização correta
                'cpf_cnpj' => $ticket->client->cpf_cnpj,
                'phone' => $request->phone,
                'email' => $ticket->client->email,
                'company_name' => $ticket->client->company_name,
                'office' => $ticket->client->office,
                'quantity' => $ticket->client->quantity,
                'is_member' => $ticket->client->is_member == 1 ? 'Sim':'Não',
                'member_number' => $ticket->client->member_number,
                'description' => $ticket->description,
                'state' => $ticket->client->state,
                'city' => $ticket->client->city,
                'type' => 'contato',
                'id' => $ticket->id,
                'created_at' => $ticket->created_at->format('d/m/Y H:i:s')
            ];
            //Envia o e-mail
            if (env('APP_NAME') != 'AABB-SP'){
                dispatch(new SendUserNotification($data));
            }

            //ENVIA O E-MAIL DE CONTATO PARA OS ATENDENTES
            if (env('APP_NAME') == 'Ultra Lims'){
                $subject = 'Novo LEAD'.($page ? ' Produto - '.$page->title : '');
            }elseif (env('APP_NAME') == 'AABB-SP'){
                $subject = 'SAC - AABB São Paulo';
            }else{
                $subject = 'Novo Ticket'.($page ? ' - '.$page->title : '');
            }
            $data['subject'] = $subject;
            $data['title'] = $subject;
            $data['name'] = $client->name;
            $data['type'] = 'ticket';
            $data['description'] = '<b>Assunto do Ticket:</b> '.$ticket->title.'
                    <b>Número do ticket:</b> #'.$ticket->id.'
                    <b>Mensagem do ticket:</b> '.$ticket->description;
            unset($data['layout']);
            foreach (User::where('status', true)->get() as $user){
                if ($user->email == 'admin@impetussistemas.com.br'){
                    continue;
                }
                if (!$user->hasPermissionTo('Ticket Admin')){
                    continue;
                }
                $data['to'] = $user->email;
                $data['url'] = $request->url;
                dispatch(new SendUserNotification($data));
            }

            SendEpicFlowMessage::dispatch($client->name, $page->title, $request->phone)->delay(now()->addMinute());
            if (env('APP_NAME') == 'Ultra Lims'){
                SendCrmContact::dispatch($client->name, $client->email, $client->phone, $client->office, $client->company_name, $page ? $page->title:null, $ticket->description);   
            }

            /*if (env('APP_NAME') == 'Ultra Lims'){
                try {
                    $integationJira = Integration::where('title', 'JIRA')->first();
                    $jira = new Jira($integationJira->url, $integationJira->token);
                    $jira->createIssue($data['description']);
                }catch (\Exception $e){

                }
            }*/

            $lgpd = new Lgpd();
            $lgpd->page_id = $request->page_id;
            $lgpd->type = 'form';
            $lgpd->name = $request->name.' '.$request->lastname;
            $lgpd->phone = preg_replace("/[^0-9]/", "", $request->phone);
            $lgpd->email = $request->email;
            $lgpd->ip = $request->ip();
            $lgpd->save();

            DB::commit();
            return response()->json(['success' => true]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Falha ao enviar formulário, tente novamente', 'e' => $e->getMessage()]);
        }
    }

    //REDIRECIONA PARA UMA PÁGINA DE OBRIGADO
    public function obrigado(){
        return view('site.pages.general.obrigado');
    }

    //REDIRECIONA PARA UMA PÁGINA DE OBRIGADO WPP
    public function wpp(){
        if (!isset($_GET['redirect']) || !isset($_GET['from'])){
            return redirect()->back();
        }
        return view('site.pages.general.obrigado-wpp');
    }

    //PEGA O IP DE QUEM PREENCHEU O FORMULÁRIO
    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return the server IP if the client IP is not found using this method.
    }
}

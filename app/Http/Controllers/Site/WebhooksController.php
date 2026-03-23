<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Articles\Article;
use App\Models\UltraLims\UL_Alert_Inmetro;
use App\Models\UltraLims\UL_User;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;

class WebhooksController extends Controller{
    //GERA ARTIGO COM OS DADOS RECEBIDOS DO WEBHOOK
    public function machined(Request $request, $appKey){
        //VALIDA SE O APP-KEY PASSADO É O MESMO DA APLICAÇÃO
        if (!$appKey || !hash_equals($appKey, str_replace('base64:', '', env('APP_KEY')))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        //VALIDA SE OS DADOS ESTÃO SENDO ENVIADOS CORRETAMENTE
        $validator = Validator::make($request->all(), [
            'article_title' => 'required',
            'article_slug' => 'required',
            'article_content_html' => 'required',
            'article_description' => 'required',
            'article_keyword' => 'required',
        ],[
            'article_title.required' => 'O título é obrigatório',
            'article_slug.required' => 'A slug é obrigatória',
            'article_content_html.required' => 'O conteúdo é obrigatório',
            'article_description.required' => 'A descrição é obrigatória',
            'article_keyword.required' => 'As palavras chaves são obrigatórias',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $user = User::where('email', 'admin@impetussistemas.com.br')->first();

        // Pega todos os dados da requisição
        $data = $request->all();
        // Log os dados no arquivo articles.log
        Log::channel('articles')->info('Received webhook data:', $data);

        // Cria um novo artigo com os dados recebidos
        Article::create([
           'title' => $data['article_title'],
           'slug' => $data['article_slug'],
           'content' => $data['article_content_html'],
           'status' => 'draft',
           'seo_title' => $data['article_title'],
           'seo_description' => $data['article_description'],
           'seo_keywords' => $data['article_keyword'],
           'edited_by' => $user->id,
           'version' => 1,
           'message' => '&nbsp;<span class="text-primary ps-3">v1</span>&nbsp;-&nbsp;<a href="'.route('admin.users.show', $user->hash_id).'" class="text-primary">'.$user->name.' '.$user->lastname.'</a><span class="text-gray-800">&nbsp;criou a publicação.</span>'
        ]);

        return response()->json(['message' => 'Data received and logged successfully'], 200);
    }

    //GERA ARTIGO COM OS DADOS RECEBIDOS DO RANKFIX
    public function rankfix(Request $request, $appKey){
        //VALIDA SE O APP-KEY PASSADO É O MESMO DA APLICAÇÃO
        if (!$appKey || !hash_equals($appKey, str_replace('base64:', '', env('APP_KEY')))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        //VALIDA SE OS DADOS ESTÃO SENDO ENVIADOS CORRETAMENTE
        $validator = Validator::make($request->all(), [
            'article_title' => 'required',
            'article_slug' => 'required',
            'article_content_html' => 'required',
            'article_description' => 'required',
            'article_keyword' => 'required',
        ],[
            'article_title.required' => 'O título é obrigatório',
            'article_slug.required' => 'A slug é obrigatória',
            'article_content_html.required' => 'O conteúdo é obrigatório',
            'article_description.required' => 'A descrição é obrigatória',
            'article_keyword.required' => 'As palavras chaves são obrigatórias',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $user = User::where('email', 'admin@impetussistemas.com.br')->first();

        // Pega todos os dados da requisição
        $data = $request->all();
        // Log os dados no arquivo articles.log
        Log::channel('articles')->info('Received webhook data:', $data);

        // Cria um novo artigo com os dados recebidos
        Article::create([
            'title' => $data['article_title'],
            'slug' => $data['article_slug'],
            'content' => $data['article_content_html'],
            'status' => 'draft',
            'seo_title' => $data['article_title'],
            'seo_description' => $data['article_description'],
            'seo_keywords' => $data['article_keyword'],
            'edited_by' => $user->id,
            'version' => 1,
            'message' => '&nbsp;<span class="text-primary ps-3">v1</span>&nbsp;-&nbsp;<a href="'.route('admin.users.show', $user->hash_id).'" class="text-primary">'.$user->name.' '.$user->lastname.'</a><span class="text-gray-800">&nbsp;criou a publicação.</span>'
        ]);

        return response()->json(['message' => 'Data received and logged successfully'], 200);
    }

    //REALIZA O LOGIN NA ULTRALIMS COM OS DADOS RECEBIDOS DO WEBHOOK
    public function login(Request $request, $appKey){
        //VALIDA SE O APP-KEY PASSADO É O MESMO DA APLICAÇÃO
        if (!$appKey || !hash_equals($appKey, str_replace('base64:', '', env('APP_KEY')))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        //VALIDA SE OS DADOS ESTÃO SENDO ENVIADOS CORRETAMENTE
        $validator = Validator::make($request->all(), [
            'idUser' => 'required',
            'user' => 'required',
            'email' => 'required',
            'tipoUser' => 'required',
            'idLaboratorio' => 'required',
            'laboratorio' => 'required',
            'urlRedirect' => 'required',
        ],[
            'idUser.required' => 'O id do usuário é obrigatório',
            'user.required' => 'O nome do usuário é obrigatório',
            'email.required' => 'O e-mail do usuário é obrigatório',
            'tipoUser.required' => 'O tipo do usuário é obrigatório',
            'idLaboratorio.required' => 'O id do laboratório é obrigatório',
            'laboratorio.required' => 'O nome do laboratório é obrigatório',
            'urlRedirect.required' => 'A url de redirecionamento é obrigatória',
        ]);
        if($validator->fails()){
            // Log dos dados no arquivo logins.log
            Log::channel('logins')->info('Error: '.$validator->errors()->first(), $request->all());
            return response()->json([
                'error' => $validator->errors()->first()
            ], 400);
        }

        try {
            // Pega todos os dados da requisição
            $data = $request->all();
            // Log dos dados no arquivo logins.log
            Log::channel('logins')->info('Received webhook data:', $data);

            // Verifica se o usuário já existe com os mesmos dados
            $user = UL_User::where('idUser', $data['idUser'])
                ->where('user', $data['user'])
                ->where('email', $data['email'])
                ->where('tipoUser', $data['tipoUser'])
                ->where('idLaboratorio', $data['idLaboratorio'])
                ->where('laboratorio', $data['laboratorio'])
                ->where('urlRedirect', $data['urlRedirect'])
                ->first();

            // Se não houver, cria um novo
            if (!$user) {
                $user = UL_User::create($data);
            }

            // Força o login do usuário usando o guard 'ultralims'
            //Auth::guard('ultralims')->login($user);

            return response()->json([
                'message' => 'Data received and logged successfully',
                'user' => $user,
                'url' => 'https://ultralims.com.br/cliente-ultra/'.Hashids::encode($user->id).'/login'
                //'url' => 'https://ultralims.com.br/cliente-ultra'
            ], 200);
        }catch (\Exception $e){
            // Log dos dados no arquivo logins.log
            Log::channel('logins')->info('Error: '.$e->getMessage(), $request->all());
            return response()->json([
                'message' => 'Error: '.$e->getMessage()
            ], 500);
        }
    }

    //CRIA O ALERTA PARA TODOS OS USUÁRIOS
    public function alert(Request $request, $appKey){
        //VALIDA SE O APP-KEY PASSADO É O MESMO DA APLICAÇÃO
        if (!$appKey || !hash_equals($appKey, str_replace('base64:', '', env('APP_KEY')))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        //VALIDA SE OS DADOS ESTÃO SENDO ENVIADOS CORRETAMENTE
        $validator = Validator::make($request->all(), [
            'alert' => 'required',
            'link' => 'required'
        ],[
            'alert.required' => 'O alerta é obrigatório',
            'link.required' => 'O link é obrigatório',
        ]);
        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()->first()
            ], 400);
        }

        try {
            // CRIA O ALERTA
            $alert = UL_Alert_Inmetro::create([
                'alert' => $request->alert,
                'link' => str_replace('amp;', '', $request->link),
            ]);

            // RECUPERA TODOS OS USUÁRIOS
            $users = UL_User::all();

            // ASSOCIA O ALERTA A TODOS OS USUÁRIOS SEM DEFINIR O read_at (deixa como NULL)
            foreach ($users as $user) {
                $alert->users()->attach($user->id, ['read_at' => null]);
            }

            return response()->json([
                'message' => 'Data received successfully',
            ], 200);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Error: '.$e->getMessage()
            ], 500);
        }
    }
}

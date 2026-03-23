<?php

namespace App\Http\Controllers\Auth;

use App\Mail\userNotificationsMail;
use App\Models\Auth\LoginCode;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
//use App\Mail\userNotificationsMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        if(Auth::check()){
            return redirect()->route('admin.index');
        }
        return view('auth.pages.login');
    }

    public function forgetPassword(Request $request){
        if($request->has('forget_password')){
            $user = User::where('email', $request->data)->orWhere('cpf', $request->data)->first();
            if($user){
                $token = Str::random(60);

                DB::table('password_resets')->where('email', $user->email)->delete();
                DB::table('password_resets')->insert([
                    'email' => $user->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);

                $data = [
                    'subject' => 'Duarte Pessoa Costa - Alteração de senha',
                    'name' => $user->name,
                    'email' => $user->email,
                    'title' => 'Alteração de senha',
                    'content' => 'Olá '.$user->name.', recebemos uma solicitação
                    para alterar a sua senha de acesso. Para continuar com o procedimento clique no botão abaixo
                    .',
                    'buttons' => [
                        [
                            'title' => 'Alterar senha',
                            'url' => route('auth.resetPassword', $token)
                        ]
                    ],
                    'footer' => 'Caso não tenha sido você, desconsidere este e-mail',
                    'footer_msg' => 'Duarte Pessoa Costa.'
                ];

                $this->sendmail($data);

                return response()->json(['success' => true, 'message' => 'Um email foi enviado para '.$user->email.' com as instruções para alterar a senha.']);

            }else{
                return response()->json(['success' => false, 'message' => 'Usuário não encontrado.']);
            }

            exit();
        }
        return view('auth.pages.forget-password');
    }

    public function resetPassword($token, Request $request){
        $token = DB::table('password_resets')->where('token', $token)->first();
        if($token){
            return view('auth.pages.reset-password', ['token' => $token]);
        }else{
            Session::flash('error', 'URL inválida ou expirada!');
            return redirect()->route('auth.forgetPassword');
        }
    }

    public function resetPasswordAction(Request $request){

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8'
        ],[
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.'
        ]);

        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $token = DB::table('password_resets')->where('token', $request->token)->first();
        if($token){
            $user = User::where('email', $token->email)->first();
            if($user){
                $user->password = Hash::make($request->password);
                $user->save();
                DB::table('password_resets')->where('email', $user->email)->delete();
                Session::flash('success', 'Senha alterada com sucesso!');
                return response()->json(['success' => true, 'redirectUrl' => route('auth.login')]);
            }else{
                Session::flash('error', 'Usuário não encontrado!');
                return response()->json(['success' => true, 'redirectUrl' => route('auth.forgetPassword')]);
            }
        }else{
            Session::flash('error', 'URL inválida ou expirada!');
            return response()->json(['success' => true, 'redirectUrl' => route('auth.forgetPassword')]);
        }
    }

    public function sendMail(array $data){
        Mail::send(new userNotificationsMail($data));
    }

    public function logout(){
        if(Auth::check()){
            Auth::logout();
            Session::regenerate();
            return redirect()->route('auth.login');
        }
    }

    public function makeLogin(Request $request)
    {
        $return = [
            'status' => null,
            'message' => null,
            'redirect' => null,
            'url' => null
        ];

        $validator = Validator::make([
            'email' => 'required|email',
            'password' => 'required'
        ],[
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'O campo email deve ser um email válido',
            'password.required' => 'A senha é obrigatória'
        ]);

        if($validator->fails()){
            $return['status'] = false;
            $return['message'] = $validator->errors()->first();
            return response()->json($return);
        }

        //if (auth()->attempt($request->only('email', 'password'), true)) {
        $user = User::where('email', $request->email)->where('status', 1)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)){
                /*$loginCode = LoginCode::create([
                    'user_id' => $user->id,
                    'code' => Hash::make(Carbon::now()),
                    'valid_until' => Carbon::now()->addMinutes(5)
                ]);
                $data = [
                    'subject' => 'FM2S - Código de segurança',
                    'name' => $user->name.' '.$user->lastname,
                    'email' => $user->email,
                    'title' => 'Código de segurança',
                    'content' => 'Olá '.$user->name.', para continuar com o acesso ao sistema, copie o código de autenticação abaixo e cole no campo para realizar o login.',
                    'code' => $loginCode->code,
                    'footer' => 'Caso não tenha sido você, entre em contato com o suporte.',
                    'footer_msg' => 'Impetus Sitemas'
                ];
                $this->sendmail($data);
                */
                if ($user->google2fa_secret == null){
                    auth()->attempt($request->only('email', 'password'), true);
                    $return['status'] = 'success';
                    $return['url'] = route('admin.index');
                    $return['redirect'] = true;
                }else{
                    $return['status'] = 'success';
                    $return['redirect'] = false;
                }
            }else{
                $return['status'] = false;
                $return['message'] = 'Senha incorreta';
                return response()->json($return);
            }
        }else{
            $return['status'] = false;
            $return['message'] = 'E-mail incorreto';
            return response()->json($return);
        }

        return response()->json($return);
    }

    public function makeLoginCode(Request $request)
    {
        $return = [
            'status' => null,
            'message' => null,
            'redirect' => null,
            'url' => null
        ];

        $validator = Validator::make([
            'email' => 'required|email',
            'password' => 'required',
            'code' => 'required'
        ], [
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'O campo email deve ser um email válido',
            'password.required' => 'A senha é obrigatória',
            'code.required' => 'O código de segurança é obrigatório'
        ]);

        if ($validator->fails()) {
            $return['status'] = false;
            $return['message'] = $validator->errors()->first();
            return response()->json($return);
        }

        $user = User::where('email', $request->email)->where('status', 1)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)){
                try {
                    $google2fa = new Google2FA();
                    if ($google2fa->verifyKey($user->google2fa_secret, $request->code)) {
                        auth()->attempt($request->only('email', 'password'), true);
                        $return['status'] = true;
                        $return['url'] = route('admin.index');
                    }else{
                        if(Auth::check()) {
                            Auth::logout();
                            Session::regenerate();
                        }
                        $return['status'] = false;
                        $return['message'] = 'Código de segurança incorreto';
                        return response()->json($return);
                    }
                }catch (\Exception $e){
                    $return['status'] = false;
                    $return['message'] = 'Código de segurança incorreto';
                    return response()->json($return);
                }

                /*$loginCode = LoginCode::where('user_id', $user->id)->where('code', $request->code)->first();
                if ($loginCode){
                    if ($loginCode->valid_until >= Carbon::now()){
                        auth()->attempt($request->only('email', 'password'), true);
                        $return['status'] = true;
                        $return['url'] = route('admin.index');
                    }else{
                        $return['status'] = false;
                        $return['message'] = 'Código de segurança expirado';
                        return response()->json($return);
                    }
                }else{
                    $return['status'] = false;
                    $return['message'] = 'Código de segurança incorreto';
                    return response()->json($return);
                }*/
            }else{
                $return['status'] = false;
                $return['message'] = 'Senha incorreta';
                return response()->json($return);
            }
        }else{
            $return['status'] = false;
            $return['message'] = 'E-mail incorreto';
            return response()->json($return);
        }

        return response()->json($return);
    }
}

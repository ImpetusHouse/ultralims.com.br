<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\File\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $title = "Dashboard";
        $data = [
            'title' => $title
        ];
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('admin.index')],
        ];

        try {
            $apiBlogs = Http::get('https://impetus.nucleonerd.com.br/api/blogs/');
//            $apiBlogs = Http::get('http://127.0.0.1:8001/api/blogs/');
            $arrayBlogs = $apiBlogs->json();
        } catch (\Illuminate\Http\Client\ConnectionException $e){
            $arrayBlogs = [];
        }

        return view('admin.pages.dashboard', compact('title', 'data', 'breadcrumbs'))
            ->with('arrayBlogs', $arrayBlogs);
    }

    public function imageUpload(Request $request){

        $originName = $request->file('upload')->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);

        $extension = $request->file('upload')->getClientOriginalExtension();

        $fileName = md5($fileName).'_'.time().'.'.$extension;

        $request->file('upload')->move('images/gallery', $fileName);

        $url = asset('images/gallery/'.$fileName);

        return response()->json(['uploaded' => true, 'url' => $url]);
    }

    public function index(){
        if(Auth::user()->can('Usuários')) {
            $users = User::orderBy('name')->orderBy('lastname')->get();
            $title = "Usuários";
            $breadcrumbs = [
                ['title' => 'Usuários', 'url' => route('admin.users.index')]
            ];
            $data = [
                'title' => $title,
                'breadcrumbs' => $breadcrumbs,
                'users' => $users
            ];
            return view('admin.pages.users.index', $data);
        }else{
            return redirect()->route('admin.index');
        }
    }

    public function show(User $user){
        if ($user->email == 'admin@impetussistemas.com.br' && $user->email != Auth::user()->email){
            return redirect()->route('admin.index');
        }
        if(Auth::user()->can('Usuários')){
            $title = "Visualizar usuário";
            $breadcrumbs = [
                ['title' => 'Usuários', 'url' => route('admin.users.index')],
                ['title' => 'Visualizar usuário', 'url' => route('admin.users.show', $user->hash_id)],
            ];
        }else{
            if ($user->id != Auth::user()->id){
                return redirect()->route('admin.index');
            }
            $title = "Meu perfil";
            $breadcrumbs = [
                ['title' => 'Meu perfil', 'url' => route('admin.users.show', $user->hash_id)],
            ];
        }
        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'user' => $user,
            'page' => 'show'
        ];
        return view('admin.pages.users.show', $data);
    }

    public function create()
    {
        if(Auth::user()->can('Usuários')) {
            $user = new User();
            $title = "Inserir usuário";
            $breadcrumbs = [
                ['title' => 'Usuários', 'url' => route('admin.users.index')],
                ['title' => 'Inserir usuário', 'url' => route('admin.users.create')],
            ];
            $data = [
                'title' => $title,
                'breadcrumbs' => $breadcrumbs,
                'user' => $user,
                'page' => 'form'
            ];

            return view('admin.pages.users.form', $data);
        }else{
            return redirect()->route('admin.index');
        }
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('Usuários')) {
            return $this->save(new User(), $request, 'store');
        }else{
            return redirect()->route('admin.index');
        }
    }

    public function edit(User $user)
    {
        if ($user->email == 'admin@impetussistemas.com.br' && $user->email != Auth::user()->email){
            return redirect()->route('admin.index');
        }
        if(Auth::user()->can('Usuários')){
            $title = "Editar usuário";
            $breadcrumbs = [
                ['title' => 'Usuários', 'url' => route('admin.users.index')],
                ['title' => 'Editar usuário', 'url' => route('admin.users.edit', $user->hash_id)],
            ];
        }else{
            if ($user->id != Auth::user()->id){
                return redirect()->route('admin.index');
            }
            $title = "Editar perfil";
            $breadcrumbs = [
                ['title' => 'Editar perfil', 'url' => route('admin.users.edit', $user->hash_id)],
            ];
        }
        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'user' => $user,
            'page' => 'form'
        ];
        return view('admin.pages.users.form', $data);
    }

    public function update(Request $request, User $user){
        return $this->save($user, $request, 'edit');
    }

    public function save($user, $request, $action){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'lastname' => 'required',
            'description' => 'required',
            'email' => 'bail|required|unique:users,email,'.$user->id,
            'access_type' => 'required'
        ],[
            'name.required' => 'O nome é obrigatório!',
            'lastname.required' => 'O sobrenome é obrigatório!',
            'description.required' => 'A descrição é obrigatória!',
            'email.required' => 'O e-mail é obrigatório!',
            'email.unique' => 'O e-mail já está sendo utilizado!',
            'access_type.required' => 'A permissão de acesso é obrigatória!'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        if (Auth::user()->can('Usuários')){
            $validator = Validator::make($request->all(), [
                'status' => 'required'
            ],[
                'status.required' => 'O status é obrigatório!'
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($action == 'store'){
            $validator = Validator::make($request->all(), [
                'password' => 'required',
                'confirm_password' => 'required',
            ],[
                'password.required' => 'A senha é obrigatória!',
                'confirm_password.required' => 'A confirmação de senha é obrigatória!',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            if($request->password != $request->confirm_password){
                return response()->json(['success' => false, 'message' => 'As senhas digitadas não coincidem!']);
            }
        }else{
            if (isset($request->password)){
                $validator = Validator::make($request->all(), [
                    'confirm_password' => 'required'
                ],[
                    'confirm_password.required' => 'A confirmação de senha é obrigatória!'
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if($request->password != $request->confirm_password){
                    return response()->json(['success' => false, 'message' => 'As senhas digitadas não coincidem!']);
                }
            }
        }

        //$storage_service = new \App\Services\StorageService();

        DB::beginTransaction();
        try{
            if($request->has('_profile')){
                $base64_image = $request->input('_profile'); // your base64 encoded
                @list($type, $file_data) = explode(';', $base64_image);
                @list(, $file_data) = explode(',', $file_data);

                $imageName = md5(date('dmYHis')).'.'.'png';
                $folder = 'public/users/photos';
                $path = $folder.'/'.$imageName;
                Storage::put($path, base64_decode($file_data));

                // decode the base64 file
                $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_image));
                // save it to temporary dir first.
                $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
                file_put_contents($tmpFilePath, $fileData);
                // this just to help us get file info.
                $tmpFile = new File($tmpFilePath);
                $file = new UploadedFile(
                    $tmpFile->getPathname(),
                    $tmpFile->getFilename(),
                    $tmpFile->getMimeType(),
                    0,
                    false // Mark it as test, since the file isn't from real HTTP POST.
                );
                //$storage_service->saveAwsFile('storage/users/photos', $file, $imageName);
            }else{
                $path = $user->photo;
            }

            if (strlen($request->password) > 0){
                $password = Hash::make($request->password);
            }else{
                $password = $user->password;
            }

            $user->fill($request->input());
            $user->photo = $path;
            $user->password = $password;
            $user->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Usuário '.($action == 'store' ? 'inserido':'editado').' com sucesso!'
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao '.($action == 'store' ? 'salvar':'editar').' usuário!' . $e->getMessage(),
            ]);
        }
    }

    public function destroy(User $user){
        if ($user->email == 'admin@impetussistemas.com.br' && $user->email != Auth::user()->email){
            return redirect()->route('admin.index');
        }
        if(Auth::user()->can('Usuários')) {
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'Usuário removido com sucesso!'
            ]);
        }else{
            return redirect()->route('admin.index');
        }
    }

    public function permissions(User $user){
        if ($user->email == 'admin@impetussistemas.com.br' && $user->email != Auth::user()->email){
            return redirect()->route('admin.index');
        }
        $roles = Role::orderByRaw("FIELD(name, 'Super-Admin', 'Ações rápidas', 'Publicações', 'Páginas', 'Geral', 'Tickets', 'III', 'Ultra Lims') ASC")->get();
        $title = "Visualizar permissões";
        $breadcrumbs = [
            ['title' => 'Usuários', 'url' => route('admin.users.index')],
            ['title' => 'Visualizar permissões', 'url' => route('admin.users.permissions', $user->hash_id)],
        ];
        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'user' => $user,
            'roles' => $roles,
            'page' => 'permissions'
        ];

        return view('admin.pages.users.permissions', $data);
    }

    public function permissionsSave(User $user, Request $request){
        if ($user->email == 'admin@impetussistemas.com.br' && $user->email != Auth::user()->email){
            return redirect()->route('admin.index');
        }
        if(Auth::user()->can('Usuários')) {
            DB::beginTransaction();
            try{
                //Super Admin
                $superAdmin = null;
                if (isset($request->super_admin)){
                    $superAdmin = 'Super-Admin';
                }
                $user->syncRoles($superAdmin);
                //Permissões
                $permissions = null;
                if (isset($request->permissions_id)){
                    $permissions = Permission::whereIn('id', $request->permissions_id)->get();
                }
                $user->syncPermissions($permissions);
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Permissões do usuário editadas com sucesso!'
                ]);
            }catch(\Exception $e){
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao editar permissões do usuário!' . $e->getMessage(),
                ]);
            }
        }else{
            return redirect()->route('admin.index');
        }
    }

    public function logs(User $user){
        if ($user->email == 'admin@impetussistemas.com.br' && $user->email != Auth::user()->email){
            return redirect()->route('admin.index');
        }

        $title = "Visualizar logs";
        $breadcrumbs = [
            ['title' => 'Usuários', 'url' => route('admin.users.index')],
            ['title' => 'Visualizar logs', 'url' => route('admin.users.logs', $user->hash_id)],
        ];
        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'user' => $user,
            'page' => 'logs'
        ];

        return view('admin.pages.users.logs', $data);
    }

    public function qrCode(User $user){
        if ($user->email != Auth::user()->email){
            return [
               'success' => false
            ];
        }
        DB::beginTransaction();
        try {
            // Initialise the 2FA class
            $google2fa = new Google2FA();
            // Add the secret key to the user model
            $google2fa_secret = $google2fa->generateSecretKey();
            $user->google2fa_secret = $google2fa_secret;
            $user->save();
            // Generate the QR image. This is the image the user will scan with their app to set up two factor authentication
            $QR_Image = $google2fa->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $google2fa_secret
            );
            DB::commit();
            return [
                'success' => true,
                'qrCode' => QrCode::size(250)->margin(0)->generate($QR_Image)
            ];
        }catch (\Exception $e){
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function removeQrCode(User $user){
        if ($user->email != Auth::user()->email){
            if (Auth::user()->hasRole('Super-Admin')){
                return [
                    'success' => false
                ];
            }
        }
        DB::beginTransaction();
        try {
            $user->google2fa_secret = null;
            $user->save();
            DB::commit();
            return [
                'success' => true
            ];
        }catch (\Exception $e){
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}

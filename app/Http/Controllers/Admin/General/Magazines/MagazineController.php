<?php

namespace App\Http\Controllers\Admin\General\Magazines;

use App\Http\Controllers\Controller;
use App\Models\General\Magazines\Magazine;
use Buglinjo\LaravelWebp\Webp;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class MagazineController extends Controller{
    public function index(){
        $title = 'Revistas';
        $breadcrumbs = [
            ['url' => route('admin.magazines.index'), 'title' => $title],
        ];
        $magazines = Magazine::orderBy('title')->get();
        return view('admin.pages.general.magazines.list', compact('title', 'breadcrumbs', 'magazines'));
    }

    public function create(){
        $title = 'Criar revista';
        $breadcrumbs = [
            ['url' => route('admin.magazines.index'), 'title' => 'Revistas'],
            ['url' => route('admin.magazines.create'), 'title' => $title],
        ];
        $magazine = new Magazine();
        return view('admin.pages.general.magazines.form', compact('title', 'breadcrumbs', 'magazine'));
    }

    public function store(Request $request){
        return $this->save($request, new Magazine(), 'store');
    }

    public function edit(Magazine $magazine){
        $title = 'Editar revista';
        $breadcrumbs = [
            ['url' => route('admin.magazines.index'), 'title' => 'Revistas'],
            ['url' => route('admin.magazines.edit', $magazine->hash_id), 'title' => $title],
        ];
        return view('admin.pages.general.magazines.form', compact('title', 'breadcrumbs', 'magazine'));
    }

    public function update(Request $request, Magazine $magazine){
        return $this->save($request, $magazine, 'update');
    }

    public function destroy(Magazine $magazine){
        $magazine->delete();
        return response()->json([
            'success' => true,
            'message' => 'Revista excluído com sucesso',
        ]);
    }

    public function save($request, $magazine, $action){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required',
        ],[
            'title.required' => 'O título é obrigatório',
            'status.required' => 'O status é obrigatório',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        if ($magazine->id == null){
            $validator = Validator::make($request->all(), [
                'pdf' => 'required'
            ],[
                'pdf.required' => 'A foto é obrigatória'
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }
        DB::beginTransaction();
        try{
            if ($request->has('pdf')){
                $directory = '/revistas';
                // Verifica se a pasta já existe, se não, cria com permissão 755
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory, 0755, true);
                }

                $file = $request->file('pdf');
                $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . date('Ymd_His');
                $extension = $file->getClientOriginalExtension();
                $magazine->pdf = 'storage/'.$file->storeAs($directory, $filename . '.' . $extension, 'public');
            }

            $path = null;
            if($request->has('imagem') && strlen($request->imagem) > 0 && $request->imagem != str_replace('public/', 'storage/', asset($magazine->photo)) && $request->imagem != 'null'){
                $base64_image = $request->input('imagem'); // your base64 encoded

                $folder = 'storage/revistas';
                $path = $folder.'/'.Str::slug($request->title).'.webp';

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
                $webp = Webp::make($file);
                $webp->save(public_path($path), 100);

                //$storage_service->saveAwsFile($folder, $file, Str::slug($request->client).'.webp');
                $path = str_replace('storage/', 'public/', $path);
            }

            $magazine->fill($request->input());
            if ($path != null){
                $magazine->photo = $path;
            }elseif($request->imagem == 'null'){
                $magazine->photo = null;
            }
            $magazine->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Revista '.($action == 'store' ? 'criada':'editada').' com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." a revista",
                'e' => $e->getMessage()
            ]);
        }
    }
}

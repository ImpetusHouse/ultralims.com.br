<?php

namespace App\Http\Controllers\Admin\General\Alerts;

use App\Http\Controllers\Controller;
use App\Models\General\Alerts\Alert;
use App\Models\General\Galleries\Gallery;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\File\File;
use Buglinjo\LaravelWebp\Webp;

class AlertController extends Controller{
    public function index(){
        $title = 'Comunicados';
        $breadcrumbs = [
            ['url' => route('admin.alerts.index'), 'title' => $title],
        ];
        $alerts = Alert::orderBy('title')->get();
        return view('admin.pages.general.alerts.list', compact('title', 'breadcrumbs', 'alerts'));
    }

    public function create(){
        $title = 'Criar comunicado';
        $breadcrumbs = [
            ['url' => route('admin.alerts.index'), 'title' => 'Comunicados'],
            ['url' => route('admin.alerts.create'), 'title' => $title],
        ];
        $alert = new Alert();
        $galleries = Gallery::orderBy('title')->get();
        return view('admin.pages.general.alerts.form', compact('title', 'breadcrumbs', 'alert', 'galleries'));
    }

    public function store(Request $request){
        return $this->save($request, new Alert(), 'store');
    }

    public function edit(Alert $alert){
        $title = 'Editar comunicado';
        $breadcrumbs = [
            ['url' => route('admin.alerts.index'), 'title' => 'Comunicados'],
            ['url' => route('admin.alerts.edit', $alert->hash_id), 'title' => $title],
        ];
        $galleries = Gallery::orderBy('title')->get();
        return view('admin.pages.general.alerts.form', compact('title', 'breadcrumbs', 'alert', 'galleries'));
    }

    public function update(Request $request, Alert $alert){
        return $this->save($request, $alert, 'update');
    }

    public function destroy(Alert $alert){
        DB::beginTransaction();
        try {
            $alert->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Comunicado excluído com sucesso',
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => true,
                'message' => 'Falha ao excluir comunicado, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    public function save($request, $alert, $action){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'status' => 'required',
        ],[
            'title.required' => 'O título é obrigatório',
            'slug.required' => 'O slug é obrigatório',
            'description.required' => 'A descrição é obrigatória',
            'status.required' => 'O status é obrigatório'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try{
            $path = null;
            if($request->has('imagem') && strlen($request->imagem) > 0 && $request->imagem != str_replace('public/', 'storage/', asset($alert->photo)) && $request->imagem != 'null'){
                $base64_image = $request->input('imagem'); // your base64 encoded

                $folder = 'storage/comunicados';
                $path = $folder.'/'.Str::slug($request->slug).'.webp';

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

            $alert->fill($request->input());
            if ($path != null){
                $alert->photo = $path;
            }elseif($request->imagem == 'null'){
                $alert->photo = null;
            }
            if ($action == 'store'){
                $alert->display_order = Alert::max('display_order') + 1;
            }
            $alert->save();

            if(!empty($request->galleries) or $request->galleries != null){
                $galleries = $request->galleries;
                //Save categories pivot
                $alert->galleries()->sync($galleries);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Comunicado '.($action == 'store' ? 'criado':'editado').' com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." o comunicado, tente novamente",
                'e' => $e->getMessage()
            ]);
        }
    }

    public function getSlug(Request $request){
        $slug = Str::slug($request->title);
        $alert = Alert::where('slug', $slug)->first();
        if(!$alert){
            return response()->json([
                'success' => true,
                'slug' => $slug,
            ]);
        }
        return response()->json([
            'success' => false,
            'suggestion' => date('d-m-Y-H-i').'-'.$slug,
        ]);
    }

    public function order($type){
        if ($type == 'alerts'){
            $items = Alert::orderBy('display_order')->get();
        }else{
            return response()->json([
                'sucess' => false,
                'message' => 'Tipo de ordenação inválida, tente novamente'
            ]);
        }
        return response()->json([
            'success' => true,
            'items' => $items,
        ]);
    }

    public function orderType($type, $id){
        if ($type == 'alerts'){
            $items = Alert::orderBy('display_order')->get();
        }else{
            return response()->json([
                'sucess' => false,
                'message' => 'Tipo de ordenação inválida, tente novamente'
            ]);
        }
        return response()->json([
            'success' => true,
            'items' => $items,
        ]);
    }

    public function saveOrder(Request $request, $type, $id){
        $i = 1;
        if ($type == 'alerts'){
            foreach ($request->items as $item){
                $alert = Alert::where('id', $item)->first();
                $alert->display_order = $i;
                $alert->save();
                $i++;
            }
        }else{
            return response()->json([
                'sucess' => false,
                'message' => 'Tipo de ordenação inválida, tente novamente'
            ]);
        }
        return response()->json(['success' => true]);
    }
}

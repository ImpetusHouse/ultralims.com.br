<?php

namespace App\Http\Controllers\Admin\General\Events;

use App\Http\Controllers\Controller;
use App\Models\General\Events\Event;
use App\Models\Pages\Page;
use Buglinjo\LaravelWebp\Webp;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class EventController extends Controller{
    public function index(){
        $title = 'Eventos';
        $breadcrumbs = [
            ['url' => route('admin.events.index'), 'title' => $title],
        ];
        $events = Event::orderBy('title')->get();
        return view('admin.pages.general.events.list', compact('title', 'breadcrumbs', 'events'));
    }

    public function create(){
        $title = 'Criar evento';
        $breadcrumbs = [
            ['url' => route('admin.events.index'), 'title' => 'Eventos'],
            ['url' => route('admin.events.create'), 'title' => $title],
        ];
        $event = new Event();
        $pages = Page::orderBy('title')->get();
        return view('admin.pages.general.events.form', compact('title', 'breadcrumbs', 'event', 'pages'));
    }

    public function store(Request $request){
        return $this->save($request, new Event(), 'store');
    }

    public function edit(Event $event){
        $title = 'Editar evento';
        $breadcrumbs = [
            ['url' => route('admin.events.index'), 'title' => 'Eventos'],
            ['url' => route('admin.events.edit', $event->hash_id), 'title' => $title],
        ];
        $pages = Page::orderBy('title')->get();
        return view('admin.pages.general.events.form', compact('title', 'breadcrumbs', 'event', 'pages'));
    }

    public function update(Request $request, Event $event){
        return $this->save($request, $event, 'update');
    }

    public function destroy(Event $event){
        $event->delete();
        return response()->json([
            'success' => true,
            'message' => 'Evento excluído com sucesso',
        ]);
    }

    public function save($request, $event, $action){
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'title' => 'required',
            'slug' => 'required',
            'content' => 'required',
            'status' => 'required',
        ],[
            'date.required' => 'A data é obrigatória',
            'title.required' => 'O título é obrigatório',
            'slug.required' => 'O slug é obrigatório',
            'content.required' => 'O conteúdo é obrigatório',
            'status.required' => 'O status é obrigatório'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        if ($event->id == null){
            $validator = Validator::make($request->all(), [
                'photo_square' => 'required'
            ],[
                'photo_square.required' => 'A foto é obrigatória'
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }
        //Caso esteja marcado para exibir o botão, executa algumas validações
        if (isset($request->button_display)){
            $validator = Validator::make($request->all(), [
                'button_title' => 'required',
                'button_type' => 'required',
            ],[
                'button_title.required' => 'O título do botão é obrigatório',
                'button_type.required' => 'O destino do botão é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            //Casso esteja marcado para redirecionar para página interna
            if ($request->button_type == 'inner_page'){
                $validator = Validator::make($request->all(), [
                    'button_pagina' => 'required',
                ],[
                    'button_pagina.required' => 'A página do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }

                $event->button_type = 'inner_page';
                $event->button_link = $request->button_pagina;
            }
            //Caso esteja marcado para redirecionar para uma URL
            if ($request->button_type == 'link'){
                $validator = Validator::make($request->all(), [
                    'button_url' => 'required',
                ],[
                    'button_url.required' => 'O link do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }

                $event->button_type = 'link';
                $event->button_link = $request->button_url;
            }
        }
        DB::beginTransaction();
        try{
            if ($request->has('photo_square')){
                $directory = '/eventos';
                // Verifica se a pasta já existe, se não, cria com permissão 755
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory, 0755, true);
                }

                $file = $request->file('photo_square');
                $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . date('Ymd_His');
                $extension = $file->getClientOriginalExtension();
                $event->photo_square = 'storage/'.$file->storeAs($directory, $filename . '.' . $extension, 'public');
            }

            $path = null;
            if($request->has('imagem') && strlen($request->imagem) > 0 && $request->imagem != str_replace('public/', 'storage/', asset($event->photo)) && $request->imagem != 'null'){
                $base64_image = $request->input('imagem'); // your base64 encoded

                $folder = 'storage/eventos';
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

            $event->fill($request->input());
            if ($path != null){
                $event->photo = $path;
            }elseif($request->imagem == 'null'){
                $event->photo = null;
            }
            $event->button_display = true;
            if ($action == 'store'){
                $event->display_order = Event::max('display_order') + 1;
            }
            $event->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Evento '.($action == 'store' ? 'criado':'editado').' com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." o evento",
                'e' => $e->getMessage()
            ]);
        }
    }

    public function getSlug(Request $request){
        $slug = Str::slug($request->title);
        $event = Event::where('slug', $slug)->first();
        if(!$event){
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
        if ($type == 'events'){
            $items = Event::orderBy('display_order')->get();
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
        if ($type == 'events'){
            $items = Event::orderBy('display_order')->get();
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
        if ($type == 'events'){
            foreach ($request->items as $item){
                $event = Event::where('id', $item)->first();
                $event->display_order = $i;
                $event->save();
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

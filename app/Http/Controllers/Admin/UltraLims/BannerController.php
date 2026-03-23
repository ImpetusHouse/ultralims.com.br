<?php

namespace App\Http\Controllers\Admin\UltraLims;

use App\Http\Controllers\Controller;
use App\Models\Pages\Page;
use App\Models\Settings\Color;
use App\Models\UltraLims\Banner;
use Buglinjo\LaravelWebp\Webp;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class BannerController extends Controller {
    public function index(){
        $title = 'Banners';
        $breadcrumbs = [
            ['url' => route('admin.banners.index'), 'title' => $title],
        ];
        $banners = Banner::orderBy('title')->get();
        return view('admin.pages.ultralims.banners.list', compact('title', 'breadcrumbs', 'banners'));
    }

    public function create(){
        $title = 'Criar banner';
        $breadcrumbs = [
            ['url' => route('admin.banners.index'), 'title' => 'Eventos'],
            ['url' => route('admin.banners.create'), 'title' => $title],
        ];
        $banner = new Banner();
        $pages = Page::orderBy('title')->get();
        $colors = Color::all();
        return view('admin.pages.ultralims.banners.form', compact('title', 'breadcrumbs', 'banner', 'pages', 'colors'));
    }

    public function store(Request $request){
        return $this->save($request, new Banner(), 'store');
    }

    public function edit(Banner $banner){
        $title = 'Editar banner';
        $breadcrumbs = [
            ['url' => route('admin.banners.index'), 'title' => 'Banners'],
            ['url' => route('admin.banners.edit', $banner->hash_id), 'title' => $title],
        ];
        $pages = Page::orderBy('title')->get();
        $colors = Color::all();
        return view('admin.pages.ultralims.banners.form', compact('title', 'breadcrumbs', 'banner', 'pages', 'colors'));
    }

    public function update(Request $request, Banner $banner){
        return $this->save($request, $banner, 'update');
    }

    public function destroy(Banner $banner){
        $banner->delete();
        return response()->json([
            'success' => true,
            'message' => 'Banner excluído com sucesso',
        ]);
    }

    public function save($request, $banner, $action){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ],[
            'title.required' => 'O título é obrigatório',
            'description.required' => 'A descrição é obrigatória',
            'status.required' => 'O status é obrigatório'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
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

                $banner->button_type = 'inner_page';
                $banner->button_link = $request->button_pagina;
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

                $banner->button_type = 'link';
                $banner->button_link = $request->button_url;
            }
        }

        DB::beginTransaction();
        try{
            $path = null;
            if($request->has('imagem') && strlen($request->imagem) > 0 && $request->imagem != str_replace('public/', 'storage/', asset($banner->image)) && $request->imagem != 'null'){
                $base64_image = $request->input('imagem'); // your base64 encoded

                $folder = 'storage/ultralims/banners';
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

            $banner->fill($request->input());

            if ($path != null){
                $banner->image = $path;
            }elseif($request->imagem == 'null'){
                $banner->image = null;
            }

            $banner->button_display = isset($request->button_display);

            if ($action == 'store'){
                $banner->display_order = Banner::max('display_order') + 1;
            }

            $banner->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Banner '.($action == 'store' ? 'criado':'editado').' com sucesso',
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

    public function order($type){
        if ($type == 'banners'){
            $items = Banner::orderBy('display_order')->get();
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
        if ($type == 'banners'){
            $items = Banner::orderBy('display_order')->get();
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
        if ($type == 'banners'){
            foreach ($request->items as $item){
                $banner = Banner::where('id', $item)->first();
                $banner->display_order = $i;
                $banner->save();
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

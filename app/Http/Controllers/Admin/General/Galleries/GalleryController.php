<?php

namespace App\Http\Controllers\Admin\General\Galleries;

use App\Http\Controllers\Controller;
use App\Models\General\Galleries\Gallery;
use App\Models\General\Galleries\Photo;
use Buglinjo\LaravelWebp\Webp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GalleryController extends Controller{
    public function index(){
        $title = 'Galerias';
        $breadcrumbs = [
            ['url' => route('admin.galleries.index'), 'title' => $title],
        ];
        $galleries = Gallery::orderBy('title')->get();
        return view('admin.pages.general.galleries.list', compact('title', 'breadcrumbs', 'galleries'));
    }

    public function create(){
        $title = 'Criar galeria';
        $breadcrumbs = [
            ['url' => route('admin.galleries.index'), 'title' => 'Galerias'],
            ['url' => route('admin.galleries.create'), 'title' => $title],
        ];
        $gallery = new Gallery();
        return view('admin.pages.general.galleries.form', compact('title', 'breadcrumbs', 'gallery'));
    }

    public function store(Request $request){
        return $this->save($request, new Gallery(), 'store');
    }

    public function edit(Gallery $gallery){
        $title = 'Editar galeria';
        $breadcrumbs = [
            ['url' => route('admin.galleries.index'), 'title' => 'Galerias'],
            ['url' => route('admin.galleries.edit', $gallery->hash_id), 'title' => $title],
        ];
        return view('admin.pages.general.galleries.form', compact('title', 'breadcrumbs', 'gallery'));
    }

    public function update(Request $request, Gallery $gallery){
        return $this->save($request, $gallery, 'update');
    }

    public function destroy(Gallery $gallery){
        $gallery->delete();
        return response()->json([
            'success' => true,
            'message' => 'Galeria de fotos excluída com sucesso',
        ]);
    }

    public function save($request, $gallery, $action){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required',
            'status' => 'required',
            'date' => 'required',
        ],[
            'title.required' => 'O título é obrigatório',
            'slug.required' => 'A slug é obrigatória',
            'status.required' => 'O status é obrigatório',
            'date.required' => 'A data da galeria é obrigatória',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try{
            $gallery->fill($request->input());
            $gallery->save();

            if (isset($request->photos)){
                foreach ($request->photos as $photo){
                    $folder = 'storage/galerias/' . $gallery->hash_id;
                    $path = $folder . '/' . Str::slug(pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . date('Ymd_His') . '.webp';

                    if (!file_exists($folder)) {
                        File::makeDirectory(public_path($folder));
                    }

                    $webp = Webp::make($photo);
                    $webp->save(public_path($path), 100);
                    $path = str_replace('storage/', 'public/', $path);

                    Photo::create([
                        'gallery_id' => $gallery->id,
                        'path' => $path
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Galeria de fotos '.($action == 'store' ? 'criada':'editada').' com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." galeria de fotos",
                'e' => $e->getMessage()
            ]);
        }

    }

    public function getSlug(Request $request){
        $slug = Str::slug($request->title);
        $gallery = Gallery::where('slug', $slug)->first();
        if(!$gallery){
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
}

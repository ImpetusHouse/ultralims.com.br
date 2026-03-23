<?php

namespace App\Http\Controllers\Admin\General\Testimonials;

use App\Http\Controllers\Controller;
use App\Models\General\Testimonials\Testimonial;
use App\Models\General\Testimonials\Category;
use Buglinjo\LaravelWebp\Webp;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class TestimonialController extends Controller
{
    public function index()
    {
        $title = 'Depoimentos';
        $breadcrumbs = [
            ['url' => route('admin.testimonials.index'), 'title' => 'Depoimentos'],
        ];
        $testimonials = Testimonial::all();
        return view('admin.pages.general.testimonials.list', compact('title', 'breadcrumbs', 'testimonials'));
    }

    public function create()
    {
        $title = 'Criar depoimento';
        $breadcrumbs = [
            ['url' => route('admin.testimonials.index'), 'title' => 'Depoimentos'],
            ['url' => route('admin.testimonials.create'), 'title' => 'Criar depoimento'],
        ];
        $testimonial = new Testimonial();
        $categories = Category::orderBy('title')->get();
        return view('admin.pages.general.testimonials.form', compact('title', 'breadcrumbs', 'testimonial', 'categories'));
    }

    public function store(Request $request)
    {
        $testimonial = new Testimonial();
        $json = $this->save($request, $testimonial, 'store');
        return $json;
    }

    public function edit(Testimonial $testimonial)
    {
        $title = 'Editar depoimento';
        $breadcrumbs = [
            ['url' => route('admin.testimonials.index'), 'title' => 'Depoimentos'],
            ['url' => route('admin.testimonials.edit', $testimonial->hash_id), 'title' => 'Editar depoimento'],
        ];

        $testimonial->url = asset(str_replace('public/', 'storage/', $testimonial->path));
        $categories = Category::orderBy('title')->get();
        return view('admin.pages.general.testimonials.form', compact('title', 'breadcrumbs', 'testimonial', 'categories'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $json = $this->save($request, $testimonial, 'update');
        return $json;
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return response()->json([
            'success' => true,
            'message' => 'Depoimento excluído com sucesso',
        ]);
    }

    public function save($request, $testimonial, $action){
        $validator = Validator::make($request->all(), [
            'client' => 'required',
            'description' => 'required',
            'status' => 'required'
        ],[
            'client.required' => 'O nome do cliente é obrigatório!',
            'description.required' => 'A descrição é obrigatória!',
            'status.required' => 'O status é obrigatório!'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        if (strlen($request->link) > 0){
            if ($action == 'store' || $testimonial->thumb == null){
                $validator = Validator::make($request->all(), [
                    'thumb' => 'required'
                ],[
                    'thumb.required' => 'A thumb é obrigatória'
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
        }
        /*if ($action == 'store'){
            $validator = Validator::make($request->all(), [
                'imagem' => 'required'
            ],[
                'imagem.required' => 'A imagem é obrigatória!'
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }*/


        //$storage_service = new \App\Services\StorageService();

        DB::beginTransaction();
        try{
            $path = null;
            if($request->has('imagem') && strlen($request->imagem) > 0 && $request->imagem != str_replace('public/', 'storage/', asset($testimonial->path)) && $request->imagem != 'null'){
                $base64_image = $request->input('imagem'); // your base64 encoded

                $folder = 'storage/depoimentos';
                $path = $folder.'/'.Str::slug($request->client).'.webp';

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

            if ($request->hasFile('thumb')){
                $file = $request->file('thumb');

                $thumb = 'storage/depoimentos/thumb/'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . date('Ymd_His').'.webp';
                $webp = Webp::make($file);
                $webp->save(public_path($thumb), 100);

                $testimonial->thumb = str_replace('storage/', 'public/', $thumb);
            }

            $testimonial->fill($request->input());
            if ($path != null){
                $testimonial->path = $path;
            }elseif($request->imagem == 'null'){
                $testimonial->path = null;
            }
            $testimonial->save();

            if(!empty($request->categories) or $request->categories != null){
                //Save categories pivot
                $testimonial->categories()->sync($request->categories);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Depoimento '.($action == 'store' ? 'criado':'editado').' com sucesso!',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." o depoimento!".$e->getMessage()
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin\General\Topics;

use App\Http\Controllers\Controller;
use App\Models\General\Topics\Category;
use App\Models\General\Topics\Topic;
use App\Models\Pages\Page;
use Buglinjo\LaravelWebp\Webp;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $topics = Topic::all();
        $categories = Category::where('display', '1')->orderBy('title')->get();

        $title = "Tópicos";
        $breadcrumbs = [
            ['title' => $title, 'url' => route('admin.topics.index')],
        ];

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'topics' => $topics,
            'categories' => $categories
        ];
        return view('admin.pages.general.topics.list', $data);
    }

    public function create()
    {
        $topic = new Topic();
        $categories = Category::orderBy('title')->get();
        $pages = Page::orderBy('title')->get();

        $title = "Inserir tópico";
        $breadcrumbs = [
            ['title' => "Tópicos", 'url' => route('admin.topics.index')],
            ['title' => $title, 'url' => route('admin.topics.create')]
        ];

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'topic' => $topic,
            'categories' => $categories,
            'pages' => $pages
        ];

        return view('admin.pages.general.topics.form', $data);
    }

    public function store(Request $request)
    {
        $json = $this->save($request, new Topic(), 'store');
        return $json;
    }

    public function edit(Topic $topic)
    {
        $categories = Category::orderBy('title')->get();
        $pages = Page::orderBy('title')->get();

        $title = "Editar tópico";
        $breadcrumbs = [
            ['title' => "Tópicos", 'url' => route('admin.topics.index')],
            ['title' => $title, 'url' => route('admin.topics.edit', $topic->hash_id)],
        ];

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'topic' => $topic,
            'categories' => $categories,
            'pages' => $pages
        ];

        return view('admin.pages.general.topics.form', $data);
    }

    public function update(Request $request, Topic $topic)
    {
        $json = $this->save($request, $topic, 'update');
        return $json;
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();
        return response()->json([
            'success' => true,
            'message' => 'FAQ removido com sucesso!'
        ]);
    }

    public function save($request, $topic, $action){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required',
            'category_id' => 'required'
        ],[
            'title.required' => 'O título é obrigatório!',
            'status.required' => 'O status é obrigatório!',
            'category_id.required' => 'A categoria é obrigatória!'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try{
            if($request->has('photo')){
                $base64_image = $request->input('photo'); // your base64 encoded

                $folder = 'storage/topics';
                $path = $folder.'/'.Str::slug($request->title).'.webp';

                if(!file_exists($folder)) {
                    \Illuminate\Support\Facades\File::makeDirectory(public_path($folder));
                }

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
                $path = str_replace('storage/', 'public/', $path);
            }else{
                $path = null;
            }

            if ($request->status == 1){
                $lastTopic = Topic::where('category_id', $request->category_id)->orderBy('display_order', 'desc')->first();
                if ($lastTopic == null){
                    $display_order = 1;
                }else{
                    $display_order = $lastTopic->display_order + 1;
                }
            }else{
                $display_order = null;
            }

            $topic->fill($request->input());
            $topic->path = $path != null ? $path : $topic->path;
            $topic->display_order = $display_order;
            $topic->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Tópico '.($action == 'store' ? 'criado':'editado').' com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." o tópico".$e->getMessage()
            ]);
        }
    }

    public function getFaqs(Category $category){
        $topics = Topic::where('status', 1)->where('category_id', $category->id)->orderBy('display_order')->get();
        $topics = $topics->map(function ($topic){
            $topic->new_title = Str::limit(trim(strip_tags(html_entity_decode($topic->title))), 50, '...');
            $topic->new_description = Str::limit(trim(strip_tags(html_entity_decode($topic->description))), 60, '...');
            return $topic;
        });
        return response()->json($topics);
    }

    public function displayOrder(Request $request){
        DB::beginTransaction();
        try{
            $i = 1;
            foreach ($request->orderId as $id){
                $topic = Topic::findOrFail($id);
                $topic->display_order = $i;
                $topic->save();
                $i++;
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Ordem de exibição editada com sucesso!',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao editar ordem de exibição!".$e->getMessage()
            ]);
        }
    }
}

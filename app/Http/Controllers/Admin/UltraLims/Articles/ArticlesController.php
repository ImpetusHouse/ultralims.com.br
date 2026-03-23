<?php

namespace App\Http\Controllers\Admin\UltraLims\Articles;

use App\Http\Controllers\Controller;
use App\Models\UltraLims\Articles\Article;
use App\Models\UltraLims\Articles\Category;
use App\Models\UltraLims\Articles\Tag;
use Buglinjo\LaravelWebp\Webp;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class ArticlesController extends Controller
{
    public function index(){
        $articles = Article::orderBy('created_at', 'desc')->get();

        $title = "Publicações";
        $breadcrumbs = [
            ['title' => $title, 'url' => route('admin.ultralims.articles.index')]
        ];
        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'articles' => $articles
        ];
        return view('admin.pages.ultralims.articles.index', $data);
    }

    public function create(){
        $article = new Article();
        $categories = Category::orderBy('title')->get();

        $title = "Inserir publicação";
        $breadcrumbs = [
            ['title' => 'Publicações', 'url' => route('admin.ultralims.articles.index')],
            ['title' => $title, 'url' => route('admin.ultralims.articles.create')],
        ];
        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'article' => $article,
            'categories' => $categories
        ];

        return view('admin.pages.ultralims.articles.form', $data);
    }

    public function store(Request $request)
    {
        return $this->save(new Article(), $request, 'store');
    }

    public function edit(Article $article){
        $categories = Category::orderBy('title')->get();

        $title = "Editar publicação";
        $breadcrumbs = [
            ['title' => 'Publicações', 'url' => route('admin.ultralims.articles.index')],
            ['title' => $title, 'url' => route('admin.ultralims.articles.edit', $article->hash_id)],
        ];
        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'article' => $article,
            'categories' => $categories
        ];
        return view('admin.pages.ultralims.articles.form', $data);
    }

    public function update(Request $request, Article $article){
        return $this->save($article, $request, 'update');
    }

    public function save($article, $request, $action){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'slug' => 'required',
            'categories' => 'required',
            'seo_title' => 'required',
            'seo_description' => 'required',
        ],[
            'title.required' => 'O título é obrigatório',
            'content.required' => 'O conteúdo é obrigatório',
            'slug.required' => 'A slug é obrigatória',
            'categories.required' => 'A obrigatório selecionar pelo menos uma categoria',
            'seo_title.required' => 'O meta title é obrigatório',
            'seo_description.required' => 'A meta description é obrigatória',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try{
            if($request->has('photo')){
                $base64_image = $request->input('photo'); // your base64 encoded

                $folder = 'storage/cliente-ultra/blog';
                $path = $folder.'/'.$request->slug.'.webp';

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

            if ($action == 'update'){
                $oldArticle = $article;
                $article = $oldArticle->replicate();
                $article->created_at = $oldArticle->created_at;
                $article->article_id = $oldArticle->id;

                $article->version = $oldArticle->version+1;
                $article->message = '&nbsp;<span class="text-primary ps-3">v'.$article->version.'</span>&nbsp;-&nbsp;<a href="'.route('admin.users.show', Auth::user()->hash_id).'" class="text-primary">'.Auth::user()->name.' '.Auth::user()->lastname.'</a><span class="text-gray-800">&nbsp;editou a publicação.</span>';

                $article->save();
                $article->categories()->sync($oldArticle->categories->pluck('id'));
                $article->tags()->sync($oldArticle->tags->pluck('id'));
                $oldArticle->delete();
            }else{
                $article->version = 1;
                $article->message = '&nbsp;<span class="text-primary ps-3">v'.$article->version.'</span>&nbsp;-&nbsp;<a href="'.route('admin.users.show', Auth::user()->hash_id).'" class="text-primary">'.Auth::user()->name.' '.Auth::user()->lastname.'</a><span class="text-gray-800">&nbsp;criou a publicação.</span>';
            }

            $article->edited_by = Auth::user()->id;

            switch ($request->status) {
                case 'published':
                    $status = 'published';
                    if ($article->status != $status){
                        $article->published_by = Auth::user()->id;
                        $published_at = Carbon::now();
                    }else{
                        $published_at = $article->published_at;
                    }
                    break;
                case 'scheduled':
                    $status = 'scheduled';
                    $schedule_for = $request->input('scheduled_for') ?? null;
                    break;
                case 'draft':
                    $status = 'draft';
                    break;
                case 'inactive':
                    $status = 'inactive';
                    break;
            }

            $article->photo = $path ?? $article->photo;
            $article->title = $request->title;
            $article->content = $request->content;
            $article->slug = $request->slug;
            $article->status = $status;
            $article->seo_title = $request->seo_title;
            $article->seo_description = $request->seo_description;
            $article->seo_keywords = strtolower($request->seo_keywords);
            $article->published_at = $published_at ?? null;
            $article->scheduled_for = $schedule_for ?? null;
            $article->save();

            if(!empty($request->categories) or $request->categories != null){
                $categories = $request->categories;
                //Save categories pivot
                $article->categories()->sync($categories);
            }

            if (strlen($request->tags > 0)){
                $tags_id = [];
                foreach (explode(',', implode(',', array_column(json_decode($_POST['tags']), 'value'))) as $tag){
                    $tag = strtolower(trim($tag));
                    $tagModel = Tag::where('title', $tag)->first();
                    if ($tagModel == null){
                        $tagModel = Tag::create([
                            'title' => $tag
                        ]);
                    }
                    $tags_id[] = $tagModel->id;
                }
                $article->tags()->sync($tags_id);
            }else{
                $article->tags()->sync(null);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Publicação '.($action == 'store' ? 'inserida':'editada').' com sucesso!'
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao '.($action == 'store' ? 'salvar':'editar').' publicação!' . $e->getMessage(),
            ]);
        }
    }

    public function destroy(Article $article){
        $article->delete();
        return response()->json([
            'success' => true,
            'message' => 'Publicação removida com sucesso!'
        ]);
    }

    public function undo(Article $article, $id){
        $undoArticle = Article::where('id', $id)->withTrashed()->first();

        $newArticle = $undoArticle->replicate();
        $newArticle->created_at = $article->created_at;
        $newArticle->deleted_at = null;
        $newArticle->article_id = $article->id;

        $newArticle->version = $article->version+1;
        $newArticle->message = '&nbsp;<span class="text-primary ps-3">v'.$newArticle->version.'</span>&nbsp;-&nbsp;<a href="'.route('admin.users.show', Auth::user()->hash_id).'" class="text-primary">'.Auth::user()->name.' '.Auth::user()->lastname.'</a><span class="text-gray-800">&nbsp;recuperou a <span class="text-primary fw-bold">v'.$undoArticle->version.'</span> da publicação.</span>';

        $newArticle->save();
        $newArticle->categories()->sync($undoArticle->categories->pluck('id'));
        $newArticle->tags()->sync($undoArticle->tags->pluck('id'));
        $article->delete();

        return redirect()->route('admin.ultralims.articles.edit', $newArticle->hash_id);
    }

    public function getSlug(Request $request){
        $slug = $request->title;
        $slug = Str::slug($slug);
        $article = Article::where('slug', $slug)->first();
        if(!$article){
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

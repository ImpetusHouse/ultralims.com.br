<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Articles\Article;
use App\Models\Articles\Category;
use App\Models\Articles\Tag;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request){
        if (isset($_GET['tag'])){
            $tag = Tag::where('title', str_replace('-', ' ', $_GET['tag']))->pluck('id')->first();
            if ($tag == null){
                return redirect()->route('blog');
            }
            $articles = Article::where('status', 'published')->whereHas('tags', function ($q) use ($tag) {
                $q->where('articles_tags.id', $tag);
            })->orderBy('published_at', 'desc')->orderBy('created_at', 'desc')->paginate(6);
        }elseif(isset($_GET['categoria'])){
            $category = Category::where('slug', $_GET['categoria'])->pluck('id')->first();
            if ($category == null){
                return redirect()->route('blog');
            }
            $articles = Article::where('status', 'published')->whereHas('categories', function ($q) use ($category) {
                $q->where('articles_categories.id', $category);
            })->orderBy('published_at', 'desc')->orderBy('created_at', 'desc')->paginate(6);
        }elseif (isset($_GET['search'])){
            $articles = Article::where('status', 'published')->where('title', 'LIKE', '%'.$_GET['search'].'%')
                //->orWhere('content', 'LIKE', '%'.$_GET['search'].'%')
                ->orderBy('published_at', 'desc')->orderBy('created_at', 'desc')->paginate(6);
        }else{
            $articles = Article::where('status', 'published')->orderBy('published_at', 'desc')->orderBy('created_at', 'desc')->paginate(6);
        }

        if ($request->ajax()) {
            return view('site.pages.blog.inc.articles', compact('articles'))->render();
        }

        //Informações para filtragens de tags e categorias
        $articlesCount = Article::where('status', 'published')->count();
        $tags = Tag::where('title', '!=', '')->withCount('articles')->get()->sortByDesc('articles_count')->take(10);
        $categorias = Category::withCount('articles')->get()->sortByDesc('articles_count')->take(10);

        if(env('APP_NAME') == 'AABB-SP'){
            SEOTools::setTitle(env('APP_NAME').' - '.'AABB-SP');
            SEOTools::setDescription('Aconteceu na AABB.');
        }else{
            SEOTools::setTitle(env('APP_NAME').' - '.'Blog');
            SEOTools::setDescription('Acompanhe nosso BLOG. Semanalmente novidades para você.');
        }
        SEOTools::setCanonical(route('blog'));
        SEOTools::opengraph()->setType('article');
        SEOTools::opengraph()->setUrl(route('blog'));
        SEOTools::opengraph()->addImage(asset('images/seo/'.env('APP_NAME').'/blog.png'));
        SEOTools::jsonLd()->addImage(asset('images/seo/'.env('APP_NAME').'/blog.png'));

        //Array com as variáveis
        $data = [
            'articles' => $articles,
            'articlesCount' => $articlesCount,
            'tags' => $tags,
            'categorias' => $categorias
        ];
        return view('site.pages.blog.index', $data);
    }

    public function show($slug){
        $article = Article::where('slug', $slug)->where('status', '!=', 'inactive')->first();

        if ($article == null){
            return redirect()->route('blog');
        }

        $date = Carbon::parse($article->published_at != null ? $article->published_at:$article->created_at)->locale('pt-BR');
        $article->created_at_br = $date->translatedFormat('d').' de '.$date->translatedFormat('F').' de '.$date->translatedFormat('Y');

        $related = $article->categories->first()->articles->where('id', '!=', $article->id)->where('status', 'published')->sortByDesc('created_at')->take(3);
        $related = $related->map(function($item) {
            $date = Carbon::parse($item->published_at != null ? $item->published_at:$item->created_at)->locale('pt-BR');
            $item->created_at_br = $date->translatedFormat('d').' de '.$date->translatedFormat('F').' de '.$date->translatedFormat('Y');
            return $item;
        });

        $path = 'images/seo/'.env('APP_NAME').'/blog.png';

        SEOTools::setTitle($article->seo_title ? (env('APP_NAME').' - '.$article->seo_title) : $article->title);
        SEOTools::setDescription($article->seo_description?? \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($article->content))));
        SEOTools::setCanonical(route('blog.show', $article->slug));
        SEOTools::metatags()->addKeyword(explode(',', $article->seo_keywords));
        SEOTools::opengraph()->setType('article');
        SEOTools::opengraph()->setUrl(route('blog'));
        SEOTools::opengraph()->addImage(str_replace('/public', '/storage', asset($article->photo ?? $path)));
        SEOTools::jsonLd()->addImage(str_replace('/public', '/storage', asset($article->photo ?? $path)));

        $data = [
            'article' => $article,
            'related' => $related,
            'index' => true
        ];
        return view('site.pages.blog.show', $data);
    }
}

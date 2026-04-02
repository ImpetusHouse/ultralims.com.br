<?php

namespace App\Http\Controllers\Site\UltraLIMS;

use App\Http\Controllers\Controller;
use App\Jobs\SendUserNotification;
use App\Models\General\Events\Event;
use App\Models\General\Products\FilterCategory;
use App\Models\General\Products\Product;
use App\Models\Pages\Page;
use App\Models\UltraLims\Articles\Article;
use App\Models\UltraLims\Articles\Category;
use App\Models\UltraLims\Articles\Tag;
use App\Models\UltraLims\Articles\UL_Article_User;
use App\Models\UltraLims\Banner;
use App\Models\UltraLims\Cookie\UL_Cookie;
use App\Models\UltraLims\Cookie\UL_Cookie_User;
use App\Models\UltraLims\UL_Alert;
use App\Models\UltraLims\UL_Alert_Inmetro;
use App\Models\UltraLims\UL_Banner_User;
use App\Models\UltraLims\UL_Call_User;
use App\Models\UltraLims\UL_Chat_User;
use App\Models\UltraLims\UL_Form;
use App\Models\UltraLims\UL_Product_User;
use App\Models\UltraLims\UL_Product_User_Click;
use App\Models\UltraLims\UL_University_User;
use App\Models\UltraLims\UL_User;
use App\Models\UltraLims\Wishlist;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

class UltraLimsController extends Controller{

    public function index(){
        SEOTools::setTitle(env('APP_NAME').' - Cliente Ultra');
        SEOTools::setDescription('.');
        SEOTools::setCanonical(route('ultralims.index'));
        SEOTools::opengraph()->setType('article');
        SEOTools::opengraph()->setUrl(route('ultralims.index'));
        SEOTools::opengraph()->addImage(asset('images/seo/'.env('APP_NAME').'/blog.png'));
        SEOTools::jsonLd()->addImage(asset('images/seo/'.env('APP_NAME').'/blog.png'));

        $articles = Article::where('status', 'published')->orderBy('created_at', 'desc')->take(4)->get();
        $banners = Banner::where('status', true)->orderBy('display_order')->get();
        $events = Event::where('status', true)
            ->where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->take(2)
            ->get();
        $page = new Page();
        if (env('APP_ENV') == 'local'){
            $page->menu_id = 1;
        }else{
            $page->menu_id = 2;
        }

        return view('site.pages.ultralims.index', compact('articles', 'banners', 'events', 'page'));
    }

    public function dashboard($appKey)
    {
        //VALIDA SE O APP-KEY PASSADO É O MESMO DA APLICAÇÃO
        if (!$appKey || !hash_equals($appKey, str_replace('base64:', '', env('APP_KEY')))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // Extensões publicadas
        $productsCount = Product::where('status', true)->count();
        $productClicks = UL_Product_User_Click::with('user', 'product')->get();

        // Lista de desejos
        $wishlists = Wishlist::with('user')->get();
        $wishlistCount = $wishlists->count();

        // Produtos por usuário (ul_product_user)
        $productIWantUsers = UL_Product_User::with('user')->get();
        $productIWantUserCount = $productIWantUsers->count();

        // Cliques em banner
        $bannerClicks = UL_Banner_User::with('user')->get();
        $bannerClickCount = $bannerClicks->count();

        // Banners mais clicados no mês atual
        $topClickedProducts = UL_Product_User_Click::select('product_id', DB::raw('COUNT(*) as clicks'))
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('product_id')
            ->orderByDesc('clicks')
            ->take(5)
            ->get()
            ->map(function ($item) use ($startOfMonth, $endOfMonth) {
                // Busca todos os usuários que clicaram nesse banner no mês atual
                $clicks = UL_Product_User_Click::with('user')
                    ->where('product_id', $item->product_id)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->get();

                return [
                    'product' => $item->product->title ?? 'Sem título',
                    'clicks' => $item->clicks,
                    'users' => $clicks->map(function ($click) {
                        return [
                            'name' => $click->user->user ?? null,
                            'email' => $click->user->email ?? null,
                            'date' => $click->created_at->format('d/m/Y') ?? null,
                        ];
                    })->unique('user_id')->values(), // remove duplicados se o mesmo user clicou mais de uma vez
                ];
            });

        // Últimos 5 blogs
        $latestArticles = Article::where('status', 'published') // ou '1' se for booleano
        ->orderByDesc('published_at')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                // Busca todos os usuários que clicaram nesse artigo
                $clicks = UL_Article_User::with('user')
                    ->where('article_id', $item->id)
                    ->get();

                return [
                    'title' => $item->title,
                    'clicks' => $clicks->count(),
                    'users' => $clicks->map(function ($click) {
                        return [
                            'name' => $click->user->user ?? null,
                            'email' => $click->user->email ?? null,
                            'date' => $click->created_at->format('d/m/Y') ?? null,
                        ];
                    })->unique('user_id')->values()
                ];
            });

        //University clicks
        $universityClicks = UL_University_User::with('user')->get();
        $universityClicksCount = $universityClicks->count();

        //Call clicks
        $callClicks = UL_Call_User::with('user')->get();
        $callClicksCount = $callClicks->count();

        //Chat clicks
        $chatClicks = UL_Chat_User::with('user')->get();
        $chatClicksCount = $chatClicks->count();

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Accept");

        return response()->json([
            'products_count' => $productsCount,
            'product_users' => $productClicks->map(function ($item) {
                return [
                    'product' => $item->product->title,
                    'user' => $item->user->user ?? null,
                    'email' => $item->user->email ?? null,
                    'date' => $item->created_at->format('d/m/Y') ?? null,
                ];
            }),

            'wishlist_count' => $wishlistCount,
            'wishlist_users' => $wishlists->map(function ($item) {
                return [
                    'product' => $item->product->title,
                    'user' => $item->user->user ?? null,
                    'email' => $item->user->email ?? null,
                    'date' => $item->created_at->format('d/m/Y') ?? null,
                ];
            }),

            'product_i_want_user_count' => $productIWantUserCount,
            'product_i_want_users' => $productIWantUsers->map(function ($item) {
                return [
                    'product' => $item->product ? $item->product->title : 'Produto excluído',
                    'user' => $item->user->user ?? null,
                    'email' => $item->user->email ?? null,
                    'date' => $item->created_at->format('d/m/Y') ?? null,
                ];
            }),

            'banner_clicks_count' => $bannerClickCount,
            'banner_click_users' => $bannerClicks->map(function ($item) {
                return [
                    'banner' => $item->banner->title,
                    'user' => $item->user->user ?? null,
                    'email' => $item->user->email ?? null,
                    'date' => $item->created_at->format('d/m/Y') ?? null,
                ];
            }),

            'most_clicked_product_this_month' => $topClickedProducts->toArray(),

            'latest_articles' => $latestArticles,

            'university_clicks_count' => $universityClicksCount,
            'university_click_users' => $universityClicks->map(function ($item) {
                return [
                    'user' => $item->user->user ?? null,
                    'email' => $item->user->email ?? null,
                    'date' => $item->created_at->format('d/m/Y') ?? null,
                ];
            }),

            'call_clicks_count' => $callClicksCount,
            'call_click_users' => $callClicks->map(function ($item) {
                return [
                    'user' => $item->user->user ?? null,
                    'email' => $item->user->email ?? null,
                    'date' => $item->created_at->format('d/m/Y') ?? null,
                ];
            }),

            'chat_clicks_count' => $chatClicksCount,
            'chat_click_users' => $chatClicks->map(function ($item) {
                return [
                    'user' => $item->user->user ?? null,
                    'email' => $item->user->email ?? null,
                    'date' => $item->created_at->format('d/m/Y') ?? null,
                ];
            }),
        ]);
    }

    public function bannerRead($id)
    {
        $user = Auth::guard('ultralims')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $ultimoClique = \App\Models\UltraLims\UL_Banner_User::where('user_id', $user->id)
            ->where('banner_id', $id)
            ->orderByDesc('created_at')
            ->first();

        if ($ultimoClique && $ultimoClique->created_at->diffInMinutes(now()) < 5) {
            return response()->json(['status' => 'ok']);
        }

        // Registra novo clique
        \App\Models\UltraLims\UL_Banner_User::create([
            'user_id' => $user->id,
            'banner_id' => $id,
        ]);

        return response()->json(['status' => 'ok']);
    }

    public function universityRead()
    {
        $user = Auth::guard('ultralims')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $ultimoRegistro = \App\Models\UltraLims\UL_University_User::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->first();

        if ($ultimoRegistro && $ultimoRegistro->created_at->diffInMinutes(now()) < 5) {
            return response()->json(['status' => 'ok']);
        }

        \App\Models\UltraLims\UL_University_User::create([
            'user_id' => $user->id,
        ]);

        return response()->json(['status' => 'ok']);
    }

    public function callRead()
    {
        $user = Auth::guard('ultralims')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $ultimoRegistro = \App\Models\UltraLims\UL_Call_User::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->first();

        if ($ultimoRegistro && $ultimoRegistro->created_at->diffInMinutes(now()) < 5) {
            return response()->json(['status' => 'ok']);
        }

        \App\Models\UltraLims\UL_Call_User::create([
            'user_id' => $user->id,
        ]);

        return response()->json(['status' => 'ok']);
    }

    public function chatRead()
    {
        $user = Auth::guard('ultralims')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $ultimoRegistro = \App\Models\UltraLims\UL_Chat_User::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->first();

        if ($ultimoRegistro && $ultimoRegistro->created_at->diffInMinutes(now()) < 5) {
            return response()->json(['status' => 'ok']);
        }

        \App\Models\UltraLims\UL_Chat_User::create([
            'user_id' => $user->id,
        ]);

        return response()->json(['status' => 'ok']);
    }

    public function produtos(Request $request){
        $filterCategories = FilterCategory::orderBy('title')->get();

        $query = Product::query()->where('status', true);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', '%'.$search.'%')
                    ->orWhere('description', 'LIKE', '%'.$search.'%')
                    ->orWhere('benefits', 'LIKE', '%'.$search.'%');
            });
        }

        $selectedFilterId = null;
        if ($request->filled('filtro')) {
            $filterId = (int) $request->input('filtro');
            if ($filterCategories->contains('id', $filterId)) {
                $selectedFilterId = $filterId;
                $query->whereHas('filterCategories', function ($q) use ($filterId) {
                    $q->whereKey($filterId);
                });
            }
        }

        $products = $query->orderBy('display_order')->paginate(8)->withQueryString();

        if ($request->ajax()) {
            return view('site.pages.ultralims.produtos.produto', compact('products'))->render();
        }

        SEOTools::setTitle(env('APP_NAME').' - Loja');
        SEOTools::setDescription('.');
        SEOTools::setCanonical(route('ultralims.produtos'));
        SEOTools::opengraph()->setType('article');
        SEOTools::opengraph()->setUrl(route('ultralims.produtos'));
        SEOTools::opengraph()->addImage(asset('images/seo/'.env('APP_NAME').'/blog.png'));
        SEOTools::jsonLd()->addImage(asset('images/seo/'.env('APP_NAME').'/blog.png'));

        $page = new Page();
        $page->menu_id = 2;

        return view('site.pages.ultralims.produtos.index', compact('products', 'page', 'filterCategories', 'selectedFilterId'));
    }

    public function produto($slug){
        $product = Product::where('slug', $slug)->first();
        if (!$product){
            return redirect()->back();
        }

        SEOTools::setTitle(env('APP_NAME').' - '.$product->title);
        SEOTools::setDescription(\Illuminate\Support\Str::limit(html_entity_decode(strip_tags($product->description))));
        SEOTools::setCanonical(route('ultralims.produtos.show', $slug));
        SEOTools::opengraph()->setType('article');
        SEOTools::opengraph()->setUrl(route('ultralims.produtos.show', $slug));
        SEOTools::opengraph()->addImage(asset(str_replace('public/', 'storage/', $product->photo)));
        SEOTools::jsonLd()->addImage(asset(str_replace('public/', 'storage/', $product->photo)));

        $page = new Page();
        $page->menu_id = 2;

        if (Auth::guard('ultralims')->user()){
            $user_id = Auth::guard('ultralims')->user()->id;
        }else{
            $user_id = null;
        }
        $wishlist = Wishlist::where('user_id', $user_id)->where('product_id', $product->id)->first();

        if (Auth::guard('ultralims')->check()) {
            $user = Auth::guard('ultralims')->user();

            if ($user) {
                $ultimoRegistro = \App\Models\UltraLims\UL_Product_User_Click::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->orderByDesc('created_at')
                    ->first();

                if (!$ultimoRegistro || $ultimoRegistro->created_at->diffInMinutes(now()) >= 5) {
                    \App\Models\UltraLims\UL_Product_User_Click::create([
                        'user_id' => $user->id,
                        'product_id' => $product->id
                    ]);
                }
            }
        }

        return view('site.pages.ultralims.produtos.show', compact( 'product', 'page', 'wishlist'));
    }

    public function produtoApi($appKey){
        //VALIDA SE O APP-KEY PASSADO É O MESMO DA APLICAÇÃO
        if (!$appKey || !hash_equals($appKey, str_replace('base64:', '', env('APP_KEY')))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        try {
            return response()->json([
                'success' => true,
                'products' => Product::where('status', true)->orderBy('display_order')->get()
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Falha ao obter produtos',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function euQuero($slug){
        $product = Product::where('slug', $slug)->first();
        if (!$product){
            return response()->json([
                'success' => false,
                'message' => 'Produto não encontrato, tente novamente'
            ]);
        }
        DB::beginTransaction();
        try {
            $user_id = Auth::guard('ultralims')->user()->id;
            $productUser = UL_Product_User::where('user_id', $user_id)->where('product_id', $product->id)->first();
            if (!$productUser){
                UL_Product_User::create([
                    'product_id' => $product->id,
                    'user_id' => $user_id
                ]);

                $data = [
                    'subject' => 'Novo pedido',
                    'title' => 'Novo pedido',
                    'product' => $product->title,
                    'name' => Auth::guard('ultralims')->user()->user,
                    'email' => Auth::guard('ultralims')->user()->email,
                    'tipoUser' => Auth::guard('ultralims')->user()->tipoUser,
                    'laboratorio' => Auth::guard('ultralims')->user()->laboratorio,
                    'type' => 'order',
                    'description' => 'Novo pedido recebido',
                ];
                //$data['to'] = 'benhur.azolini@ultralims.com.br';
                //dispatch(new SendUserNotification($data));
                $data['to'] = 'luciangela.fontana@ultralims.com.br';
                dispatch(new SendUserNotification($data));
            }
            DB::commit();
            return response()->json([
                'success' => true,
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    public function wishlist($slug){
        $product = Product::where('slug', $slug)->first();
        if (!$product){
            return response()->json([
                'success' => false,
                'message' => 'Produto não encontrato, tente novamente'
            ]);
        }
        DB::beginTransaction();
        try {
            $user_id = Auth::guard('ultralims')->user()->id;
            $wishlist = Wishlist::where('user_id', $user_id)->where('product_id', $product->id)->first();
            if (!$wishlist){
                Wishlist::create([
                    'product_id' => $product->id,
                    'user_id' => $user_id
                ]);
            }else{
                $wishlist->delete();
            }
            DB::commit();
            return response()->json([
                'success' => true,
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao adicionar na lista de desejo, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    public function blog(Request $request){
        if (isset($_GET['tag'])){
            $tag = Tag::where('title', str_replace('-', ' ', $_GET['tag']))->pluck('id')->first();
            if ($tag == null){
                return redirect()->route('blog');
            }
            $articles = Article::where('status', 'published')->whereHas('tags', function ($q) use ($tag) {
                $q->where('ultralims_articles_tags.id', $tag);
            })->orderBy('published_at', 'desc')->orderBy('created_at', 'desc')->paginate(6);
        }elseif(isset($_GET['categoria'])){
            $category = Category::where('slug', $_GET['categoria'])->pluck('id')->first();
            if ($category == null){
                return redirect()->route('blog');
            }
            $articles = Article::where('status', 'published')->whereHas('categories', function ($q) use ($category) {
                $q->where('ultralims_articles_categories.id', $category);
            })->orderBy('published_at', 'desc')->orderBy('created_at', 'desc')->paginate(6);
        }elseif (isset($_GET['search'])){
            $articles = Article::where('status', 'published')->where('title', 'LIKE', '%'.$_GET['search'].'%')
                //->orWhere('content', 'LIKE', '%'.$_GET['search'].'%')
                ->orderBy('published_at', 'desc')->orderBy('created_at', 'desc')->paginate(6);
        }else{
            $articles = Article::where('status', 'published')->orderBy('published_at', 'desc')->orderBy('created_at', 'desc')->paginate(6);
        }

        if ($request->ajax()) {
            return view('site.pages.ultralims.blog.inc.articles', compact('articles'))->render();
        }

        //Informações para filtragens de tags e categorias
        $articlesCount = Article::where('status', 'published')->count();
        $tags = Tag::where('title', '!=', '')->withCount('articles')->get()->sortByDesc('articles_count')->take(10);
        $categorias = Category::withCount('articles')->get()->sortByDesc('articles_count')->take(10);

        SEOTools::setTitle(env('APP_NAME').' - '.'Blog');
        SEOTools::setDescription('Acompanhe nosso BLOG. Semanalmente novidades para você.');
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
        return view('site.pages.ultralims.blog.index', $data);
    }

    public function blogShow($slug){
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

        if (Auth::guard('ultralims')->check()) {
            $user = Auth::guard('ultralims')->user();

            if ($user) {
                $ultimoRegistro = \App\Models\UltraLims\Articles\UL_Article_User::where('user_id', $user->id)
                    ->where('article_id', $article->id)
                    ->orderByDesc('created_at')
                    ->first();

                if (!$ultimoRegistro || $ultimoRegistro->created_at->diffInMinutes(now()) >= 5) {
                    \App\Models\UltraLims\Articles\UL_Article_User::create([
                        'user_id' => $user->id,
                        'article_id' => $article->id
                    ]);
                }
            }
        }

        $data = [
            'article' => $article,
            'related' => $related,
            'index' => true
        ];
        return view('site.pages.ultralims.blog.show', $data);
    }

    public function blogApi($appKey){
        //VALIDA SE O APP-KEY PASSADO É O MESMO DA APLICAÇÃO
        if (!$appKey || !hash_equals($appKey, str_replace('base64:', '', env('APP_KEY')))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        try {
            return response()->json([
                'success' => true,
                'articles' => Article::where('status', 'published')->orderBy('published_at', 'desc')->get()
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Falha ao obter publicações',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function blogWebhook(Request $request, $appKey)
    {
        //VALIDA SE O APP-KEY PASSADO É O MESMO DA APLICAÇÃO
        if (!$appKey || !hash_equals($appKey, str_replace('base64:', '', env('APP_KEY')))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        //VALIDA SE OS DADOS ESTÃO SENDO ENVIADOS CORRETAMENTE
        $validator = Validator::make($request->all(), [
            'photo' => 'required',
            'title' => 'required',
            'content' => 'required',
        ],[
            'photo.required' => 'A foto é obrigatória',
            'title.required' => 'O título é obrigatório',
            'content.required' => 'O conteúdo é obrigatório',
        ]);
        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()->first()
            ], 400);
        }

        try {
            $title = $request->input('title');
            $slug = Str::slug($title);
            $imageUrl = $request->input('photo');

            // Obtém a extensão original da imagem
            $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
            $fileName = $slug . '.' . $extension;

            // Define o caminho de armazenamento
            $folder = 'public/cliente-ultra/blog';
            $path = $folder . '/' . $fileName;

            // Baixa e salva o conteúdo da imagem
            $imageContents = file_get_contents($imageUrl);
            Storage::put($path, $imageContents);

            // Gera o caminho público
            $publicPath = Storage::url($path); // Ex: /storage/cliente-ultra/blog/slug.jpg

            // Limpa o HTML e pega os primeiros 162 caracteres
            $cleanContent = strip_tags($request->input('content'));
            $seoDescription = Str::limit($cleanContent, 162, '...');

            // Cria o artigo no banco
            Article::create([
                'photo' => str_replace('/storage', 'public', $publicPath),
                'title' => $title,
                'slug' => $slug,
                'content' => $request->input('content'),
                'status' => 'published',
                'published_at' => Carbon::now(),
                'published_by' => 3,
                'seo_title' => $title,
                'seo_description' => $seoDescription,

            ]);

            return response()->json(['success' => true]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Falha ao salvar publicação',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function productWebhook(Request $request, $appKey)
    {
        //VALIDA SE O APP-KEY PASSADO É O MESMO DA APLICAÇÃO
        if (!$appKey || !hash_equals($appKey, str_replace('base64:', '', env('APP_KEY')))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        //VALIDA SE OS DADOS ESTÃO SENDO ENVIADOS CORRETAMENTE
        $validator = Validator::make($request->all(), [
            'photo' => 'required',
            'title' => 'required',
            'content' => 'required',
        ],[
            'photo.required' => 'A foto é obrigatória',
            'title.required' => 'O título é obrigatório',
            'content.required' => 'O conteúdo é obrigatório',
        ]);
        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()->first()
            ], 400);
        }

        try {
            $title = $request->input('title');
            $slug = Str::slug($title);
            $imageUrl = $request->input('photo');

            // Obtém a extensão original da imagem
            $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
            $fileName = $slug . '.' . $extension;

            // Define o caminho de armazenamento
            $folder = 'public/cliente-ultra/blog';
            $path = $folder . '/' . $fileName;

            // Baixa e salva o conteúdo da imagem
            $imageContents = file_get_contents($imageUrl);
            Storage::put($path, $imageContents);

            // Gera o caminho público
            $publicPath = Storage::url($path); // Ex: /storage/cliente-ultra/blog/slug.jpg

            // Cria o produto no banco
            Product::create([
                'display_order' => Product::orderBy('display_order', 'desc')->first()->display_order + 1,
                'photo' => str_replace('/storage', 'public', $publicPath),
                'title' => $title,
                'description' => $request->input('content'),
                'slug' => $slug,
                'benefits' => null,
                'status' => true
            ]);

            return response()->json([
                'success' => true,
                'slug' => $slug
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Falha ao salvar publicação',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function comunicadosApi($appKey, $idLaboratorio){
        //VALIDA SE O APP-KEY PASSADO É O MESMO DA APLICAÇÃO
        if (!$appKey || !hash_equals($appKey, str_replace('base64:', '', env('APP_KEY')))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        try {
            return response()->json([
                'success' => true,
                'alerts' => UL_Alert::where('idLaboratorio', $idLaboratorio)->orderBy('start_date', 'desc')->get()
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Falha ao obter comunicados',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function getCookies(){
        // Buscar cookies ativos para hoje
        $today = now();
        $userId = Auth::guard('ultralims')->user()->id; // Substitua por $user->id se o usuário não estiver autenticado via Auth

        $cookies = UL_Cookie::where('start', '<=', $today)
            ->where('end', '>=', $today)
            ->whereDoesntHave('ulCookieUsers', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('start', 'asc')
            ->get();

        return response()->json($cookies);
    }

    public function markAsSeen($id){
        $cookie = UL_Cookie::findOrFail($id);

        UL_Cookie_User::create([
           'cookie_id' => $cookie->id,
           'user_id' => Auth::guard('ultralims')->user()->id
        ]);

        return response()->json(['message' => 'Cookie marcado como visto']);
    }


    public function chat(){
        return view('site.pages.ultralims.chat');
    }

    public function alerts(Request $request)
    {
        $user = Auth::guard('ultralims')->user();

        if (!$user) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        $alert = UL_Alert_Inmetro::find($request->alert_id);

        if (!$alert) {
            return response()->json(['error' => 'Alerta não encontrado'], 404);
        }

        // Atualiza o campo read_at na tabela pivot
        $user->alerts()->updateExistingPivot($alert->id, ['read_at' => now()]);

        return response()->json(['message' => 'Alerta marcado como lido']);
    }

    public function login($id)
    {   
        $id = Hashids::decode($id);
        $user = UL_User::where('id', $id)->first(); // Pega o usuário com base no ID do cookie
        if ($user) {
            Auth::guard('ultralims')->login($user); // Loga o usuário
            return redirect()->route('ultralims.index');
        }

        abort(403);
    }

    public function codex(Request $request)
    {
        // 1) Autenticação
        $ulUser = Auth::guard('ultralims')->user();
        if (!$ulUser) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // 2) Montar payload exigido pelo webhook
        // Ajuste os campos conforme seu modelo UL_User e relacionamentos.
        $payload = [
            'idUser'        => $ulUser->idUser,                                     // obrigatório
            'user'          => $ulUser->user, // obrigatório
            'email'         => $ulUser->email,     // obrigatório
            'tipoUser'      => $ulUser->tipoUser,  // obrigatório
            'idLaboratorio' => $ulUser->idLaboratorio, // obrigatório
            'laboratorio'   => $ulUser->laboratorio, // obrigatório
        ];

        // 3) Construir a URL do webhook com APP_KEY sem 'base64:'
        $appKey = 'VfMgKayfNwFcVBHZ2Ay6tohTcaFtFuYQGaq6pg6ddb8=';

        $webhookUrl = "https://codex.ultralims.com.br/webhooks/login/{$appKey}";

        try {
            // 4) Enviar POST JSON (timeout e headers adequados)
            $response = Http::timeout(10)
                ->acceptJson()
                ->asJson()
                ->post($webhookUrl, $payload);

            if (!$response->ok()) {
                Log::warning('Webhook Codex não OK', [
                    'status' => $response->status(),
                    'body'   => $response->body()
                ]);
                return response()->json([
                    'error' => 'Falha ao contatar o Codex',
                    'status' => $response->status()
                ], 502);
            }

            $data = $response->json();

            // 5) Validar retorno esperado
            if (!isset($data['url']) || empty($data['url'])) {
                Log::warning('Webhook Codex respondeu sem URL', ['data' => $data]);
                return response()->json([
                    'error' => 'Resposta inválida do Codex (sem URL).'
                ], 502);
            }

            // 6) Retornar URL para o frontend redirecionar
            return response()->json(['url' => $data['url']]);

        } catch (\Throwable $e) {
            Log::error('Erro ao chamar webhook Codex', [
                'message' => $e->getMessage()
            ]);
            return response()->json([
                'error' => 'Erro interno ao acionar o Codex'
            ], 500);
        }
    }

    public function ia(Request $request)
    {
        // 1) Autenticação
        $ulUser = Auth::guard('ultralims')->user();
        if (!$ulUser) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // 2) Montar payload exigido pelo webhook
        // Ajuste os campos conforme seu modelo UL_User e relacionamentos.
        $payload = [
            'idUser'        => $ulUser->idUser,                                     // obrigatório
            'user'          => $ulUser->user, // obrigatório
            'email'         => $ulUser->email,     // obrigatório
            'tipoUser'      => $ulUser->tipoUser,  // obrigatório
            'idLaboratorio' => $ulUser->idLaboratorio, // obrigatório
            'laboratorio'   => $ulUser->laboratorio, // obrigatório
        ];

        // 3) Construir a URL do webhook com APP_KEY sem 'base64:'
        $appKey = 'TvobNS6CFBrSrYAk2xUhVWbEguFcIZLjINhRVd3Hr0c=';

        $webhookUrl = "https://ia.ultralims.com.br/webhooks/login/{$appKey}";

        try {
            // 4) Enviar POST JSON (timeout e headers adequados)
            $response = Http::timeout(10)
                ->acceptJson()
                ->asJson()
                ->post($webhookUrl, $payload);

            if (!$response->ok()) {
                Log::warning('Webhook IA não OK', [
                    'status' => $response->status(),
                    'body'   => $response->body()
                ]);
                return response()->json([
                    'error' => 'Falha ao contatar o IA',
                    'status' => $response->status()
                ], 502);
            }

            $data = $response->json();

            // 5) Validar retorno esperado
            if (!isset($data['url']) || empty($data['url'])) {
                Log::warning('Webhook IA respondeu sem URL', ['data' => $data]);
                return response()->json([
                    'error' => 'Resposta inválida da IA (sem URL).'
                ], 502);
            }

            // 6) Retornar URL para o frontend redirecionar
            return response()->json(['url' => $data['url']]);

        } catch (\Throwable $e) {
            Log::error('Erro ao chamar webhook Codex', [
                'message' => $e->getMessage()
            ]);
            return response()->json([
                'error' => 'Erro interno ao acionar o Codex'
            ], 500);
        }
    }

    public function form(Request $request)
    {
        // 1. Obter usuário autenticado e verificar
        $user = Auth::guard('ultralims')->user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado.'], 401);
        }

        // 2. Definir regras de validação
        $rules = [
            'company' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:20', // CNPJ é opcional para a busca, mas obrigatório para o formulário
            'name' => 'required|string|max:255',
            'office' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            // Validação de telefone: formato (XX) XXXXX-XXXX ou (XX) XXXX-XXXX
            // Remove caracteres não numéricos e verifica se tem 10 ou 11 dígitos.
            'phone' => [
                'required',
                'string',
                'regex:/^\(\d{2}\)\s\d{4,5}-\d{4}$/', // Formato (XX) XXXX-XXXX ou (XX) XXXXX-XXXX
            ],
            'notify_on' => 'required|in:email,phone,all',
        ];

        $messages = [
            'company.required' => 'O campo Empresa é obrigatório.',
            'name.required' => 'O campo Nome é obrigatório.',
            'office.required' => 'O campo Cargo é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'O E-mail deve ser um endereço de e-mail válido.',
            'phone.required' => 'O campo Whatsapp é obrigatório.',
            'phone.regex' => 'O campo Whatsapp deve estar no formato (XX) XXXXX-XXXX ou (XX) XXXX-XXXX.',
            'notify_on.required' => 'O campo Preferência de Alertas é obrigatório.',
            'notify_on.in' => 'Valor inválido para Preferência de Alertas.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $cnpjData = [];

        // 3. Busca de endereço pelo CNPJ (se fornecido)
        if (!empty($data['cnpj'])) {
            // Limpa o CNPJ (remove pontos, barras e hífens)
            $cleanCnpj = preg_replace('/[^0-9]/', '', $data['cnpj']);

            if (strlen($cleanCnpj) === 14) {
                try {
                    $response = Http::get("https://brasilapi.com.br/api/cnpj/v1/{$cleanCnpj}");

                    if ($response->successful()) {
                        $cnpjResponse = $response->json();
                        // Mapeia os dados da API para os campos do modelo UL_Form
                        $cnpjData = [
                            'company' => $cnpjResponse['razao_social'] ?? $data['empresa'], // Usa Razão Social se disponível
                            'cnpj' => $cleanCnpj,
                            'state' => $cnpjResponse['uf'] ?? null,
                            'city' => $cnpjResponse['municipio'] ?? null,
                            'neighborhood' => $cnpjResponse['bairro'] ?? null,
                            'street' => $cnpjResponse['logradouro'] ?? null,
                            'number' => $cnpjResponse['numero'] ?? null,
                            'complement' => $cnpjResponse['complemento'] ?? null,
                        ];
                    } else {
                        // Loga o erro, mas não impede o salvamento do formulário
                        Log::warning("BrasilAPI CNPJ Error: Status {$response->status()} for CNPJ {$cleanCnpj}");
                    }
                } catch (\Exception $e) {
                    Log::error("BrasilAPI CNPJ Exception: " . $e->getMessage());
                }
            }
        }

        // 4. Preparar dados para o UL_Form
        $formData = array_merge($cnpjData, [
            'idLaboratorio' => $user->idLaboratorio,
            'idUser' => $user->idUser,
            'company' => $data['company'], // Usa o valor do formulário como fallback/principal se a API não for usada ou falhar
            'cnpj' => $cleanCnpj ?? $data['cnpj'],
            'name' => $data['name'],
            'office' => $data['office'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'notify_on' => $data['notify_on'],
        ]);

        // 5. Criar ou atualizar o UL_Form (usando updateOrCreate para evitar duplicidade se o usuário já enviou)
        // Assumindo que a combinação idUser e idLaboratorio é única para este formulário
        try {
            $form = UL_Form::updateOrCreate(
                [
                    'idUser' => $user->idUser,
                    'idLaboratorio' => $user->idLaboratorio
                ],
                $formData
            );

            // 6. Retorno de sucesso
            return response()->json([
                'message' => 'Formulário salvo com sucesso!',
                'form_id' => $form->id
            ], 200);

        } catch (\Exception $e) {
            Log::error("UL_Form Save Exception: " . $e->getMessage());
            return response()->json(['message' => 'Erro interno ao salvar o formulário.'], 500);
        }
    }
}

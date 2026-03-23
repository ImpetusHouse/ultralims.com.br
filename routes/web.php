<?php

use App\Models\UltraLims\UL_User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Artesaos\SEOTools\Facades\SEOTools;

//CONTROLLER AUTENTICAÇÃO
use App\Http\Controllers\Auth\AuthController;

//CONTROLLERS ADMIN
use App\Http\Controllers\Admin\AdminController;

//PUBLICAÇÕES
use App\Http\Controllers\Admin\Articles\ArticlesController;
use App\Http\Controllers\Admin\Articles\CategoriesController;

//PÁGINAS
use App\Models\Pages\Page;
use App\Http\Controllers\Admin\Pages\PageController;
use App\Http\Controllers\Admin\Pages\PrefixSlugController;
use App\Http\Controllers\Admin\Pages\CategoriesController as PageCategoriesController;
use App\Http\Controllers\Admin\Pages\BlocksController;
use App\Http\Controllers\Site\BlogController as FrontBlogController;
use App\Http\Controllers\Admin\Pages\IA\IAController;
use App\Http\Controllers\Admin\Pages\IA\PromptController;

//GERAL
use App\Http\Controllers\Admin\General\Cards\CardController;
use App\Http\Controllers\Admin\General\Cards\CategoryController as CardCategoriesController;
use App\Http\Controllers\Admin\General\Cards\SubcategoryController as CardSubcategoryController;
use App\Http\Controllers\Admin\General\Alerts\AlertController;
use App\Http\Controllers\Admin\General\Testimonials\TestimonialController;
use App\Http\Controllers\Admin\General\Events\EventController;
use App\Http\Controllers\Admin\General\FAQ\FAQController;
use App\Http\Controllers\Admin\General\FAQ\CategoriesController as FAQCategoriesController;
use App\Http\Controllers\Admin\General\Galleries\GalleryController;
use App\Http\Controllers\Admin\General\Galleries\PhotoController;
use App\Http\Controllers\Admin\General\Topics\TopicController;
use App\Http\Controllers\Admin\General\Topics\CategoriesController as TopicsCategoriesController;
use App\Http\Controllers\Admin\General\Logos\LogoController;
use App\Http\Controllers\Admin\General\Logos\CategoriesController as LogoCategoriesController;
use App\Http\Controllers\Admin\General\Folder\FolderController;
use App\Http\Controllers\Admin\General\Folder\ItemController;
use App\Http\Controllers\Admin\General\Magazines\MagazineController;
use App\Http\Controllers\Admin\General\Portfolios\PortfolioController;
use App\Http\Controllers\Admin\General\Portfolios\CategoryController as PortfolioCategoryController;
use App\Http\Controllers\Admin\General\Products\ProductController;
use App\Http\Controllers\Admin\General\Products\CategoryController as ProductCategoryController;

//Ultra Lims
use App\Http\Controllers\Admin\UltraLims\BannerController;
use App\Http\Controllers\Admin\UltraLims\Articles\ArticlesController as UltralimsArticlesController;
use App\Http\Controllers\Admin\UltraLims\Articles\CategoriesController as UltralimsCategoriesController;
use App\Http\Controllers\Admin\UltraLims\CookieController;
use App\Http\Controllers\Admin\UltraLims\ChatController as UltraLimsChatController;

//TICKET
use App\Http\Controllers\Admin\QuickActions\Tickets\TicketController;
use App\Http\Controllers\Admin\QuickActions\Tickets\ReasonsRefusalController;
use App\Http\Controllers\Admin\QuickActions\Tickets\PreAwnserController;
use App\Http\Controllers\Admin\QuickActions\Tickets\AutomaticMessagesController;
use App\Models\QuickActions\Tickets\AutomaticMessages;
use App\Models\QuickActions\Tickets\PreAwnser;
use App\Models\QuickActions\Tickets\ReasonsRefusal;

//REDIRECTS
use App\Http\Controllers\Admin\QuickActions\RedirectController;
//LGPD
use App\Http\Controllers\Admin\QuickActions\LGPD\LgpdController;
//EMAIL
use App\Http\Controllers\Admin\QuickActions\EmailController;

use App\Http\Controllers\Admin\General\BlogController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Site\WebhooksController;
//ROTAS DA LOJA
use App\Http\Controllers\Site\StoreController;
//EXCLUSIVO PARA O SITE DO Ultra Lims
use App\Http\Controllers\Site\UltraLIMS\UltraLimsController;
use App\Http\Controllers\Site\UltraLIMS\AlertController as UltraLimsAlertController;

/*
|--------------------------------------------------------------------------
| BIBLIOTECAS EXTERNAS
|--------------------------------------------------------------------------
|
|  composer require spatie/laravel-permission
|  composer require vinkla/hashids
|  composer require buglinjo/laravel-webp
|  composer require artesaos/seotools
|  composer require pragmarx/google2fa-laravel
|  composer require simplesoftwareio/simple-qrcode "~1"
|
*/

Route::get('/', function () {
    if (isset($_GET['busca']) && env('APP_NAME') == 'AABB-SP'){
        return redirect()->route('aabbsp.busca', $_GET['busca']);
    }
    $page = Page::where('slug', 'home')->first();
    SEOTools::setTitle(env('APP_NAME').' - '.$page->seo_title);
    SEOTools::setDescription($page->seo_description);
    SEOTools::setCanonical(route($page->slug));
    SEOTools::metatags()->addKeyword(explode(',', $page->seo_keywords));

    SEOTools::opengraph()->setType('article');
    SEOTools::opengraph()->setUrl(url('/' . $page->slug));
    SEOTools::opengraph()->addImage(str_replace('/public', '/storage', asset($page->seo_image)));

    SEOTools::jsonLd()->addImage(str_replace('/public', '/storage', asset($page->seo_image)));

    $index = true;
    return view('site.pages.index', compact('page', 'index'));
})->name('home');

//ROTA DOS REDIRECIONAMENTOS
foreach (\App\Models\QuickActions\Redirect::where('status', true)->get() as $redirect) {
    //Redireciona para a url
    Route::get($redirect->from, function () use ($redirect) {
        return redirect($redirect->to, 301);
    });
}

//ROTA DE EVENTOS
Route::get('/eventos/{slug}', [SiteController::class, 'event'])->name('events.show');
//ROTA DE EVENTOS
Route::get('/comunicados/{slug}', [SiteController::class, 'alert'])->name('alerts.show');
//ROTA DE EVENTOS
Route::get('/loadEvents', [SiteController::class, 'events'])->name('events');
//ROTA DE COMUNICADOS
Route::get('/loadAlerts', [SiteController::class, 'alerts'])->name('alerts');
//ROTA DE GALERIAS
Route::get('/loadGalleries', [SiteController::class, 'galleries'])->name('galleries');
//ROTA DE REVISTAS
Route::get('/loadMagazines', [SiteController::class, 'magazines'])->name('magazines');
//ROTA DE TÓPICOS
Route::get('/loadTopics', [SiteController::class, 'topics'])->name('topics');
//ROTA PARA A PÁGINA DE OBRIGADO
Route::get('/obrigado', [SiteController::class, 'obrigado'])->name('obrigado');
//ROTA PARA A PÁGINA DE OBRIGADO WPP
Route::get('/wpp', [SiteController::class, 'wpp'])->name('wpp');

Route::group([
    'prefix' => 'webhooks',
    'as' => 'webhooks.'
], function () {
    //ROTA QUE CRIA UM ARTIGO ATRAVÉS DE UM WEBHOOK
    Route::post('/machined/{appKey}', [WebhooksController::class, 'machined']);
    Route::post('/rankfix/{appKey}', [WebhooksController::class, 'rankfix']);
    if (env('APP_NAME') == 'Ultra Lims'){
        //ROTA QUE REALIZA O LOGIN NA ULTRALIMS ATRAVÉS DE UM WEBHOOK
        Route::post('/login/{appKey}', [WebhooksController::class, 'login']);
        Route::post('/alert/{appKey}', [WebhooksController::class, 'alert']);
    }
});

Route::group([
    'prefix' => 'apis',
    'as' => 'apis.'
], function () {
    if (env('APP_NAME') == 'Ultra Lims'){
        Route::get('/{appKey}/cliente-ultra/dashboard', [UltraLimsController::class, 'dashboard'])->name('ultralims.api.dashboard');
        Route::get('/{appKey}/cliente-ultra/loja', [UltraLimsController::class, 'produtoApi'])->name('ultralims.api.produto');
        Route::get('/{appKey}/cliente-ultra/blog', [UltraLimsController::class, 'blogApi'])->name('ultralims.api.produto');
        Route::get('/{appKey}/cliente-ultra/comunicados/{idLaboratorio}', [UltraLimsController::class, 'comunicadosApi'])->name('ultralims.api.comunicados');
        Route::post('/{appKey}/cliente-ultra/blog/webhook', [UltraLimsController::class, 'blogWebhook'])->name('ultralims.blog.blogWebhook');
        Route::post('/{appKey}/cliente-ultra/product/webhook', [UltraLimsController::class, 'productWebhook'])->name('ultralims.blog.productWebhook');
    }
});

/*Route::group([
    'prefix' => '',
    'as' => 'store.'
], function () {
    Route::get('/carrinho', [StoreController::class, 'cart'])->name('cart');
    Route::get('/pesquisa', [StoreController::class, 'search'])->name('search');
    Route::get('/historico', [StoreController::class, 'history'])->name('history');
    Route::get('/checkout', [StoreController::class, 'checkout'])->name('checkout');
    Route::get('/produto', [StoreController::class, 'product'])->name('product');
});*/

//ROTAS EXCLUSIVAS DO Ultra Lims
if (env('APP_NAME') == 'Ultra Lims'){
    Route::group(['middleware' => ['auth.ultralims']], function () {
        Route::get('/cliente-ultra', [UltraLimsController::class, 'index'])->name('ultralims.index');
        Route::get('/cliente-ultra/extensoes-lims', [UltraLimsController::class, 'produtos'])->name('ultralims.produtos');
        Route::get('/cliente-ultra/extensoes-lims/{slug}', [UltraLimsController::class, 'produto'])->name('ultralims.produtos.show');
        Route::get('/cliente-ultra/extensoes-lims/{slug}/eu-quero', [UltraLimsController::class, 'euQuero'])->name('ultralims.produtos.quero');
        Route::get('/cliente-ultra/extensoes-lims/{slug}/desejo', [UltraLimsController::class, 'wishlist'])->name('ultralims.produtos.wishlist');

        Route::get('/cliente-ultra/comunicados', [UltraLimsAlertController::class, 'index'])->name('ultralims.alerts.index');
        Route::get('/cliente-ultra/comunicados/{slug}', [UltraLimsAlertController::class, 'show'])->name('ultralims.alerts.show');
        Route::post('/cliente-ultra/comunicados', [UltraLimsAlertController::class, 'store'])->name('ultralims.alerts.store');
        Route::get('/cliente-ultra/comunicados/{id}/edit', [UltraLimsAlertController::class, 'edit'])->name('ultralims.alerts.edit');
        Route::put('/cliente-ultra/comunicados/{id}', [UltraLimsAlertController::class, 'update'])->name('ultralims.alerts.update');
        Route::delete('/cliente-ultra/comunicados/{id}', [UltraLimsAlertController::class, 'destroy'])->name('ultralims.alerts.destroy');

        Route::get('/cliente-ultra/cookies', [UltraLimsController::class, 'getCookies'])->name('ultralims.cookies.index');
        Route::get('/cliente-ultra/cookies/{cookie_id}/mark-as-seen', [UltraLimsController::class, 'markAsSeen'])->name('ultralims.cookies.seen');

        Route::post('/alerts/read', [UltraLimsController::class, 'alerts'])->name('ultralims.alerts.read');
        Route::post('/cliente-ultra/banners/{id}/read', [UltraLimsController::class, 'bannerRead'])->name('ultralims.banners.read');
        Route::post('/cliente-ultra/university/read', [UltraLimsController::class, 'universityRead'])->name('ultralims.university.read');
        Route::post('/cliente-ultra/call/read', [UltraLimsController::class, 'callRead'])->name('ultralims.call.read');
        Route::post('/cliente-ultra/chat/read', [UltraLimsController::class, 'chatRead'])->name('ultralims.chat.read');

        Route::post('/cliente-ultra/form', [UltraLimsController::class, 'form'])->name('ultralims.form');
    });
    //ROTAS DE BLOG
    Route::get('/cliente-ultra/chat', [UltraLimsController::class, 'chat'])->name('ultralims.chat');
    Route::get('/cliente-ultra/blog', [UltraLimsController::class, 'blog'])->name('ultralims.blog');
    Route::get('/cliente-ultra/blog/{slug}', [UltraLimsController::class, 'blogShow'])->name('ultralims.blog.show');

    //ROTAS DE LOGIN
    Route::get('/cliente-ultra/{id}/login', [UltraLimsController::class, 'login'])->name('ultralims.login');
    Route::post('/cliente-ultra/codex', [UltraLimsController::class, 'codex'])->name('ultralims.codex');
    Route::post('/cliente-ultra/ia', [UltraLimsController::class, 'ia'])->name('ultralims.ia');
}

//ROTAS PARA AS PÁGINAS
foreach (\App\Models\Pages\Page::all() as $page) {
    $url = '';
    if ($page->prefix_slug->count() > 0) {
        $url .= implode('/', $page->prefix_slug->pluck('slug')->toArray()) . '/';
    }
    $url .= $page->slug;

    if (\App\Models\QuickActions\Redirect::where('from', '/'.$url)->where('status', true)->count() > 0){
        continue;
    }

    Route::get($url, function () use ($page, $url) { //ROTA DAS PÁGINAS PUBLICADAS
        if ($page->intranet && !\Illuminate\Support\Facades\Auth::check()){
            return redirect()->route('auth.login');
        }
        if ($page->status) {
            SEOTools::setTitle(env('APP_NAME').' - '.$page->seo_title);
            SEOTools::setDescription($page->seo_description);
            SEOTools::setCanonical(route($page->slug));
            SEOTools::metatags()->addKeyword(explode(',', $page->seo_keywords));

            SEOTools::opengraph()->setType('article');
            SEOTools::opengraph()->setUrl(url('/' . $page->slug));
            SEOTools::opengraph()->addImage(str_replace('/public', '/storage', asset($page->seo_image)));

            SEOTools::jsonLd()->addImage(str_replace('/public', '/storage', asset($page->seo_image)));

            $index = true;
            return view('site.pages.index', compact('page', 'index', 'url'));
        } else {
            return redirect('/');
        }
    })->name($page->slug);

    if (env('APP_NAME') != 'AABB-SP'){
        Route::get($url . '/{page}', function (\App\Models\Pages\Page $page) use ($url) { //ROTAS DE TESTES DAS PÁGINAS
            $index = false;
            return view('site.pages.index', compact('page', 'index', 'url'));
        })->name('page.' . $page->hash_id);
    }
}

//ROTA PARA SALVAR SE ACEITOU OS COOKIES
Route::post('/lgpd', [LgpdController::class, 'store'])->name('lgpd');

//ROTA PARA OS BLOCOS DE CONTATO
Route::post('/contato/save/', [SiteController::class, 'contato'])->name('saveContato');

//ROTAS DE BLOG
Route::get('/blog', [FrontBlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [FrontBlogController::class, 'show'])->name('blog.show');

//-----------------------------------------------------------// - Rotas de autenticação
Route::group([
    'prefix' => 'auth',
    'as' => 'auth.',
], function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'makeLogin'])->name('makeLogin');
    Route::post('loginCode', [AuthController::class, 'makeLoginCode'])->name('makeLoginCode');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('forget-password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');
    Route::post('forget-password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');
    Route::get('reset-password/{token}', [AuthController::class, 'resetPassword'])->name('resetPassword');
    Route::post('reset-password-action', [AuthController::class, 'resetPasswordAction'])->name('resetPasswordAction');
});

//-----------------------------------------------------------// - Rotas do painel de administrador
Route::group([
    'middleware' => ['auth.user', 'access.panel'],
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('index');

    //ROTAS PARA A PERMISSÃO "Usuários"
    Route::group([
        'prefix' => 'users',
        'as' => 'users.',
    ], function () {
        Route::get('/{user}/qrCode', [AdminController::class, 'qrCode'])->name('qrCode');
        Route::get('/{user}/removeQrCode', [AdminController::class, 'removeQrCode'])->name('removeQrCode');
        Route::get('/{user}/permissions', [AdminController::class, 'permissions'])->name('permissions');
        Route::post('/{user}/permissions', [AdminController::class, 'permissionsSave'])->name('permissions.save');
        Route::get('/{user}/logs', [AdminController::class, 'logs'])->name('logs');
    });
    Route::resource('/users', AdminController::class);

    //ROTAS PARA PERMISSÃO "Configurações gerais"
    Route::group(['middleware' => ['can:Configurações gerais']], function () {
        Route::group([
            'prefix' => 'settings',
            'as' => 'settings.'
        ], function () {
            Route::get('/menu/create', [SettingsController::class, 'menuCreate'])->name('menu.create');
            Route::post('/menu', [SettingsController::class, 'menuStore'])->name('menu.store');
            Route::get('/menu/{menu}/edit', [SettingsController::class, 'menuEdit'])->name('menu.edit');
            Route::put('/menu/{menu}', [SettingsController::class, 'menuUpdate'])->name('menu.update');
            Route::delete('/menu/{menu}/destroy', [SettingsController::class, 'menuDestroy'])->name('menu.destroy');
            Route::get('/menu/{menu}/default', [SettingsController::class, 'menuDefault'])->name('menu.default');
            Route::get('/remove-logo/{menu}', [SettingsController::class, 'removeLogo'])->name('removeLogo');
            Route::get('/remove-logo-scroll/{menu}', [SettingsController::class, 'removeLogoScroll'])->name('removeLogoScroll');

            Route::post('/group', [SettingsController::class, 'storeItem'])->name('group.store');
            Route::put('/group/{group}', [SettingsController::class, 'updateItem'])->name('group.update');
            Route::get('/group/{group}/items', [SettingsController::class, 'showItems'])->name('group.show');
            Route::get('/group/{group}/default', [SettingsController::class, 'defaultItem'])->name('group.default');
            Route::delete('/group/{group}/destroy', [SettingsController::class, 'destroyItem'])->name('group.destroy');

            Route::post('/get-item-menu', [SettingsController::class, 'getItemMenu'])->name('getItemMenu');
            Route::post('/save-item-menu', [SettingsController::class, 'saveItemMenu'])->name('saveItemMenu');
            Route::delete('/delete-item-menu/{item_menu}', [SettingsController::class, 'deleteItemMenu'])->name('deleteItemMenu');
            Route::post('/display-order-item-menu', [SettingsController::class, 'displayOrderItemMenu'])->name('displayOrderItemMenu');

            Route::get('/fonts/create', [SettingsController::class, 'fontCreate'])->name('fonts.create');
            Route::post('/fonts', [SettingsController::class, 'fontStore'])->name('fonts.store');
            Route::get('/fonts/{font}/edit', [SettingsController::class, 'fontEdit'])->name('fonts.edit');
            Route::put('/fonts/{font}', [SettingsController::class, 'fontUpdate'])->name('fonts.update');
            Route::delete('/fonts/{font}/destroy', [SettingsController::class, 'fontDestroy'])->name('fonts.destroy');
            Route::get('/fonts/{font}/default', [SettingsController::class, 'fontDefault'])->name('fonts.default');

            Route::post('/save-cookie', [SettingsController::class, 'saveCookie'])->name('saveCookie');

            Route::post('/get-color', [SettingsController::class, 'getColor'])->name('getColor');
            Route::post('/save-color', [SettingsController::class, 'saveColor'])->name('saveColor');
            Route::delete('/delete-color/{color}', [SettingsController::class, 'deleteColor'])->name('deleteColor');

            Route::post('/get-scripts', [SettingsController::class, 'getScripts'])->name('getScripts');
            Route::post('/save-script', [SettingsController::class, 'saveScript'])->name('saveScript');
            Route::delete('/delete-script/{script}', [SettingsController::class, 'deleteScript'])->name('deleteScript');

            Route::get('/get-integration/{integration}', [SettingsController::class, 'getIntegration'])->name('getIntegration');
            Route::post('/save-integration/{integration}', [SettingsController::class, 'saveIntegration'])->name('saveIntegration');
        });
        Route::resource('/settings', SettingsController::class);
    });

    //-----------------------------------------------------------// - PUBLICAÇÕES

    //ROTAS PARA PERMISSÃO "Publicações"
    Route::group(['middleware' => ['can:Publicações']], function () {
        Route::group([
            'prefix' => 'articles',
            'as' => 'articles.'
        ], function () {
            Route::resource('/categories', CategoriesController::class);

            Route::post('/gpt', [ArticlesController::class, 'gpt'])->name('gpt');
            Route::post('/get-slug', [ArticlesController::class, 'getSlug'])->name('get.slug');
            Route::get('/{article}/undo/{id}', [ArticlesController::class, 'undo'])->name('undo');
        });
        Route::resource('/articles', ArticlesController::class);
    });

    //-----------------------------------------------------------// - PÁGINAS

    //ROTAS PARA PERMISSÃO "Páginas"
    Route::group(['middleware' => ['can:Páginas']], function () {
        Route::group([
            'prefix' => 'pages',
            'as' => 'pages.'
        ], function () {
            Route::resource('/categories', PageCategoriesController::class);
            Route::resource('/prefixSlug', PrefixSlugController::class);
            Route::post('/get-slug', [PageController::class, 'getSlug'])->name('get.slug');
            Route::get('/{page}/copy', [PageController::class, 'copy'])->name('copy');

            Route::get('/{type}/order', [PageController::class, 'order'])->name('order');
            Route::get('/{type}/order/{id}', [PageController::class, 'orderType'])->name('order.type');
            Route::post('/{type}/order/{id}', [PageController::class, 'saveOrder'])->name('save.order');

            Route::group([
                'prefix' => 'blocks',
                'as' => 'blocks.'
            ], function () {
                Route::any('/validate/bloco', [BlocksController::class, 'validateBloco'])->name('validateBloco');
                Route::any('/validate/content', [BlocksController::class, 'validateContent'])->name('validateContent');
                Route::any('/validate/layout', [BlocksController::class, 'validateLayout'])->name('validateLayout');

                Route::post('/display-order', [BlocksController::class, 'displayOrder'])->name('display-order');
                Route::post('/change-title', [BlocksController::class, 'changeTitle'])->name('change-title');

                Route::get('/{block}/copy', [BlocksController::class, 'copy'])->name('copy');
                Route::post('/makeTemplate', [BlocksController::class, 'makeTemplate'])->name('makeTemplate');
                Route::post('/useTemplate', [BlocksController::class, 'useTemplate'])->name('useTemplate');

                Route::get('/', [BlocksController::class, 'index'])->name('index');
                Route::get('/create', [BlocksController::class, 'create'])->name('create');
                Route::post('/', [BlocksController::class, 'store'])->name('store');
                Route::get('/{block}', [BlocksController::class, 'edit'])->name('edit');
                Route::post('/{block}', [BlocksController::class, 'update'])->name('update');
                Route::delete('/{block}', [BlocksController::class, 'destroy'])->name('destroy');
            });
        });
        Route::resource('/pages', PageController::class);

        Route::group([
            'prefix' => 'ia',
            'as' => 'ia.'
        ], function () {
            Route::post('/generate', [IAController::class, 'generate'])->name('generate');

            Route::resource('/prompts', PromptController::class);
        });
        Route::resource('/ia', IAController::class);
    });

    //-----------------------------------------------------------// - GERAL

    //ROTAS PARA CONSUMIR O BLOG DA IMPETUS
    Route::resource('/blog', BlogController::class);

    //ROTAS PARA PERMISSÃO "Cards"
    Route::group(['middleware' => ['can:Cards']], function () {
        Route::group([
            'prefix' => 'cards',
            'as' => 'cards.'
        ], function () {
            Route::resource('/categories', CardCategoriesController::class);
            Route::resource('/subcategories', CardSubcategoryController::class);
            Route::get('/{type}/order', [CardController::class, 'order'])->name('order');
            Route::get('/{type}/order/{id}', [CardController::class, 'orderType'])->name('order.type');
            Route::post('/{type}/order/{id}', [CardController::class, 'saveOrder'])->name('save.order');
            Route::get('/{card}/file', [CardController::class, 'file'])->name('file');
        });
        Route::resource('/cards', CardController::class);
    });

    //ROTAS PARA PERMISSÃO "Comunicados"
    Route::group(['middleware' => ['can:Comunicados']], function () {
        Route::group([
            'prefix' => 'alerts',
            'as' => 'alerts.'
        ], function () {
            Route::post('/get-slug', [AlertController::class, 'getSlug'])->name('get.slug');

            Route::get('/{type}/order', [AlertController::class, 'order'])->name('order');
            Route::get('/{type}/order/{id}', [AlertController::class, 'orderType'])->name('order.type');
            Route::post('/{type}/order/{id}', [AlertController::class, 'saveOrder'])->name('save.order');
        });
        Route::resource('/alerts', AlertController::class);
    });

    //ROTAS PARA PERMISSÃO "Depoimentos"
    Route::group(['middleware' => ['can:Depoimentos']], function () {
        Route::group([
            'prefix' => 'testimonials',
            'as' => 'testimonials.'
        ], function () {
            Route::resource('/categories', \App\Http\Controllers\Admin\General\Testimonials\CategoriesController::class);
        });
        Route::resource('/testimonials', TestimonialController::class);
    });

    //ROTAS PARA PERMISSÃO "Eventos"
    Route::group(['middleware' => ['can:Eventos']], function () {
        Route::group([
            'prefix' => 'events',
            'as' => 'events.'
        ], function () {
            Route::post('/get-slug', [EventController::class, 'getSlug'])->name('get.slug');

            Route::get('/{type}/order', [EventController::class, 'order'])->name('order');
            Route::get('/{type}/order/{id}', [EventController::class, 'orderType'])->name('order.type');
            Route::post('/{type}/order/{id}', [EventController::class, 'saveOrder'])->name('save.order');
        });
        Route::resource('/events', EventController::class);
    });

    //ROTAS PARA PERMISSÃO "FAQ"
    Route::group(['middleware' => ['can:FAQ']], function () {
        Route::group([
            'prefix' => 'faq',
            'as' => 'faq.'
        ], function () {
            Route::resource('/categories', FAQCategoriesController::class);
            Route::get('/{type}/order', [FAQController::class, 'order'])->name('order');
            Route::get('/{type}/order/{id}', [FAQController::class, 'orderType'])->name('order.type');
            Route::post('/{type}/order/{id}', [FAQController::class, 'saveOrder'])->name('save.order');
        });
        Route::resource('/faq', FAQController::class);
    });

    //ROTAS PARA PERMISSÃO "Galerias"
    Route::group(['middleware' => ['can:Galerias']], function () {
        Route::group([
            'prefix' => 'galleries',
            'as' => 'galleries.'
        ], function () {
            Route::post('/get-slug', [GalleryController::class, 'getSlug'])->name('get.slug');
            Route::resource('/photos', PhotoController::class);
        });
        Route::resource('/galleries', GalleryController::class);
    });

    //ROTAS PARA PERMISSÃO "Logos"
    Route::group(['middleware' => ['can:Logos']], function () {
        Route::group([
            'prefix' => 'logosCategories',
            'as' => 'logosCategories.'
        ], function () {
            Route::resource('/logos', LogoController::class);
        });
        Route::resource('/logosCategories', LogoCategoriesController::class);
    });

    //ROTAS PARA PERMISSÃO "Mídias"
    Route::group(['middleware' => ['can:Mídias']], function () {
        Route::group([
            'prefix' => 'folders',
            'as' => 'folders.'
        ], function () {
            Route::post('/upload', [ItemController::class, 'upload'])->name('items.upload');
            Route::resource('/items', ItemController::class);
        });
        Route::resource('/folders', FolderController::class);
    });

    //ROTAS PARA A PERMISSÃO "Portfólios"
    Route::group(['middleware' => ['can:Portfólios']], function () {
        Route::group([
            'prefix' => 'portfolios',
            'as' => 'portfolios.'
        ], function () {
            Route::get('/{type}/order', [PortfolioController::class, 'order'])->name('order');
            Route::get('/{type}/order/{id}', [PortfolioController::class, 'orderType'])->name('order.type');
            Route::post('/{type}/order/{id}', [PortfolioController::class, 'saveOrder'])->name('save.order');
            Route::resource('/categories', PortfolioCategoryController::class);
        });
        Route::resource('/portfolios', PortfolioController::class);
    });

    //ROTAS PARA A PERMISSÃO "Produtos"
    Route::group(['middleware' => ['can:Produtos']], function () {
        Route::group([
            'prefix' => 'products',
            'as' => 'products.'
        ], function () {
            Route::get('/{type}/order', [ProductController::class, 'order'])->name('order');
            Route::get('/{type}/order/{id}', [ProductController::class, 'orderType'])->name('order.type');
            Route::post('/{type}/order/{id}', [ProductController::class, 'saveOrder'])->name('save.order');
            Route::resource('/categories', ProductCategoryController::class);
            Route::post('/get-slug', [ProductController::class, 'getSlug'])->name('get.slug');

            Route::get('/orders', [ProductController::class, 'orders'])->name('orders');
            Route::get('/{product}/orders', [ProductController::class, 'ordersProduct'])->name('ordersProduct');
            Route::get('/wishlist', [ProductController::class, 'wishlist'])->name('wishlist');
            Route::get('/{product}/wishlist', [ProductController::class, 'wishlistProduct'])->name('wishlistProduct');
        });
        Route::resource('/products', ProductController::class);
    });

    //ROTAS PARA PERMISSÃO "Revistas"
    Route::group(['middleware' => ['can:Revistas']], function () {
        Route::resource('/magazines', MagazineController::class);
    });

    //ROTAS PARA PERMISSÃO "Tópicos"
    Route::group(['middleware' => ['can:Tópicos']], function () {
        Route::group([
            'prefix' => 'topics',
            'as' => 'topics.'
        ], function () {
            Route::resource('/categories', TopicsCategoriesController::class);
            Route::group([
                'prefix' => 'categories',
                'as' => 'categories.'
            ], function () {
                Route::post('/get', [TopicsCategoriesController::class, 'getCategories'])->name('get');
                Route::post('/display-order', [TopicsCategoriesController::class, 'displayOrder'])->name('display-order');
            });
            Route::post('/get/{category}', [TopicController::class, 'getFaqs'])->name('get');
            Route::post('/display-order', [TopicController::class, 'displayOrder'])->name('display-order');
        });
        Route::resource('/topics', TopicController::class);
    });

    //-----------------------------------------------------------// - Ultra Lims


    //ROTAS PARA PERMISSÃO "Publicações" e "Banners"
    if (env('APP_NAME') == 'Ultra Lims') {
        Route::group([
            'prefix' => 'ultralims',
            'as' => 'ultralims.'
        ], function () {
            Route::group(['middleware' => ['can:Publicações']], function () {
                Route::group([
                    'prefix' => 'articles',
                    'as' => 'articles.'
                ], function () {
                    Route::resource('/categories', UltralimsCategoriesController::class);

                    Route::post('/gpt', [UltralimsArticlesController::class, 'gpt'])->name('gpt');
                    Route::post('/get-slug', [UltralimsArticlesController::class, 'getSlug'])->name('get.slug');
                    Route::get('/{article}/undo/{id}', [UltralimsArticlesController::class, 'undo'])->name('undo');
                });
                Route::resource('/articles', UltralimsArticlesController::class);
            });

            Route::group(['middleware' => ['can:Cokies']], function () {
                Route::resource('/cookies', CookieController::class);
            });

            Route::group([
                'prefix' => 'chat',
                'as' => 'chat.'
            ], function () {
                Route::get('/', [UltralimsChatController::class, 'index'])->name('index');
                Route::get('/{id}', [UltralimsChatController::class, 'show'])->name('show');
                Route::put('/{id}', [UltralimsChatController::class, 'update'])->name('update');
            });
        });
        Route::group(['middleware' => ['can:Banners']], function () {
            Route::group([
                'prefix' => 'banners',
                'as' => 'banners.'
            ], function () {
                Route::get('/{type}/order', [BannerController::class, 'order'])->name('order');
                Route::get('/{type}/order/{id}', [BannerController::class, 'orderType'])->name('order.type');
                Route::post('/{type}/order/{id}', [BannerController::class, 'saveOrder'])->name('save.order');
            });
            Route::resource('/banners', BannerController::class);
        });
    }

    //-----------------------------------------------------------// - LGPD

    //ROTAS PARA "Super-Admin"
    Route::group(['middleware' => ['role:Super-Admin']], function () {
        Route::resource('/redirects', RedirectController::class);

        Route::group([
            'prefix' => 'lgpd',
            'as' => 'lgpd.'
        ], function () {
            Route::resource('/', LgpdController::class);
        });

        Route::resource('/emails', EmailController::class);
    });

    //-----------------------------------------------------------// - TICKETS

    //ROTAS PARA A PERMISSÃO TICKET ADMIN E TICKET ATENDENTE
    Route::group([
        'prefix' => 'tickets',
        'as' => 'tickets.',
        'middleware' => ['permission:Ticket Admin|Ticket Atendente']
    ], function () {
        Route::get('/', [TicketController::class, 'index'])->name('index');
        Route::delete('/{ticket}', [TicketController::class, 'destroy'])->name('destroy');
        Route::post('/store', [TicketController::class, 'store'])->name('store');
        Route::get('/show/{ticket}', [TicketController::class, 'show'])->name('show');
        Route::post('/set-user', [TicketController::class, 'setUserTicket'])->name('set-user');
        Route::post('/set-status', [TicketController::class, 'setStatusTicket'])->name('set-status');
        Route::post('/forward', [TicketController::class, 'forward'])->name('forward');
        Route::post('/send/message', [TicketController::class, 'sendMessage'])->name('send-message');
        Route::delete('/delete/message/{awnser}', [TicketController::class, 'deleteMessage'])->name('deleteMessage');
        Route::post('/preAwnser', [TicketController::class, 'getPreAwnser'])->name('get-pre-awnser');

        //ROTAS PARA A PERMISSÃO TICKET ADMIN
        Route::group([
            'prefix' => 'configuration',
            'as' => 'configuration.',
            'middleware' => ['can:Ticket Admin']
        ], function () {
            Route::get('/', function () {
                $reasonsRefusals = ReasonsRefusal::all();
                $preAwnsers = PreAwnser::all();
                $autoMessages = AutomaticMessages::all();

                $autoMessage = [];
                foreach ($autoMessages as $message) {
                    $autoMessage[$message->to] = $message->message;
                }

                $title = "Configurações";
                $breadcrumbs = [
                    ['url' => route('admin.tickets.index'), 'title' => 'Tickets'],
                    ['url' => route('admin.tickets.configuration.index'), 'title' => 'Configurações'],
                ];
                $data = [
                    'title' => $title,
                    'breadcrumbs' => $breadcrumbs,
                    'reasonsRefusals' => $reasonsRefusals,
                    'autoMessage' => $autoMessage,
                    'preAwnsers' => $preAwnsers
                ];
                return view('admin.pages.quickActions.tickets.configuration.index', $data);
            })->name('index');

            Route::group([
                'prefix' => 'reasons-refusal',
                'as' => 'reasons-refusal.'
            ], function () {
                Route::post('/store', [ReasonsRefusalController::class, 'store'])->name('store');
                Route::post('/update/{reasonsRefusal}', [ReasonsRefusalController::class, 'update'])->name('update');
                Route::post('/delete', [ReasonsRefusalController::class, 'destroy'])->name('destroy');
            });

            Route::group([
                'prefix' => 'pre-awnser',
                'as' => 'pre-awnser.'
            ], function () {
                Route::get('/create', [PreAwnserController::class, 'create'])->name('create');
                Route::get('/edit/{preAwnser}', [PreAwnserController::class, 'edit'])->name('edit');

                Route::post('/store', [PreAwnserController::class, 'store'])->name('store');
                Route::post('/update/{preAwnser}', [PreAwnserController::class, 'update'])->name('update');
                Route::post('/delete', [PreAwnserController::class, 'destroy'])->name('destroy');
            });

            Route::group([
                'prefix' => 'auto-message',
                'as' => 'auto-message.'
            ], function () {
                Route::post('/update', [AutomaticMessagesController::class, 'update'])->name('update');
            });
        });
    });
});

#CLIENT TICKETS
Route::post('tickets/set-status', [TicketController::class, 'setStatusTicket'])->name('tickets.set-status');
Route::post('tickets/login/{ticket}', [TicketController::class, 'clientLogin'])->name('ticket.login');
Route::group([
    'prefix' => 'tickets',
    'as' => 'tickets.public.'
], function () {
    Route::get('/abrir-ticket', [TicketController::class, 'create'])->name('index');
    Route::get('/{ticket}', [TicketController::class, 'showPublic'])->name('show');
    Route::post('/{ticket}/send-message', [TicketController::class, 'sendMessage'])->name('send-message');
});

//-----------------------------------------------------------// - ROTAS DE COMANDOS NO PHP
/*Route::get('migrate', function () {
    Artisan::call('migrate');
});
Route::get('db', function () {
    Artisan::call('migrate:fresh --seed');
});
Route::get('storage', function () {
    Artisan::call('storage:link');
});
Route::get('flushCache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
});

Route::get('/makeUser', function () {
    $user = new \App\Models\User();
    $user->name = 'Impetus';
    $user->lastname = 'Sistemas';
    $user->description = 'Administrador do sistema.';
    $user->email = 'admin@impetussistemas.com.br';
    $user->password = \Illuminate\Support\Facades\Hash::make('123456');
    $user->status = 1;
    $user->office = 'Super Admin';
    $user->save();
});*/

//-----------------------------------------------------------// - ROTAS DE SCRIPTS DE MANIPULAÇÃO DE BANCO DE DADOS
//Criar permissões do sistema
/*Route::get('makePermissions', function(){
    $role = Role::create(['name' => 'Ações rápidas']);
    $configuracoesGerais = Permission::create(['name' => 'Configurações gerais']);
    $usuarios = Permission::create(['name' => 'Usuários']);
    $role->syncPermissions($configuracoesGerais->id, $usuarios->id);

    $role = Role::create(['name' => 'Publicações']);
    $publicacoes = Permission::create(['name' => 'Publicações']);
    $role->syncPermissions($publicacoes->id);

    $role = Role::create(['name' => 'Páginas']);
    $paginas = Permission::create(['name' => 'Páginas']);
    $role->syncPermissions($paginas->id);

    $role = Role::create(['name' => 'Geral']);
    $depoimentos = Permission::create(['name' => 'Depoimentos']);
    $faq = Permission::create(['name' => 'FAQ']);
    $topicos = Permission::create(['name' => 'Tópicos']);
    $logos = Permission::create(['name' => 'Logos']);
    $eventos = Permission::create(['name' => 'Eventos']);
    $galerias = Permission::create(['name' => 'Galerias']);
    $cards = Permission::create(['name' => 'Cards']);
    $comunicados = Permission::create(['name' => 'Comunicados']);
    $role->syncPermissions($depoimentos->id, $faq->id, $topicos->id, $logos->id, $eventos->id, $galerias->id, $cards->id, $comunicados->id);

    $user = \App\Models\User::where('email', 'admin@impetussistemas.com.br')->first();
    $role = \Spatie\Permission\Models\Role::create(['name' => 'Super-Admin']);
    $user->assignRole($role);
});*/
//Criar permissões de ticket
/*Route::get('makePermissionsTicket', function(){
    $role = Role::create(['name' => 'Tickets']);
    $ticket_admin = \Spatie\Permission\Models\Permission::create(['name' => 'Ticket Admin']);
    $ticket_atendente = \Spatie\Permission\Models\Permission::create(['name' => 'Ticket Atendente']);
    $role->syncPermissions($ticket_admin->id, $ticket_atendente->id);
});*/
//CRIAR PERMISSÕES DO III
/*Route::get('makePermissionsIII', function(){
    $role = \Spatie\Permission\Models\Role::create(['name' => 'III']);
    $membros = \Spatie\Permission\Models\Permission::create(['name' => 'Membros']);
    $centrosPesquisa = \Spatie\Permission\Models\Permission::create(['name' => 'Centros de pesquisa']);
    $pesquisasPlataformas = \Spatie\Permission\Models\Permission::create(['name' => 'Pesquisas/Plataformas']);
    $role->syncPermissions($membros->id, $centrosPesquisa->id, $pesquisasPlataformas->id);
});*/
//CRIAR PERMISSÕES DO Ultra Lims
/*Route::get('makePermissionsUL', function(){
    $role = \Spatie\Permission\Models\Role::create(['name' => 'Ultra Lims']);
    $banners = \Spatie\Permission\Models\Permission::create(['name' => 'Banners']);
    $role->syncPermissions($banners->id);
});*/
//NOVAS PERMISSÕES
/*Route::get('/portfolioPermission', function (){
    $role = \Spatie\Permission\Models\Role::where('name', 'Geral')->first();
    $portfolio = \Spatie\Permission\Models\Permission::create(['name' => 'Portfólios']);
    $role->permissions()->attach($portfolio);
});
Route::get('/produtosPermission', function (){
    $role = \Spatie\Permission\Models\Role::where('name', 'Geral')->first();
    $produto = \Spatie\Permission\Models\Permission::create(['name' => 'Produtos']);
    $role->permissions()->attach($produto);
});
Route::get('/midiasPermission', function () {
    $role = \Spatie\Permission\Models\Role::where('name', 'Geral')->first();
    $midias = \Spatie\Permission\Models\Permission::create(['name' => 'Mídias']);
    $role->permissions()->attach($midias);
});
Route::get('/cookiesPermission', function () {
    $role = \Spatie\Permission\Models\Role::where('name', 'Ultra Lims')->first();
    $cookies = \Spatie\Permission\Models\Permission::create(['name' => 'Cookies']);
    $role->permissions()->attach($cookies);
});*/

/* CRIA A INTEGRAÇÃO COM O MAILERSEND
Route::get('/createIntegration', function (){
    \App\Models\Settings\Integration::create([
        'title' => 'MailerSend',
        'documentation' => "Para acessar a documentação clique <a href='https://developers.mailersend.com/?_gl=1*pscp3i*_gcl_aw*R0NMLjE3MTg5OTkyNjMuQ2p3S0NBand5ZFN6QmhCT0Vpd0FqMFhONEo0TFRVY3hUb25XSnQtcUN4RVlKcTBXRTRPYnhfRTFjYnlZZFpWV0FfOVhwN2V3ZkwzRm5Cb0NHUUlRQXZEX0J3RQ..*_gcl_au*MTY3MzkzNTU5NC4xNzE4OTk0NDA0*_up*MQ..&gclid=CjwKCAjwydSzBhBOEiwAj0XN4J4LTUcxTonWJt-qCxEYJq0WE4Obx_E1cbyYdZVWA_9Xp7ewfL3FnBoCGQIQAvD_BwE' target='_blank'><b><u><em>aqui</em></u></b></a>",
    ]);
});
*/
//CRIA A INTEGRAÇÃO COM O EPICFLOW
/*Route::get('/createIntegration', function (){
    \App\Models\Settings\Integration::create([
        'title' => 'EpicFlow',
        'documentation' => "Para acessar a documentação clique <a href='http://flow.ultralims.com.br/' target='_blank'><b><u><em>aqui</em></u></b></a>",
    ]);
});


Route::get('/setCookies', function (){
    return redirect()->route('home');
});

*/
<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Articles\Category as ArticlesCategory;
use App\Models\General\Testimonials\Testimonial;
use App\Models\General\Topics\Topic;
use App\Models\Pages\Category;
use App\Models\Pages\Page;
use App\Models\Pages\PrefixSlug;
use App\Models\Settings\Color;
use App\Models\Settings\Font;
use App\Models\Settings\Group_Item_Menu;
use App\Models\Settings\Menu;
use Buglinjo\LaravelWebp\Webp;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PageController extends Controller{
    public function index(){
        $title = 'Páginas';
        $breadcrumbs = [
            ['url' => route('admin.pages.index'), 'title' => 'Páginas'],
        ];
        $pages = Page::orderBy('title')->get();
        return view('admin.pages.pages.list', compact('title', 'breadcrumbs', 'pages'));
    }

    public function show(Page $page){
        $title = 'Layout da página';
        $breadcrumbs = [
            ['url' => route('admin.pages.index'), 'title' => 'Páginas'],
            ['url' => route('admin.pages.show', $page->hash_id), 'title' => $title],
        ];
        $pages = Page::all();
        $fonts = Font::orderBy('profile')->get();
        $colors = Color::all();

        $titleColor = Color::where($page->mode == 'light' ? 'is_default_title_light':'is_default_title_dark', true)->first();
        if ($titleColor == null){
            $titleColor = new Color();
            if ($page->mode == 'light'){
                $titleColor->color = '#0E1326';
            }else{
                $titleColor->color = '#FFFFFF';
            }
        }
        $contentColor = Color::where($page->mode == 'light' ? 'is_default_content_light':'is_default_content_dark', true)->first();
        if ($contentColor == null){
            $contentColor = new Color();
            if ($page->mode == 'light'){
                $contentColor->color = '#9FADC2';
            }else{
                $contentColor->color = '#FFFFFF';
            }
        }
        $iconColor = Color::where($page->mode == 'light' ? 'is_default_icon_light':'is_default_icon_dark', true)->first();
        if ($iconColor == null){
            $iconColor = new Color();
            $iconColor->color = '#03B7FC';
        }

        return view('admin.pages.pages.show', compact('title', 'breadcrumbs', 'page', 'pages', 'colors', 'titleColor', 'contentColor', 'iconColor', 'fonts'));
    }

    public function create()
    {
        $title = 'Criar página';
        $breadcrumbs = [
            ['url' => route('admin.pages.index'), 'title' => 'Páginas'],
            ['url' => route('admin.pages.create'), 'title' => $title],
        ];
        $page = new Page();
        $pages = Page::orderBy('title')->get();
        $categories = Category::orderBy('title')->get();
        $menus = Menu::orderBy('title')->get();
        $groups = Group_Item_Menu::orderBy('title')->get();
        $prefixSlugs = PrefixSlug::orderBy('slug')->get();
        return view('admin.pages.pages.form', compact('title', 'breadcrumbs', 'page', 'categories', 'prefixSlugs', 'pages', 'menus', 'groups'));
    }

    public function store(Request $request)
    {
        $page = new Page();
        $json = $this->save($request, $page, 'store');
        return $json;
    }

    public function edit(Page $page)
    {
        $title = 'Editar página';
        $breadcrumbs = [
            ['url' => route('admin.pages.index'), 'title' => 'Páginas'],
            ['url' => route('admin.pages.edit', $page->hash_id), 'title' => $title],
        ];
        $pages = Page::where('id', '!=', $page->id)->orderBy('title')->get();
        $categories = Category::orderBy('title')->get();
        $menus = Menu::orderBy('title')->get();
        $groups = Group_Item_Menu::orderBy('title')->get();
        $prefixSlugs = PrefixSlug::orderBy('slug')->get();
        return view('admin.pages.pages.form', compact('title', 'breadcrumbs', 'page', 'categories', 'prefixSlugs', 'pages', 'menus', 'groups'));
    }

    public function update(Request $request, Page $page)
    {
        $json = $this->save($request, $page, 'update');
        return $json;
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return response()->json([
            'success' => true,
            'message' => 'Página excluída com sucesso!',
        ]);
    }

    public function save($request, $page, $action){
        $validator = Validator::make($request->all(), [
            'categories_id' => 'required',
            'menu_id' => 'required',
            'title' => 'required',
            'slug' => 'required',
            'intranet' => 'required',
            'mode' => 'required',
            'header' => 'required',
            'footer' => 'required',
            'seo_title' => 'required',
            'seo_description' => 'required',
        ],[
            'categories_id.required' => 'A sessão é obrigatória',
            'menu_id.required' => 'É obrigatório selecionar um menu',
            'title.required' => 'O título é obrigatório',
            'slug.required' => 'O slug é obrigatório',
            'intranet.required' => 'É obrigatório selecionar se a página é uma intranet',
            'mode.required' => 'É obrigatório definir se a página é modo light ou dark',
            'header.required' => 'É obrigatório definir se a página exibirá o header',
            'footer.required' => 'É obrigatório definir se a página exibirá o footer',
            'seo_title.required' => 'O título de SEO é obrigatório',
            'seo_description.required' => 'A descrição de SEO é obrigatória',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        DB::beginTransaction();
        try{
            if($request->has('photo')){
                $base64_image = $request->input('photo'); // your base64 encoded

                $folder = 'storage/pages';
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
                $tmpFile = new \Symfony\Component\HttpFoundation\File\File($tmpFilePath);

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
                $path = $page->seo_image;
            }

            /*if ($request->has('svg')){
                $directory = '/pages/svg';
                // Verifica se a pasta já existe, se não, cria com permissão 755
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory, 0755, true);
                }

                $file = $request->file('svg');
                $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . date('Ymd_His');
                $extension = $file->getClientOriginalExtension();
                $svg = 'storage/'.$file->storeAs($directory, $filename . '.' . $extension, 'public');
            }else{
                $svg = $page->svg;
            }*/

            $page->fill($request->input());
            $page->seo_image = $path;
            $page->menu = 0;
            //$page->page_id = $request->page_id == 0 ? null : $request->page_id;
            if ($action == 'store'){
                $page->display_order = Page::max('display_order') + 1;
            }
            $page->save();

            $page->categories()->sync($request->categories_id);
            $page->pages_parents()->sync($request->pages_id);

            $page->prefix_slug()->sync(null);
            if (isset($request->slug_prefix)){
                $page->prefix_slug()->sync($request->slug_prefix);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Página '.($action == 'store' ? 'criada':'editada').' com sucesso!',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." o página!".$e->getMessage()
            ]);
        }
    }

    public function getSlug(Request $request){
        /*$slug = $request->title;
        $slug = Str::slug($slug);
        $page = Page::where('slug', $slug)->first();
        if(!$page){
            return response()->json([
                'success' => true,
                'slug' => $slug,
            ]);
        }

        return response()->json([
            'success' => false,
            'suggestion' => date('d-m-Y-H-i').'-'.$slug,
        ]);*/

        return response()->json([
            'success' => true,
            'slug' => Str::slug($request->title),
        ]);
    }

    public function copy(Page $page){
        DB::beginTransaction();
        try{
            $new_page = $page->replicate();
            $new_page->push();
            $new_page->title = $page->title.' - Cópia';
            $new_page->slug = $page->slug.'-copia';
            $new_page->status = false;
            $new_page->save();

            $new_page->prefix_slug()->sync($page->prefix_slug->pluck('id')->toArray());
            foreach ($page->blocks as $block){
                $new_block = $block->replicate();
                $new_block->push();
                $new_block->page_id = $new_page->id;
                $new_block->save();
                foreach ($block->tabs as $tab){
                    $new_tab = $tab->replicate();
                    $new_tab->push();
                    $new_tab->block_id = $new_block->id;
                    $new_tab->save();
                }
            }
            DB::commit();
            return response()->json([
                'success' => true
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao copiar página: ".$e->getMessage()
            ]);
        }
    }

    public function order($type){
        if ($type == 'page'){
            $items = Page::orderBy('title')->get();
        }elseif ($type == 'pages'){
            $items = Page::orderBy('display_order')->get();
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
        if ($type == 'page'){
            $page = Page::find($id);
            $items = $page->pages_childrens;
        }elseif ($type == 'pages'){
            $items = Page::orderBy('display_order')->get();
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
        if ($type == 'page'){
            foreach ($request->items as $item_id) {
                DB::table('pages_pages_pivot')
                    ->where('page_parent_id', $id)
                    ->where('page_id', $item_id)
                    ->update(['display_order' => $i]);
                $i++;
            }
        }elseif ($type == 'pages'){
            foreach ($request->items as $item){
                $page = Page::where('id', $item)->first();
                $page->display_order = $i;
                $page->save();
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

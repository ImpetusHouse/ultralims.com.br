<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pages\Page;
use App\Models\Settings\Color;
use App\Models\Settings\Cookie;
use App\Models\Settings\Font;
use App\Models\Settings\Group_Item_Menu;
use App\Models\Settings\Integration;
use App\Models\Settings\Item_Menu;
use App\Models\Settings\Menu;
use App\Models\Settings\Script;
use Buglinjo\LaravelWebp\Webp;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class SettingsController extends Controller
{
    public function index(){

        $title = "Configurações gerais";
        $breadcrumbs = [
            ['title' => $title, 'url' => route('admin.settings.index')]
        ];
        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'pages' => Page::where('status', 1)->orderBy('title')->get(),
            'groups' => Group_Item_Menu::orderBy('title')->get(),
            'menus' => Menu::orderBy('title')->get(),
            'fonts' => Font::orderBy('profile')->get(),
            'cookie' => Cookie::first(),
            'colors' => Color::all(),
            'scripts' => Script::orderBy('title')->get(),
            'integrations' => Integration::orderBy('title')->get()
        ];
        return view('admin.pages.settings.index', $data);
    }

    //-----------------------------------------------------------// - LAYOUTS DE MENU
    function menuCreate(){
        $title = 'Criar menu';
        $breadcrumbs = [
            ['title' => 'Configurações gerais', 'url' => route('admin.settings.index')],
            ['title' => $title, 'url' => route('admin.settings.menu.create')],
        ];
        $menu = new Menu();
        $colors = Color::all();
        return view('admin.pages.settings.menu.form', compact('title', 'breadcrumbs', 'menu', 'colors'));
    }

    function menuStore(Request $request){
        return $this->saveMenu($request, new Menu(), 'store');
    }

    function menuEdit(Menu $menu){
        $title = 'Editar menu';
        $breadcrumbs = [
            ['title' => 'Configurações gerais', 'url' => route('admin.settings.index')],
            ['title' => $title, 'url' => route('admin.settings.menu.edit', $menu->hash_id)],
        ];
        $colors = Color::all();
        return view('admin.pages.settings.menu.form', compact('title', 'breadcrumbs', 'menu', 'colors'));
    }

    function menuUpdate(Request $request, Menu $menu)
    {
        return $this->saveMenu($request, $menu, 'update');
    }

    public function saveMenu($request, $menu, $action){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'layout' => 'required',
            'background_color' => 'required',
            'item_color' => 'required',
            'item_hover_color' => 'required',
        ],[
            'title.required' => 'O título é obrigatório',
            'layout.required' => 'O layout é obrigatório',
            'background_color.required' => 'A cor de fundo é obrigatória',
            'item_color.required' => 'A cor do item é obrigatória',
            'item_hover_color.required' => 'A cor do item (hover) é obrigatória'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try {
            $menu->fill($request->all());
            $menu->save();

            $directoryPath = 'public/settings/menu/' . $menu->hash_id;
            // Verifica se o diretório não existe e cria com a permissão 755
            if (!Storage::exists($directoryPath)) {
                Storage::makeDirectory($directoryPath, 0755, true);
            }
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = $file->getClientOriginalName();
                $menu->logo = $file->storeAs($directoryPath, $filename);
            }
            if ($request->hasFile('logo_scroll')) {
                $file = $request->file('logo_scroll');
                $filename = $file->getClientOriginalName();
                $menu->logo_scroll = $file->storeAs($directoryPath, $filename);
            }
            $menu->save();
            DB::commit();
            return response()->json(['success' => true, 'Menu '.($action == 'store' ? 'criado':'editado').' com sucesso']);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao salvar configurações do menu, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    function menuDestroy(Menu $menu){
        DB::beginTransaction();
        try {
            $menu->delete();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Menu deletado com sucesso']);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao deletar menu, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    public function removeLogo(Menu $menu){
        try {
            $menu->update([
                'logo' => null
            ]);
            return response()->json(['success' => true, 'message' => 'Logo removida com sucesso']);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Falha ao remover logo, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    public function removeLogoScroll(Menu $menu){
        try {
            $menu->update([
                'logo_scroll' => null
            ]);
            return response()->json(['success' => true, 'message' => 'Logo removida com sucesso']);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Falha ao remover logo, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    //-----------------------------------------------------------// - ITENS DE MENU

    public function storeItem(Request $request){
        return $this->saveItem($request, new Group_Item_Menu(), 'store');
    }

    public function updateItem(Request $request, Group_Item_Menu $group){
        return $this->saveItem($request, $group, 'update');
    }

    public function saveItem($request, $group, $action){
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ],[
            'title.required' => 'O título é obrigatório'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try {
            $group->fill($request->all());
            $group->save();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Menu '.($action == 'store' ? 'salvo':'editado').' com sucesso']);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao '.($action == 'store' ? 'salvar':'editar').' menu, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    public function showItems(Group_Item_Menu $group){
        $title = 'Itens de menu';
        $breadcrumbs = [
            ['title' => 'Configurações gerais', 'url' => route('admin.settings.index')],
            ['title' => $title, 'url' => route('admin.settings.group.show', $group->hash_id)],
        ];
        return view('admin.pages.settings.menu.group.items', [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'group' => $group,
            'items_menu' => $group->items,
            'pages' => Page::orderBy('title')->get(),
            'colors' => Color::all(),
        ]);
    }

    public function defaultItem(Group_Item_Menu $group){
        Group_Item_Menu::where('default', true)->update(['default' => false]);
        $group->default = true;
        $group->save();
        return redirect()->route('admin.settings.index');
    }

    public function destroyItem(Group_Item_Menu $group){
        DB::beginTransaction();
        try {
            $group->delete();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Menu deletado com sucesso']);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao deletar menu, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    //-----------------------------------------------------------// - ITENS

    public function getItemMenu(Request $request){
        try {
            $itemsMenu = Item_Menu::where('id', '!=', $request->id)->where('type', 'menu')->orderBy('display_order')->get();
            return response()->json([
                'success' => true,
                'itemMenu' => $request->id == 'null' ? null : Item_Menu::findOrFail($request->id)->toArray(),
                'itemsMenu' => $itemsMenu->count() == 0 ? null:$itemsMenu->toArray()
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function saveItemMenu(Request $request){
        //Valida se o modal está enviando o título e o tipo do menu que será adicionado
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'type' => 'required',
            'item_menu_id' => 'required'
        ],[
            'title' => 'O título é obrigatório!',
            'type' => 'O tipo é obrigatório!',
            'item_menu_id' => 'É obrigatório informar se não pertence a nenhum ou à algum item de menu!'
        ]);
        //Caso houver alguma informação faltando, retorna a mensagem para o usuário
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        if ($request->menu_with_link){
            //Se for um menu do tipo link, valida se o link está sendo enviado
            $validator = Validator::make($request->all(), [
                'menu_with_link_type' => 'required'
            ],[
                'menu_with_link_type.required' => 'O tipo de link do menu é obrigatório'
            ]);
        }

        if ($request->type == 'link' || $request->menu_with_link_type == 'link'){
            //Se for um menu do tipo link, valida se o link está sendo enviado
            $validator = Validator::make($request->all(), [
                'link' => 'required'
            ],[
                'link' => 'O link é obrigatório!'
            ]);
        }elseif ($request->type == 'página' || $request->menu_with_link_type == 'página'){
            //Se for um menu do tipo página, valida se o id da página está sendo enviado
            $validator = Validator::make($request->all(), [
                'page_id' => 'required'
            ],[
                'page_id' => 'A página é obrigatória!'
            ]);
        }
        //Caso houver alguma informação faltando, retorna a mensagem para o usuário
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        //Início das ações no banco de dados
        DB::beginTransaction();
        try {
            //Busca se já existe esse item, caso não houver, cria um novo item
            if ($request->id == null){
                $itemMenu = new Item_Menu();
                $html = true;
            }else{
                $itemMenu = Item_Menu::findOrFail($request->id);
                $html = false;
            }

            if ($itemMenu->display_order == null){
                //Busca a posição que esse item será adicionado no menu, se não houver nenhum, começa a partir do 1
                $lastItemMenu = Item_Menu::where('group_id', $request->group_id)->orderBy('display_order', 'desc')->first();
                if ($lastItemMenu == null){
                    $display_order = 1;
                }else{
                    $display_order = $lastItemMenu->display_order + 1;
                }
            }else{
                $display_order = $itemMenu->display_order;
            }

            //Insere as informações do menu
            $itemMenu->fill($request->input());
            if ($itemMenu->item_menu_id == 'null'){
                $itemMenu->item_menu_id = null;
            }
            $itemMenu->display_order = $display_order;
            $itemMenu->menu_with_link = isset($request->menu_with_link);
            $itemMenu->menu_with_link_mobile = isset($request->menu_with_link_mobile);
            $itemMenu->is_mega_menu = isset($request->is_mega_menu);
            $itemMenu->background = isset($request->background);
            $itemMenu->save();

            /*if ($html){
                $html .= '<tr>';
                $html .= ' <input type="hidden" name="ids[]" value="'.$itemMenu->id.'"/>';
                $html .= '<td style="cursor: pointer"><i class="fas fa-bars text-gray-800"></i></td>';
                $html .= '<td><span class="text-gray-800 fs-5 fw-bold">'.$itemMenu->title.'</span></td>';
                $html .= ' <td><span class="text-gray-800 fs-5 fw-bold">'.ucfirst($itemMenu->type).'</span></td>';
                $html .= '<td class="text-center">';
                $itemMenuId = "'".$itemMenu->id."'";
                $html .= '<button type="button" class="btn btn-sm btn-icon btn-light-primary" onclick="openMenuModal('.$itemMenuId.')">';
                $html .= '<i class="fas fa-pencil"></i>';
                $html .= '</button>';
                $html .= '<button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="removeItemMenu('.$itemMenuId.')" style="margin-left: 4px">';
                $html .= '<i class="fas fa-trash"></i>';
                $html .= '</button>';
                $html .= '</td>';
                $html .= '</tr>';
            }*/

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Item de menu '.($html != false ? 'adicionado':'editado').' com sucesso!',
                'html' => $html
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function menuDefault(Menu $menu){
        DB::beginTransaction();
        try {
            Menu::where('default', true)->update([
                'default' => false
            ]);
            $menu->default = true;
            $menu->save();
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
        }
        return redirect()->route('admin.settings.index');
    }

    public function deleteItemMenu(Item_Menu $item_menu){
        try {
            $item_menu->delete();
            return response()->json([
                'success' => true
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function displayOrderItemMenu(Request $request){
        try {
            $display_order = 1;
            foreach ($request->ids as $id){
                $itemMenu = Item_Menu::findOrFail($id);
                $itemMenu->display_order = $display_order;
                $itemMenu->save();
                $display_order++;
            }
            return response()->json([
                'success' => true
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    //-----------------------------------------------------------// - FONTES

    public function fontCreate(){
        $title = 'Criar fonte';
        $breadcrumbs = [
            ['title' => 'Configurações gerais', 'url' => route('admin.settings.index')],
            ['title' => $title, 'url' => route('admin.settings.fonts.create')],
        ];
        $font = new Font();
        return view('admin.pages.settings.fonts.form', compact('title', 'breadcrumbs', 'font'));
    }

    public function fontStore(Request $request){
        return $this->fontsSave($request, new Font(), 'store');
    }

    public function fontEdit(Font $font){
        $title = 'Editar fonte';
        $breadcrumbs = [
            ['title' => 'Configurações gerais', 'url' => route('admin.settings.index')],
            ['title' => $title, 'url' => route('admin.settings.fonts.edit', $font->hash_id)],
        ];
        return view('admin.pages.settings.fonts.form', compact('title', 'breadcrumbs', 'font'));
    }

    public function fontUpdate(Request $request, Font $font){
        return $this->fontsSave($request, $font, 'update');
    }

    public function fontDestroy(Font $font){
        DB::beginTransaction();
        try {
            $font->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Fonte excluída com sucesso'
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao excluir fonte, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    public function fontsSave($request, $font, $action)
    {
        $validator = Validator::make($request->all(), [
            'profile' => 'required',
            'desktop' => 'required|numeric',
            'mobile' => 'required|numeric',
            'type' => 'required|in:title,description,button',
            'line_spacing' => 'required|numeric',
            'is_bold' => 'boolean',
        ], [
            'profile.required' => 'O perfil é obrigatório',
            'desktop.required' => 'Um tamanho de fonte para desktop é obrigatório',
            'desktop.numeric' => 'O tamanho de fonte para desktop deve ser um número',
            'mobile.required' => 'Um tamanho de fonte para mobile é obrigatório',
            'mobile.numeric' => 'O tamanho de fonte para mobile deve ser um número',
            'type.required' => 'O tipo é obrigatório',
            'type.in' => 'O tipo deve ser título, descrição ou botão',
            'line_spacing.required' => 'O espaçamento entre linhas é obrigatório',
            'line_spacing.numeric' => 'O espaçamento entre linhas deve ser um número',
            'is_bold.boolean' => 'O valor de negrito deve ser verdadeiro ou falso',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        DB::beginTransaction();
        try {
            $font->fill($request->all());
            $font->save();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Fonte ' . ($action == 'store' ? 'criada' : 'editada') . ' com sucesso']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao salvar configurações de fonte, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }


    public function fontDefault(Font $font){
        DB::beginTransaction();
        try {
            // Desativar o default apenas para perfis do mesmo tipo
            Font::where('type', $font->type)->where('default', true)->update([
                'default' => false
            ]);

            // Definir o perfil fornecido como default
            $font->default = true;
            $font->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
        return redirect()->route('admin.settings.index');
    }


    //-----------------------------------------------------------// - COOKIE

    public function saveCookie(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required',
        ],[
            'title.required' => 'O título é obrigatório',
            'status.required' => 'É obrigatório selecionar se irá exibir ou não',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try {
            $cookie = Cookie::first();
            $cookie->fill($request->all());
            $cookie->save();
            DB::commit();
            return response()->json(['success' => true]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Falha ao salvar informações do alerta de cookie, tente novamente']);
        }
    }

    //-----------------------------------------------------------// - COLOR

    public function getColor(Request $request){
        try {
            return response()->json([
                'success' => true,
                'color' => $request->id == 'null' ? null : Color::findOrFail($request->id)->toArray()
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function saveColor(Request $request){
        $validator = Validator::make($request->all(), [
            'color' => 'required'
        ],[
            'color.required' => 'A cor é obrigatória'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try {
            if ($request->id == null){
                $color = new Color();
            }else{
                $color = Color::findOrFail($request->id);
            }
            $color->fill($request->input());
            if (isset($request->is_default_title_light)){
                $is_default_title_light = Color::where('is_default_title_light', true)->where('id', '!=', $color->id)->first();
                if ($is_default_title_light != null){
                    $is_default_title_light->is_default_title_light = false;
                    $is_default_title_light->save();
                }
            }
            if (isset($request->is_default_title_dark)){
                $is_default_title_dark = Color::where('is_default_title_dark', true)->where('id', '!=', $color->id)->first();
                if ($is_default_title_dark != null){
                    $is_default_title_dark->is_default_title_dark = false;
                    $is_default_title_dark->save();
                }
            }
            if (isset($request->is_default_content_light)){
                $is_default_content_light = Color::where('is_default_content_light', true)->where('id', '!=', $color->id)->first();
                if ($is_default_content_light != null){
                    $is_default_content_light->is_default_content_light = false;
                    $is_default_content_light->save();
                }
            }
            if (isset($request->is_default_content_dark)){
                $is_default_content_dark = Color::where('is_default_content_dark', true)->where('id', '!=', $color->id)->first();
                if ($is_default_content_dark != null){
                    $is_default_content_dark->is_default_content_dark = false;
                    $is_default_content_dark->save();
                }
            }
            if (isset($request->is_default_icon_light)){
                $is_default_icon_light = Color::where('is_default_icon_light', true)->where('id', '!=', $color->id)->first();
                if ($is_default_icon_light != null){
                    $is_default_icon_light->is_default_icon_light = false;
                    $is_default_icon_light->save();
                }
            }
            if (isset($request->is_default_icon_dark)){
                $is_default_icon_dark = Color::where('is_default_icon_dark', true)->where('id', '!=', $color->id)->first();
                if ($is_default_icon_dark != null){
                    $is_default_icon_dark->is_default_icon_dark = false;
                    $is_default_icon_dark->save();
                }
            }
            $color->is_default_title_light = isset($request->is_default_title_light);
            $color->is_default_title_dark = isset($request->is_default_title_dark);
            $color->is_default_content_light = isset($request->is_default_content_light);
            $color->is_default_content_dark = isset($request->is_default_content_dark);
            $color->is_default_icon_light = isset($request->is_default_icon_light);
            $color->is_default_icon_dark = isset($request->is_default_icon_dark);
            $color->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Cor '.($request->id == null ? 'adicionada':'editada').' com sucesso!'
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deleteColor(Color $color){
        try {
            $color->delete();
            return response()->json([
                'success' => true
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    //-----------------------------------------------------------// - SCRIPTS

    public function getScripts(Request $request){
        try {
            return response()->json([
                'success' => true,
                'script' => $request->id == 'null' ? null : Script::findOrFail($request->id)->toArray()
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function saveScript(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'position' => 'required',
            'script' => 'required'
        ],[
            'title' => 'O título é obrigatório',
            'position' => 'A posição é obrigatório',
            'script' => 'O script é obrigatório'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try {
            if ($request->id == null){
                $script = new Script();
            }else{
                $script = Script::findOrFail($request->id);
            }
            $script->title = $request->title;
            $script->position = $request->position;
            $script->show_mobile = isset($request->show_mobile);
            $script->script = $request->script;
            $script->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Script '.($request->id == null ? 'adicionado':'editado').' com sucesso'
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deleteScript(Script $script){
        try {
            $script->delete();
            return response()->json([
                'success' => true
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    //-----------------------------------------------------------// - INTEGRAÇÕES

    public function getIntegration(Integration $integration){
        return response()->json([
            'success' => true,
            'integration' => $integration
        ]);
    }

    public function saveIntegration(Request $request, Integration $integration){
        DB::beginTransaction();
        try {
            $integration->fill($request->all());
            if ($integration->url || $integration->token || $integration->key || $integration->secret){
                $integration->status = true;
            }else{
                $integration->status = false;
            }
            $integration->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Integração salva com sucesso'
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao salvar integração, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }
}

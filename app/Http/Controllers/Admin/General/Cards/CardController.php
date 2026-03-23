<?php

namespace App\Http\Controllers\Admin\General\Cards;

use App\Http\Controllers\Controller;
use App\Models\General\Cards\Card;
use App\Models\General\Cards\Category;
use App\Models\General\Cards\Subcategory;
use App\Models\Pages\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller{
    public function index(){
        $title = 'Cards';
        $breadcrumbs = [
            ['url' => route('admin.cards.index'), 'title' => $title],
        ];
        $cards = Card::orderBy('title')->get();
        $categories = Category::orderBy('title')->get();
        return view('admin.pages.general.cards.list', compact('title', 'breadcrumbs', 'cards', 'categories'));
    }

    public function create(){
        $title = 'Criar card';
        $breadcrumbs = [
            ['url' => route('admin.cards.index'), 'title' => 'Cards'],
            ['url' => route('admin.cards.create'), 'title' => $title],
        ];
        $card = new Card();
        $categories = Category::orderBy('title')->get();
        $subcategories = Subcategory::orderBy('title')->get();
        $pages = Page::orderBy('title')->get();
        return view('admin.pages.general.cards.form', compact('title', 'breadcrumbs', 'card', 'categories', 'subcategories', 'pages'));
    }

    public function store(Request $request){
        return $this->save($request, new Card(), 'store');
    }

    public function edit(Card $card){
        $title = 'Editar card';
        $breadcrumbs = [
            ['url' => route('admin.cards.index'), 'title' => 'Cards'],
            ['url' => route('admin.cards.edit', $card->hash_id), 'title' => $title],
        ];
        $categories = Category::orderBy('title')->get();
        $subcategories = Subcategory::orderBy('title')->get();
        $pages = Page::orderBy('title')->get();
        return view('admin.pages.general.cards.form', compact('title', 'breadcrumbs', 'card', 'categories', 'subcategories', 'pages'));
    }

    public function update(Request $request, Card $card){
        return $this->save($request, $card, 'update');
    }

    public function destroy(Card $card){
        $card->delete();
        return response()->json([
            'success' => true,
            'message' => 'Card excluído com sucesso',
        ]);
    }

    public function save($request, $card, $action){
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'title' => 'required',
            //'description' => 'required',
            'type' => 'required',
            'status' => 'required'
        ],[
            'category_id.required' => 'A categoria é obrigatória',
            'title.required' => 'O título é obrigatório',
            //'description.required' => 'A descrição é obrigatória',
            'type.required' => 'O tipo do card é obrigatório',
            'status.required' => 'O status é obrigatório'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        if ($request->type == 'page' && !$request->page_id) {
            return response()->json(['success' => false, 'message' => 'A página é obrigatória']);
        }
        if ($request->type == 'link' && !$request->link) {
            return response()->json(['success' => false, 'message' => 'O link é obrigatório']);
        }
        if ($request->type == 'file' && !$request->file && $card->file == null) {
            return response()->json(['success' => false, 'message' => 'O arquivo é obrigatório']);
        }
        if ($request->type == 'modal' && !$request->modal_description) {
            return response()->json(['success' => false, 'message' => 'O descrição do modal é obrigatória']);
        }
        DB::beginTransaction();
        try{
            $card->fill($request->input());
            if ($request->type == 0){
                $card->type = null;
            }
            $card->save();
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $card->file = $file->storeAs('cards/'.$card->id, $filename, 'public');
                if (strpos($card->file, 'public/') == false) {
                    $card->file = 'public/' . $card->file;
                }
            }
            if ($action == 'store'){
                $card->order = Card::where('subcategory_id', $request->subcategory_id)->max('order') + 1;
            }
            $card->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Card '.($action == 'store' ? 'criado':'editado').' com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." card",
                'e' => $e->getMessage()
            ]);
        }
    }

    public function file(Card $card){
        try {
            $card->file = null;
            $card->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Arquivo removido com sucesso',
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Falha ao remover arquivo, tente novamente",
                'e' => $e->getMessage()
            ]);
        }
    }

    public function order($type){
        if ($type == 'category' || $type == 'subcategory'){
            $items = Category::all();
        }elseif ($type == 'card'){
            $items = Subcategory::all();
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
        if ($type == 'category'){
            $items = Card::where('category_id', $id)->where('subcategory_id', null)->orderBy('order')->get();
        }elseif ($type == 'subcategory'){
            $items = Subcategory::where('category_id', $id)->orderBy('order')->get();
        }elseif ($type == 'card'){
            $items = Card::where('subcategory_id', $id)->orderBy('order')->get();
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
        if ($type == 'category'){
            foreach ($request->items as $item){
                $card = Card::where('id', $item)->where('category_id', $id)->where('subcategory_id', null)->first();
                $card->order = $i;
                $card->save();
                $i++;
            }
        }elseif ($type == 'subcategory'){
            foreach ($request->items as $item){
                $subcategory = Subcategory::where('id', $item)->where('category_id', $id)->first();
                $subcategory->order = $i;
                $subcategory->save();
                $i++;
            }
        }elseif ($type == 'card'){
            foreach ($request->items as $item){
                $card = Card::where('id', $item)->where('subcategory_id', $id)->first();
                $card->order = $i;
                $card->save();
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

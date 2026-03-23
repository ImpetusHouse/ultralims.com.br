<?php

namespace App\Http\Controllers\Admin\General\FAQ;

use App\Http\Controllers\Controller;
use App\Models\General\FAQ\Category;
use App\Models\General\FAQ\FAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FAQController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $faqs = FAQ::all();
        $categories = Category::where('display', '1')->orderBy('title')->get();

        $title = "FAQ's";
        $breadcrumbs = [
            ['title' => "FAQ's", 'url' => route('admin.faq.index')],
        ];

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'faqs' => $faqs,
            'categories' => $categories
        ];
        return view('admin.pages.general.faq.list', $data);
    }

    public function create()
    {
        $faq = new FAQ();
        $categories = Category::all();

        $title = "Inserir FAQ";
        $breadcrumbs = [
            ['title' => "FAQ's", 'url' => route('admin.faq.index')],
            ['title' => 'Inserir FAQ', 'url' => route('admin.faq.create')]
        ];

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'faq' => $faq,
            'categories' => $categories
        ];

        return view('admin.pages.general.faq.form', $data);
    }

    public function store(Request $request)
    {
        $json = $this->save($request, new FAQ(), 'store');
        return $json;
    }

    public function edit(FAQ $faq)
    {
        $categories = Category::all();

        $title = "Editar FAQ";
        $breadcrumbs = [
            ['title' => "FAQ's", 'url' => route('admin.faq.index')],
            ['title' => 'Editar FAQ', 'url' => route('admin.faq.edit', $faq->hash_id)],
        ];

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'faq' => $faq,
            'categories' => $categories
        ];

        return view('admin.pages.general.faq.form', $data);
    }

    public function update(Request $request, FAQ $faq)
    {
        $json = $this->save($request, $faq, 'update');
        return $json;
    }

    public function destroy(FAQ $faq)
    {
        $faq->delete();
        return response()->json([
            'success' => true,
            'message' => 'FAQ removido com sucesso!'
        ]);
    }

    public function save($request, $faq, $action){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'category_id' => 'required'
        ],[
            'title.required' => 'O título é obrigatório!',
            'description.required' => 'A descrição é obrigatória!',
            'status.required' => 'O status é obrigatório!',
            'category_id.required' => 'A categoria é obrigatória!'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try{
            if ($request->status == 1){
                if ($action == 'store'){
                    $display_order = FAQ::where('status', 1)->max('display_order') + 1;
                    $display_order_category = FAQ::where('category_id', $request->category_id)->where('status', 1)->max('display_order') + 1;
                }
            }else{
                $display_order = null;
            }
            $faq->fill($request->input());
            $faq->display_order_category = $display_order_category;
            $faq->display_order = $display_order;
            $faq->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'FAQ '.($action == 'store' ? 'criado':'editado').' com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." o FAQ",
                'e' => $e->getMessage()
            ]);
        }
    }

    public function order($type){
        if ($type == 'category' || $type == 'faq_category'){
            $items = Category::all();
        }elseif ($type == 'faq'){
            $items = FAQ::all();
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
            $items = Category::orderBy('display_order')->get();
        }elseif ($type == 'faq_category'){
            $items = FAQ::where('category_id', $id)->orderBy('display_order_category')->get();
        }elseif ($type == 'faq'){
            $items = FAQ::orderBy('display_order')->get();
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
                $category = Category::where('id', $item)->first();
                $category->display_order = $i;
                $category->save();
                $i++;
            }
        }elseif ($type == 'faq_category'){
            foreach ($request->items as $item){
                $faq = FAQ::where('id', $item)->where('category_id', $id)->first();
                $faq->display_order_category = $i;
                $faq->save();
                $i++;
            }
        }elseif ($type == 'faq'){
            foreach ($request->items as $item){
                $faq = FAQ::where('id', $item)->first();
                $faq->display_order = $i;
                $faq->save();
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

<?php

namespace App\Http\Controllers\Admin\Pages\IA;

use App\Http\Controllers\Controller;
use App\Models\Pages\IA\Prompt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PromptController extends Controller{
    public function index(){
        $title = 'Prompts';
        $breadcrumbs = [
            ['url' => route('admin.ia.index'), 'title' => 'IA'],
            ['url' => route('admin.ia.prompts.index'), 'title' => $title],
        ];

        $prompts = Prompt::orderBy('title')->get();

        return view('admin.pages.pages.ia.prompts.list', compact('title', 'breadcrumbs', 'prompts'));
    }

    public function create(){
        $title = "Inserir prompt";
        $breadcrumbs = [
            ['title' => "IA", 'url' => route('admin.ia.index')],
            ['title' => 'Prompts', 'url' => route('admin.ia.prompts.index')],
            ['title' => $title, 'url' => route('admin.ia.prompts.create')]
        ];

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'prompt' => new Prompt()
        ];

        return view('admin.pages.pages.ia.prompts.form', $data);
    }

    public function store(Request $request){
        return $this->save($request, new Prompt(), 'store');
    }

    public function edit(Prompt $prompt){
        $title = "Editar prompt";
        $breadcrumbs = [
            ['title' => "IA", 'url' => route('admin.ia.index')],
            ['title' => 'Prompts', 'url' => route('admin.ia.prompts.index')],
            ['title' => $title, 'url' => route('admin.ia.prompts.edit', $prompt->hash_id)]
        ];

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'prompt' => $prompt,
        ];

        return view('admin.pages.pages.ia.prompts.form', $data);
    }

    public function update(Request $request, Prompt $prompt){
        return $this->save($request, $prompt, 'update');
    }

    public function destroy(Prompt $prompt){
        $prompt->delete();
        return response()->json([
            'success' => true,
            'message' => 'Prompt removido com sucesso'
        ]);
    }

    public function save($request, $prompt, $action){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'prompt' => 'required',
        ],[
            'title.required' => 'O título é obrigatório',
            'prompt.required' => 'O prompt é obrigatório',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try{
            $prompt->fill($request->input());
            $prompt->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Prompt '.($action == 'store' ? 'criado':'editado').' com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." o prompt",
                'e' => $e->getMessage()
            ]);
        }
    }
}

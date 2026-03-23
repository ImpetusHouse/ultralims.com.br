<?php

namespace App\Http\Controllers\Admin\Pages\IA;

use App\Http\Controllers\Controller;
use App\Models\Pages\Block;
use App\Models\Pages\IA\Prompt;
use App\Models\Pages\Page;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IAController extends Controller{
    public function index(){
        $title = 'IA';
        $breadcrumbs = [
            ['url' => route('admin.ia.index'), 'title' => $title],
        ];

        $pages = Page::orderBy('title')->get();
        $blocks = Block::where('layout', 6)->orderBy('page_id')->get();

        return view('admin.pages.pages.ia.list', compact('title', 'breadcrumbs', 'pages', 'blocks'));
    }

    public function show(Block $ium){
        $block = $ium;

        //Breadcrumbs
        $title = $block->title.' '.$block->subtitle;
        $breadcrumbs = [
            ['url' => route('admin.ia.index'), 'title' => 'IA'],
            ['url' => route('admin.ia.show', $block->id), 'title' => $title],
        ];

        $prompts = Prompt::orderBy('title')->get();

        return view('admin.pages.pages.ia.show', compact('title', 'breadcrumbs', 'block', 'prompts'));
    }

    public function generate(Request $request){
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'keyword' => 'required',
            'prompt' => 'required',
        ],[
            'description.required' => 'O conteúdo é obrigatório',
            'keyword.required' => 'A palavra chave é obrigatória',
            'prompt.required' => 'O prompt é obrigatório'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        try {
            $openAIService = new OpenAIService();

            $prompt = $request->prompt;
            $prompt = str_replace('_TEXT_', $request->description, $prompt);
            $prompt = str_replace('_KEYWORD_', $request->keyword, $prompt);
            $prompt = str_replace('_WORDCOUNT_', strlen($request->description), $prompt);

            $response = $openAIService->getResponse($prompt);

            return response()->json([
                'success' => true,
                'message' => 'Conteúdo gerado com sucesso',
                'response' => $response
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Falha ao gerar conteúdo, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, Block $ium){
        $block = $ium;

        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ],[
            'description.required' => 'O conteúdo é obrigatório',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        DB::beginTransaction();
        try {
            $block->content = $request->description;
            $block->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Conteúdo atualizado com sucesso'
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao atualizar conteúdo, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }
}

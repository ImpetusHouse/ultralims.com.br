<?php

namespace App\Http\Controllers\Site\UltraLIMS;

use App\Http\Controllers\Controller;
use App\Models\UltraLims\UL_Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AlertController extends Controller{
    public function index(Request $request){
        if (isset($_GET['search'])){
            $alerts = UL_Alert::where('idLaboratorio', Auth::guard('ultralims')->user()->idLaboratorio)->where('title', 'LIKE', '%'.$_GET['search'].'%')->orderBy('start_date', 'desc')->paginate(9);
        }else{
            $alerts = UL_Alert::where('idLaboratorio', Auth::guard('ultralims')->user()->idLaboratorio)->orderBy('start_date', 'desc')->paginate(9);
        }

        if ($request->ajax()) {
            return view('site.pages.ultralims.alerts.alert', compact('alerts'))->render();
        }

        return view('site.pages.ultralims.alerts.index', compact('alerts'));
    }

    public function show($slug){
        $alert = UL_Alert::where('slug', $slug)->first();

        if ($alert == null){
            return response()->json([
                'success' => false,
                'message' => 'Comunicado não encontrado'
            ]);
        }

        //Descomentar quando liberar a versão final
        if ($alert->idLaboratorio != Auth::guard('ultralims')->user()->idLaboratorio){
            return response()->json([
               'success' => false,
               'message' => 'Você não possui permissão apra editar esse comunciado'
            ]);
        }

        return view('site.pages.ultralims.alerts.show', compact('alert'));
    }

    public function store(Request $request){
        return $this->save($request, new UL_Alert(), 'store');
    }

    public function edit($id){
        $alert = UL_Alert::where('id', $id)->first();

        if ($alert == null){
            return response()->json([
                'success' => false,
                'message' => 'Comunicado não encontrado'
            ]);
        }

        //Descomentar quando liberar a versão final
        if ($alert->idLaboratorio != Auth::guard('ultralims')->user()->idLaboratorio){
            return response()->json([
               'success' => false,
               'message' => 'Você não possui permissão apra editar esse comunciado'
            ]);
        }

        return response()->json([
            'success' => true,
            'alert' => $alert
        ]);
    }

    function update(Request $request, $id){
        $alert = UL_Alert::where('id', $id)->first();

        if ($alert == null){
            return response()->json([
                'success' => false,
                'message' => 'Comunicado não encontrado'
            ]);
        }

        //Descomentar quando liberar a versão final
        if ($alert->idLaboratorio != Auth::guard('ultralims')->user()->idLaboratorio){
            return response()->json([
               'success' => false,
               'message' => 'Você não possui permissão apra editar esse comunciado'
            ]);
        }

        return $this->save($request, $alert, 'update');
    }

    public function destroy($id){
        try {
            $alert = UL_Alert::where('id', $id)->first();

            if ($alert == null){
                return response()->json([
                    'success' => false,
                    'message' => 'Comunicado não encontrado'
                ]);
            }

            //Descomentar quando liberar a versão final
            if ($alert->idLaboratorio != Auth::guard('ultralims')->user()->idLaboratorio){
                return response()->json([
                   'success' => false,
                   'message' => 'Você não possui permissão apra editar esse comunciado'
                ]);
            }

            $alert->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Alerta excluído com sucesso'
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir alerta, tente novamente',
                'e' => $e->getMessage()
            ]);
        }
    }

    public function save($request, $alert, $action){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ],[
            'title.required' => 'O título é obrigatório',
            'content.required' => 'O conteúdo é obrigatório',
            'start_date.required' => 'A data inicial é obrigatória',
            'end_date.required' => 'A data final é obrigatória',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        DB::beginTransaction();
        try{
            $idLaboratorio = Auth::guard('ultralims')->user()->idLaboratorio;
            //$idLaboratorio = 1;
            $idUser = Auth::guard('ultralims')->user()->idUser;
            //$idUser = 1;

            $alert->fill($request->input());
            // Verifica se uma imagem foi enviada
            if ($request->hasFile('photo')) {
                // Define o caminho para salvar a imagem
                $path = $request->file('photo')->store('ultralims/alerts/'.$idLaboratorio, 'public'); // 'alerts' é a pasta e 'public' é o disco
                $alert->photo = $path; // Salva o caminho da imagem no modelo
            }else if ($action == 'store'){
                $path = 'ultralims/alerts/default.png';
                $alert->photo = $path;
            }
            $alert->idUser = $idUser;
            $alert->idLaboratorio = $idLaboratorio;
            if ($action == 'store'){
                $alert->slug = Str::slug($alert->title);
            }
            $alert->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Alerta '.($action == 'store' ? 'criado':'editado').' com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao ".($action == 'store'? 'salvar':'editar')." o alerta",
                'e' => $e->getMessage()
            ]);
        }
    }
}

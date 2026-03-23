<?php

namespace App\Http\Controllers\Admin\General\Logos;

use App\Http\Controllers\Controller;
use App\Models\General\Logos\Logo;

class LogoController extends Controller
{
    public function destroy(Logo $logo){
        $logo->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logo excluída com sucesso',
        ]);
    }
}

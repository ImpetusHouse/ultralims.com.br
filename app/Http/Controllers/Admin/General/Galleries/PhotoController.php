<?php

namespace App\Http\Controllers\Admin\General\Galleries;

use App\Http\Controllers\Controller;
use App\Models\General\Galleries\Photo;

class PhotoController extends Controller {
    public function destroy(Photo $photo){
        $photo->delete();
        return response()->json([
            'success' => true,
            'message' => 'Foto excluída com sucesso',
        ]);
    }
}

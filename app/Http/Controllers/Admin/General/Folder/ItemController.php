<?php

namespace App\Http\Controllers\Admin\General\Folder;

use App\Http\Controllers\Controller;
use App\Models\General\Folder\Folder;
use App\Models\General\Folder\Item;
use Illuminate\Http\Request;

class ItemController extends Controller {
    public function upload(Request $request) {
        $request->validate([
            'folder_id' => 'nullable|exists:folders,id',
            'files' => 'required' // Limite de 1MB
        ]);

        // Se existe um folder_id, obtenha o slug da pasta
        $folder = $request->folder_id ? Folder::find($request->folder_id) : null;
        $folderSlug = $folder ? '/'.$folder->slug : '';

        foreach ($request->file('files') as $file){
            // Defina o caminho de destino com base na pasta
            $path = $file->storeAs('midias' . $folderSlug, $file->getClientOriginalName(), 'public');
            $item = Item::create([
                'folder_id' => $request->folder_id,
                'title' => $file->getClientOriginalName(),
                'path' => $path,
                'size' => $file->getSize(),
                'extension' => $file->getClientOriginalExtension()
            ]);
        }

        return response()->json(['success' => true, 'item' => $item]);
    }

    public function update(Request $request, Item $item) {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255'
        ]);
        $item->update(['title' => $validatedData['title']]);

        return response()->json(['success' => true, 'item' => $item]);
    }

    public function move(Request $request) {
        $validatedData = $request->validate([
            'item_id' => 'required|exists:items,id',
            'new_folder_id' => 'nullable|exists:folders,id'
        ]);
        $item = Item::find($validatedData['item_id']);
        $item->update(['folder_id' => $validatedData['new_folder_id']]);
        return response()->json(['success' => true, 'item' => $item]);
    }

    public function destroy(Item $item) {
        $item->delete();
        return response()->json(['success' => true]);
    }
}

<?php

namespace App\Http\Controllers\Admin\General\Folder;

use App\Http\Controllers\Controller;
use App\Models\General\Folder\Folder;
use App\Models\General\Folder\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FolderController extends Controller {
    public function index() {
        $title = 'Mídias';
        $breadcrumbs = [
            ['url' => route('admin.folders.index'), 'title' => 'Pastas'],
        ];
        $folders = Folder::orderBy('title')->get();
        $items = Item::where('folder_id', null)->orderBy('title')->get();
        return view('admin.pages.general.midias.folders', compact('title', 'breadcrumbs', 'folders', 'items'));
    }

    public function show(Folder $folder){
        $title = 'Mídias';
        $breadcrumbs = [
            ['url' => route('admin.folders.index'), 'title' => 'Pastas'],
            ['url' => route('admin.folders.show', $folder->id), 'title' => $folder->title],
        ];
        $folders = Folder::where('id', 0)->get();
        $items = Item::where('folder_id', $folder->id)->orderBy('title')->get();
        $folderOpen = $folder;

        return view('admin.pages.general.midias.folders', compact('title', 'breadcrumbs', 'folders', 'items', 'folderOpen'));
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Folder::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        $folder = Folder::create([
            'title' => $request->title,
            'slug' => $slug,
        ]);
        return response()->json(['folder' => $folder]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $folder = Folder::findOrFail($id);
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Folder::where('slug', $slug)->where('id', '!=', $folder->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        $folder->update([
            'title' => $request->title,
            'slug' => $slug,
        ]);
        return response()->json(['folder' => $folder]);
    }

    public function destroy(Folder $folder) {
        $folder->delete();
        return response()->json(['success' => true]);
    }
}

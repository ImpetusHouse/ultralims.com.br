<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class BlogController extends Controller
{
    public function index(){
        $title = 'Blog';
        $breadcrumbs = [
            ['url' => route('admin.blog.index'), 'title' => $title],
        ];

        $apiBlogs = Http::get('https://impetus.nucleonerd.com.br/api/blogs/');
//        $apiBlogs = Http::get('http://127.0.0.1:8001/api/blogs/');
        $arrayBlogs = $apiBlogs->json();

        return view('admin.pages.general.blog.index', compact('title', 'breadcrumbs'))
            ->with('arrayBlogs', $arrayBlogs);
    }

    public function show($blog){

        $apiBlogs = Http::get('https://impetus.nucleonerd.com.br/api/blogs/' . $blog);
//        $apiBlogs = Http::get('http://127.0.0.1:8001/api/blogs/' . $blog);
        $blogs = $apiBlogs->json();

        $arrayBlog = $blogs['blog'];
        $arrayBlogs = $blogs['blogs'];

        $title = 'Visualizar blog';
        $breadcrumbs = [
            ['url' => route('admin.blog.index'), 'title' => 'Blog'],
            ['url' => route('admin.blog.show', $blog), 'title' => $title]
        ];
        return view('admin.pages.general.blog.show', compact('title', 'breadcrumbs'))
            ->with('arrayBlog', $arrayBlog)
            ->with('arrayBlogs', $arrayBlogs);
    }
}

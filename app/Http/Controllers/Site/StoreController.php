<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class StoreController extends Controller{
    public function cart(){
        return view('site.pages.store.cart');
    }

    public function search(){
        return view('site.pages.store.search');
    }

    public function history(){
        return view('site.pages.store.history');
    }

    public function checkout(){
        return view('site.pages.store.checkout');
    }

    public function product(){
        return view('site.pages.store.product');
    }
}

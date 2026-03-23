@extends('site.layout')
@section('content')
    @foreach ($page->blocks->sortBy('display_order') as $block)
        @include('site.inc.blocos.bloco_' . $block->layout . '.index', ['i' => ($loop->index + 1)])
    @endforeach
@endsection

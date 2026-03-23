@extends('site.pages.ultralims.layout')
@php
    /** @var TYPE_NAME $article */
    $article->content = str_replace('<h2', '<h2 class="mb-3 mt-4 text-2xl md:text-3xl font-bold text-gray-800"', $article->content);
    $article->content = str_replace('<h3', '<h3 class="mb-3 mt-4 text-xl md:text-2xl font-semibold text-gray-800"', $article->content);
    $article->content = str_replace('<h4', '<h4 class="mb-3 mt-4 text-lg md:text-xl font-semibold text-gray-800"', $article->content);
    $article->content = str_replace('<p', '<p style="font-size: 16px"', $article->content);
    $article->content = str_replace('<a', '<a class="text-blue-700"', $article->content);
@endphp
@push('head')
    <style>
        .wpp-button{
            display: none;
        }
    </style>
@endpush
@section('content')
    @include('site.inc.breadcrumb', ['breadcrumbs' => generateBreadcrumbs()])
    <section class="pt-10 md:pt-20 pb-24 md:pb-32 overflow-hidden">
        <div class="container px-4 mx-auto">
            <div class="md:max-w-2xl mx-auto mb-12 text-center">
                <div class="flex items-center justify-center">
                    {{--<p class="inline-block font-medium" style="color: #01AEF0">{{ $article->user->name.' '.$article->user->lastname }}</p>
                    <span class="mx-1" style="color: #01AEF0">•</span>--}}
                    <p class="inline-block font-medium" style="color: #01AEF0">{{ $article->published_at->translatedFormat('d').' '.ucfirst($article->published_at->translatedFormat('M Y')) }}</p>
                </div>
                <h1 class="mb-4 text-3xl md:text-4xl leading-tight text-gray-900 font-black tracking-tighter">{{ $article->title }}</h1>
                <div>
                    @foreach($article->categories as $category)
                        <a href="/cliente-ultra/blog?categoria={{ $category->slug }}"
                           class="mb-4 font-sans max-w-max px-3 py-1 text-sm font-semibold uppercase rounded-xl"
                           style="color: {{ $category->color }}; background-color: {{ $category->color.'33' }}">{{ $category->title }}</a>
                    @endforeach
                </div>
            </div>
            <div class="mb-6 mx-auto max-w-max overflow-hidden rounded-lg">
                <img src="{{ asset(str_replace('public/', 'storage/', $article->photo)) }}" alt="">
            </div>
            <div class="md:max-w-3xl mx-auto text-base md:text-lg text-[#737276] font-normal">
                {!! nl2br($article->content) !!}
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {{-- RocketChat --}}
    @if(Auth::guard('ultralims')->user() != null && Auth::guard('ultralims')->user()->chat)
        <script type="text/javascript">
            (function(w, d, s, u) {
                w.RocketChat = function(c) { w.RocketChat._.push(c) }; w.RocketChat._ = []; w.RocketChat.url = u;
                var h = d.getElementsByTagName(s)[0], j = d.createElement(s);
                j.async = true; j.src = 'https://atendimento.ultralims.com.br/livechat/rocketchat-livechat.min.js?_=201903270000';
                h.parentNode.insertBefore(j, h);
            })(window, document, 'script', 'https://atendimento.ultralims.com.br/livechat');
        </script>
    @endif
@endpush

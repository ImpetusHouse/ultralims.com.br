@extends('site.pages.ultralims.layout')
@php
    /** @var TYPE_NAME $alert */
    $alert->content = str_replace('<h2', '<h2 class="mb-3 mt-4 text-2xl md:text-3xl font-bold text-gray-800"', $alert->content);
    $alert->content = str_replace('<h3', '<h3 class="mb-3 mt-4 text-xl md:text-2xl font-semibold text-gray-800"', $alert->content);
    $alert->content = str_replace('<h4', '<h4 class="mb-3 mt-4 text-lg md:text-xl font-semibold text-gray-800"', $alert->content);
    $alert->content = str_replace('<p', '<p style="font-size: 16px"', $alert->content);
    $alert->content = str_replace('<a', '<a class="text-blue-700"', $alert->content);
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
                <h1 class="text-3xl md:text-4xl leading-tight text-gray-900 font-black tracking-tighter">{{ $alert->title }}</h1>
            </div>
            <div class="md:max-w-3xl mx-auto text-base md:text-lg text-[#737276] font-normal">
                {!! nl2br($alert->content) !!}
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

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('site.inc.head')

<body class="antialiased bg-body text-body font-body">
    {{-- HEADER --}}
    @php
        if (!isset($page)){
            $menu = \App\Models\Settings\Menu::where('default', true)->first();
        }else{
            $menu = $page->menuItem;
        }
    @endphp
    @include('site.inc.headers.layout_'.$menu->layout.'.menu')

    {{-- CONTEÚDO --}}
    <main class="allButFooter">
        @yield('content')
    </main>

    @php
        $cookie = \App\Models\Settings\Cookie::orderBy('title')->first();
    @endphp
    @if($cookie->status)
        @include('site.inc.cookies.layout_1', ['cookie' => $cookie])
    @endif

    {{-- MODAL --}}
    @include('site.inc.modals.youtube')
    @include('site.inc.modals.card')
    {{--@include('site.inc.modals.feira-analitica')--}}

    {{-- FOOTER --}}
    @include('site.inc.footers.'.env('APP_NAME'))

    @include('site.inc.scripts')
    @vite('resources/js/app.js')
</body>

</html>

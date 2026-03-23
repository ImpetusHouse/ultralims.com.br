<head>
    <link rel="shortcut icon" href="{{ asset('images/favicon/'.env('APP_NAME').'.ico') }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @if(env('APP_ENV') == 'local')
        <meta name="robots" content="noindex, nofollow"> <!-- desenvolvimento -->
    @endif
    @vite('resources/css/app.css')
    {!! SEO::generate() !!}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="{{ env('FONT_FAMILY') }}" rel="stylesheet">
    {{-- SCRIPTS INSERIDOS PELO PAINEL --}}
    @foreach(\App\Models\Settings\Script::where('position', 'head')->get() as $script)
        {!! $script->script !!}
    @endforeach
    {{-- SWIPER (CARROSSEL) --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    @include('site.inc.styles.fonts', ['block' => new \App\Models\Pages\Block(), 'tab' => new \App\Models\Pages\Block_Tab()])
    <style>
        {{-- RECAPTCHA --}}
        .grecaptcha-badge{
            display: none !important;
        }

        {{-- MODAL DE VÍDEO DO YOUTUBE --}}
        .video-container {

            position: relative;
        }
        .video-container video {
            width: 100%;
            height: 100%;
            position: absolute;
            object-fit: cover;
            z-index: -1;
        }
        /* Just styling the content of the div, the magic in the previous rules */

        {{-- DEIXA UMA IMAGEM QUADRADA --}}
        .square {
            aspect-ratio: 1 / 1; /* Isso define a largura e altura para serem iguais */
        }

        {{-- DEIXA A IMAGEM 16:9 --}}
        .ratio-16-9 {
            position: relative;
            width: 100%; /* Isso pode ser ajustado para caber no contêiner desejado */
            padding-top: 56.25%; /* Proporção de altura para largura de 16:9 (9/16 = 0.5625) */
        }

        {{-- DEIXA A IMAGEM NO TAMANHO DA REVISTA --}}
        .magazine {
            position: relative;
            width: 100%; /* Isso pode ser ajustado para caber no contêiner desejado */
            padding-top: 125%;
        }

        {{-- DEIXA A IMAGEM 2:1 --}}
        .ratio-2-1 {
            position: relative;
            width: 100%;
            padding-top: 50%; /* 8/16 = 0.5 = 50% */
        }

        /* Imagem absolutamente posicionada para preencher o contêiner da proporção */
        .ratio-16-9 img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* Isto irá cobrir o espaço disponível sem perder a proporção */
        }

        {{-- LIMITA O TEXTO EM 1 LINHA --}}
        .one-line-text {
            display: block; /* Garante que o span se comporte como um bloco */
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        {{-- LIMITA O TEXTO EM 2 LINHAS --}}
        .two-line-text {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        {{-- LIMITA O TEXTO EM 3 LINHAS --}}
        .three-line-text {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        {{-- LIMITA O TEXTO EM 5 LINHAS --}}
        .five-line-text {
            display: -webkit-box;
            -webkit-line-clamp: 5;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    @yield('head')
    @stack('head')
</head>

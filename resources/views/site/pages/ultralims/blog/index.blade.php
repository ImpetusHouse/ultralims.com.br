@extends('site.pages.ultralims.layout')
@push('head')
    <style>
        .loading-icon {
            display: none;
        }

        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 4px solid #fff;
            width: 20px;
            height: 20px;
            -webkit-animation: spin 1s linear infinite;
            animation: spin 1s linear infinite;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .button-category:hover{
            color: #01AEF0;
            background-color: #01AEF020;
        }

        .button-category-active{
            color: #01AEF0;
            background-color: #01AEF020
        }

        .wpp-button{
            display: none;
        }
    </style>
@endpush
@section('content')
    @include('site.inc.breadcrumb', ['breadcrumbs' => generateBreadcrumbs()])
    <section class="pt-20 pb-24 md:pb-32 overflow-hidden">
        <div class="container px-4 mx-auto">
            <div class="md:max-w-5xl mx-auto mb-8 md:mb-16 text-center">
                <h3 class="mb-4 block-title font-black font-heading leading-tight text-gray-900 tracking-tighter">
                    Acompanhe nosso <span style="color: #01AEF0">BLOG</span>.
                    @if(env('APP_NAME') == 'Ultra Lims')
                        <br>Sempre com novidades sobre o mundo LIMS.
                    @endif
                </h3>
                <p class="mb-10 text-[#737276] block-description">Semanalmente novidades para você.</p>
                <div class="relative mx-auto md:w-80">
                    <img class="absolute transform -translate-y-1/2" src="{{ asset('images/blog/search.svg') }}" alt="" style="top: 50%; left: 1rem;">
                    <form method="GET" action="{{ route('ultralims.blog') }}">
                        <input name="search" value="{{ $_GET['search'] ?? '' }}" class="w-full py-3 pl-12 pr-4 text-gray-900 leading-tight placeholder-gray-500 border border-gray-200 rounded-lg shadow-xsm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" type="text" placeholder="Procurar">
                    </form>
                </div>
            </div>
            <ul class="flex flex-wrap mb-8 -mx-2 text-center">
                <li class="w-full md:w-auto px-2">
                    <a href="{{ route('ultralims.blog') }}" class="inline-block w-full py-2 px-4 mb-4 md:mb-0 text-sm {{ !isset($_GET['categoria']) ? 'button-category-active' : 'text-gray-400' }} button-category font-bold rounded-xl hover:shadow-sm">Todos ({{ $articlesCount }})</a>
                </li>
                @foreach ($categorias as $categoria)
                    <li class="w-full md:w-auto px-2">
                        <a href="/cliente-ultra/blog?categoria={{ $categoria->slug }}" class="inline-block w-full py-2 px-4 mb-4 md:mb-0 text-sm {{ isset($_GET['categoria']) ? ($_GET['categoria'] == $categoria->slug ? 'button-category-active' : 'text-gray-400') : 'text-gray-400' }} button-category font-bold rounded-xl hover:shadow-sm">{{ $categoria->title }} ({{ $categoria->articles->count() }})</a>
                    </li>
                @endforeach
            </ul>
            <div class="articles-container flex flex-wrap -mx-4 mb-12 md:mb-20">
                @include('site.pages.ultralims.blog.inc.articles', ['articles' => $articles])
            </div>
            @if($articles->count() == 6)
                <a class="flex items-center justify-center py-2 px-4 mx-auto text-sm leading-5 text-white font-medium hover:opacity-70 md:max-w-max rounded-xl load-more" href="javascript:void(0);" data-page="2" style="background-color: #01AEF0">
                    <span class="mr-3">Ver mais</span>
                    <span class="loading-icon">
                        <div class="spinner"></div>
                    </span>
                    <svg class="arrow-icon text-green-50" width="12" height="10" viewbox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.7583 4.40833C10.6809 4.33023 10.5887 4.26823 10.4871 4.22592C10.3856 4.18362 10.2767 4.16183 10.1667 4.16183C10.0567 4.16183 9.94773 4.18362 9.84619 4.22592C9.74464 4.26823 9.65247 4.33023 9.575 4.40833L6.83333 7.15833V0.833333C6.83333 0.61232 6.74554 0.400358 6.58926 0.244078C6.43297 0.0877975 6.22101 0 6 0C5.77899 0 5.56702 0.0877975 5.41074 0.244078C5.25446 0.400358 5.16667 0.61232 5.16667 0.833333V7.15833L2.425 4.40833C2.26808 4.25141 2.05525 4.16326 1.83333 4.16326C1.61141 4.16326 1.39859 4.25141 1.24167 4.40833C1.08475 4.56525 0.99659 4.77808 0.99659 5C0.99659 5.22192 1.08475 5.43475 1.24167 5.59167L5.40833 9.75833C5.48759 9.8342 5.58104 9.89367 5.68333 9.93333C5.78308 9.97742 5.89094 10.0002 6 10.0002C6.10906 10.0002 6.21692 9.97742 6.31667 9.93333C6.41896 9.89367 6.51241 9.8342 6.59167 9.75833L10.7583 5.59167C10.8364 5.5142 10.8984 5.42203 10.9407 5.32048C10.9831 5.21893 11.0048 5.11001 11.0048 5C11.0048 4.88999 10.9831 4.78107 10.9407 4.67952C10.8984 4.57797 10.8364 4.4858 10.7583 4.40833Z" fill="currentColor"></path>
                    </svg>
                </a>
            @endif
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        function buildLoadMoreUrl(page) {
            const currentUrl = new URL(window.location.href);
            const params = new URLSearchParams(currentUrl.search);

            // Atualiza o parâmetro da página para a próxima página
            params.set('page', page);

            // Constrói a nova URL com os parâmetros atualizados
            return `${currentUrl.pathname}?${params.toString()}`;
        }
        $('.load-more').click(function() {
            var page = $(this).data('page');
            var loadMoreUrl = buildLoadMoreUrl(page);

            var btn = $(this);
            var loadingIcon = btn.find('.loading-icon');
            var arrowIcon = btn.find('.arrow-icon');

            loadingIcon.show();
            arrowIcon.hide();
            $.ajax({
                url: loadMoreUrl,
                type: 'GET',
                success: function(response) {
                    $('.articles-container').append(response);

                    // Verifica se há menos de 6 publicações na resposta
                    var numPublicacoes = $(response).filter('.article').length;
                    if (numPublicacoes < 6) {
                        // Esconde o botão 'Ver mais'
                        btn.fadeOut(150);
                    }

                    $('.load-more').data('page', page + 1);

                    loadingIcon.hide();
                    arrowIcon.show();
                },
                error: function (){
                    loadingIcon.hide();
                    arrowIcon.show();
                }
            });
        });
    </script>
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

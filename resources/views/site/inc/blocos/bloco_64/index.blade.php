@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
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

        .lg-outer .lg-thumb-item.active, .lg-outer .lg-thumb-item:hover{
            border-color: {{ env('PRIMARY_COLOR') }} !important;

        }
    </style>
@endpush
<section id="section_{{ $i }}" class="overflow-hidden" style="background-color: {{ $block->background_color }}; margin-bottom: {{ $block->margin_bottom }}px; margin-top: {{ $block->margin_top }}px">
    <div class="container mx-auto px-4 mb-8">
        <div class="md:flex md:justify-between mb-10 w-full">
            <div>
                @if($block->title || $block->subtitle)
                    <h2 class="font-black font-heading {{ $block->content ? 'mb-4':'' }}">
                        <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">@if($block->title){{ $block->title }}@endif</span><span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">@if($block->subtitle) {{ $block->subtitle }}@endif</span>
                    </h2>
                @endif
                @if($block->content)
                    <p class="block-description-{{$block->id}}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                @endif
            </div>
            <div class="relative md:w-80 pt-1 mt-8 md:mt-0">
                <img class="absolute transform -translate-y-1/2 top-[50%]" src="{{ asset('images/blog/search.svg') }}" alt="" style="left: 1rem; top: 50%">
                <form method="GET" id="form-{{ $block->id }}">
                    <input name="search" value="{{ $_GET['search'] ?? '' }}" class="w-full py-3 pl-12 pr-4 text-gray-900 leading-tight placeholder-gray-500 border border-gray-200 rounded-lg shadow-xsm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" type="text" placeholder="Procurar">
                </form>
            </div>
        </div>
        <div class="relative max-w-md md:max-w-none mx-auto">
            <div class="flex flex-wrap -mx-4 -mb-8 topics-container">
                @php
                    $category = \App\Models\General\Topics\Category::where('id', json_decode($block->topic_category))->first();
                    $items = $category->topics()->where('status', true);
                    // Verifica se o parâmetro de busca foi enviado
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $searchTerm = $_GET['search']; // Armazena o termo de busca
                        $items->where(function($query) use ($searchTerm) {
                            $query->where('title', 'like', "%{$searchTerm}%");
                        });
                    }
                    $items = $items->orderBy('created_at', 'desc')->paginate(20);
                    $container = 'topics-container';
                    $container_item = 'topic-container';
                    $route = 'topics';
                @endphp
                @include('site.pages.topics.topic', ['topics' => $items])
            </div>
        </div>
    </div>
    @if($items->count() == 20)
        <a class="flex items-center justify-center py-2 px-4 mx-auto text-sm leading-5 text-white font-medium hover:opacity-70 md:max-w-max rounded-xl load-more" href="javascript:void(0);" data-page="2" style="background-color: {{ env('PRIMARY_COLOR') }}">
            <span class="mr-3">Ver mais</span>
            <span class="loading-icon">
                <div class="spinner"></div>
            </span>
            <svg class="arrow-icon text-green-50" width="12" height="10" viewbox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.7583 4.40833C10.6809 4.33023 10.5887 4.26823 10.4871 4.22592C10.3856 4.18362 10.2767 4.16183 10.1667 4.16183C10.0567 4.16183 9.94773 4.18362 9.84619 4.22592C9.74464 4.26823 9.65247 4.33023 9.575 4.40833L6.83333 7.15833V0.833333C6.83333 0.61232 6.74554 0.400358 6.58926 0.244078C6.43297 0.0877975 6.22101 0 6 0C5.77899 0 5.56702 0.0877975 5.41074 0.244078C5.25446 0.400358 5.16667 0.61232 5.16667 0.833333V7.15833L2.425 4.40833C2.26808 4.25141 2.05525 4.16326 1.83333 4.16326C1.61141 4.16326 1.39859 4.25141 1.24167 4.40833C1.08475 4.56525 0.99659 4.77808 0.99659 5C0.99659 5.22192 1.08475 5.43475 1.24167 5.59167L5.40833 9.75833C5.48759 9.8342 5.58104 9.89367 5.68333 9.93333C5.78308 9.97742 5.89094 10.0002 6 10.0002C6.10906 10.0002 6.21692 9.97742 6.31667 9.93333C6.41896 9.89367 6.51241 9.8342 6.59167 9.75833L10.7583 5.59167C10.8364 5.5142 10.8984 5.42203 10.9407 5.32048C10.9831 5.21893 11.0048 5.11001 11.0048 5C11.0048 4.88999 10.9831 4.78107 10.9407 4.67952C10.8984 4.57797 10.8364 4.4858 10.7583 4.40833Z" fill="currentColor"></path>
            </svg>
        </a>
    @endif
</section>
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
    <script>
        $('#form-{{ $block->id }}').on('submit', function (e) {
            e.preventDefault(); // Impede o comportamento padrão de envio do formulário
            // Obtém o valor do campo de busca
            var searchValue = $(this).find('input[name="search"]').val();
            // Constrói a URL com o parâmetro de busca, usando o caminho atual da página
            var newUrl = location.pathname + '?search=' + encodeURIComponent(searchValue);
            // Redireciona para a nova URL
            location.href = newUrl;
        });
        function buildLoadMoreUrl(page) {
            const currentUrl = new URL(window.location.href);
            const params = new URLSearchParams(currentUrl.search);

            // Atualiza o parâmetro da página para a próxima página
            params.set('page', page);

            // Constrói a nova URL com os parâmetros atualizados
            return `{{ route($route) }}?${params.toString()}`;
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
                data: {
                  category_id: {{ json_decode($block->topic_category) }}
                },
                success: function(response) {
                    $('.{{ $container }}').append(response);

                    // Verifica se há menos de 6 publicações na resposta
                    var numPublicacoes = $(response).filter('.{{ $container_item }}').length;
                    if (numPublicacoes < 20) {
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
@endpush

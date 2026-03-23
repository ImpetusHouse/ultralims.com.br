@push('head')
    <style>
        #pagination-{{ $block->id }} {
            text-align: center;
        }
        #pagination-{{ $block->id }} .swiper-pagination-bullet {
            background-color: #B8C2CC; /* Cor cinza para bullets inativos */
            margin-right: 8px; /* Espaçamento entre os bullets */
        }
        #pagination-{{ $block->id }} .swiper-pagination-bullet-active {
            background-color: {{ env('PRIMARY_COLOR') }}; /* Cor para o bullet ativo */
        }

        .svg-icon-{{ $block->id }} svg {
            width: 30px;
            height: 32px;
        }
        .svg-icon-{{ $block->id }} path {
            fill: {{ $block->topics_color }} !important;
        }
    </style>
@endpush

<section id="section_{{ $i }}" style="background-color: {{ $block->background_color }}; padding-top: {{ $block->margin_top }}px; padding-bottom: {{ $block->margin_bottom }}px">
    <div class="container px-4 mx-auto">
        @if($block->title || $block->subtitle || $block->content)
            <div class="flex flex-wrap items-center mb-12">
                <div class="w-full mb-4 lg:mb-0">
                    @if($block->title || $block->subtitle)
                        <h2 class="block-title font-black font-heading mb-2">
                            <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                            @if($block->subtitle)
                                <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                            @endif
                        </h2>
                    @endif
                    @if($block->content)
                        <p class="block-description" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                    @endif
                </div>
            </div>
        @endif
        @php
            $pages = \App\Models\Pages\Page::whereIn('id', json_decode($block->pages))->where('status', true)->orderBy('display_order')->get();
        @endphp
        <div class="flex flex-wrap -mx-4 -mb-8">
            <div class="swiper swiper-container-{{ $block->id }}">
                <div class="swiper-wrapper">
                    <div class="swiper-slide flex-wrap" style="display: flex !important;">
                    @if(env('APP_NAME') == 'AABB-SP')
                        @push('head')
                            <style>
                                #div-icon-00:hover #bg-icon-00 {
                                    background-color: {{ $block->tag_color }} !important;
                                }
                                #div-icon-00:hover #title-icon-00 {
                                    color: {{ $block->pdf_color }} !important;
                                }
                                #div-icon-00:hover #svg-icon-00 path {
                                    fill: {{ $block->pdf_color }} !important;
                                }
                                #div-icon-01:hover #bg-icon-01 {
                                    background-color: {{ $block->tag_color }} !important;
                                }
                                #div-icon-01:hover #title-icon-01 {
                                    color: {{ $block->pdf_color }} !important;
                                }
                                #div-icon-01:hover #svg-icon-01 path {
                                    fill: {{ $block->pdf_color }} !important;
                                }
                            </style>
                        @endpush
                        <div class="w-full md:w-1/2 lg:w-1/4 px-4 py-2" id="div-icon-00">
                            <div class="cursor-pointer" onclick="toggleModal{{$block->id}}()">
                                <div id="bg-icon-00" class="pt-8 px-6 pb-6 rounded shadow h-full" style="background-color: {{ $block->primary_color }}">
                                    <div id="svg-icon-00" class="w-10 h-10 svg-icon-{{ $block->id }}">
                                        <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M40.95 38.32L32.87 30.24C35.57 26.94 37.05 22.8 37.05 18.52C37.06 8.31 28.74 0 18.53 0C8.32 0 0 8.31 0 18.53C0 28.75 8.31 37.06 18.53 37.06C22.81 37.06 26.95 35.58 30.25 32.88L38.33 40.96C38.68 41.31 39.15 41.51 39.65 41.51C40.15 41.51 40.61 41.32 40.97 40.97C41.33 40.62 41.52 40.15 41.52 39.65C41.52 39.15 41.33 38.69 40.97 38.33L40.95 38.32ZM33.33 18.53C33.33 26.69 26.69 33.34 18.52 33.34C10.35 33.34 3.72 26.69 3.72 18.53C3.72 10.37 10.36 3.72 18.53 3.72C26.7 3.72 33.34 10.36 33.34 18.53H33.33Z" fill="white"/>
                                        </svg>
                                    </div>
                                    <span id="title-icon-00" class="font-bold font-heading w-full text-[14px]" style="color: {{ $block->tag_title_color }}">Pesquisar</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 lg:w-1/4 px-4 py-2" id="div-icon-01">
                            <a href="https://portal.multiclubes.com.br/aabbsp/login.aspx?ReturnUrl=%2Faabbsp%2F" target="_blank">
                                <div id="bg-icon-01" class="pt-8 px-6 pb-6 rounded shadow h-full" style="background-color: {{ $block->primary_color }}">
                                    <div id="svg-icon-01" class="w-10 h-10 svg-icon-{{ $block->id }}">
                                        <svg width="40" height="44" viewBox="0 0 40 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M37.56 43.9999C36.46 43.9999 35.56 43.0999 35.56 41.9999V37.5599C35.56 35.7199 34.84 33.9899 33.54 32.6899C32.24 31.3899 30.51 30.6699 28.67 30.6699H10.89C9.05 30.6699 7.32 31.3899 6.02 32.6899C4.72 33.9899 4 35.7199 4 37.5599V41.9999C4 43.0999 3.1 43.9999 2 43.9999C0.9 43.9999 0 43.0999 0 41.9999V37.5599C0 34.6499 1.13 31.9199 3.19 29.8599C5.25 27.7999 7.98 26.6699 10.89 26.6699H28.67C31.58 26.6699 34.31 27.7999 36.37 29.8599C38.43 31.9199 39.56 34.6499 39.56 37.5599V41.9999C39.56 43.0999 38.66 43.9999 37.56 43.9999Z" fill="white"/>
                                            <path d="M19.7806 21.78C13.7806 21.78 8.89062 16.9 8.89062 10.89C8.89062 4.88 13.7706 0 19.7806 0C25.7906 0 30.6706 4.88 30.6706 10.89C30.6706 16.9 25.7906 21.78 19.7806 21.78ZM19.7806 4C15.9806 4 12.8906 7.09 12.8906 10.89C12.8906 14.69 15.9806 17.78 19.7806 17.78C23.5806 17.78 26.6706 14.69 26.6706 10.89C26.6706 7.09 23.5806 4 19.7806 4Z" fill="white"/>
                                        </svg>
                                    </div>
                                    <span id="title-icon-01" class="font-bold font-heading w-full text-[14px]" style="color: {{ $block->tag_title_color }}">Portal do Associado</span>
                                </div>
                            </a>
                        </div>
                    @endif
                    @foreach($pages as $item)
                        @php
                            $url = '';
                            if ($item->prefix_slug->count() > 0) {
                                $url .= implode('/', $item->prefix_slug->pluck('slug')->toArray()) . '/';
                            }
                            $url = '/' . $url . $item->slug;
                        @endphp
                        @push('head')
                            <style>
                                #div-icon-{{ $item->id }}:hover #bg-icon-{{ $item->id }} {
                                    background-color: {{ $block->tag_color }} !important;
                                }
                                #div-icon-{{ $item->id }}:hover #title-icon-{{ $item->id }} {
                                    color: {{ $block->pdf_color }} !important;
                                }
                                #div-icon-{{ $item->id }}:hover #svg-icon-{{ $item->id }} path {
                                    fill: {{ $block->pdf_color }} !important;
                                }
                            </style>
                        @endpush
                        <div id="div-icon-{{ $item->id }}" class="w-full md:w-1/2 lg:w-1/4 px-4 py-2">
                            <a href="{{ $url }}">
                                <div id="bg-icon-{{ $item->id }}" class="pt-8 px-6 pb-6 rounded shadow h-full" style="background-color: {{ $block->primary_color }}">
                                    <div id="svg-icon-{{ $item->id }}" class="w-10 h-10 svg-icon-{{ $block->id }}">
                                        {!! $item->svg !!}
                                    </div>
                                    <span id="title-icon-{{ $item->id }}" class="font-bold font-heading w-full text-[14px]" style="color: {{ $block->tag_title_color }}">{{ $item->title }}</span>
                                </div>
                            </a>
                        </div>
                        @if($loop->index == 5)
                            </div>
                            <div class="swiper-slide flex-wrap" style="display: flex !important;">
                        @endif
                    @endforeach
                    </div>
                </div>
            </div>
            <div class="swiper-pagination-{{ $block->id }}" id="pagination-{{ $block->id }}"></div>
        </div>
    </div>
</section>

@if(env('APP_NAME') == 'AABB-SP')
    <!-- Modal de pesquisa -->
    <div id="searchModal-{{ $block->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 opacity-0 transition-opacity duration-500" style="display: none;">
        <div class="bg-white p-1 rounded shadow-lg w-full max-w-lg relative">
            <div class="relative mx-auto w-full">
                <img class="absolute transform -translate-y-1/2" src="{{ asset('images/blog/search.svg') }}" alt="" style="top: 50%; left: 1rem;">
                <form method="GET" action="/">
                    <input name="busca" class="w-full py-3 pl-12 pr-4 text-gray-900 leading-tight placeholder-gray-500 border border-gray-200 rounded-lg shadow-xsm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" type="text" placeholder="Procurar">
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleModal{{$block->id}}() {
                var modal = document.getElementById('searchModal-{{ $block->id }}');
                if (modal.style.display === 'none' || modal.style.display === '') {
                    modal.style.display = 'flex';
                    setTimeout(function() {
                        modal.classList.add('opacity-100');
                        modal.classList.remove('opacity-0');
                    }, 10);
                } else {
                    modal.classList.add('opacity-0');
                    modal.classList.remove('opacity-100');
                    setTimeout(function() {
                        modal.style.display = 'none';
                    }, 300);
                }
            }

            window.onclick = function(event) {
                var modal = document.getElementById('searchModal-{{ $block->id }}');
                if (event.target == modal) {
                    toggleModal{{$block->id}}();
                }
            }
        </script>
    @endpush
@endif

@push('scripts')
    <script>
        new Swiper('.swiper-container-{{ $block->id }}', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            centeredSlides: false,
            pagination: {
                el: '.swiper-pagination-{{ $block->id }}',
                clickable: true,
                bulletClass: 'swiper-pagination-bullet',
                bulletActiveClass: 'swiper-pagination-bullet-active'

            }
        });
    </script>
@endpush

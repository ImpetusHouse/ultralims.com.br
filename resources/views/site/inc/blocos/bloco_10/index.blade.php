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
        #swiper-button-prev-{{ $block->id }}, #swiper-button-next-{{ $block->id }} {
            color: {{ env('PRIMARY_COLOR') }}; /* Define a cor vermelha */
        }

        /* Se você quiser mudar a cor ao passar o mouse sobre os botões */
        #swiper-button-prev-{{ $block->id }}:hover, #swiper-button-next-{{ $block->id }}:hover {
            color: {{ env('PRIMARY_COLOR').'33' }}; /* Define uma cor verde ao passar o mouse */
        }
    </style>
@endpush
<section id="section_{{ $i }}" class="py-20 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="container px-4 mx-auto">
        <div class="flex flex-wrap items-center justify-between max-w-2xl lg:max-w-full mb-12">
            <div class="w-full lg:w-1/2 mb-4 lg:mb-0">
                <h2 class="block-title font-black font-heading">
                    <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                    @if($block->subtitle)
                        <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                    @endif
                </h2>
            </div>
            <div class="w-full lg:w-1/2 lg:pl-16 block-description">
                <p style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
            </div>
        </div>
        <!-- Swiper -->
        <div class="swiper swiper-container-{{ $block->id }} mb-2">
            <div class="swiper-wrapper">
                @foreach($block->tabs->sortBy('display_order') as $tab)
                    @php
                        $url = '';
                        if ($tab->button_display){
                            $url = 'href="';
                            if ($tab->button_type == 'inner_page') {
                                $page = \App\Models\Pages\Page::where('id', $tab->button_link)->first();
                                if ($page != null){
                                    $prefix = '';
                                    if ($page->prefix_slug->count() > 0) {
                                        $prefix .= implode('/', $page->prefix_slug->pluck('slug')->toArray()) . '/';
                                    }
                                    $url .= '/' . $prefix . $page->slug;
                                }
                            } elseif ($tab->button_type == 'link') {
                                $url .= $tab->button_link;
                            }
                            $url .= '"';
                        }
                    @endphp
                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <{!! $tab->button_display ? 'a':'span' !!} class="flex justify-center md:block h-full" {!! $url !!} {!! $tab->button_display && $tab->button_type == 'inner_page' ? '' : 'target="_blank"' !!}>
                            <div class="relative h-[500px] md:h-full w-full rounded-3xl overflow-hidden">
                                <img class="h-[500px] md:h-full w-full object-cover transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset($tab->image) }}" alt="{{ $block->title }}"/>
                                <div class="absolute bottom-0 left-0 w-full px-11">
                                    <div class="px-8 py-4 bg-opacity-10 rounded-xl shadow-5xl bg-white" style="-webkit-backdrop-filter: blur(5px); backdrop-filter: blur(5px);">
                                        <h3 class="text-lg text-center font-semibold" style="color: {{ $tab->title_color }};">{{ $tab->title }}</h3>
                                        <h3 class="text-center text-sm text-opacity-80" style="color: {{ $tab->subtitle_color }}">{{ $tab->subtitle }}</h3>
                                    </div>
                                </div>
                            </div>
                        </{!! $tab->button_display ? 'a':'span' !!}>
                    </div>
                @endforeach
            </div>
            {{--<!-- Add Navigation -->
            <div class="swiper-button-prev" id="swiper-button-prev-{{ $block->id }}"></div>
            <div class="swiper-button-next" id="swiper-button-next-{{ $block->id }}"></div>--}}
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination-{{ $block->id }}" id="pagination-{{ $block->id }}"></div>
    </div>
</section>
@push('scripts')
    <script>
        new Swiper('.swiper-container-{{ $block->id }}', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            centeredSlides: false,
            autoplay: {
                delay: 5000, // Define o intervalo de tempo entre as transições
                disableOnInteraction: false, // O autoplay não será desativado após interações do usuário (swipes, cliques, etc.)
            },
            //slideToClickedSlide: true,
            pagination: {
                el: '.swiper-pagination-{{ $block->id }}',
                clickable: true,
                bulletClass: 'swiper-pagination-bullet',
                bulletActiveClass: 'swiper-pagination-bullet-active'

            },
            /*navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },*/
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
            }
        });
    </script>
@endpush

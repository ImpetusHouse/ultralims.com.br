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
<section id="section_{{ $i }}" class="relative overflow-hidden" style="background-color: {{ $block->background_color }}; padding-top: {{ $block->margin_top }}px; padding-bottom: {{ $block->margin_bottom }}px">
    <div class="relative container mx-auto px-4">
        <div class="relative max-w-md md:max-w-none mx-auto">
            <div class="flex flex-wrap -mx-0 md:-mx-4">
                <div class="w-full md:w-1/3 px-4 mb-4 lg:mb-0">
                    <div class="max-w-2xl">
                        <h2 class="block-title font-black font-heading mb-2">
                            <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                            @if($block->subtitle)
                                <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                            @endif
                        </h2>
                        <p class="block-description mb-8" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                        <a href="/comunicados" class="block sm:inline-block py-4 px-8 mb-4 sm:mb-0 sm:mr-3 block-button-title text-center font-semibold leading-none hover:opacity-70 rounded" style="color: {{ $block->button_title_color }}; background-color: {{ $block->button_color }}">Todos os comunicados</a>
                    </div>
                </div>
                <div class="w-full md:w-2/3">
                    @php
                        $alerts = \App\Models\General\Alerts\Alert::where('status', true)->whereIn('id', json_decode($block->alerts))->orderBy('display_order')->get();
                    @endphp
                        <!-- Swiper -->
                    <div class="swiper swiper-container-{{ $block->id }}">
                        <div class="swiper-wrapper">
                            @foreach($alerts as $alert)
                                <!-- Slide 1 -->
                                <div class="swiper-slide">
                                    <a href="{{ route('alerts.show', $alert->slug) }}">
                                        <div class="square relative flex items-end px-6 rounded-3xl overflow-hidden">
                                            <img class="absolute top-0 left-0 w-full h-full object-cover transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset(str_replace('public/', 'storage/', $alert->photo)) }}" alt="{{ $alert->title }}">
                                            @if($block->type)
                                                <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black to-transparent"></div>
                                                <div class="relative w-full pb-2">
                                                    <span class="block lg:text-sm text-md text-white font-medium one-line-text">{{ $alert->title }}</span>
                                                    <span class="block lg:text-xs text-sm text-gray-500 font-medium one-line-text">{{ html_entity_decode(strip_tags($alert->description)) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        {{--<!-- Add Navigation -->
                        <div class="swiper-button-prev" id="swiper-button-prev-{{ $block->id }}"></div>
                        <div class="swiper-button-next" id="swiper-button-next-{{ $block->id }}"></div>--}}
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination-{{ $block->id }} mt-8" id="pagination-{{ $block->id }}"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script>
        new Swiper('.swiper-container-{{ $block->id }}', {
            loop: true,
            centeredSlides: false,
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

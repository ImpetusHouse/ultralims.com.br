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
<section id="section_{{ $i }}" class="relative py-10 sm:py-20 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="relative container mx-auto px-4">
        <div class="relative max-w-md md:max-w-none mx-auto">
            <div class="flex flex-wrap items-end -mx-4 lg:mb-8 mb-4">
                <div class="w-full lg:w-1/2 px-4 mb-4 lg:mb-0">
                    <div class="max-w-2xl">
                        <h2 class="block-title font-black font-heading mb-2">
                            <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                            @if($block->subtitle)
                                <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                            @endif
                        </h2>
                        <p class="block-description" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 px-4 lg:text-right">
                    <a href="/eventos" class="block sm:inline-block py-4 px-8 mb-4 sm:mb-0 sm:mr-3 block-button-title text-center font-semibold leading-none hover:opacity-70 rounded" style="color: {{ $block->button_title_color }}; background-color: {{ $block->button_color }}">Todos os eventos</a>
                </div>
            </div>
            @php
                $events = \App\Models\General\Events\Event::where('status', true)->whereIn('id', json_decode($block->events))->orderBy('date')->get();
            @endphp
            <!-- Swiper -->
            <div class="swiper swiper-container-{{ $block->id }}">
                <div class="swiper-wrapper">
                    @foreach($events as $event)
                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <a href="{{ route('events.show', $event->slug) }}">
                                <div class="square relative flex items-end px-6 mb-8 rounded-3xl overflow-hidden">
                                    <img class="absolute top-0 left-0 w-full h-full object-cover transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset(str_replace('public/', 'storage/', $event->photo_square)) }}" alt="{{ $event->title }}">
                                    <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black to-transparent"></div>
                                    <div class="relative w-full pb-2">
                                        <span class="lg:text-xs text-sm px-3 font-semibold rounded-2xl" style="background-color: {{ env('PRIMARY_COLOR') }}; color: #FFF">{{ $event->date->format('d/m/Y') }}</span>
                                        <span class="block lg:text-sm text-md text-white font-medium one-line-text">{{ $event->title }}</span>
                                    </div>
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
            <div class="swiper-pagination-{{ $block->id }}" id="pagination-{{ $block->id }}"></div>
        </div>
    </div>
</section>
@push('scripts')
    <script>
        new Swiper('.swiper-container-{{ $block->id }}', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            centeredSlides: false,
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
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
            }
        });
    </script>
@endpush

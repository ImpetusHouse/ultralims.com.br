@php
    /** @var TYPE_NAME $block */
    $testimonials = \App\Models\General\Testimonials\Testimonial::whereIn('id', json_decode($block->testimonials))->orderBy('client')->get();
@endphp
@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
    <style>
        #pagination-{{ $block->id }} {
            text-align: center;
            position: absolute;
            left: 0;
            right: 0;
            bottom: 10px; /* Ajuste conforme necessário */
        }
        #pagination-{{ $block->id }} .swiper-pagination-bullet {
            background-color: {{ $block->logo_title_color }}; /* Cor cinza para bullets inativos */
            margin-right: 0.25rem !important; /* Espaçamento entre os bullets */
            border-radius: 0 !important;

            width: 2rem !important;
        }
        #pagination-{{ $block->id }} .swiper-pagination-bullet-active {
            background-color: {{ $block->logo_background_color }}; /* Cor para o bullet ativo */
        }
        @media (min-width: 768px) {
            .swiper-slide-border-right {
                border-right: 1px solid {{ $block->divider_color }}; /* Cor da linha divisória */
            }
        }
    </style>
@endpush
<section id="section_{{ $i }}" class="py-20 lg:py-32 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="container px-4 mx-auto">
        <div class="max-w-lg lg:max-w-7xl mx-auto">
            <div class="flex flex-wrap -mx-4 mb-18 items-center">
                <div class="w-full lg:w-1/2 px-4 mb-8 lg:mb-0">
                    <div class="max-w-md">
                        <h2 class="font-black font-heading">
                            <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                            @if($block->subtitle)
                                <span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                            @endif
                        </h2>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 px-4">
                    <div class="max-w-lg">
                        <p class="block-description-{{ $block->id }}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                    </div>
                </div>
            </div>

            <!-- Swiper -->
            <div class="swiper swiper-container-{{ $block->id }}">
                <div class="swiper-wrapper mb-12 items-end">
                    @foreach($testimonials as $testimonial)
                        <div class="swiper-slide">
                            <div class="relative w-full">
                                <div class="max-w-sm">
                                    <img class="block mb-6 mt-10" src="{{ asset('images/blocos/bloco_54/quote-white.svg') }}" alt="">
                                    <p class="text-lg mb-6" style="color: {{ $block->tag_title_color }}">“{!! nl2br($testimonial->description) !!}”</p>
                                    <div class="flex items-center">
                                        <img class="block w-12 h-12 rounded-full" src="{{ asset(str_replace('public/', 'storage/', $testimonial->path)) }}" alt="{{ $testimonial->client }}">
                                        <div class="ml-4">
                                            <span class="block font-semibold leading-none mb-1" style="color: {{ $block->tag_color }}">{{ $testimonial->client }}</span>
                                            <span class="block text-sm" style="color: {{ $block->tag_title_color }}">{{ $testimonial->description_client }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination-{{ $block->id }} inline-block mr-1 w-8 h-1" id="pagination-{{ $block->id }}"></div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script>
        function updateSlideBorders(swiper) {
            const slides = swiper.slides;
            slides.forEach((slide) => {
                slide.classList.remove('swiper-slide-border-right');
            });
            slides[swiper.activeIndex].classList.add('swiper-slide-border-right');
        }

        new Swiper('.swiper-container-{{ $block->id }}', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            pagination: {
                el: '.swiper-pagination-{{ $block->id }}',
                clickable: true,
                bulletClass: 'swiper-pagination-bullet',
                bulletActiveClass: 'swiper-pagination-bullet-active'

            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 80,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 80,
                },
                1024: {
                    slidesPerView: 2,
                    spaceBetween: 80,
                },
            },
            on: {
                init: function () {
                    updateSlideBorders(this);
                },
                slideChange: function () {
                    updateSlideBorders(this);
                }
            }
        });
    </script>
@endpush

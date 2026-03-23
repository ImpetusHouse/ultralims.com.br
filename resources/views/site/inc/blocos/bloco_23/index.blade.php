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
<section id="section_{{ $i }}" class="relative py-12 sm:py-24 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="relative container mx-auto px-4">
        <div class="w-full flex justify-center mb-14">
            <div class="max-w-xl xs:max-w-4xl text-center">
                <h2 class="block-title font-black font-heading mb-6">
                    <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                    @if($block->subtitle)
                        <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                    @endif
                </h2>
                <p class="block-description" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
            </div>
        </div>
        @php
            $researchs = \App\Models\III\ResearchPlatform\ResearchPlatform::where('thematic_area', true)->where('status', true)->orderBy('title')->get();
        @endphp
        <!-- Swiper -->
        <div class="swiper swiper-container-{{ $block->id }}">
            <div class="swiper-wrapper">
                @foreach($researchs as $research)
                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <a href="{{ route('pesquisas.show', $research->slug) }}">
                            <div class="relative h-48 xl:h-44 pt-4 md:pt-6 px-9 pb-7 rounded-3xl overflow-hidden">
                                <img class="absolute bottom-0 left-0 w-full h-full object-cover transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset(str_replace('public/', 'storage/', $research->photo)) }}" alt="">
                                <div class="absolute bottom-0 left-0 p-4 w-full">
                                    <span class="block font-black text-white text-md two-line-text">{{ $research->title }}</span>
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
</section>
@push('scripts')
    <script>
        new Swiper('.swiper-container-{{ $block->id }}', {
            loop: true,
            centeredSlides: true,
            slideToClickedSlide: true,
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
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            }
        });
    </script>
@endpush

@php
    $galleries = \App\Models\General\Galleries\Gallery::where('status', true)->whereIn('id', json_decode($block->galleries))->orderBy('date', 'desc')->get();
@endphp
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

        @if($galleries->count() > 3)
            @media (min-width: 768px) {
                .swiper-container-{{ $block->id }} {
                    width: 100vw; /* Define a largura para 100% da largura da janela */
                    position: relative; /* Posicionamento relativo para alinhamento adequado */
                    left: 50%; /* Move para a direita pela metade da própria largura */
                    right: 50%; /* Move para a esquerda pela metade da própria largura */
                    margin-left: -50vw; /* Ajuste para a metade da largura da janela para a esquerda */
                    margin-right: -50vw; /* Ajuste para a metade da largura da janela para a direita */
                }
            }
        @endif

        .lg-outer .lg-thumb-item.active, .lg-outer .lg-thumb-item:hover{
            border-color: {{ env('PRIMARY_COLOR') }} !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery/css/lightgallery.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery/css/lightgallery-bundle.min.css">
@endpush
<section id="section_{{ $i }}" class="pb-10 sm:pb-20 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="container mx-auto px-4">
        <div class="mx-auto">
            <div class="flex flex-wrap items-end -mx-4 lg:mb-8 mb-4">
                <div class="w-full lg:w-1/2 px-4 mb-4 lg:mb-0">
                    <div class="max-w-2xl">
                        @if($block->title || $block->subtitle)
                            <h2 class="block-title font-black font-heading {{ $block->content ? 'mb-2':'' }}">
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
                <div class="w-full lg:w-1/2 px-4 lg:text-right">
                    @if($block->type)
                        <a href="/galerias" class="block sm:inline-block py-4 px-8 mb-4 sm:mb-0 sm:mr-3 block-button-title text-center font-semibold leading-none hover:opacity-70 rounded" style="color: {{ $block->button_title_color }}; background-color: {{ $block->button_color }}">Todas as galerias</a>
                    @endif
                </div>
            </div>
            <!-- Swiper -->
            <div class="swiper swiper-container-{{ $block->id }}">
                <div class="swiper-wrapper">
                    @foreach($galleries as $gallery)
                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <div class="gallery-container" id="gallery-{{ $gallery->id }}">
                                <a href="javascript:void(0);"
                                   data-lg="true"
                                   data-src="{{ asset(str_replace('public/', 'storage/', $gallery->photos->first()->path)) }}"
                                   data-sub-html="<h4>{{ $gallery->title }}</h4><h5>Foto: {{ $gallery->photographer }}</h5>">
                                    <div class="ratio-16-9 relative flex items-end mb-8 rounded-3xl overflow-hidden">
                                        <img class="absolute top-0 left-0 w-full h-full object-cover transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset(str_replace('public/', 'storage/', $gallery->photos->first()->path)) }}" alt="{{ $gallery->title }}">
                                        <div class="absolute bottom-0 left:0 w-full h-32 bg-gradient-to-t from-black to-transparent"></div>
                                        <div class="absolute w-full pb-2 px-6">
                                            <span class="block lg:text-lg text-md text-white font-medium one-line-text gallery-title">{{ $gallery->title }}</span>
                                        </div>
                                    </div>
                                </a>
                                @foreach($gallery->photos as $photo)
                                    @if($loop->first) @continue @endif
                                    <a href="javascript:void(0);" style="display: none;"
                                       data-lg="true"
                                       data-src="{{ asset(str_replace('public/', 'storage/', $photo->path)) }}"
                                       data-sub-html="<h4>{{ $gallery->title }}</h4><h5>Foto: {{ $gallery->photographer }}</h5>">
                                        <img class="lazyload" data-src="{{ asset(str_replace('public/', 'storage/', $photo->path)) }}" alt="{{ $gallery->title }}">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                {{--<!-- Add Navigation -->
                <div class="swiper-button-prev" id="swiper-button-prev-{{ $block->id }}"></div>
                <div class="swiper-button-next" id="swiper-button-next-{{ $block->id }}"></div>--}}
            </div>
            <!-- Add Pagination -->
            @if($galleries->count() <= 3)
                <div class="swiper-pagination-{{ $block->id }}" id="pagination-{{ $block->id }}"></div>
            @endif
        </div>
    </div>
</section>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/lightgallery/lightgallery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery/plugins/thumbnail/lg-thumbnail.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
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
                    slidesPerView: {{ $galleries->count() > 3 ? 2.5 : 2 }},
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: {{ $galleries->count() > 3 ? 3.5 : 2 }},
                    spaceBetween: 20,
                },
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
            const galleryContainers = document.querySelectorAll('.gallery-container:not(.lg-initialized)');
            galleryContainers.forEach(container => {
                lightGallery(container, {
                    selector: 'a[data-lg="true"]',
                    speed: 500,
                    thumbnail: true,
                    plugins: [lgThumbnail], // Se você estiver usando o plugin de zoom também
                    thumbWidth: 100,
                    thumbMargin: 5,
                    exThumbImage: 'data-src' // Define o atributo que contém o caminho da thumbnail para lazy load
                });
                container.classList.add('lg-initialized');
            });

            const galleryTitles = document.querySelectorAll('.gallery-title');
            galleryTitles.forEach(title => {
                title.parentElement.parentElement.parentElement.addEventListener('mouseover', function() {
                    title.classList.remove('one-line-text');
                });
                title.parentElement.parentElement.parentElement.addEventListener('mouseout', function() {
                    title.classList.add('one-line-text');
                });
            });
        });
    </script>
@endpush

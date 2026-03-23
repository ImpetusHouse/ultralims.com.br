@extends('site.layout')
@php
    /** @var TYPE_NAME $alert */
    $alert->description = str_replace('<h2', '<h2 class="mb-4 text-3xl md:text-4xl font-semibold text-[#00268A]"', $alert->description);
    $alert->description = str_replace('<h3', '<h3 class="mb-4 text-2xl md:text-3xl font-semibold text-[#00268A]"', $alert->description);
    $alert->description = str_replace('<h4', '<h4 class="mb-4 text-xl md:text-2xl font-semibold text-[#00268A]"', $alert->description);
    $alert->description = str_replace('<strong', '<strong class="text-[#00268A] font-black"', $alert->description);
@endphp
@push('head')
    @if($alert->galleries->count() > 0)
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery/css/lightgallery.min.css">
    @endif
    <style>
        .center-title:hover{
            color: {{ env('PRIMARY_COLOR') }};
        }

        #pagination {
            text-align: center;
        }
        #pagination .swiper-pagination-bullet {
            background-color: #B8C2CC; /* Cor cinza para bullets inativos */
            margin-right: 8px; /* Espaçamento entre os bullets */
        }
        #pagination .swiper-pagination-bullet-active {
            background-color: {{ env('PRIMARY_COLOR') }}; /* Cor para o bullet ativo */
        }
        #swiper-button-prev, #swiper-button-next {
            color: {{ env('PRIMARY_COLOR') }}; /* Define a cor vermelha */
        }

        /* Se você quiser mudar a cor ao passar o mouse sobre os botões */
        #swiper-button-prev:hover, #swiper-button-next:hover {
            color: {{ env('PRIMARY_COLOR').'33' }}; /* Define uma cor verde ao passar o mouse */
        }
    </style>
@endpush
@section('content')
    <img src="{{ asset('images/blocos/bloco_3/default.png') }}" alt="{{ $alert->title }}" class="w-full h-48 object-cover">
    @include('site.inc.breadcrumb', ['breadcrumbs' => generateBreadcrumbs()])
    <section class="pt-20 pb-24 md:pb-32 overflow-hidden">
        <div class="container px-4 mx-auto">
            <div class="flex flex-wrap -m-8 lg:-m-12">
                <div class="w-full md:w-1/3 p-8 lg:p-12">
                    <div class="w-full mx-auto square">
                        <img class="rounded-3xl w-full h-full object-cover transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset(str_replace('public/', 'storage/', $alert->photo)) }}" alt="{{ $alert->title }}">
                    </div>
                </div>
                <div class="w-full md:w-2/3 p-8 lg:p-12">
                    <h2 class="block-title font-black font-heading racking-tighter-xl text-[#00268A] mb-4">{{ $alert->title }}</h2>
                    <div class="block-description text-[#8E9AAF]">{!! nl2br($alert->description) !!}</div>
                </div>
            </div>
        </div>
    </section>
    @if($alert->galleries->count() > 0)
        <section class="py-2 sm:py-4 overflow-hidden">
            <div class="container mx-auto px-4">
                <div class="max-w-md md:max-w-none mx-auto">
                    <div class="flex flex-wrap items-end -mx-4 lg:mb-8 mb-4">
                        <h2 class="block-title font-black font-heading text-[#00268A]">Confira as galerias de fotos</h2>
                    </div>
                    <div class="relative max-w-md md:max-w-none mx-auto">
                        <div class="flex flex-wrap -mx-4 -mb-8 galleries-container">
                            @php $galleries = $alert->galleries @endphp
                            @include('site.pages.galleries.gallery')
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <section class="py-10 sm:py-20 overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="max-w-md md:max-w-none mx-auto">
                <div class="flex flex-wrap items-end -mx-4 lg:mb-8 mb-4">
                    <div class="w-full lg:w-1/2 px-4 mb-4 lg:mb-0">
                        <div class="max-w-2xl">
                            <h2 class="block-title font-black font-heading text-[#00268A]">Outros comunicados</h2>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2 px-4 lg:text-right">
                        <a href="/comunicados" class="block sm:inline-block py-4 px-8 mb-4 sm:mb-0 sm:mr-3 block-button-title text-center font-semibold leading-none hover:opacity-70 rounded" style="color: #665800; background-color: #FFDC00">Todos os comunicados</a>
                    </div>
                </div>
                <!-- Swiper -->
                <div class="swiper swiper-container">
                    <div class="swiper-wrapper mb-2">
                        @foreach($alerts as $alert)
                            <!-- Slide 1 -->
                            <div class="swiper-slide">
                                <a href="{{ route('alerts.show', $alert->slug) }}">
                                    <div class="square relative flex items-end px-6 mb-8 rounded-3xl overflow-hidden">
                                        <img class="absolute top-0 left-0 w-full h-full object-cover transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset(str_replace('public/', 'storage/', $alert->photo)) }}" alt="{{ $alert->title }}">
                                        <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black to-transparent"></div>
                                        <div class="relative w-full pb-2">
                                            <span class="block lg:text-sm text-md text-white font-medium one-line-text">{{ $alert->title }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination" id="pagination"></div>
                    {{--<!-- Add Navigation -->
                    <div class="swiper-button-prev" id="swiper-button-prev-{{ $block->id }}"></div>
                    <div class="swiper-button-next" id="swiper-button-next-{{ $block->id }}"></div>--}}
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/lightgallery/lightgallery.min.js"></script>
    <script>
        new Swiper('.swiper-container', {
            loop: true,
            centeredSlides: false,
            pagination: {
                el: '.swiper-pagination',
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

        document.addEventListener('DOMContentLoaded', function () {
            generateLightBox()
        });
        function generateLightBox(){
            const galleryContainers = document.querySelectorAll('.gallery-container');
            galleryContainers.forEach(container => {
                lightGallery(container, {
                    selector: 'a[data-lg="true"]',
                    speed: 500
                });
            });
        }
    </script>
@endpush

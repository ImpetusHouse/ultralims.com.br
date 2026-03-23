@extends('site.layout')
@php
    /** @var TYPE_NAME $event */
    $event->content = str_replace('<h2', '<h2 class="mb-4 text-3xl md:text-4xl font-semibold"', $event->content);
    $event->content = str_replace('<h3', '<h3 class="mb-4 text-2xl md:text-3xl font-semibold"', $event->content);
    $event->content = str_replace('<h4', '<h4 class="mb-4 text-xl md:text-2xl font-semibold"', $event->content);
    $event->content = str_replace('<strong', '<strong class="font-black"', $event->content);
@endphp
@push('head')
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
    @if(env('APP_NAME') == 'AABB-SP')
        <img src="{{ asset('images/blocos/bloco_3/default.png') }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
    @endif
    @include('site.inc.breadcrumb', ['breadcrumbs' => generateBreadcrumbs()])
    <section class="pt-20 pb-24 md:pb-32 overflow-hidden">
        <div class="container px-4 mx-auto">
            <div class="flex flex-wrap -m-8 lg:-m-12">
                <div class="w-full md:w-1/3 p-8 lg:p-12">
                    <div class="w-full mx-auto square">
                        <img class="rounded-3xl w-full h-full object-cover transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset(str_replace('public/', 'storage/', $event->photo_square)) }}" alt="{{ $event->title }}">
                    </div>
                </div>
                <div class="w-full md:w-2/3 p-8 lg:p-12">
                    <h2 class="block-title font-black font-heading racking-tighter-xl text-[#00268A] mb-4">{{ $event->title }}</h2>
                    <div class="mb-4 block-description text-[#3499F6] font-black">
                        {{ $event->date->format('d/m/Y') }}
                        @if($event->end_date)
                            - {{ $event->end_date->format('d/m/Y') }}
                        @endif
                    </div>
                    @if($event->time)
                        <div class="mb-4 block-description">
                            <span class="text-[#00268A] font-black">Horário: </span>
                            <span class="text-[#8E9AAF]">{{ $event->time }}</span>
                        </div>
                    @endif
                    @if($event->local)
                        <div class="mb-4 block-description">
                            <span class="text-[#00268A] font-black">Local: </span>
                            <span class="text-[#8E9AAF]">{{ $event->local }}</span>
                        </div>
                    @endif
                    <div class="block-description">{!! nl2br($event->content) !!}</div>
                </div>
            </div>
        </div>
    </section>
    @if($events->count() > 0)
        <section class="py-10 sm:py-20 overflow-hidden">
            <div class="container mx-auto px-4">
                <div class="max-w-md md:max-w-none mx-auto">
                    <div class="flex flex-wrap items-end -mx-4 lg:mb-8 mb-4">
                        <div class="w-full lg:w-1/2 px-4 mb-4 lg:mb-0">
                            <div class="max-w-2xl">
                                <h2 class="block-title font-black font-heading text-[#00268A]">Outros</h2>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/2 px-4 lg:text-right">
                            <a href="/eventos" class="block sm:inline-block py-4 px-8 mb-4 sm:mb-0 sm:mr-3 block-button-title text-center font-semibold leading-none hover:opacity-70 rounded" style="color: #665800; background-color: #FFDC00">Todos os eventos</a>
                        </div>
                    </div>
                    <!-- Swiper -->
                    <div class="swiper swiper-container">
                        <div class="swiper-wrapper mb-2">
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
                        <!-- Add Pagination -->
                        <div class="swiper-pagination" id="pagination"></div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
@push('scripts')
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
    </script>
@endpush

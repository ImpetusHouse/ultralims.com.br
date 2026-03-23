@extends('site.layout')
@section('content')
    @php
        /** @var TYPE_NAME $analysisGroup */
        $block = new \App\Models\Pages\Block();
        $block->id = 99999;
        $block->layout = 3;

        $block->margin_top = 35;
        $block->margin_bottom = 35;
        $block->image = '/images/blocos/bloco_3/default.png';
        $block->content_type = 'image';
    @endphp
    @include('site.inc.blocos.bloco_' . $block->layout . '.index', ['i' => 1])
    @include('site.inc.breadcrumb', ['breadcrumbs' => generateBreadcrumbs()])
    <section class="bg-white">
        <div style="background-color: white; padding-bottom: 2rem">
            @if($pages->count() > 0)
                <div class="mt-8 container mx-auto px-4">
                    <div class="text-[#293F57] text-lg mb-4">
                        <span class="font-black">{{ $pages->count() }}</span> páginas encontradas
                    </div>
                    <div>
                        @foreach($pages as $item)
                            <div class="py-6 border-t-2 border-gray-100 group">
                                <div class="flex flex-wrap lg:flex-nowrap items-center">
                                    <div class="w-full lg:w-9/12 px-4 mb-10 lg:mb-0">
                                        <div class="max-w-2xl">
                                            <p class="text-lg font-semibold text-gray-900 mb-1">{{ $item->title }}</p>
                                            <span class="w-full two-line-text block text-gray-400">{{ $item->seo_description }}</span>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-auto px-4 ml-auto text-right">
                                        @php
                                            $url = '';
                                            if ($item->prefix_slug->count() > 0) {
                                                $url .= implode('/', $item->prefix_slug->pluck('slug')->toArray()) . '/';
                                            }
                                            $url = '/' . $url . $item->slug;
                                        @endphp
                                        <a href="{{ $url }}" class="hidden group-hover:inline-block w-full lg:w-auto transition duration-300 ease-in-out py-4 px-8 mb-4 sm:mb-0 sm:mr-3 block-button-title text-center text-[#000000] text-opacity-60 bg-[#FFDC00] hover:bg-[#665800] font-semibold leading-none hover:opacity-70 rounded">
                                            Visualizar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($events->count() > 0)
                <div class="mt-8 container mx-auto px-4">
                    <div class="text-[#293F57] text-lg mb-4">
                        <span class="font-black">{{ $events->count() }}</span> eventos encontradas
                    </div>
                    <div>
                        @foreach($events as $event)
                            <div class="py-6 border-t-2 border-gray-100 group">
                                <div class="flex flex-wrap lg:flex-nowrap items-center">
                                    <div class="w-full lg:w-9/12 px-4 mb-10 lg:mb-0">
                                        <div class="max-w-2xl">
                                            <p class="text-lg font-semibold text-gray-900 mb-1">{{ $event->title }}</p>
                                            <span class="w-full two-line-text block text-gray-400">{!! strip_tags(html_entity_decode($event->content)) !!}</span>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-auto px-4 ml-auto text-right">
                                        <a href="{{ route('events.show', $event->slug) }}" class="hidden group-hover:inline-block w-full lg:w-auto transition duration-300 ease-in-out py-4 px-8 mb-4 sm:mb-0 sm:mr-3 block-button-title text-center text-[#000000] text-opacity-60 bg-[#FFDC00] hover:bg-[#665800] font-semibold leading-none hover:opacity-70 rounded">
                                            Visualizar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($galleries->count() > 0)
                <div class="mt-8 container mx-auto px-4">
                    <div class="text-[#293F57] text-lg mb-4">
                        <span class="font-black">{{ $galleries->count() }}</span> galerias encontradas
                    </div>
                    <div>
                        @foreach($galleries as $gallery)
                            <div class="py-6 border-t-2 border-gray-100 group">
                                <div class="flex flex-wrap lg:flex-nowrap items-center">
                                    <div class="w-full lg:w-9/12 px-4 mb-10 lg:mb-0">
                                        <div class="max-w-2xl">
                                            <p class="text-lg font-semibold text-gray-900">{{ $gallery->title }}</p>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-auto px-4 ml-auto text-right">
                                        <a href="/galerias?search={{ urlencode($gallery->title) }}" class="hidden group-hover:inline-block w-full lg:w-auto transition duration-300 ease-in-out py-4 px-8 mb-4 sm:mb-0 sm:mr-3 block-button-title text-center text-[#000000] text-opacity-60 bg-[#FFDC00] hover:bg-[#665800] font-semibold leading-none hover:opacity-70 rounded">
                                            Visualizar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($alerts->count() > 0)
                <div class="mt-8 container mx-auto px-4">
                    <div class="text-[#293F57] text-lg mb-4">
                        <span class="font-black">{{ $alerts->count() }}</span> comunicados encontradas
                    </div>
                    <div>
                        @foreach($alerts as $alert)
                            <div class="py-6 border-t-2 border-gray-100 group">
                                <div class="flex flex-wrap lg:flex-nowrap items-center">
                                    <div class="w-full lg:w-9/12 px-4 mb-10 lg:mb-0">
                                        <div class="max-w-2xl">
                                            <p class="text-lg font-semibold text-gray-900 mb-1">{{ $alert->title }}</p>
                                            <span class="w-full two-line-text block text-gray-400">{!! strip_tags(html_entity_decode($alert->description)) !!}</span>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-auto px-4 ml-auto text-right">
                                        <a href="{{ route('alerts.show', $alert->slug) }}" class="hidden group-hover:inline-block w-full lg:w-auto transition duration-300 ease-in-out py-4 px-8 mb-4 sm:mb-0 sm:mr-3 block-button-title text-center text-[#000000] text-opacity-60 bg-[#FFDC00] hover:bg-[#665800] font-semibold leading-none hover:opacity-70 rounded">
                                            Visualizar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($magazines->count() > 0)
                <div class="mt-8 container mx-auto px-4">
                    <div class="text-[#293F57] text-lg mb-4">
                        <span class="font-black">{{ $magazines->count() }}</span> revistas encontradas
                    </div>
                    <div>
                        @foreach($magazines as $magazine)
                            <div class="py-6 border-t-2 border-gray-100 group">
                                <div class="flex flex-wrap lg:flex-nowrap items-center">
                                    <div class="w-full lg:w-9/12 px-4 mb-10 lg:mb-0">
                                        <div class="max-w-2xl">
                                            <p class="text-lg font-semibold text-gray-900">{{ $magazine->title }}</p>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-auto px-4 ml-auto text-right">
                                        <a href="/revistas?search={{ urlencode($magazine->title) }}" class="hidden group-hover:inline-block w-full lg:w-auto transition duration-300 ease-in-out py-4 px-8 mb-4 sm:mb-0 sm:mr-3 block-button-title text-center text-[#000000] text-opacity-60 bg-[#FFDC00] hover:bg-[#665800] font-semibold leading-none hover:opacity-70 rounded">
                                            Visualizar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@extends('site.layout')
@php
    /** @var TYPE_NAME $article */
    $article->content = str_replace('<h2', '<h2 class="mb-3 mt-4 text-2xl md:text-3xl font-bold text-gray-800"', $article->content);
    $article->content = str_replace('<h3', '<h3 class="mb-3 mt-4 text-xl md:text-2xl font-semibold text-gray-800"', $article->content);
    $article->content = str_replace('<h4', '<h4 class="mb-3 mt-4 text-lg md:text-xl font-semibold text-gray-800"', $article->content);
    $article->content = str_replace('<p', '<p style="font-size: 16px"', $article->content);
    $article->content = str_replace('<a', '<a class="text-blue-700"', $article->content);
@endphp
@if($article->galleries->count() > 0)
    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery/css/lightgallery.min.css">
    @endpush
@endif
@section('content')
    @if(env('APP_NAME') == 'AABB-SP')
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
    @endif
    @include('site.inc.breadcrumb', ['breadcrumbs' => generateBreadcrumbs()])
    <section class="pt-10 md:pt-20 pb-12 md:pb-16 overflow-hidden">
        <div class="container px-4 mx-auto">
            <div class="md:max-w-2xl mx-auto mb-12 text-center">
                @if($article->status == 'published')
                    <div class="flex items-center justify-center">
                        @if(env('APP_NAME') != 'AABB-SP')
                            <p class="inline-block font-medium" style="color: {{ env('PRIMARY_COLOR') }}">{{ $article->user->name.' '.$article->user->lastname }}</p>
                            <span class="mx-1" style="color: {{ env('PRIMARY_COLOR') }}">•</span>
                        @endif
                        <p class="inline-block font-medium" style="color: {{ env('PRIMARY_COLOR') }}">{{ $article->published_at->translatedFormat('d').' '.ucfirst($article->published_at->translatedFormat('M Y')) }}</p>
                    </div>
                @endif
                <h1 class="mb-4 text-3xl md:text-4xl leading-tight text-gray-900 font-black tracking-tighter">{{ $article->title }}</h1>
                <div>
                    @foreach($article->categories as $category)
                        <a href="/blog?categoria={{ $category->slug }}"
                           class="mb-4 font-sans max-w-max px-3 py-1 text-sm font-semibold uppercase rounded-xl"
                           style="color: {{ $category->color }}; background-color: {{ $category->color.'33' }}">{{ $category->title }}</a>
                    @endforeach
                </div>
            </div>
            <div class="mb-6 mx-auto max-w-max overflow-hidden rounded-lg">
                <img src="{{ asset(str_replace('public/', 'storage/', $article->photo)) }}" alt="">
            </div>
            <div class="md:max-w-3xl mx-auto text-base md:text-lg text-[#737276] font-normal">
                {!! nl2br($article->content) !!}
            </div>
        </div>
    </section>
    @if($article->galleries->count() > 0)
        <section class="relative py-2 sm:py-4 overflow-hidden" style="background-color: white">
            <div class="relative container mx-auto px-4 mb-8">
                <h2 class="mb-4 text-xl md:text-2xl leading-tight text-gray-900 font-black tracking-tighter">Confira mais fotos</h2>
                <div class="relative max-w-md md:max-w-none mx-auto">
                    <div class="flex flex-wrap -mx-4 -mb-8 galleries-container">
                        @php $galleries = $article->galleries @endphp
                        @include('site.pages.galleries.gallery')
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
@if($article->galleries->count() > 0)
    <script src="https://cdn.jsdelivr.net/npm/lightgallery/lightgallery.min.js"></script>
    <script>
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
@endif

@php
    $articles = \App\Models\Articles\Article::where('status', 'published')->orderBy('published_at', 'desc')->take(3)->get();
@endphp
@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="relative overflow-hidden" style="padding-top: {{ $block->margin_top }}px; padding-bottom: {{ $block->margin_bottom }}px">
    <div class="relative container px-4 mx-auto">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-wrap -mx-4 mb-20 items-end">
                <div class="w-full lg:w-2/3 xl:w-1/2 px-4 mb-14 lg:mb-0">
                    <div>
                        @if($block->tag)
                            <span class="inline-block py-1 px-3 mb-4 text-xs font-semibold rounded-full" style="color: {{ $block->tag_title_color }}; background-color: {{ $block->tag_color }}">{{ $block->tag }}</span>
                        @endif
                        <h2 class="font-heading font-bold">
                            <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">&nbsp;{{ $block->subtitle }}</span>@endif
                        </h2>
                    </div>
                </div>
                <div class="w-full lg:w-1/3 xl:w-1/2 px-4 lg:text-right">
                    <a class="relative group inline-block py-4 px-6 font-semibold rounded transition duration-300 overflow-hidden" href="{{ route('blog') }}" style="color: {{ $block->button_title_color }}; background-color: {{ $block->button_border_color }}">
                        <div class="absolute top-0 right-0 w-full h-full transform group-hover:translate-x-full group-hover:scale-102 transition duration-500" style="background-color: {{ $block->button_color }}"></div>
                        <span class="relative">Ver todas as publicações</span>
                    </a>
                </div>
            </div>
            <div class="flex flex-wrap -mx-4 -mb-12">
                @foreach($articles as $article)
                    <div class="w-full lg:w-1/3 px-4 mb-8">
                        <a class="block max-w-md mx-auto group relative" href="{{ route('blog.show', $article->slug) }}">
                            <div class="absolute bottom-0 left-0 w-full p-5">
                                <div class="p-5 rounded-xl" style="background-color: {{ $block->primary_color }}">
                                    <h4 class="text-xl font-semibold w-full two-line-text" style="color: {{ $block->content_color }}">{{ $article->title }}</h4>
                                    <div class="hover:opacity-70 hidden group-hover:flex justify-end mt-5 items-center text-orange-900 font-semibold">
                                        <span class="mr-2" style="color: {{ $block->divider_color }}">Ver publicação</span>
                                        <svg width="8" height="12" viewbox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="color: {{ $block->divider_color }};">
                                            <path d="M6.82994 5.28995L2.58994 1.04995C2.49698 0.95622 2.38638 0.881826 2.26452 0.831057C2.14266 0.780288 2.01195 0.75415 1.87994 0.75415C1.74793 0.75415 1.61723 0.780288 1.49537 0.831057C1.37351 0.881826 1.26291 0.95622 1.16994 1.04995C0.983692 1.23731 0.87915 1.49076 0.87915 1.75495C0.87915 2.01913 0.983692 2.27259 1.16994 2.45995L4.70994 5.99995L1.16994 9.53995C0.983692 9.72731 0.87915 9.98076 0.87915 10.2449C0.87915 10.5091 0.983692 10.7626 1.16994 10.9499C1.26338 11.0426 1.3742 11.116 1.49604 11.1657C1.61787 11.2155 1.74834 11.2407 1.87994 11.2399C2.01155 11.2407 2.14201 11.2155 2.26385 11.1657C2.38569 11.116 2.4965 11.0426 2.58994 10.9499L6.82994 6.70995C6.92367 6.61699 6.99806 6.50638 7.04883 6.38453C7.0996 6.26267 7.12574 6.13196 7.12574 5.99995C7.12574 5.86794 7.0996 5.73723 7.04883 5.61537C6.99806 5.49351 6.92367 5.38291 6.82994 5.28995Z" fill="currentColor"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <img class="block w-full h-80 rounded-lg object-cover" src="{{ asset(str_replace('public/', 'storage/', $article->photo)) }}" alt="">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

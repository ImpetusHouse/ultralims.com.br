@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="py-20 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="container px-4 mx-auto">
        <div class="flex flex-wrap -m-8">
            @for($i = 1; $i <= 2; $i++)
                @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                    <div class="w-full md:flex-1 p-8">
                        <div class="flex flex-wrap -m-3">
                            @php
                                $articles = \App\Models\Articles\Article::where('status', 'published')->orderBy('published_at', 'desc')->limit(2)->get();
                            @endphp
                            @foreach($articles as $article)
                                <div class="w-full md:w-1/2 p-3">
                                    <div class="max-w-sm mx-auto">
                                        <a href="{{ route('blog.show', $article->slug) }}" style="color: {{ $block->button_color }}">
                                            <div class="mb-6 max-w-max overflow-hidden rounded-xl">
                                                <img class="transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset(str_replace('public/', 'storage/', $article->photo)) }}" alt="{{ $article->title }}">
                                            </div>
                                        </a>
                                        @php
                                            $category = $article->categories->first();
                                        @endphp
                                        <a href="{{ route('blog.show', $article->slug) }}" class="font-sans max-w-max px-3 py-1 text-sm font-semibold uppercase rounded-xl" style="color: {{ $category->color }}; background-color: {{ $category->color.'33' }}">{{ $category->title }}</a>
                                        <a class="mt-4 mb-2 inline-block hover:underline w-full" href="{{ route('blog.show', $article->slug) }}" style="color: {{ $block->button_color }}">
                                            <h3 class="text-lg font-bold font-heading leading-normal one-line-text">{{ html_entity_decode(strip_tags($article->title)) }}</h3>
                                        </a>
                                        <p class="text-sm md:text-base w-full three-line-text" style="color: {{ $block->button_title_color }}">{{ html_entity_decode(strip_tags($article->content)) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="w-full md:w-5/12 p-8">
                        <div class="flex flex-col justify-between h-full">
                            <div class="mb-8">
                                <h2 class="font-black font-heading mb-4">
                                    <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}"> {{ $block->subtitle }}</span>@endif
                                </h2>
                                <p class="block-description-{{ $block->id }}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                            </div>
                            <a class="inline-flex items-center leading-normal hover:opacity-70" href="{{ route('blog') }}" style="color: {{ $block->primary_color }}">
                                <span class="mr-2 font-semibold">Ver todas as publicações</span>
                                <svg width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5 3.75L15.75 9M15.75 9L10.5 14.25M15.75 9L2.25 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endif
            @endfor
        </div>
    </div>
</section>

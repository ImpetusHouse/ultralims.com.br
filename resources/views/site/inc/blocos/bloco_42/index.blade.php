<section id="section_{{ $i }}">
    <div class="py-20" style="background-color: {{ $block->background_color }}">
        <div class="container mx-auto px-4">
            <div class="mb-6 flex flex-wrap justify-center">
                <div class="mb-16 w-full text-center">
                    @if($block->tag)
                        <span class="font-bold" style="color: {{ $block->tag_color }}">{{ $block->tag }}</span>
                    @endif
                    <h2 class="block-title font-black font-heading">
                        <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                        @if($block->subtitle)
                            <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                        @endif
                    </h2>
                </div>
                <div class="flex flex-wrap -mx-3 mb-16">
                    @php
                        $article = \App\Models\Articles\Article::where('status', 'published')->orderBy('published_at', 'desc')->first();
                    @endphp
                    <div class="mb-6 lg:mb-0 w-full lg:w-1/2 px-3">
                        <div class="h-full flex flex-col rounded shadow">
                            <img class="rounded-t object-cover h-80 lg:h-full w-full" src="{{ asset(str_replace('public/', 'storage/', $article->photo)) }}" alt="{{ $article->title }}">
                            <div class="mt-auto p-6 rounded-b" style="background-color: {{ $block->divider_color }}">
                                <span class="text-sm" style="color: {{ $block->date_color }};">
                                    {{ ucwords($article->published_at->translatedFormat('d M, Y')) }}
                                </span>
                                <h2 class="my-2 text-2xl font-bold w-full two-line-text" style="color: {{ $block->primary_color }};">
                                    {{ html_entity_decode(strip_tags($article->title)) }}
                                </h2>
                                <p class="mb-6 text-gray-400 w-full three-line-text" style="color: {{ $block->content_color }}">
                                    {{ html_entity_decode(strip_tags($article->content)) }}
                                </p>
                                <a class="text-green-600 hover:opacity-70 font-bold" href="{{ route('blog.show', $article->slug) }}" style="color: {{ env('PRIMARY_COLOR') }}">
                                    Ler mais
                                </a>
                            </div>
                        </div>
                    </div>
                    @php
                        $articles = \App\Models\Articles\Article::where('id', '!=', $article->id)->where('status', 'published')->orderBy('published_at', 'desc')->limit(4)->get();
                    @endphp
                    <div class="flex flex-wrap w-full lg:w-1/2">
                        @foreach($articles as $article)
                            <div class="mb-6 w-full lg:w-1/2 px-3">
                                <div class="rounded overflow-hidden shadow">
                                    <img class="lg:h-48 rounded-t object-cover" src="{{ asset(str_replace('public/', 'storage/', $article->photo)) }}" alt="{{ $article->title }}" alt="">
                                    <div class="p-6 rounded-b" style="background-color: {{ $block->divider_color }}">
                                        <span class="text-sm" style="color: {{ $block->date_color }};">
                                            {{ ucwords($article->published_at->translatedFormat('d M, Y')) }}
                                        </span>
                                        <h2 class="my-2 text-2xl font-bold w-full two-line-text" style="color: {{ $block->primary_color }};">
                                            {{ html_entity_decode(strip_tags($article->title)) }}
                                        </h2>
                                        <a class="text-green-600 hover:opacity-70 font-bold" href="{{ route('blog.show', $article->slug) }}" style="color: {{ env('PRIMARY_COLOR') }}">
                                            Ler mais
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <a class="inline-block py-2 px-6 rounded-l-xl rounded-t-xl hover:opacity-70 text-gray-50 font-bold leading-loose outline-none transition duration-200" style="background-color: {{ env('PRIMARY_COLOR') }}" href="{{ route('blog') }}">
                        Ver mais publicações
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

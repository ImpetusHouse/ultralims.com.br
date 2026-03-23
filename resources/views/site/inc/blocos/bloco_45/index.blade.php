@php
    /** @var TYPE_NAME $block */
    $tab = $block->tabs->first();
    $portfolios = \App\Models\General\Portfolios\Portfolio::whereIn('id', json_decode($block->portfolios))->orderBy('display_order')->get();
@endphp
@push('head')
    <style>
        .button-{{ $block->id }}:hover{
            color: {{ $block->button_title_color }} !important;
            background-color: {{ $block->button_color }} !important;
        }

        /* Inicialmente esconde os elementos absolute dentro de cada div relative */
        .relative .block-{{ $block->id }} .absolute {
            opacity: 0;
            transition: opacity 0.3s ease; /* Transição suave para a opacidade */
            pointer-events: none; /* Desativa eventos de mouse quando não visível */
        }

        /* Quando o mouse está sobre qualquer div relative, torna os elementos absolute visíveis */
        .relative:hover .block-{{ $block->id }} .absolute {
            opacity: 0.75;
            pointer-events: auto; /* Ativa eventos de mouse quando visível */
        }

    </style>
@endpush
<section id="section_{{ $i }}">
    <div class="py-20" style="background-color: {{ $block->background_color }}">
        <div class="container px-4 mx-auto">
            <div class="mb-16 flex flex-wrap justify-center md:justify-between items-center">
                <div class="text-center lg:text-left">
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
                <a class="hidden md:inline-block py-2 px-6 rounded-l-xl rounded-t-xl hover:opacity-70 font-bold transition duration-200 leading-loose" href="#" style="color: {{ $block->button_title_color_1 }}; background-color: {{ $block->button_color_1 }}">
                    Ver todos os portfólios
                </a>
            </div>
            <div class="flex flex-wrap -mx-4 mb-4">
                @foreach($portfolios as $portfolio)
                    @php
                        $page = $portfolio->page;
                        $url = '';
                        if ($page != null){
                            if ($page->prefix_slug->count() > 0) {
                                $url .= implode('/', $page->prefix_slug->pluck('slug')->toArray()) . '/';
                            }
                            $url = '/' . $url . $page->slug;
                        }
                    @endphp
                    <div class="relative mb-4 w-full md:w-1/2 lg:w-1/3 px-4">
                        <div class="relative block-{{ $block->id }} h-80 mb-5 mx-auto rounded-lg">
                            <img class="h-80 w-full relative rounded-lg object-cover" src="{{ asset(str_replace('public/', 'storage/', $portfolio->photo)) }}" alt="{{ $portfolio->title }}">
                            <div class="absolute inset-0 rounded-lg" style="background-color: {{ $block->primary_color }}"></div>
                            <div class="absolute inset-0 p-6 flex flex-col items-start">
                                <span style="color: {{ $tab->subtitle_color }}">{{ $portfolio->tag }}</span>
                                <p class="mb-auto text-xl lg:text-2xl font-bold" style="color: {{ $tab->title_color }}">{{ $portfolio->title }}</p>
                                <a class="button-{{ $block->id }} inline-block py-2 px-4 border-2 bg-transparent transition duration-200 rounded-l-xl rounded-t-xl font-bold leading-loose" href="{{ $url }}" style="border-color: {{ $block->button_color }}; color: {{ $block->button_color }}">
                                    Ver mais
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center">
                <a class="md:hidden inline-block py-2 px-6 rounded-l-xl rounded-t-xl font-bold transition duration-200" href="#" style="color: {{ $block->button_title_color_1 }}; background-color: {{ $block->button_color_1 }}">
                    Ver todos os portfólios
                </a>
            </div>
        </div>
    </div>
</section>

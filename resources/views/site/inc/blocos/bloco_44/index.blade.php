@php
    /** @var TYPE_NAME $block */
    $tab = $block->tabs->first();
    $categories = \App\Models\General\Portfolios\Category::whereIn('id', json_decode($block->portfolios_categories))->orderBy('display_order')->get();
@endphp
@push('head')
    <style>
        .categories-{{ $block->id }}:hover{
            background-color: {{ $tab->button_color_1 }} !important;
            color: {{ $tab->button_title_color_1 }} !important;
        }
        .categories-{{ $block->id }}.active {
            background-color: {{ $tab->button_color_1 }} !important;
            color: {{ $tab->button_title_color_1 }} !important;
        }
        /* Inicialmente esconde os elementos absolute dentro de cada div relative */
        .relative .block-{{ $block->id }} .absolute {
            opacity: 0;
            transition: opacity 0.3s ease; /* Transição suave para a opacidade */
            pointer-events: none; /* Desativa eventos de mouse quando não visível */
        }

        /* Quando o mouse está sobre qualquer div relative, torna os elementos absolute visíveis */
        .relative:hover .block-{{ $block->id }} .absolute {
            opacity: 0.9;
            pointer-events: auto; /* Ativa eventos de mouse quando visível */
        }
    </style>
@endpush
<section id="section_{{ $i }}">
    <div class="py-20" style="background-color: {{ $block->background_color }}">
        <div class="container mx-auto px-4">
            <div class="mb-8 md:mb-16 max-w-lg mx-auto text-center">
                @if($block->tag)
                    <span class="font-bold" style="color: {{ $block->tag_color }}">{{ $block->tag }}</span>
                @endif
                <h2 class="block-title font-black font-heading mb-12">
                    <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                    @if($block->subtitle)
                        <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                    @endif
                </h2>
                <div class="inline-flex flex-wrap py-1 sm:px-1 sm:space-x-1 rounded text-sm" style="background-color: {{ $tab->button_color }}">
                    @foreach($categories as $category)
                        <button class="category-btn w-full sm:w-auto mb-1 sm:mb-0 mx-1 sm:mx-0 py-2 px-4 rounded hover:shadow font-bold focus:outline-none transition duration-200 categories-{{ $block->id }} {{ $loop->first ? 'active':'' }}"
                                data-category="{{ $category->id }}"
                                style="background-color: {{ $tab->button_color }}; color: {{ $block->button_title_color }}">
                            {{ $category->title }}
                        </button>
                    @endforeach
                </div>
            </div>
            <div id="portfolioContainer" class="flex flex-wrap -mx-4">
                @foreach($categories as $category)
                    @foreach($category->portfolios()->limit(6)->get() as $portfolio)
                        @if($loop->index == 0 || $loop->index == 3)
                            <div class="hidden flex-wrap w-full lg:w-1/2 mb-8 lg:mb-0 portfolios-item category-{{ $category->id }}">
                        @endif
                            @php
                                $classes = '';
                                if ($loop->index == 0 || $loop->index == 1){
                                    $classes = 'lg:w-1/2 mb-8';
                                }elseif($loop->index == 4 || $loop->index == 5){
                                    $classes = 'lg:w-1/2 mt-8';
                                }

                                $page = $portfolio->page;
                                $url = '';
                                if ($page != null){
                                    if ($page->prefix_slug->count() > 0) {
                                        $url .= implode('/', $page->prefix_slug->pluck('slug')->toArray()) . '/';
                                    }
                                    $url = '/' . $url . $page->slug;
                                }
                            @endphp
                            <div class="relative portfolio-item w-full px-4 {{ $classes }}">
                                <div class="relative block-{{ $block->id }}">
                                    <img class="{{ $loop->index == 2 || $loop->index == 3 ? 'lg:h-128 h-64' : 'h-64' }} w-full rounded-lg object-cover relative" src="{{ asset(str_replace('public/', 'storage/', $portfolio->photo)) }}" alt="">
                                    <div class="overlay absolute inset-0 bg-gray-900 rounded-lg">
                                        <div class="p-6 flex justify-center">
                                            <div class="max-w-md my-auto w-full">
                                                <span class="font-bold" style="color: {{ $tab->subtitle_color }};">{{ $portfolio->tag }}</span>
                                                <h2 class="{{ $loop->index == 2 || $loop->index == 3 ? 'lg:text-5xl':'lg:text-2xl' }} text-4xl font-bold" style="color: {{ $tab->title_color }};">{{ $portfolio->title }}</h2>
                                                @if($loop->index == 2 || $loop->index == 3)
                                                    <p class="md:block hidden" style="color: {{ $tab->content_color }}">{{ $portfolio->description }}</p>
                                                @endif
                                                <a class="mt-6 inline-block py-2 px-6 rounded-l-xl rounded-t-xl hover:opacity-70 font-bold leading-loose" href="{{ $url }}" style="color: {{ $block->button_title_color }}; background-color: {{ $block->button_color }}">
                                                    Ver mais
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @if($loop->index == 2 || $loop->index == 5)
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
            <div class="w-full text-center lg:mt-8 mt-0">
                <a class="inline-block py-2 px-6 rounded-l-xl rounded-t-xl hover:opacity-70 font-bold leading-loose transition duration-200" href="#" style="color: {{ $block->button_title_color_1 }}; background-color: {{ $block->button_color_1 }}">
                    Ver todos os portfólios
                </a>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categories = document.querySelectorAll('.category-btn');
            const portfolios = document.querySelectorAll('.portfolios-item');

            // Função para alterar a categoria ativa
            categories.forEach(btn => {
                btn.addEventListener('click', function() {
                    categories.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    const category = this.dataset.category;
                    portfolios.forEach(portfolio => {
                        if (portfolio.classList.contains('category-' + category)) {
                            portfolio.classList.add('flex');
                            portfolio.classList.remove('hidden');
                        } else {
                            portfolio.classList.add('hidden');
                            portfolio.classList.remove('flex');
                        }
                    });
                });
            });

            // Ativa a primeira categoria por padrão
            if (categories.length > 0) {
                categories[0].click();
            }
        });
    </script>
@endpush

@php
    /** @var TYPE_NAME $block */
    $tabs = $block->tabs->sortBy(function ($tab) {
        // Definindo a ordem personalizada
        $order = [1, 2, 3, 6, 5, 4];

        // Retorna a posição do valor 'tab' no array $order
        return array_search($tab->tab, $order);
    });
@endphp
<section id="section_{{ $i }}">
    <div class="py-20 overflow-hidden" style="background-color: {{ $block->background_color }}">
        <div class="container mx-auto px-4">
            <div class="mb-16 max-w-md text-center mx-auto">
                @if($block->tag)
                    <span class="font-bold" style="color: {{ $block->tag_color }}">{{ $block->tag }}</span>
                @endif
                <h2 class="block-title font-black font-heading mb-2">
                    <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                    @if($block->subtitle)
                        <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                    @endif
                </h2>
            </div>
            <div class="relative flex flex-wrap -mx-4 z-0">
                <img class="h-128 hidden xl:block absolute top-0 right-0 -mt-4 -mr-16" style="z-index: -1;" src="{{ asset('images/blocos/bloco_47/line-light-gray.svg') }}" alt="">
                @foreach($tabs as $tab)
                    @php
                        if ($tab->tab == 1 || $tab->tab == 2 || $tab->tab == 3){
                            $classes = 'mb-10 lg:mb-32';
                        }elseif($tab->tab == 6){
                            $classes = 'mb-10 order-last lg:order-1';
                        }elseif ($tab->tab == 5){
                            $classes = 'mb-10 md:mb-0 order-1 lg:order-0';
                        }elseif ($tab->tab == 4){
                            $classes = 'lg:order-last';
                        }
                    @endphp
                    <div class="w-full md:w-1/2 lg:w-1/3 px-4 {{ $classes }}">
                        <div class="max-w-xs">
                            <span class="mb-4 lg:mb-10 flex w-16 h-16 items-center justify-center rounded-full font-bold text-2xl" style="background-color: {{ $tab->background_color }}; color: {{ $tab->icon_color }}">{{ $tab->tab }}</span>
                            <h3 class="mb-4 text-2xl font-bold font-heading w-full two-line-text" style="color: {{ $tab->title_color }}">{{ $tab->title }}</h3>
                            <p class="leading-loose w-full three-line-text" style="color: {{ $tab->subtitle_color }}">{{ $tab->subtitle }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

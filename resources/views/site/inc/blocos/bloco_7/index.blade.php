<section id="section_{{ $i }}" class="pt-8 pb-2" style="background-color: {{ $block->background_color }}">
    <div class="container px-4 mx-auto">
        <div class="flex flex-wrap -mx-3">
            @foreach($block->tabs->sortBy('display_order') as $tab)
                <div class="w-full md:w-1/2 lg:w-1/4 px-3 mb-6">
                    <div class="p-8 text-center rounded" style="background-color: {{ $tab->background_color }} !important;">
                        <img class="w-12 h-12 mx-auto mb-2" src="{{ asset($tab->image) }}">
                        <p class="mb-2 block-description" style="color: {{ $tab->title_color }}">{{ $tab->title }}</p>
                        <span class="block-title font-bold font-heading" style="color: {{ $tab->subtitle_color }}">{{ $tab->subtitle }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

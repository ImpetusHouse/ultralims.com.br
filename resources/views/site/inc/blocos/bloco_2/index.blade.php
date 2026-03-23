<section id="section_{{ $i }}" class="pt-16 pb-20" style="background-color: {{ $block->background_color }}">
    <div class="container px-4 mx-auto">
        <div class="flex flex-wrap items-center mb-12">
            <div class="w-full lg:w-1/2 mb-4 lg:mb-0">
                <h2 class="block-title font-black font-heading">
                    <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                    @if($block->subtitle)
                        <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                    @endif
                </h2>
            </div>
            <div class="w-full lg:w-1/2 lg:pl-16 block-description">
                <p style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 -mb-6">
            @foreach($block->tabs->sortBy('display_order') as $tab)
                <div class="w-full md:w-1/2 lg:w-1/4 px-3 mb-6">
                    <div class="pt-8 px-6 pb-6 bg-white text-center rounded shadow">
                        <img class="mx-auto w-10 h-10 mb-4" src="{{ asset($tab->image) }}" alt="">
                        <h3 class="mb-2 font-bold font-heading" style="color: {{ $tab->title_color }}">{{ $tab->title }}</h3>
                        <p class="text-sm" style="color: {{ $tab->subtitle_color }}">{!! nl2br($tab->subtitle) !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

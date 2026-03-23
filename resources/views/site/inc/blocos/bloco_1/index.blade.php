<section id="section_{{ $i }}" class="py-20" style="background-color: {{ $block->background_color }}">
    <div class="container px-4 mx-auto">
        <div class="flex flex-wrap items-center justify-between max-w-2xl lg:max-w-full mb-12">
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
        <div class="flex flex-wrap -mx-3 -mb-6 text-center">
            @foreach($block->tabs->sortBy('display_order') as $tab)
                <div class="w-full md:w-1/2 {{ $block->tabs->count() == 3 ? 'lg:w-1/3':'lg:w-1/4' }} px-3 mb-6">
                    @if($tab->content_link)
                    <a href="{{ $tab->content_link }}" target="_blank">
                    @endif
                        <div class="{{ $block->tabs->count() == 3 ? 'p-12':'pr-2 pl-2 pb-5 pt-5' }} bg-white shadow rounded">
                            <img class="mx-auto {{ $block->tabs->count() == 3 ? 'my-4':'mb-4' }} h-40" src="{{ asset($tab->image) }}" alt="{{ $tab->title }}">
                            <h3 class="mb-2 font-bold font-heading" style="color: {!! $tab->title_color !!}">{{ $tab->title }}</h3>
                            <p class="text-sm leading-relaxed" style="color: {!! $tab->subtitle_color !!}">{{ $tab->subtitle }}</p>
                        </div>
                    @if($tab->content_link)
                    </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

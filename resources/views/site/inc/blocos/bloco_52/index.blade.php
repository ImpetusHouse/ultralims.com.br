<section id="section_{{ $i }}" class="relative py-20 md:py-80 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <img class="hidden md:block absolute top-0 left-0 w-full h-full md:object-top object-cover" src="{{ asset($block->image) }}" alt="">
    <div class="relative container px-4 mx-auto">
        <div class="max-w-xs sm:max-w-md lg:max-w-lg xl:max-w-2xl">
            <h2 class="block-title font-black font-heading mb-12">
                <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                @if($block->subtitle)
                    <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                @endif
            </h2>
            <p class="max-w-sm lg:max-w-xl {{ $block->button_display ? 'mb-12':"" }} block-description" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
            @if($block->button_display)
                <div class="sm:flex items-center">
                    @include('site.inc.buttons.layout_'.$block->type, ['item' => $block])
                </div>
            @endif
        </div>
    </div>
</section>

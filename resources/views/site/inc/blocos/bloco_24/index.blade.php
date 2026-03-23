<section id="section_{{ $i }}" class="py-10 overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="rounded-3xl overflow-hidden" style="background-color: {{ $block->background_color }}">
            <div class="flex flex-wrap -mx-4">
                @for($i = 1; $i <= 2; $i++)
                    @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                        <div class="w-full lg:w-1/2 px-4">
                            <img class="block h-112 sm:h-135 lg:h-full w-full object-cover rounded-4xl" src="{{ asset($block->image) }}" alt="{{ $block->title }}"  >
                        </div>
                    @else
                        <div class="w-full lg:w-1/2 px-4 self-center">
                            <div class="max-w-md xl:max-w-lg py-24 lg:py-40 px-8 mx-auto">
                                <h2 class="block-title font-black font-heading tracking-tight mb-6">
                                    <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                                    @if($block->subtitle)
                                        <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                                    @endif
                                </h2>
                                <p class="block-description mb-10" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                                @if($block->button_display)
                                    @include('site.inc.buttons.layout_1', ['item' => $block])
                                @endif
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </div>
</section>

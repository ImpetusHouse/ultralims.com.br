@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="relative overflow-hidden" style="background-color: {{ $block->background_color }}; padding-bottom: {{ $block->margin_bottom }}px; padding-top: {{ $block->margin_top }}px">
    <div class="relative container mx-auto px-4 z-10">
        <div class="flex flex-wrap -mx-4">
            @for($i = 1; $i <= 2; $i++)
                @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                    <div class="w-full lg:w-1/2 px-4 flex items-center justify-center {{ $block->display_content ? 'block md:block':'hidden md:block' }}">
                        <div class="relative" style="z-index: 0;">
                            <img class="h-128 w-full max-w-lg object-cover rounded-3xl md:rounded-br-none" src="{{ asset($block->image) }}" alt="">
                            @if($block->tabs->where('tab', 1)->first()->display_image)
                                <img class="hidden md:block absolute" style="top:-2rem; right: 3rem; z-index: -1;" src="{{ asset($block->tabs->where('tab', 1)->first()->image) }}" alt="">
                            @endif
                            @if($block->tabs->where('tab', 2)->first()->display_image)
                                <img class="hidden md:block absolute" style="top:3rem; right: -3rem; z-index: -1;" src="{{ asset($block->tabs->where('tab', 2)->first()->image) }}" alt="">
                            @endif
                            @if($block->tabs->where('tab', 3)->first()->display_image)
                                <img class="hidden md:block absolute" style="bottom:2.5rem; left: -4.5rem; z-index: -1;" src="{{ asset($block->tabs->where('tab', 3)->first()->image) }}" alt="">
                            @endif
                            @if($block->tabs->where('tab', 4)->first()->display_image)
                                <img class="hidden md:block absolute" style="bottom:-2rem; right: -2rem; z-index: -1;" src="{{ asset($block->tabs->where('tab', 4)->first()->image) }}" alt="">
                            @endif
                        </div>
                    </div>
                @else
                    <div class="w-full lg:w-1/2 px-4 md:mb-20 lg:mb-0 flex items-center {{ $block->display_content ? 'mb-12':'mb-0' }}">
                        <div class="w-full text-center lg:text-left">
                            <div class="max-w-md mx-auto lg:mx-0">
                                <h2 class="font-black font-heading mb-4">
                                    <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                                    @if($block->subtitle)
                                        <span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                                    @endif
                                </h2>
                            </div>
                            <div class="max-w-sm mx-auto lg:mx-0">
                                <p class="block-description-{{ $block->id }} {{ $block->button_display || $block->button_display_1 ? 'mb-6':'' }}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                                <div>
                                    @if($block->button_display)
                                        @include('site.inc.buttons.layout_'.$block->type, ['item' => $block])
                                    @endif
                                    @if($block->button_display_1)
                                        @include('site.inc.buttons.layout_'.$block->type, ['item' => $block, 'buttonOne' => true])
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endfor
        </div>
    </div>
    @if($block->tabs->where('tab', 1)->first()->display_content)
        <img class="hidden lg:block absolute inset-0 w-full" src="{{ asset($block->logo) }}" alt="">
    @endif
</section>

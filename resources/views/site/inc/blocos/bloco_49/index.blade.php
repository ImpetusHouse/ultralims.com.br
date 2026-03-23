<section id="section_{{ $i }}" class="overflow-hidden">
    <div class="relative" style="background-color: {{ $block->background_color }}; padding-top: {{ $block->margin_top }}px; padding-bottom: {{ $block->margin_bottom }}px;">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-4">
                @for($i = 1; $i <= 2; $i++)
                    @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                        <div class="w-full lg:w-1/2 px-4 hidden lg:block">
                            <img class="lg:absolute top-0 my-12 lg:my-0 h-full w-full lg:w-1/2 rounded-3xl lg:rounded-none object-cover {{ $block->content_alignment == 'left' ? 'left-0 z-50':"" }}" src="{{ asset($block->tabs->where('tab', 1)->first()->image) }}?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1050&amp;q=80" alt="">
                        </div>
                    @else
                        <div class="w-full lg:w-1/2 {{ $block->content_alignment == 'left' ? 'px-16':"px-4" }} flex items-center">
                            <div class="w-full text-center lg:text-left">
                                @if($block->tabs->where('tab', 1)->first()->display_content)
                                    <img class="hidden lg:block absolute inset-0 w-full" src="{{ asset($block->image) }}" alt="">
                                @endif
                                <div class="relative max-w-md mx-auto lg:mx-0">
                                    <h2 class="block-title font-black font-heading mb-3">
                                        <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                                        @if($block->subtitle)
                                            <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                                        @endif
                                    </h2>
                                </div>
                                <div class="relative max-w-sm mx-auto lg:mx-0">
                                    <p class="block-description {{ $block->button_display || $block->button_display_1 ? 'mb-6':'' }}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
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
    </div>
</section>

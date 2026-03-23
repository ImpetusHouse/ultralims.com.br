<section id="section_{{ $i }}" class="relative overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="relative pt-12 lg:pt-20 pb-20 z-10">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-4">
                @for($i = 1; $i <= 2; $i++)
                    @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                        <div class="w-full lg:w-1/2 px-4">
                            <div class="flex flex-wrap lg:mb-4 lg:ml-6">
                                <img class="w-full md:w-1/2 lg:w-1/3 h-64 p-2 object-cover rounded-3xl lg:rounded-br-none" src="{{ asset($block->tabs->where('tab', 1)->first()->image) }}" alt="">
                                <img class="w-full md:w-1/2 lg:w-2/3 h-64 p-2 object-cover rounded-3xl lg:rounded-bl-none" src="{{ asset($block->tabs->where('tab', 2)->first()->image) }}" alt="">
                            </div>
                            <div class="flex flex-wrap lg:mb-4 lg:mr-6">
                                <img class="w-full md:w-1/2 lg:w-2/3 h-64 p-2 object-cover rounded-3xl lg:rounded-br-none" src="{{ asset($block->tabs->where('tab', 3)->first()->image) }}" alt="">
                                <img class="w-full md:w-1/2 lg:w-1/3 h-64 p-2 object-cover rounded-3xl lg:rounded-bl-none" src="{{ asset($block->tabs->where('tab', 4)->first()->image) }}" alt="">
                            </div>
                        </div>
                    @else
                        <div class="w-full lg:w-1/2 px-4 mb-12 lg:mb-0 flex items-center">
                            <div class="w-full text-center lg:text-left">
                                <div class="max-w-md mx-auto lg:mx-0">
                                    <h2 class="block-title font-black font-heading mb-4">
                                        <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                                        @if($block->subtitle)
                                            <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                                        @endif
                                    </h2>
                                </div>
                                <div class="max-w-sm mx-auto lg:mx-0">
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
    @if($block->tabs->where('tab', 1)->first()->display_content)
        <img class="hidden lg:block absolute inset-0 w-full" src="{{ asset($block->image) }}" alt="">
    @endif
</section>

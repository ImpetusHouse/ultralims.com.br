@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="relative overflow-hidden" style="background-color: {{ $block->background_color }}; padding-top: {{ $block->margin_top }}px; padding-bottom: {{ $block->margin_bottom }}px">
    <div class="relative container mx-auto px-4 z-10">
        <div class="flex flex-wrap">
            @for($i = 1; $i <= 2; $i++)
                @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                    <div class="w-full lg:w-7/12 p-4 {{ $block->tabs->where('tab', 1)->first()->display_content ? 'block md:block':'hidden md:block' }}">
                        <img class="rounded-2xl object-cover object-right-top w-full" style="height: 485px;" src="{{ asset($block->image) }}" alt="{{ $block->title }}">
                    </div>
                @else
                    <div class="w-full lg:w-5/12 p-4">
                        <div class="flex flex-col items-start justify-end h-full">
                            <h2 class="font-black font-heading mb-6">
                                <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                                @if($block->subtitle)
                                    <span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                                @endif
                            </h2>
                            <p class="block-description-{{ $block->id }} {{ $block->button_display ? 'mb-8':"" }}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                            @if($block->button_display)
                                @include('site.inc.buttons.layout_'.$block->type, ['item' => $block])
                            @endif
                        </div>
                    </div>
                @endif
            @endfor
        </div>
    </div>
    @if($block->display_content)
        <img class="hidden lg:block absolute inset-0 w-full" src="{{ asset($block->logo) }}" alt="">
    @endif
</section>

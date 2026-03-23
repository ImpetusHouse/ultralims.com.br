@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="py-20 overflow-hidden" style="background-color: {{ $block->background_color }}; padding-top: {{ $block->margin_top }}px; padding-bottom: {{ $block->margin_bottom }}px;">
    <div class="container px-4 mx-auto">
        <div class="flex flex-wrap items-center -m-8">
            @for($i = 1; $i <= 2; $i++)
                @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                    <div class="w-full md:w-1/2 p-8" id="image-{{ $block->id }}-container">
                        @php
                            $content_link = "'".$block->content_link."'";
                        @endphp
                        <img class="{{ $block->content_type == 'youtube_embed' ? 'cursor-pointer' : 'md:transform md:hover:-translate-x-16 md:transition md:ease-in-out md:duration-1000' }}"
                            src="{{ asset($block->image) }}" alt="{{ $block->title }}" id="block-{{ $block->id }}-image"
                            {!! $block->content_type == 'youtube_embed' ? 'onclick="imageToVideo('.$block->id.', '.$content_link.')"':'' !!}>
                    </div>
                @else
                    <div class="w-full md:w-1/2 p-8">
                        <h2 class="font-black font-heading mb-4">
                            <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                            @if($block->subtitle)
                                <span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                            @endif
                        </h2>
                        <div class="mb-8 block-description-{{ $block->id }}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</div>
                        <div class="mb-11 md:inline-block rounded-xl shadow-4xl">
                            @if($block->button_display)
                                @include('site.inc.buttons.layout_1', ['item' => $block])
                            @endif
                        </div>
                    </div>
                @endif
            @endfor
        </div>
    </div>
</section>

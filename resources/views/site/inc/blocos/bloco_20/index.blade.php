@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="overflow-hidden" style="background-color: {{ $block->background_color }}; padding-top: {{ $block->margin_top }}px; padding-bottom: {{ $block->margin_bottom }}px;">
    <div class="container px-4 mx-auto">
        <div class="overflow-hidden rounded-xl">
            <div class="flex flex-wrap">
                @for($i = 1; $i <= 2; $i++)
                    @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                        <div class="w-full md:w-1/2">
                            <div class="relative h-full overflow-hidden">
                                @php
                                    $content_link = "'".$block->content_link."'";
                                @endphp
                                <img class="w-full h-full object-cover transform hover:scale-105 transition duration-500 {{ $block->content_type === 'youtube_embed' ? 'cursor-pointer':'' }}"
                                     src="{{ asset($block->image) }}"
                                     alt="{{ $block->title }}"
                                    {{ $block->content_type === 'youtube_embed' ? 'data-video-url="'.$block->content_link.'"':'' }}>
                            </div>
                        </div>
                    @else
                        <div class="flex-1 md:w-1/2">
                            <div class="p-10 flex flex-col justify-between h-full" style="background-color: {{ $block->primary_color }}">
                                <div class="mb-12">
                                    <h2 class="font-black font-heading">
                                        <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                                        @if($block->subtitle)
                                            <span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                                        @endif
                                    </h2>
                                </div>
                                <div class="inline-block">
                                    <p class="mb-6 block-description-{{ $block->id }}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                                    @if($block->button_display)
                                        @include('site.inc.buttons.layout_1', ['item' => $block])
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </div>
</section>

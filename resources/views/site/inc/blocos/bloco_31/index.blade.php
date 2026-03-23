@php
    /** @var TYPE_NAME $block */
    $block->content = str_replace('<h2', '<h2 class="mb-2 text-lg md:text-xs font-semibold"', $block->content);
    $block->content = str_replace('<h3', '<h3 class="mb-2 text-md md:text-lg font-semibold"', $block->content);
    $block->content = str_replace('<h4', '<h4 class="mb-2 text-sm md:text-md font-semibold"', $block->content);
    $block->content = str_replace('<strong', '<strong class="font-black"', $block->content);
    $block->content = str_replace('<a', '<a class="text-blue-600"', $block->content);
@endphp
@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" style="background-color: {{ $block->background_color }}; margin-bottom: {{ $block->margin_bottom }}px; margin-top: {{ $block->margin_top }}px">
    <div class="container px-4 mx-auto">
        <div class="flex flex-wrap items-center">
            <div class="w-full mb-4 lg:mb-0 {{ $block->content_alignment == 'center' ? 'text-center':'' }}">
                @if($block->title || $block->subtitle)
                    <h2 class="font-black font-heading {{ $block->content ? 'mb-2':'' }}">
                        <span class="{{ $block->type ? $block->type : 'block-title-'.$block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="{{ $block->type ? $block->type : 'block-subtitle-'.$block->id }}" style="color: {!! $block->subtitle_color !!}"> {{ $block->subtitle }}</span>@endif
                    </h2>
                @endif
                @if($block->content)
                    <div class="block-description-{{ $block->id }}" style="color: {!! $block->content_color !!} !important;">{!! nl2br($block->content) !!}</div>
                @endif
            </div>
        </div>
    </div>
</section>

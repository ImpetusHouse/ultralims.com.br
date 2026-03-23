@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="overflow-hidden bg-center" style="background-image: url('{{ asset($block->image) }}'); background-color: {{ $block->background_color }}; padding-top: {{ $block->margin_top }}px; padding-bottom: {{ $block->margin_bottom }}px">
    <div class="container mx-auto px-4 pt-32 pb-32">
        <h2 class="font-black font-heading mb-4 w-full md:max-w-md">
            <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">&nbsp;{{ $block->subtitle }}</span>@endif
        </h2>
        <p class="block-description-{{ $block->id }} {{ $block->button_display ? 'mb-8':"" }} w-full md:max-w-lg" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
        @if($block->button_display)
            @include('site.inc.buttons.layout_'.$block->type, ['item' => $block])
        @endif
    </div>
</section>

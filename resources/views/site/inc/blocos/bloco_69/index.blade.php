@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="relative overflow-hidden" style="background-color: {{ $block->background_color }}; padding-bottom: {{ $block->margin_bottom }}px; padding-top: {{ $block->margin_top }}px">
    <img class="hidden md:block absolute top-0 right-0 object-cover h-full -mr-32 lg:mr-0" src="{{ asset($block->image) }}" alt="{{ $block->title.' '.$block->subtitle }}">
    <div class="container px-4 mx-auto">
        <div class="relative py-24 md:py-32 lg:py-48 xs:px-8 z-50">
            <div class="flex flex-col items-start">
                @if($block->tag)
                    <div class="py-1 px-3 rounded-xl uppercase text-xs font-bold tracking-widest mb-6" style="color: {{ $block->tag_title_color }}; background-color: {{ $block->tag_color }}">
                        {{ $block->tag }}
                    </div>
                @endif
                <h2 class="font-black font-heading mb-4 w-full md:max-w-md">
                    <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">&nbsp;{{ $block->subtitle }}</span>@endif
                </h2>
                <p class="block-description-{{ $block->id }} {{ $block->button_display ? 'mb-6':"" }} text-center" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                @if($block->button_display)
                    @include('site.inc.buttons.layout_'.$block->type, ['item' => $block])
                @endif
            </div>
        </div>
    </div>
</section>

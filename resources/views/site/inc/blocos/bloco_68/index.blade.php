@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="relative overflow-hidden" style="background-color: {{ $block->background_color }}; padding-bottom: {{ $block->margin_bottom }}px; padding-top: {{ $block->margin_top }}px">
    <div class="container px-4 mx-auto">
        <div class="w-full rounded-xl relative py-12 px-8 overflow-hidden" style="background-color: {{ $block->primary_color }}">
            <img class="absolute top-0 h-full object-cover hidden lg:block" src="{{ asset($block->image) }}" alt="{{ $block->title.' '.$block->subtitle }}" style="left: -16rem">
            <div class="relative z-50">
                <div class="flex flex-col justify-center items-center max-w-lg mx-auto">
                    @if($block->tag)
                        <div class="py-1 px-3 rounded-xl uppercase text-xs font-bold tracking-widest mb-6 mx-auto" style="color: {{ $block->tag_title_color }}; background-color: {{ $block->tag_color }}">
                            {{ $block->tag }}
                        </div>
                    @endif
                    <h2 class="font-black font-heading mb-4 w-full md:max-w-md text-center">
                        <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">&nbsp;{{ $block->subtitle }}</span>@endif
                    </h2>
                    <p class="block-description-{{ $block->id }} {{ $block->button_display ? 'mb-6':"" }} text-center" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                    @if($block->button_display)
                        @include('site.inc.buttons.layout_'.$block->type, ['item' => $block])
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

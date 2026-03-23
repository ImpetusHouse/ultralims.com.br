@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="relative overflow-hidden" style="background-color: {{ $block->background_color }}; margin-bottom: {{ $block->margin_bottom }}px; margin-top: {{ $block->margin_top }}px">
    <div class="relative container px-4 mx-auto">
        <div class="max-w-2xl mx-auto mb-16 text-center">
            @if($block->tag)
                <span class="inline-block text-xs py-1 px-3 font-semibold rounded-xl mb-6" style="background-color: {{ $block->tag_color }}; color: {{ $block->tag_title_color }}">{{ $block->tag }}</span>
            @endif
            <h2 class="font-black font-heading mb-4">
                <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                @if($block->subtitle)
                    <span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                @endif
            </h2>
            <p class="block-description-{{ $block->id }}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
        </div>
        <div class="flex flex-wrap justify-center -mx-4">
            @foreach($block->tabs->sortBy('tab') as $tab)
                @push('head')
                    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => $tab])
                @endpush
                <div class="w-full md:w-1/2 lg:w-auto px-4 xl:px-10 mb-10 md:mb-0">
                    <div class="max-w-sm mx-auto h-full py-8 px-6 border rounded-3xl" style="background-color: {{ $tab->background_color }}; border-color: {{ $tab->divider_color }}">
                        <div class="max-w-2xs mx-auto text-center">
                            <img class="block mx-auto mb-3" src="{{ asset($tab->image) }}" alt="{{ $tab->title }}">
                            <h5 class="block-title-{{ $block->id }}-{{ $tab->id }} mb-3" style="color: {!! $tab->title_color !!}">{{ $tab->title }}</h5>
                            @if($tab->subtitle)
                                <p class="block-description-{{ $block->id }}-{{ $tab->id }} mb-3" style="color: {{ $tab->subtitle_color }};">{!! nl2br($tab->subtitle) !!}</p>
                            @endif
                            @if($tab->number)
                                <p class="block-description-{{ $block->id }}-{{ $tab->id }} mb-8" style="color: {{ $tab->number_color }}">{{ $tab->number }}</p>
                            @endif
                            @if($tab->button_display)
                                @include('site.inc.buttons.layout_'.$tab->type, ['item' => $tab])
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

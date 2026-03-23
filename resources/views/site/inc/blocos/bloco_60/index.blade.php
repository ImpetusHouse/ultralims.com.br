@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="overflow-hidden" style="background-color: {{ $block->background_color }}; padding-top: {{ $block->margin_top }}px; padding-bottom: {{ $block->margin_bottom }}px">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap max-w-7xl mx-auto -m-3">
            @foreach($block->tabs->sortBy('tab') as $tab)
                <div class="w-full md:w-1/2 p-3">
                    <div class="rounded-3xl p-10 h-full lg:h-60" style="background-color: {{ $tab->background_color }}">
                        <div class="flex flex-wrap -m-3">
                            <div class="w-full lg:w-1/2 p-3">
                                <div class="flex flex-col justify-between gap-6 xl:gap-12">
                                    <span class="block-title-{{ $block->id }}-{{ $tab->id }} font-heading font-semibold max-w-xs tracking-tight" style="color: {{ $tab->title_color }}">{{ $tab->title }}</span>
                                    @if($tab->button_display)
                                        @include('site.inc.buttons.layout_text', ['item' => $tab])
                                    @endif
                                </div>
                            </div>
                            <div class="w-full lg:w-1/2 p-3 hidden lg:block">
                                <img class="mx-auto object-cover lg:mr-0 h-44" src="{{ asset($tab->image) }}" alt="{{ $tab->title }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

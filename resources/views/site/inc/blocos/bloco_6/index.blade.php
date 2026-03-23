@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="py-10 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="container mx-auto px-4">
        <div class="py-16 rounded-3xl">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-wrap -m-8 mb-10">
                    @for($i = 1; $i <= 2; $i++)
                        @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                            <div class="hidden md:block w-full md:w-1/2 p-8">
                                <img class="mx-auto md:mr-0 rounded" src="{{ asset($block->image) }}" alt="{{ $block->title }}">
                            </div>
                        @else
                            <div class="w-full md:w-1/2 p-8">
                                <div class="md:max-w-lg">
                                    <h2 class="font-black font-heading mb-4">
                                        <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">&nbsp;{{ $block->subtitle }}</span>@endif
                                    </h2>
                                    <p class="mb-8 block-description-{{ $block->id }}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                                    <div class="flex flex-wrap -m-2">
                                        <div class="w-full md:w-auto p-2">
                                            @if($block->button_display)
                                                @include('site.inc.buttons.layout_1', ['item' => $block])
                                            @endif
                                            @foreach($block->tabs as $tab)
                                                @if($tab->button_display)
                                                    @include('site.inc.buttons.layout_1', ['item' => $tab])
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endfor
                </div>
                <div class="p-8 md:p-12 rounded" style="background-color: {{ $block->tag_color }}">
                    <div class="flex flex-wrap -m-8">
                        @foreach($block->tabs->sortBy('display_order') as $tab)
                            <div class="w-full md:w-1/3 p-8">
                                <div class="flex flex-wrap -m-3">
                                    <div class="w-auto md:w-full lg:w-auto p-3">
                                        <div class="flex items-center justify-center w-12 h-12 rounded" style="background-color: {{ $tab->background_color }}">
                                            <img width="24" height="24" src="{{ asset($tab->image) }}">
                                        </div>
                                    </div>
                                    <div class="flex-1 p-3">
                                        <h3 class="font-heading mb-2 text-xl font-black" style="color: {!! $tab->title_color !!}">{{ $tab->title }}</h3>
                                        <p class="text-sm" style="color: {!! $tab->subtitle_color !!}">{{ $tab->subtitle }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

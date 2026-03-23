@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" style="background-color: {{ $block->background_color }}; padding-bottom: {{ $block->margin_bottom }}px; padding-top: {{ $block->margin_top }}px">
    <div class="container px-4 mx-auto">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full lg:w-1/2 px-4 mb-16 lg:mb-0">
                    <div class="max-w-lg mx-auto lg:mx-0">
                        @if($block->tag)
                            <span class="inline-block py-1 px-3 mb-5 text-sm font-semibold rounded-full" style="color: {{ $block->tag_title_color }}; background-color: {{ $block->tag_color }}">
                                {{ $block->tag }}
                            </span>
                        @endif
                        <h2 class="font-heading font-bold mb-5">
                            <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">&nbsp;{{ $block->subtitle }}</span>@endif
                        </h2>
                        <p class="block-description-{{ $block->id }}" style="color: {{ $block->content_color }}">{!! $block->content !!}</p>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 px-4">
                    <div class="flex flex-col max-w-lg mx-auto lg:mr-0">
                        @foreach($block->tabs->sortBy('tab') as $tab)
                            <div class="{{ $tab->tab == 2 ? 'self-end':'' }} w-full sm:w-80 mb-4 py-6 px-6 rounded-3xl shadow-lg" style="background-color: {{ $tab->background_color }}">
                                <div class="flex items-center">
                                    <img class="block mr-6" src="{{ asset($tab->image) }}" alt="{{ $tab->title }}">
                                    <div>
                                        <span class="block text-3xl font-bold leading-none" style="color: {{ $tab->title_color }}">{{ $tab->title }}</span>
                                        <span class="text-sm" style="color: {{ $tab->subtitle_color }}">{{ $tab->subtitle }}</span>
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

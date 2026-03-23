@php
    /** @var TYPE_NAME $block */
    $svg = '
        <svg class="mr-2 w-6 h-6 text-green-400" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
    ';
    $block->content = str_replace('<li>', '<li class="flex mb-4">'.$svg, $block->content);

@endphp
<section id="section_{{ $i }}">
    <div class="py-20" style="background-color: {{ $block->background_color }}">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center">
                @for($i = 1; $i <= 2; $i++)
                    @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                        <div class="w-full lg:w-1/2 flex flex-wrap md:-mx-4">
                            <div class="mb-8 lg:mb-0 w-full md:w-1/2 md:px-4">
                                @php $tab = $block->tabs->where('tab', 1)->first(); @endphp
                                <div class="mb-8 py-6 pl-6 pr-4 shadow-md rounded" style="background-color: {{ $tab->background_color }}">
                                    <span class="mb-4 inline-block p-3 rounded-lg" style="background-color: {{ $tab->icon_color }}">
                                        <img class="w-10 h-10" src="{{ asset($tab->image) }}"/>
                                    </span>
                                    <h4 class="mb-2 text-2xl font-bold font-heading" style="color: {{ $tab->title_color }}">{{ $tab->title }}</h4>
                                    <p style="color: {{ $tab->subtitle_color }}">{{ $tab->subtitle }}</p>
                                </div>
                                @php $tab = $block->tabs->where('tab', 2)->first(); @endphp
                                <div class="py-6 pl-6 pr-4 shadow-md rounded" style="background-color: {{ $tab->background_color }}">
                                    <span class="mb-4 inline-block p-3 rounded-lg" style="background-color: {{ $tab->icon_color }}">
                                        <img class="w-10 h-10" src="{{ asset($tab->image) }}"/>
                                    </span>
                                    <h4 class="mb-2 text-2xl font-bold font-heading" style="color: {{ $tab->title_color }}">{{ $tab->title }}</h4>
                                    <p style="color: {{ $tab->subtitle_color }}">{{ $tab->subtitle }}</p>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 lg:mt-20 md:px-4">
                                @php $tab = $block->tabs->where('tab', 3)->first(); @endphp
                                <div class="mb-8 py-6 pl-6 pr-4 shadow-md rounded-lg" style="background-color: {{ $tab->background_color }}">
                                    <span class="mb-4 inline-block p-3 rounded-lg" style="background-color: {{ $tab->icon_color }}">
                                        <img class="w-10 h-10" src="{{ asset($tab->image) }}"/>
                                    </span>
                                    <h4 class="mb-2 text-2xl font-bold font-heading" style="color: {{ $tab->title_color }}">{{ $tab->title }}</h4>
                                    <p style="color: {{ $tab->subtitle_color }}">{{ $tab->subtitle }}</p>
                                </div>
                                @php $tab = $block->tabs->where('tab', 4)->first(); @endphp
                                <div class="py-6 pl-6 pr-4 shadow-md rounded-lg" style="background-color: {{ $tab->background_color }}">
                                    <span class="mb-4 inline-block p-3 rounded-lg" style="background-color: {{ $tab->icon_color }}">
                                        <img class="w-10 h-10" src="{{ asset($tab->image) }}"/>
                                    </span>
                                    <h4 class="mb-2 text-2xl font-bold font-heading" style="color: {{ $tab->title_color }}">{{ $tab->title }}</h4>
                                    <p style="color: {{ $tab->subtitle_color }}">{{ $tab->subtitle }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="w-full lg:w-1/2 mb-12 lg:mb-0">
                            <div class="lg:mx-auto">
                                @if($block->tag)
                                    <span class="font-bold" style="color: {{ $block->tag_color }}">{{ $block->tag }}</span>
                                @endif
                                <h2 class="block-title font-black font-heading mb-4">
                                    <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                                    @if($block->subtitle)
                                        <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                                    @endif
                                </h2>
                                <p class="block-description">{!! $block->content !!}</p>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </div>
</section>

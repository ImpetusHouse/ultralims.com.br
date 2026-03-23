@push('head')
    <style>
        .svg-icon-{{ $block->id }} path {
            fill: {{ $block->topics_color }} !important;
        }
    </style>
@endpush
<section id="section_{{ $i }}" class="pt-16 pb-20" style="background-color: {{ $block->background_color }}">
    <div class="container px-4 mx-auto">
        <div class="flex flex-wrap items-center mb-12">
            <div class="w-full mb-4 lg:mb-0">
                <h2 class="block-title font-black font-heading mb-2">
                    <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                    @if($block->subtitle)
                        <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                    @endif
                </h2>
                <p class="block-description" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 -mb-6 items-stretch">
            @foreach($page->pages_childrens as $item)
                @php
                    $url = '';
                    if ($item->prefix_slug->count() > 0) {
                        $url .= implode('/', $item->prefix_slug->pluck('slug')->toArray()) . '/';
                    }
                    $url = '/' . $url . $item->slug;
                @endphp
                @push('head')
                    <style>
                        #div-icon-{{ $item->id }}:hover #bg-icon-{{ $item->id }} {
                            background-color: {{ $block->tag_color }} !important;
                        }
                        #div-icon-{{ $item->id }}:hover #title-icon-{{ $item->id }} {
                            color: {{ $block->pdf_color }} !important;
                        }
                        #div-icon-{{ $item->id }}:hover #svg-icon-{{ $item->id }} path {
                            fill: {{ $block->pdf_color }} !important;
                        }
                    </style>
                @endpush
                <div class="w-full md:w-1/2 lg:w-1/5 px-3 mb-3" id="div-icon-{{ $item->id }}">
                    <a href="{{ $url }}">
                        <div class="pt-8 px-6 pb-6 text-center rounded shadow h-full" id="bg-icon-{{ $item->id }}" style="background-color: {{ $block->primary_color }}">
                            <div class="mx-auto w-10 h-10 mb-4 svg-icon-{{ $block->id }}" id="svg-icon-{{ $item->id }}">
                                {!! $item->svg !!}
                            </div>
                            <span class="font-bold font-heading w-full text-sm" id="title-icon-{{ $item->id }}" style="color: {{ $block->tag_title_color }}">{{ $item->title }}</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

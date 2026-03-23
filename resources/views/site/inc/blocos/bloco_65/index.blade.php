@php
    /** @var TYPE_NAME $block */
    $category = \App\Models\General\Logos\Category::where('id', json_decode($block->logos_category))->first();
@endphp
@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="overflow-hidden" style="background-color: {{ $block->background_color }}; margin-bottom: {{ $block->margin_bottom }}px; margin-top: {{ $block->margin_top }}px">
    <div class="container mx-auto">
        <div class="rounded-2xl px-10 md:px-20 py-20 overflow-hidden" style="height:400px; background-color: {{ $block->primary_color }};"  >
            <div class="flex flex-wrap -m-4">
                <div class="w-full lg:w-1/2 p-4">
                    <h2 class="font-black font-heading mb-32 lg:mb-0 mr:0 lg:mr-6">
                        <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">&nbsp;{{ $block->subtitle }}</span>@endif
                    </h2>
                </div>
                <div class="w-full lg:w-1/2 p-4 relative">
                    <div class="flex flex-wrap -m-4">
                        @foreach($category->logos as $logo)
                            @if($loop->index == 0 || $loop->index == 4)
                                <div class="w-full lg:w-1/2 p-4">
                                @if($loop->index == 0)
                                    <div class="transform -translate-y-[7rem]">
                                @elseif($loop->index == 4)
                                    <div class="transform -translate-y-20">
                                @endif
                            @endif
                            <div class="rounded-lg px-10 py-6 flex items-center justify-center mb-6 flex-shrink-0" style="background: {{ $block->tag_color }}">
                                <img class="h-12" src="{{ str_replace('public/', 'storage/', $logo->path) }}" alt="">
                            </div>
                            @if($loop->index == 3 || $loop->index == 7)
                                </div>
                                @if($loop->index == 3)
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

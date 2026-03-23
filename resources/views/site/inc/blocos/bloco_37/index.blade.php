<section id="section_{{ $i }}" class="py-24 lg:py-32 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="container px-4 mx-auto">
        <div class="flex flex-wrap lg:items-center -m-8">
            <div class="w-full p-8">
                <h2 class="block-title font-black font-heading mb-4">
                    <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                    @if($block->subtitle)
                        <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                    @endif
                </h2>
                <p class="mb-10 block-description" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                <div class="flex flex-wrap">
                    @php
                        $category = \App\Models\General\FAQ\Category::where('id', json_decode($block->faq_category))->orderBy('display_order')->first();
                    @endphp
                    @foreach($category->frequentlyQuestion->sortBy('display_order_category') as $faq)
                        @php
                            /** @var TYPE_NAME $tab */
                            $faq->description = str_replace('<h2', '<h2 class="mb-2 text-lg md:text-xs font-semibold"', $faq->description);
                            $faq->description = str_replace('<h3', '<h3 class="mb-2 text-md md:text-lg font-semibold"', $faq->description);
                            $faq->description = str_replace('<h4', '<h4 class="mb-2 text-sm md:text-md font-semibold"', $faq->description);
                            $faq->description = str_replace('<strong', '<strong class="font-black"', $faq->description);
                            $faq->description = str_replace('<a', '<a class="text-blue-600"', $faq->description);
                        @endphp
                        <div class="w-full accordion-section">
                            <a class="block py-4 border-t accordion-title cursor-pointer" href="javascript:void(0);">
                                <div class="flex flex-wrap justify-between items-center -m-2">
                                    <div class="w-auto p-2">
                                        <h3 class="font-semibold tracking-tight" style="color: {{ $block->primary_color }}">{{ $faq->title }}</h3>
                                    </div>
                                    <div class="w-auto p-2 transform rotate-0 accordion-icon">
                                        <svg width="16" height="16" viewbox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.33268 10L7.99935 5.33333L12.666 10" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="flex flex-wrap accordion-content mb-2 hidden">
                                <p class="tracking tight">{!! nl2br($faq->description) !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

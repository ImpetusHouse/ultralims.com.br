@php
    /** @var TYPE_NAME $block */
    $block->content = str_replace('<h2', '<h2 class="mb-2 text-lg md:text-xs font-semibold text-[#00268A]"', $block->content);
    $block->content = str_replace('<h3', '<h3 class="mb-2 text-md md:text-lg font-semibold text-[#00268A]"', $block->content);
    $block->content = str_replace('<h4', '<h4 class="mb-2 text-sm md:text-md font-semibold text-[#00268A]"', $block->content);
    $block->content = str_replace('<strong', '<strong class="text-[#00268A] font-black"', $block->content);
    $block->content = str_replace('<a', '<a class="text-blue-600"', $block->content);
@endphp
<section id="section_{{ $i }}" class="overflow-hidden" style="background-color: {{ $block->background_color }}; padding-bottom: {{ $block->margin_bottom }}px; padding-top: {{ $block->margin_top }}px">
    <div class="container mx-auto px-4">
        <div class="px-8">
            <div class="max-w-7xl mx-auto">
                <div class="-m-8 mb-10">
                    @if($block->title || $block->subtitle)
                        <h2 class="{{ $block->type }} font-black font-heading max-w-2xl {{ $block->content ? 'mb-2':'' }}">
                            <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                            @if($block->subtitle)
                                <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                            @endif
                        </h2>
                    @endif
                    @if($block->content)
                        <div class="block-description" style="color: {!! $block->content_color !!} !important;">{!! nl2br($block->content) !!}</div>
                    @endif
                </div>
                <div class="-m-8 mb-10">
                    @php
                        $categories = \App\Models\General\Cards\Category::whereIn('id', json_decode($block->cards_categories))
                            ->with(['subcategories.cards' => function($query) {
                                $query->orderBy('order');
                            }])->get();
                    @endphp
                    @foreach($categories as $category)
                        @foreach($category->subcategories as $subcategory)
                            <div class="flex flex-wrap md:-m-8">
                                @foreach($subcategory->cards->sortBy('order') as $card)
                                    @include('site.inc.blocos.bloco_29.card', compact('card'))
                                @endforeach
                            </div>
                            {{--<div class="border-b border-gray-300 my-4 md:my-8"></div>--}}
                        @endforeach
                        <!-- Exibição de cards sem subcategoria -->
                        @php
                            $cardsWithoutSubcategory = $category->cards->whereNull('subcategory_id');
                        @endphp
                        @if($cardsWithoutSubcategory->isNotEmpty())
                            <div class="flex flex-wrap md:-m-8">
                                @foreach($cardsWithoutSubcategory->sortBy('order') as $card)
                                    @include('site.inc.blocos.bloco_29.card', compact('card'))
                                @endforeach
                            </div>
                            {{--<div class="border-b border-gray-300 my-4 md:my-8"></div>--}}
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

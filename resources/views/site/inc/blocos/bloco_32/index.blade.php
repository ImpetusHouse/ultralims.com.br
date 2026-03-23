<section id="section_{{ $i }}" class="{{ env('APP_NAME') == 'AABB-SP' ? 'pt-20 pb-12 md:pb-16':'' }} overflow-hidden" {!! env('APP_NAME') != 'AABB-SP' ?  'style="padding-top: '.$block->margin_top.'px; padding-bottom: '.$block->margin_bottom.'px"' : '' !!}>
    <div class="container px-4 mx-auto">
        <div class="lg:items-center -m-8 lg:-m-12">
            <div class="w-full p-8 lg:p-12">
                <div class="flex flex-wrap justify-center mb-4 tabs">
                    @foreach ($block->tabs->sortBy('display_order') as $tab)
                        <button type="button" class="py-2 px-4 mx-2 mb-4 text-sm leading-5 text-white font-medium hover:opacity-70 md:max-w-max {{ env('APP_NAME') == 'PróLab' ? 'rounded':'rounded-xl' }} shadow-lg tablinks {{ $tab->first ? 'active' : '' }}" onclick="changeTab(event, 'tab-{{ $tab->id }}')"  style="{{ $loop->first ? 'background-color: '.env('PRIMARY_COLOR').'; color: #FFF;' : 'background-color: #FFF; color: #737276;' }}">
                            {{ $tab->title }}
                        </button>
                    @endforeach
                </div>
                @foreach ($block->tabs->sortBy('display_order') as $tab)
                    @push('head')
                        @include('site.inc.styles.fonts', ['block' => $block, 'tab' => $tab])
                    @endpush
                    @php
                        /** @var TYPE_NAME $tab */
                        $tab->content = str_replace('<h2', '<h2 class="mb-2 text-lg md:text-xs font-semibold"', $tab->content);
                        $tab->content = str_replace('<h3', '<h3 class="mb-2 text-md md:text-lg font-semibold"', $tab->content);
                        $tab->content = str_replace('<h4', '<h4 class="mb-2 text-sm md:text-md font-semibold"', $tab->content);
                        $tab->content = str_replace('<strong', '<strong class="font-black"', $tab->content);
                        $tab->content = str_replace('<a', '<a class="text-blue-600"', $tab->content);
                    @endphp
                    <div id="tab-{{ $tab->id }}" class="tabcontent" style="{{ !$loop->first ? 'display: none;' : '' }}">
                        <h2 class="font-black font-heading mb-2">
                            <span class="block-title-{{ $block->id }}-{{ $tab->id }}" style="color: {!! $block->title_color !!}">{{ $tab->title }}</span>
                        </h2>
                        <div class="block-description mb-8" style="color: {!! $block->content_color !!} !important;">{!! nl2br($tab->content) !!}</div>
                        <div class="md:-m-8">
                            @php
                                $categories = \App\Models\General\Cards\Category::whereIn('id', json_decode($tab->cards_categories))
                                    ->with(['subcategories.cards' => function($query) {
                                        $query->orderBy('order');
                                    }])->get();
                            @endphp
                            @foreach($categories as $category)
                                @foreach($category->subcategories as $subcategory)
                                    <div class="flex flex-wrap">
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
                                    <div class="flex flex-wrap">
                                        @foreach($cardsWithoutSubcategory->sortBy('order') as $card)
                                            @include('site.inc.blocos.bloco_29.card', compact('card'))
                                        @endforeach
                                    </div>
                                    {{--<div class="border-b border-gray-300 my-4 md:my-8"></div>--}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

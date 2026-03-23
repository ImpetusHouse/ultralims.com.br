@php
     /** @var TYPE_NAME $block */
    $category = \App\Models\General\Topics\Category::where('id', json_decode($block->topic_category))->first();
@endphp
@push('head')
    <style>
        .button-{{ $block->id }}:hover{
            color: {{ $block->button_title_color }} !important;
            background-color: {{ $block->button_color }} !important;
        }
    </style>
@endpush
<section id="section_{{ $i }}" class="overflow-hidden" style="background-color: {{ $block->background_color }}; padding-top: {{ $block->margin_top }}px; padding-bottom: {{ $block->margin_bottom }}px">
    <!-- Swiper -->
    <div class="swiper swiper-container-{{ $block->id }}">
        <div class="swiper-wrapper">
            @foreach($category->topics as $topic)
                @php
                    $pageItem = $topic->page;
                    $url = '';
                    if ($pageItem->prefix_slug->count() > 0) {
                        $url .= implode('/', $pageItem->prefix_slug->pluck('slug')->toArray()) . '/';
                    }
                    $url = '/' . $url . $pageItem->slug;
                @endphp
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <div class="flex justify-center w-full h-full">
                        <div class="relative h-[400px] lg:h-[500px] w-full overflow-hidden rounded-3xl">
                            <img class="h-[400px] lg:h-[500px] w-full object-cover transform hover:scale-105 transition ease-in-out duration-500" src="{{ asset(str_replace('public/', 'storage/', $topic->path)) }}" alt="{{ $topic->title }}"/>
                            <div class="absolute bottom-0 left-0 w-full">
                                <div class="px-8 py-4">
                                    <h3 class="text-lg text-left font-semibold" style="color: {{ $block->title_color }};">{{ $topic->title }}</h3>
                                    <div class="text-left text-sm text-opacity-80 w-full two-line-text mb-6" style="color: {{ $block->subtitle_color }};">{{ strip_tags(html_entity_decode($topic->description)) }}</div>
                                    <a href="{{ $url }}" class="button-{{ $block->id }} block sm:inline-block py-3 px-8 mb-4 sm:mb-0 sm:mr-3 block-button-title text-center font-semibold leading-none rounded border bg-opacity-0" style="border-color: {{ $block->button_color }}; color: {{ $block->button_color }}">
                                        Saiba mais
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@push('scripts')
    <script>
        new Swiper('.swiper-container-{{ $block->id }}', {
            slidesPerView: 1.5,
            spaceBetween: 20,
            loop: true,
            centeredSlides: true,
            autoplay: {
                delay: 5000, // Define o intervalo de tempo entre as transições
                disableOnInteraction: false, // O autoplay não será desativado após interações do usuário (swipes, cliques, etc.)
            },
            breakpoints: {
                640: {
                    slidesPerView: 1.5,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3.5,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 5.5,
                    spaceBetween: 20,
                },
            }
        });
    </script>
@endpush

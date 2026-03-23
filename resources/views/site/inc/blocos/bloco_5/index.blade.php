@push('head')
    <style>
        #pagination-{{ $block->id }} .swiper-pagination-bullet {
            background-color: #B8C2CC; /* Cor cinza para bullets inativos */
            margin-right: 8px; /* Espaçamento entre os bullets */
        }
        #pagination-{{ $block->id }} .swiper-pagination-bullet-active {
            background-color: {{ $block->button_color }}; /* Cor para o bullet ativo */
        }
    </style>
@endpush
<section id="section_{{ $i }}" class="py-12 md:pt-20 md:pb-12" style="background-color: {{ $block->background_color }}">
    <div class="container px-4 mx-auto">
        <div class="max-w-lg mx-auto mb-8 text-center">
            @if($block->tag)
                <span class="inline-block text-xs py-1 px-3 font-semibold rounded-xl" style="background-color: {{ $block->tag_color }}; color: {{ $block->tag_title_color }}">{{ $block->tag }}</span>
            @endif
            <h2 class="my-3 block-title font-black font-heading">
                <span style="color: {{ $block->title_color }}">{{ $block->title }}</span>
                @if($block->subtitle)
                    <span style="color: {{ $block->subtitle_color }}">{{ $block->subtitle }}</span>
                @endif
            </h2>
            <p class="block-description" style="color: {{ $block->content_color }}">{!! nl2br($block->content) !!}</p>
        </div>
        <!-- Swiper -->
        <div class="text-center mb-12 swiper-pagination-{{ $block->id }}" id="pagination-{{ $block->id }}"></div>
        <div class="relative max-w-6xl mx-auto">
            <img src="{{ asset('images/blocos/bloco_05/macbook.png') }}" alt="">
            <div class="swiper-container-{{ $block->id}} absolute" style="top: 5.8%; left: 14.6%; width: 72.8%; height: 76.7%; overflow: hidden;">
                <div class="swiper-wrapper">
                    @foreach($block->tabs->sortBy('display_order') as $tab)
                        @if(!$tab->display_content) @continue @endif
                        <div class="swiper-slide">
                            @if($tab->content_type == 'image')
                                <img class="object-cover w-full h-full" src="{{ asset($tab->image) }}">
                            @elseif($tab->content_type == 'video')
                                <video class="object-cover w-full h-full" autoplay muted playsinline loop>
                                    <source src="{{ asset($tab->video) }}" type="video/mp4">
                                    Seu navegador não suporta vídeos.
                                </video>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script>
        new Swiper('.swiper-container-{{ $block->id }}', {
            pagination: {
                el: '.swiper-pagination-{{ $block->id }}',
                clickable: true,
                bulletClass: 'swiper-pagination-bullet',
                bulletActiveClass: 'swiper-pagination-bullet-active'
            },
            loop: true,
            {{--autoplay: {
                delay: 2500, // tempo em milissegundos antes de passar para o próximo slide
                disableOnInteraction: false, // continua a passar automaticamente mesmo após interação do usuário
            },--}}
        });
    </script>
@endpush

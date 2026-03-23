@push('head')
    <style>
        .video-container-{{ $block->id }} img {
            display: block;
        }
        .video-container-{{ $block->id }} video {
            display: none;
        }
    </style>
@endpush

<section id="section_{{ $i }}" class="relative pt-12 pb-12 md:pb-28 lg:pt-0 lg:pb-0 overflow-hidden" style="background-color: {{ $block->background_color }}">
    @if($block->logo)
        <img class="absolute bottom-0 right-0" src="{{ asset($block->logo) }}" alt="">
    @endif
    <div class="relative z-10 container px-4 mx-auto">
        <div class="flex flex-wrap items-center -m-8">
            @for($i = 1; $i <= 2; $i++)
                @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                    <div class="w-full md:w-1/2 p-8 {{ $block->content_type == 'video' ? 'hidden md:block video-container-'.$block->id:'' }}">
                        @if($block->content_type == 'video')
                            <img class="mx-auto" src="{{ asset($block->image) }}" alt="">
                            <video autoplay muted loop>
                                <source src="{{ asset($block->video) }}" type="video/mp4" />
                            </video>
                        @else
                            <img class="mx-auto" src="{{ asset($block->image) }}" alt="">
                        @endif
                    </div>
                @else
                    <div class="w-full md:w-1/2 p-8">
                        <div class="md:max-w-lg">
                            <h2 class="block-title font-black font-heading mb-4">
                                <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                                @if($block->subtitle)
                                    <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                                @endif
                            </h2>
                            <p class="mb-8 block-description" style="color: {!! $block->content_color !!} !important;">{!! nl2br($block->content) !!}</p>
                            <div class="flex flex-wrap -m-2">
                                @if($block->button_display)
                                    <div class="w-full md:w-auto p-2">
                                        @include('site.inc.buttons.layout_1', ['item' => $block])
                                    </div>
                                @endif
                                @foreach($block->tabs as $tab)
                                    @if($tab->button_display)
                                        <div class="w-full md:w-auto p-2">
                                            @include('site.inc.buttons.layout_1', ['item' => $tab])
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endfor
        </div>
    </div>
</section>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const videoContainers = document.querySelectorAll('.video-container-{{ $block->id }}');

            videoContainers.forEach(container => {
                const video = container.querySelector('video');
                const backgroundImage = container.querySelector('img');

                if (video) {
                    video.addEventListener('canplaythrough', function () {
                        backgroundImage.style.display = 'none';
                        video.style.display = 'block';
                    });

                    video.addEventListener('waiting', function () {
                        backgroundImage.style.display = 'block';
                        video.style.display = 'none';
                    });

                    // Inicialmente, mostramos a imagem de fundo
                    backgroundImage.style.display = 'block';
                    video.style.display = 'none';
                    // Forçar atualização do vídeo ao carregar a página
                    video.load();
                }
            });
        });
    </script>
@endpush

@push('head')
    <style>
        #block-{{ $block->id }}-image {
            position: relative;
            width: 100%; /* Largura total da área disponível */
            height: auto; /* Altura automática baseada no conteúdo */
            aspect-ratio: 3 / 2; /* Mantém uma proporção fixa */
        }
    </style>
@endpush
<section id="section_{{ $i }}" class="pb-56 sm:pb-80" style="background-color: {{ $block->content_color }}">
    <div class="relative pt-12 md:pt-16 pb-32 md:pb-64 border-b-4" style="background-color: {{ $block->background_color }}; border-color: {{ $block->primary_color }}">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto text-center mb-12 md:mb-20">
                <h2 class="block-title font-black font-heading mb-10">
                    <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                    @if($block->subtitle)
                        <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                    @endif
                </h2>
                <div>
                    @if($block->button_display)
                        @include('site.inc.buttons.layout_2', ['item' => $block])
                    @endif
                    @if($block->button_display_1)
                        @include('site.inc.buttons.layout_2', ['item' => $block, 'buttonOne' => true])
                    @endif
                </div>
            </div>
        </div>
        <div class="absolute inset-x-0 max-w-3xl mx-auto px-4" id="image-{{ $block->id }}-container">
            @php
                $content_link = "'".$block->content_link."'";
            @endphp
            <img class="rounded-3xl md:rounded-6xl md:rounded-br-none w-full h-full" src="{{ asset($block->image) }}" alt="{{ $block->title }}" id="block-{{ $block->id }}-image">
            @if($block->content_type == 'youtube_embed')
                <div class="absolute inset-0 flex items-center justify-center">
                    <button class="flex items-center justify-center bg-white rounded-full" {!! $block->content_type == 'youtube_embed' ? 'onclick="imageToVideo('.$block->id.', '.$content_link.', 48)"':'' !!}>
                        <svg class="w-16 h-16 hover:opacity-70" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor" style="color: {{ $block->primary_color }}">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </div>
</section>

@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}">
    <div class="bg-top bg-cover bg-no-repeat {{ $block->content_type == 'video' ? 'video-container':'' }}" @if($block->content_type == 'image') style="background-image: url('{{ asset($block->image) }}'); padding-top: {{ $block->margin_top }}px; padding-bottom: {{ $block->margin_bottom }}px" @endif>
        @if($block->content_type == 'video')
            <video autoplay muted loop>
                <source src="{{ asset($block->video) }}" type="video/mp4" />
            </video>
        @endif
        <div class="container px-4 mx-auto">
            <div class="py-12 text-center">
                <div class="max-w-2xl mx-auto {{ $block->button_display || ($block->tabs->first() ? $block->tabs->first()->button_display:false) ? 'mb-8':''}}">
                    <h2 class="mb-4 font-black font-heading">
                        <span class="block-title-{{ $block->id }}" style="color: {{ $block->title_color }}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {{ $block->subtitle_color }}">&nbsp;{{ $block->subtitle }}</span>@endif
                    </h2>
                    @if($block->content)
                        <p class="block-description-{{ $block->id }}" style="color: {{ $block->content_color }}">{!! nl2br($block->content) !!}</p>
                    @endif
                </div>
                <div>
                    @if($block->button_display)
                        @include('site.inc.buttons.layout_1', ['item' => $block])
                    @endif
                    @foreach($block->tabs as $tab)
                        @if($tab->button_display)
                            @push('head')
                                @include('site.inc.styles.fonts', ['block' => $block, 'tab' => $tab])
                            @endpush
                            @include('site.inc.buttons.layout_1', ['item' => $tab])
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

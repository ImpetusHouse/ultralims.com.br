@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="overflow-hidden">
    <div class="flex flex-wrap">
        <div class="w-full lg:w-5/12 bg-cover bg-no-repeat bg-center hidden md:block" style="background-image: url('{{ asset($block->image) }}');"></div>
        <div class="w-full lg:w-7/12 p-4 h-full min-h-screen" style="background-color: {{ $block->background_color }}">
            <div class="flex items-center justify-center">
                <div class="max-w-lg py-24 lg:py-40">
                    <div class="mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewbox="0 0 64 64" fill="none">
                            <circle opacity="0.3" cx="32" cy="32" r="32" fill="{{ $block->tag_color }}"></circle>
                            <circle cx="32" cy="32" r="24" fill="{{ $block->divider_color }}"></circle>
                            <path d="M41.28 24.4655C41.0779 24.2969 40.8447 24.1695 40.5933 24.0911C40.3419 24.0127 40.0775 23.9842 39.8154 24.0083C39.5534 24.0321 39.2983 24.1072 39.0654 24.2299C38.8321 24.3522 38.6257 24.5194 38.4575 24.7218L29.8487 35.0499L25.3927 30.5939C25.015 30.2292 24.5093 30.0271 23.9844 30.0318C23.4596 30.0365 22.9576 30.247 22.5862 30.6183C22.2152 30.9893 22.0044 31.4914 22.0001 32.0165C21.9954 32.5414 22.1971 33.0471 22.5618 33.4244L28.5675 39.4301C28.7538 39.6165 28.975 39.7642 29.2186 39.8651C29.4623 39.9657 29.7234 40.0173 29.9868 40.0166H30.0769C30.3551 40.0042 30.6279 39.9342 30.8776 39.8102C31.1269 39.6865 31.3481 39.5119 31.5264 39.2981L41.5353 27.2867C41.7039 27.0846 41.8309 26.8514 41.9093 26.6003C41.9877 26.3493 42.0156 26.0852 41.9918 25.8231C41.968 25.5611 41.8929 25.3067 41.7706 25.0738C41.6482 24.8409 41.4813 24.6344 41.2793 24.4658L41.28 24.4655Z" fill="{{ $block->pdf_color }}"></path>
                        </svg>
                    </div>
                    @if($block->tag)
                        <p class="uppercase font-bold text-xs tracking-widest mb-1" style="color: {{ $block->tag_title_color }};">
                            {{ $block->tag }}
                        </p>
                    @endif
                    <h2 class="font-black font-heading mb-6">
                        <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">&nbsp;{{ $block->subtitle }}</span>@endif
                    </h2>
                    <div class="block-description-{{ $block->id }} {{ $block->button_display ? 'mb-8':"" }}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</div>
                    @if($block->button_display)
                        @include('site.inc.buttons.layout_'.$block->type, ['item' => $block])
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

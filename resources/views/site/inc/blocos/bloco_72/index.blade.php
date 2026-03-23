@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
    <style>
        #button-{{ $block->id }}:hover{
            background-color: {{ $block->button_border_color }}!important;
            color: {{ $block->button_color }}!important;
        }

        .product-{{ $block->id }}:hover .product{
            border-color: {{ $block->primary_color }}!important;
        }
    </style>
@endpush
<section id="section_{{ $i }}" class="overflow-hidden" style="background-color: {{ $block->background_color }}; padding-top: {{ $block->margin_top }}px; padding-bottom: {{ $block->margin_bottom }}px;">
    <div class="container px-4 mx-auto">
        <h2 class="mb-14 font-black font-heading text-center">
            <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">&nbsp;{{ $block->subtitle }}</span>@endif
        </h2>
        <div class="flex flex-wrap -mx-4 -mb-10">
            <div class="w-full xs:w-1/2 lg:w-1/4 px-4 mb-10">
                <a class="block product-{{ $block->id }} max-w-xs xs:max-w-none mx-auto" href="#">
                    <div class="product flex items-end justify-end h-64 mb-4 bg-gray-100 rounded-xl border-2 border-transparent transition duration-150 overflow-hidden">
                        <img class="block" src="coleos-assets/product-blocks/no-bg-product-10.png" alt="">
                    </div>
                    <span class="block text-base mb-1" style="color: {{ $block->content_color }}">White Label Cap</span>
                    <span class="block text-base" style="color: {{ $block->tag_color }}">$ 199.00</span>
                </a>
            </div>
            <div class="w-full xs:w-1/2 lg:w-1/4 px-4 mb-10">
                <a class="block product-{{ $block->id }} max-w-xs xs:max-w-none mx-auto" href="#">
                    <div class="product flex items-center justify-center h-64 mb-4 bg-gray-100 rounded-xl border-2 border-transparent transition duration-150 overflow-hidden">
                        <img class="block" src="coleos-assets/product-blocks/product-no-bg2.png" alt="">
                    </div>
                    <span class="block text-base mb-1" style="color: {{ $block->content_color }}">White Label Cap</span>
                    <span class="block text-base" style="color: {{ $block->tag_color }}">$ 199.00</span>
                </a>
            </div>
            <div class="w-full xs:w-1/2 lg:w-1/4 px-4 mb-10">
                <a class="block product-{{ $block->id }} max-w-xs xs:max-w-none mx-auto" href="#">
                    <div class="product flex items-center justify-center h-64 mb-4 bg-gray-100 rounded-xl border-2 border-transparent transition duration-150 overflow-hidden">
                        <img class="block" src="coleos-assets/product-blocks/product-no-bg3.png" alt="">
                    </div>
                    <span class="block text-base mb-1" style="color: {{ $block->content_color }}">White Label Cap</span>
                    <span class="block text-base" style="color: {{ $block->tag_color }}">$ 199.00</span>
                </a>
            </div>
            <div class="w-full xs:w-1/2 lg:w-1/4 px-4 mb-10">
                <a class="block product-{{ $block->id }} max-w-xs xs:max-w-none mx-auto" href="#">
                    <div class="product flex items-center justify-center h-64 mb-4 bg-gray-100 rounded-xl border-2 border-transparent transition duration-150 overflow-hidden">
                        <img class="block" src="coleos-assets/product-blocks/no-bg-product-11.png" alt="">
                    </div>
                    <span class="block text-base mb-1" style="color: {{ $block->content_color }}">White Label Cap</span>
                    <span class="block text-base" style="color: {{ $block->tag_color }}">$ 199.00</span>
                </a>
            </div>
            <div class="w-full xs:w-1/2 lg:w-1/4 px-4 mb-10">
                <a class="block product-{{ $block->id }} max-w-xs xs:max-w-none mx-auto" href="#">
                    <div class="product flex items-center justify-center h-64 mb-4 bg-gray-100 rounded-xl border-2 border-transparent transition duration-150 overflow-hidden">
                        <img class="block" src="coleos-assets/product-blocks/product-no-bg7.png" alt="">
                    </div>
                    <span class="block text-base mb-1" style="color: {{ $block->content_color }}">White Label Cap</span>
                    <span class="block text-base" style="color: {{ $block->tag_color }}">$ 199.00</span>
                </a>
            </div>
            <div class="w-full xs:w-1/2 lg:w-1/4 px-4 mb-10">
                <a class="block product-{{ $block->id }} max-w-xs xs:max-w-none mx-auto" href="#">
                    <div class="product flex items-center justify-center h-64 mb-4 bg-gray-100 rounded-xl border-2 border-transparent transition duration-150 overflow-hidden">
                        <img class="block" src="coleos-assets/product-blocks/product-no-bg8.png" alt="">
                    </div>
                    <span class="block text-base mb-1" style="color: {{ $block->content_color }}">White Label Cap</span>
                    <span class="block text-base" style="color: {{ $block->tag_color }}">$ 199.00</span>
                </a>
            </div>
            <div class="w-full xs:w-1/2 lg:w-1/4 px-4 mb-10">
                <a class="block product-{{ $block->id }} max-w-xs xs:max-w-none mx-auto" href="#">
                    <div class="product flex items-center justify-center h-64 mb-4 bg-gray-100 rounded-xl border-2 border-transparent transition duration-150 overflow-hidden">
                        <img class="block" src="coleos-assets/product-blocks/product-no-bg9.png" alt="">
                    </div>
                    <span class="block text-base mb-1" style="color: {{ $block->content_color }}">White Label Cap</span>
                    <span class="block text-base" style="color: {{ $block->tag_color }}">$ 199.00</span>
                </a>
            </div>
            <div class="w-full xs:w-1/2 lg:w-1/4 px-4 mb-10">
                <a class="block product-{{ $block->id }} max-w-xs xs:max-w-none mx-auto" href="#">
                    <div class="product flex items-center h-64 mb-4 bg-gray-100 rounded-xl border-2 border-transparent transition duration-150 overflow-hidden">
                        <img class="block w-full" src="coleos-assets/product-blocks/product-no-bg4.png" alt="">
                    </div>
                    <span class="block text-base mb-1" style="color: {{ $block->content_color }}">White Label Cap</span>
                    <span class="block text-base" style="color: {{ $block->tag_color }}">$ 199.00</span>
                </a>
            </div>
        </div>
        <div class="text-center mt-12">
            <a id="button-{{ $block->id }}" class="block-button-title-{{ $block->id }} rounded-lg inline-flex h-12 py-2 px-4 items-center justify-center text-sm font-medium border transition duration-200" href="#" style="color: {{ $block->button_title_color }}; background-color: {{ $block->button_color }}; border-color: {{$block->button_border_color}}">
                Ver mais
            </a>
        </div>
    </div>
</section>

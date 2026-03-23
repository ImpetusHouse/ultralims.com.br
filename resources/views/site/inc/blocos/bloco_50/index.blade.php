@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
    <style>
        @media (min-width: 768px) {
            #section_{{ $i }}{
                padding-top: {{ $block->margin_top }}px;
                padding-bottom: {{ $block->margin_bottom }}px;
            }
        }
    </style>
@endpush
<section id="section_{{ $i }}" class="relative pt-[7rem] pb-12 md:pt-12 overflow-hidden" style="background-color: {{ $block->tabs->where('tab', 1)->first()->background_color }}">
    @if($block->tabs->where('tab', 2)->first()->display_content)
        <div class="hidden lg:block absolute inset-0 w-full h-full" style="background-image: url('{{ asset($block->tabs->where('tab', 2)->first()->image) }}'); background-size: cover;"></div>
    @endif
    <div class="hidden lg:block absolute top-0 left-0 md:w-5/12 xl:w-4/12 -ml-5 h-full" style="background-color: {{ $block->background_color }}">
        @if($block->tabs->where('tab', 1)->first()->display_content)
            <div class="hidden lg:block absolute inset-0 w-full h-full" style="background-image: url('{{ asset($block->tabs->where('tab', 1)->first()->image) }}'); background-size: cover;"></div>
        @endif
    </div>
    <div class="relative container px-4 mx-auto z-20">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-wrap -mx-4 items-center">
                <div class="hidden md:block w-full lg:w-2/5 px-4 mb-16 lg:mb-0">
                    <div class="relative max-w-md mx-auto lg:mx-0">
                        <img class="block w-full" src="{{ asset($block->image) }}" alt="">
                    </div>
                </div>
                <div class="w-full lg:w-3/5 px-4">
                    <div class="max-w-md lg:max-w-2xl mx-auto lg:mr-0">
                        <div class="max-w-2xl">
                            <h2 class="font-black font-heading mb-8 sm:mb-14">
                                <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">&nbsp;{{ $block->subtitle }}</span>@endif
                            </h2>
                        </div>
                        <div class="md:flex {{ $block->button_display || $block->button_display_1 ? 'mb-14':'' }} max-w-xs sm:max-w-sm md:max-w-none">
                            <div class="mb-6 md:mb-0 md:mr-8 pt-3" style="color: {!! $block->content_color !!} !important;">
                                <svg width="84" height="10" viewbox="0 0 84 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 4.25C0.585786 4.25 0.25 4.58579 0.25 5C0.25 5.41421 0.585786 5.75 1 5.75L1 4.25ZM84 5.00001L76.5 0.669879L76.5 9.33013L84 5.00001ZM1 5.75L77.25 5.75001L77.25 4.25001L1 4.25L1 5.75Z" fill="currentColor"></path>
                                </svg>
                            </div>
                            <div class="max-w-md">
                                <p class="block-description-{{ $block->id }}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                            </div>
                        </div>
                        @if($block->button_display)
                            <div class="sm:flex items-center">
                                @include('site.inc.buttons.layout_'.$block->type, ['item' => $block])
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@php
    /** @var TYPE_NAME $block */
    $testimonial = \App\Models\General\Testimonials\Testimonial::whereIn('id', json_decode($block->testimonials))->first();
@endphp
@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="relative overflow-hidden" style="background-color: {{ $block->background_color }}; padding-top: {{ $block->margin_top }}px; padding-bottom: {{ $block->margin_top }}px;">
    <div class="relative container px-4 mx-auto">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-wrap items-center -mx-4">
                @for($i = 1; $i <= 2; $i++)
                    @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                        <div class="hidden md:block w-full lg:w-1/2 px-4 order-last lg:order-none">
                            <img class="block max-w-lg mx-auto lg:mx-0 w-full" src="{{ asset($block->image) }}" alt="">
                        </div>
                    @else
                        <div class="w-full lg:w-1/2 px-4">
                            <div class="max-w-lg mx-auto lg:mr-0">
                                <h2 class="font-black font-heading mb-6">
                                    <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}"> {{ $block->subtitle }}</span>@endif
                                </h2>
                                <div class="block-description-{{ $block->id }} {{ $testimonial ? 'mb-20':'' }}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</div>
                                @if($testimonial)
                                    <p class="block-description mb-6" style="color: {{ $block->tag_title_color }}">“{!! nl2br($testimonial->description) !!}”</p>
                                    <div class="flex items-center">
                                        <img class="h-16 w-16 rounded-full object-cover" src="{{ asset(str_replace('public/', 'storage/', $testimonial->path)) }}" alt="">
                                        <div class="ml-4">
                                            <span class="font-semibold" style="color: {{ $block->primary_color }}">{{ $testimonial->client }}</span>
                                            <span class="block text-sm" style="color: {{ $block->tag_color }}">{{ $testimonial->description_client }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </div>
</section>

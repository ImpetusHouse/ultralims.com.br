@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="relative py-24 lg:py-32 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="relative container px-4 mx-auto z-10">
        <div class="flex flex-wrap lg:items-center -m-8">
            @for($i = 1; $i <= 2; $i++)
                @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                    <div class="w-full md:w-1/2 p-8 {{ $block->tabs->where('tab', 1)->first()->display_content ? 'block md:block':'hidden md:block' }}">
                        <div class="max-w-max mx-auto">
                            <img class="transform hover:-translate-y-2 transition duration-500" src="{{ asset($block->image) }}" alt="">
                        </div>
                    </div>
                @else
                    <div class="w-full md:w-1/2 p-8">
                        <div class="md:max-w-md">
                            <h2 class="font-black font-heading mb-4">
                                <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}"> {{ $block->subtitle }}</span>@endif
                            </h2>
                            <p class="mb-20 block-description-{{ $block->id }}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                            <div class="flex flex-wrap">
                                @foreach($block->tabs->sortBy('display_order') as $tab)
                                    @push('head')
                                        @include('site.inc.styles.fonts', ['block' => $block, 'tab' => $tab])
                                    @endpush
                                    <div class="w-full accordion-section">
                                        <a class="block py-4 border-t accordion-title cursor-pointer" href="javascript:void(0);">
                                            <div class="flex flex-wrap justify-between items-center -m-2">
                                                <div class="w-auto p-2">
                                                    <h3 class="block-title-{{$block->id}}-{{$tab->id}} font-semibold tracking-tight" style="color: {{ $tab->title_color }}">{{ $tab->title }}</h3>
                                                </div>
                                                <div class="w-auto p-2 transform rotate-{{ $block->type == 'close' || $block->type == null ? '0':'180' }} accordion-icon">
                                                    <svg width="16" height="16" viewbox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M3.33268 10L7.99935 5.33333L12.666 10" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="flex flex-wrap accordion-content mb-2 {{ $block->type == 'close' || $block->type == null ? 'hidden':'' }}">
                                            <div class="block-description-{{$block->id}}-{{$tab->id}} tracking tight" style="color: {{ $tab->subtitle_color }};">{!! nl2br($tab->content) !!}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endfor
        </div>
    </div>
    @if($block->display_content)
        <img class="hidden lg:block absolute inset-0 w-full" src="{{ asset($block->logo) }}" alt="">
    @endif
</section>

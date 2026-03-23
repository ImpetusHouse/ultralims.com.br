<section id="section_{{ $i }}" class="py-20 lg:py-32 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="container px-4 mx-auto">
        <div class="flex flex-wrap lg:items-center -m-8">
            @for($i = 1; $i <= 2; $i++)
                @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                    <div class="w-full md:w-1/2 p-8">
                        <div class="max-w-max mx-auto">
                            <img class="transform hover:-translate-y-2 transition duration-500" src="{{ asset($block->image) }}" alt="">
                        </div>
                    </div>
                @else
                    <div class="w-full md:w-1/2 p-8">
                        <div class="md:max-w-xl">
                            <h2 class="block-title font-black font-heading mb-4">
                                <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                                @if($block->subtitle)
                                    <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                                @endif
                            </h2>
                            <p class="mb-20 block-description" style="color: {!! $block->content_color !!} !important;">{!! nl2br($block->content) !!}</p>
                            <div class="max-w-md">
                                @php
                                    $tab = $block->tabs->sortBy('display_order')->first();
                                @endphp
                                <h3 class="mb-8 text-xl font-semibold tracking-tight" style="color: {{ $tab->subtitle_color }}">{{ $block->content_link }}</h3>
                                <div class="flex flex-wrap justify-between -m-2">
                                    <div class="flex-1 p-2">
                                        <ul class="-m-2">
                                            @foreach($block->tabs->sortBy('display_order') as $index => $tab)
                                                @if($index < $block->tabs->count() / 2)
                                                    <li class="flex items-center p-2">
                                                        <svg class="mr-3" width="22" height="22" viewbox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4.58398 11.917L8.25065 15.5837L17.4173 6.41699" stroke="{{ $block->button_color }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                        <span class="font-medium tracking-tight" style="color: {{ $tab->title_color }}">{{ $tab->title }}</span>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="flex-1 p-2">
                                        <ul class="-m-2">
                                            @foreach($block->tabs->sortBy('display_order') as $index => $tab)
                                                @if($index >= $block->tabs->count() / 2)
                                                    <li class="flex items-center p-2">
                                                        <svg class="mr-3" width="22" height="22" viewbox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4.58398 11.917L8.25065 15.5837L17.4173 6.41699" stroke="{{ $block->button_color }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                        <span class="font-medium tracking-tight" style="color: {{ $tab->title_color }}">{{ $tab->title }}</span>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endfor
        </div>
    </div>
</section>

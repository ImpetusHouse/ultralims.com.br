<section id="section_{{ $i }}" class="py-20" style="background-color: {{ $block->background_color }}">
    <div class="container px-4 mx-auto">
        <div class="flex flex-wrap -mx-4">
            @for($i = 1; $i <= 2; $i++)
                @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                    <div class="w-full lg:w-1/2 px-8">
                        <ul class="space-y-12">
                            @foreach($block->tabs->sortBy('display_order') as $tab)
                                <li class="flex -mx-4">
                                    <div class="px-4">
                            <span class="flex w-16 h-16 mx-auto items-center justify-center text-2xl font-bold font-heading rounded-full" style="background-color: {{ $tab->background_color }}">
                                <img width="24" height="24" src="{{ asset($tab->image) }}">
                            </span>
                                    </div>
                                    <div class="px-4">
                                        <h3 class="my-4 text-xl font-semibold" style="color: {{ $tab->title_color }}">{{ $tab->title }}</h3>
                                        <p style="color: {{ $tab->subtitle_color }}">{{ $tab->subtitle }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="w-full lg:w-1/2 px-8">
                        <div class="mb-12 lg:mb-0 pb-12 lg:pb-0 border-b lg:border-b-0">
                            <h2 class="block-title font-black font-heading mb-4">
                                <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                                @if($block->subtitle)
                                    <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                                @endif
                            </h2>
                            <p class="mb-8 block-description" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                            @if($block->button_display)
                                @include('site.inc.buttons.layout_1', ['item' => $block])
                            @endif
                        </div>
                    </div>
                @endif
            @endfor
        </div>
    </div>
</section>

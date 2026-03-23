<section id="section_{{ $i }}" class="relative" style="background-color: {{ $block->background_color }}">
    <div class="overflow-hidden pt-16 pb-48">
        <div class="relative container px-4 mx-auto">
            <div class="flex flex-wrap -m-8">
                <div class="w-full md:w-1/2 lg:w-4/12 xl:w-6/12 p-8">
                    <h2 class="block-title font-black font-heading mb-4">
                        <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                        @if($block->subtitle)
                            <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                        @endif
                    </h2>
                    <p class="mb-8 block-description" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                    @if($block->button_display)
                        <div class="mb-12 md:inline-block">
                            @include('site.inc.buttons.layout_1', ['item' => $block])
                        </div>
                    @endif
                </div>
                <div class="w-full md:w-1/2 lg:w-8/12 xl:w-8/12 xl:absolute xl:right-0 xl:-bottom-20 p-8">
                    <div class="flex flex-wrap justify-center items-center lg:justify-end -m-3">
                        @php
                            $tab = $block->tabs->where('tab', 1)->first();
                        @endphp
                        <div class="w-auto lg:w-1/3 xl:pt-28 p-3">
                            <div class="flex flex-wrap justify-end">
                                <div class="w-auto">
                                    <img class="mx-auto transform hover:-translate-y-16 transition ease-in-out duration-1000 {{ $tab->content_type === 'youtube_embed' ? 'cursor-pointer':'' }}" src="{{ asset($tab->image) }}" alt="" {{ $tab->content_type === 'youtube_embed' ? 'data-video-url="'.$tab->content_link.'"':'' }}>
                                </div>
                            </div>
                        </div>
                        <div class="w-auto lg:w-1/3 p-3">
                            <div class="flex flex-wrap justify-center -m-3">
                                @php
                                    $tab = $block->tabs->where('tab', 2)->first();
                                @endphp
                                <div class="w-auto p-3">
                                    <img class="mx-auto transform hover:-translate-y-16 transition ease-in-out duration-1000 {{ $tab->content_type === 'youtube_embed' ? 'cursor-pointer':'' }}" src="{{ asset($tab->image) }}" alt="" {{ $tab->content_type === 'youtube_embed' ? 'data-video-url="'.$tab->content_link.'"':'' }}>
                                </div>
                                @php
                                    $tab = $block->tabs->where('tab', 3)->first();
                                @endphp
                                <div class="w-auto p-3">
                                    <img class="mx-auto transform hover:-translate-y-16 transition ease-in-out duration-1000 {{ $tab->content_type === 'youtube_embed' ? 'cursor-pointer':'' }}" src="{{ asset($tab->image) }}" alt="" {{ $tab->content_type === 'youtube_embed' ? 'data-video-url="'.$tab->content_link.'"':'' }}>
                                </div>
                            </div>
                        </div>
                        @php
                            $tab = $block->tabs->where('tab', 4)->first();
                        @endphp
                        <div class="w-auto lg:w-1/3 p-3">
                            <div class="flex flex-wrap">
                                <div class="w-auto">
                                    <img class="mx-auto transform hover:-translate-y-16 transition ease-in-out duration-1000 {{ $tab->content_type === 'youtube_embed' ? 'cursor-pointer':'' }}" src="{{ asset($tab->image) }}" alt="" {{ $tab->content_type === 'youtube_embed' ? 'data-video-url="'.$tab->content_link.'"':'' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

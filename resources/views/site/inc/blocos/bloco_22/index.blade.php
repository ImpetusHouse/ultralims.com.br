<section id="section_{{ $i }}" class="relative py-12 sm:py-24 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="relative container mx-auto px-4">
        <div class="relative max-w-md md:max-w-none mx-auto">
            <div class="flex flex-wrap items-end -mx-4 lg:mb-16 mb-4">
                <div class="w-full lg:w-1/2 px-4 mb-16 lg:mb-0">
                    <div class="max-w-2xl">
                        <h2 class="block-title font-black font-heading mb-6">
                            <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                            @if($block->subtitle)
                                <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                            @endif
                        </h2>
                        <p class="block-description" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 px-4 lg:text-right"></div>
            </div>
            @php
                $members = \App\Models\III\Member\Member::where('status', true)->orderBy('name')->get();
            @endphp
            <div class="flex flex-wrap -mx-4 -mb-8">
                @foreach($members as $member)
                    <div class="w-full md:w-1/2 lg:w-1/5 px-4">
                        <a href="{{ route('pesquisadores.show', $member->slug) }}">
                            <div class="square relative flex items-end px-6 pt-6 pb-7 mb-8 rounded-3xl overflow-hidden">
                                <img class="absolute top-0 left-0 w-full h-full object-cover transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset(str_replace('public/', 'storage/', $member->photo)) }}" alt="{{ $member->name }}">
                                <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black to-transparent"></div>
                                <div class="relative w-full pb-2">
                                    <span class="block lg:text-sm text-md text-white font-medium">{{ $member->name }}</span>
                                    <span class="block lg:text-xs text-sm text-gray-500 font-medium one-line-text">{{ html_entity_decode(strip_tags($member->description)) }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

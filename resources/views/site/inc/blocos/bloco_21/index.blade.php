<section id="section_{{ $i }}" class="relative py-12 sm:py-24 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="relative container mx-auto px-4">
        <div class="max-w-xl xs:max-w-4xl mb-14">
            <h2 class="block-title font-black font-heading mb-6">
                <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                @if($block->subtitle)
                    <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                @endif
            </h2>
            <p class="block-description" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
        </div>
        @php
            $researchs = \App\Models\III\ResearchPlatform\ResearchPlatform::where('thematic_area', true)->where('status', true)->orderBy('title')->get();
        @endphp
        <div class="flex flex-wrap -mx-4">
            @foreach($researchs as $research)
                <div class="w-full md:w-1/3 px-4 mb-8">
                    <a href="{{ route('pesquisas.show', $research->slug) }}">
                        <div class="relative h-48 xl:h-44 pt-4 md:pt-6 px-9 pb-7 rounded-3xl overflow-hidden">
                            <img class="absolute bottom-0 left-0 w-full h-full object-cover transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset(str_replace('public/', 'storage/', $research->photo)) }}" alt="">
                            <div class="absolute bottom-0 left-0 p-4 w-full">
                                <span class="block font-black text-white text-md two-line-text">{{ $research->title }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

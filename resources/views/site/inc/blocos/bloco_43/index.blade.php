<section id="section_{{ $i }}" class="py-20" style="background-color: {{ $block->background_color }}">
    <div class="container mx-auto px-4 text-center">
        <h2 class="block-title font-black font-heading mb-12">
            <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
            @if($block->subtitle)
                <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
            @endif
        </h2>
        <div class="flex flex-wrap -mx-2">
            @php $category = \App\Models\General\Logos\Category::where('id', json_decode($block->logos_category))->first(); @endphp
            @foreach($category->logos as $logo)
                <div class="mb-4 w-full md:w-1/3 lg:w-1/6 px-2">
                    <div class="py-16 rounded">
                        <img class="mx-auto h-6" src="{{ asset(str_replace('public/', 'storage/', $logo->path)) }}" alt="">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

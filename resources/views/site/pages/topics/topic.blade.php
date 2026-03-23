@foreach($topics as $topic)
    @php
        $pageItem = $topic->page;
        $url = '';
        if ($pageItem->prefix_slug->count() > 0) {
            $url .= implode('/', $pageItem->prefix_slug->pluck('slug')->toArray()) . '/';
        }
        $url = '/' . $url . $pageItem->slug;
    @endphp
    <div class="w-full md:w-1/2 lg:w-1/4 px-4 topic-container" id="topic-{{ $topic->id }}">
        <a href="{{ $url }}">
            <div class="square relative flex items-end px-6 pt-6 pb-7 mb-8 rounded-3xl overflow-hidden">
                <img class="absolute top-0 left-0 w-full h-full object-cover transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset(str_replace('public/', 'storage/', $topic->path)) }}" alt="{{ $topic->title }}">
                <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black to-transparent"></div>
                <div class="relative w-full pb-2">
                    <span class="block lg:text-sm text-md text-white font-medium one-line-text">{{ $topic->title }}</span>
                    <span class="block lg:text-sm text-sm text-white font-normal two-line-text">{!! strip_tags(html_entity_decode($topic->description)) !!}</span>
                </div>
            </div>
        </a>
    </div>
@endforeach

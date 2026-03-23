@foreach($events as $event)
    <div class="w-full md:w-1/2 lg:w-1/4 px-4 event-container" id="event-{{ $event->id }}">
        <a href="{{ route('events.show', $event->slug) }}">
            <div class="square relative flex items-end px-6 pt-6 pb-7 mb-8 rounded-3xl overflow-hidden">
                <img class="absolute top-0 left-0 w-full h-full object-cover transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset(str_replace('public/', 'storage/', $event->photo_square)) }}" alt="{{ $event->title }}">
                <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black to-transparent"></div>
                <div class="relative w-full pb-2">
                    <span class="lg:text-xs text-sm px-3 font-semibold rounded-2xl" style="background-color: {{ env('PRIMARY_COLOR') }}; color: #FFF">{{ $event->date->format('d/m/Y') }}</span>
                    <span class="block lg:text-sm text-md text-white font-medium two-line-text">{{ $event->title }}</span>
                </div>
            </div>
        </a>
    </div>
@endforeach

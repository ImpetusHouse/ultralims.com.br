@foreach($alerts as $alert)
    <div class="w-full md:w-1/2 lg:w-1/4 px-4 alert-container" id="event-{{ $alert->id }}">
        <a href="{{ route('alerts.show', $alert->slug) }}">
            <div class="square relative flex items-end px-6 pt-6 pb-7 mb-8 rounded-3xl overflow-hidden">
                <img class="absolute top-0 left-0 w-full h-full object-cover transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset(str_replace('public/', 'storage/', $alert->photo)) }}" alt="{{ $alert->title }}">
                <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black to-transparent"></div>
                <div class="relative w-full pb-2">
                    <span class="block lg:text-sm text-md text-white font-medium two-line-text">{{ $alert->title }}</span>
                </div>
            </div>
        </a>
    </div>
@endforeach

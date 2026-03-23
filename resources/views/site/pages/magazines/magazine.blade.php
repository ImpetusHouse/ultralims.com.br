@foreach($magazines as $magazine)
    <div class="w-full md:w-1/2 lg:w-1/4 px-4 event-container" id="magazine-{{ $magazine->id }}">
        <a href="{{ asset($magazine->pdf) }}" target="_blank">
            <div class="magazine relative flex items-end px-6 pt-6 pb-7 mb-8 rounded-3xl overflow-hidden">
                <img class="absolute top-0 left-0 w-full h-full object-cover transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset(str_replace('public/', 'storage/', $magazine->photo)) }}" alt="{{ $magazine->title }}">
                <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black to-transparent"></div>
                <div class="relative w-full pb-2">
                    <span class="block lg:text-sm text-md text-white font-medium two-line-text">{{ $magazine->title }}</span>
                </div>
            </div>
        </a>
    </div>
@endforeach

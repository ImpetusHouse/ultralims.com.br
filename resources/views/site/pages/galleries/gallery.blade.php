@foreach($galleries as $gallery)
    <div class="w-full md:w-1/2 lg:w-1/4 px-4 gallery-container" id="gallery-{{ $gallery->id }}">
        <a href="javascript:void(0);"
           data-lg="true"
           data-src="{{ asset(str_replace('public/', 'storage/', $gallery->photos->first()->path)) }}"
           data-sub-html="<h4>{{ $gallery->title }}</h4><h5>Foto: {{ $gallery->photographer }}</h5>">
            <div class="square relative flex items-end px-6 pt-6 pb-7 mb-8 rounded-3xl overflow-hidden">
                <img class="lazyload absolute top-0 left-0 w-full h-full object-cover transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset(str_replace('public/', 'storage/', $gallery->photos->first()->path)) }}" alt="{{ $gallery->title }}">
                <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black to-transparent"></div>
                <div class="relative w-full pb-2">
                    <span class="block lg:text-sm text-md text-white font-medium two-line-text">{{ $gallery->title }}</span>
                </div>
            </div>
        </a>
        @foreach($gallery->photos as $photo)
            @if($loop->first) @continue @endif
            <a href="javascript:void(0);" style="display: none;"
               data-lg="true"
               data-src="{{ asset(str_replace('public/', 'storage/', $photo->path)) }}"
               data-sub-html="<h4>{{ $gallery->title }}</h4><h5>Foto: {{ $gallery->photographer }}</h5>">
                <img class="lazyload" data-src="{{ asset(str_replace('public/', 'storage/', $photo->path)) }}" alt="{{ $gallery->title }}">
            </a>
        @endforeach
    </div>
@endforeach

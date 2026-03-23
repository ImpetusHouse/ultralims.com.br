@php
    /** @var TYPE_NAME $block */
    $events = \App\Models\General\Events\Event::where('status', true)->whereIn('id', json_decode($block->events))->orderBy('display_order')->get();
    foreach ($events->sortByDesc('display_order') as $event){
        $event->content = html_entity_decode(strip_tags($event->content));
    }
@endphp
@push('head')
    <style>
        #button-prev-{{ $block->id }}:hover{
            background-color: {{ $block->button_color }} !important;
        }
        #button-prev-{{ $block->id }}:hover > svg{
            fill: {{ $block->button_title_color }} !important;
        }
        #button-next-{{ $block->id }}:hover{
            background-color: {{ $block->button_color }} !important;
        }
        #button-next-{{ $block->id }}:hover > svg{
            fill: {{ $block->button_title_color }} !important;
        }

        /* Transitions */
        #section_{{ $i }} {
            transition: background-image 1s ease-in-out;
        }
    </style>
@endpush
<section id="section_{{ $i }}" class="relative bg-cover bg-no-repeat bg-center mb-40 md:mb-32 lg:mb-32" style="background-image: url('{{ asset(str_replace('public/', 'storage/', $event->photo)) }}'); height: 650px">
    <div class="container mx-auto px-4 h-full flex items-end">
        <div class="px-10 py-10 w-full rounded-[20px] transform translate-y-1/2" style="background-color: {{ $block->background_color }};">
            <div class="md:flex">
                <div class="md:w-1/2 md:pr-4">
                    <h3 id="date-{{ $block->id }}" class="text-[16px] md:text-[18px] lg:text-[18px]" style="color: {{ $block->subtitle_color }}"></h3>
                    <h1 id="title-{{ $block->id }}" class="text-[19px] my-[10px] font-bold text-white w-full" style="color: {{ $block->title_color }}"></h1>
                    <span id="time-{{ $block->id }}" class="text-white text-[12px] md:text-[14px] lg:text-[14px] one-line-text w-full" style="color: {{ $block->content_color }}"></span>
                    <span id="local-{{ $block->id }}" class="text-white text-[12px] md:text-[14px] lg:text-[14px] one-line-text w-full" style="color: {{ $block->content_color }}"></span>
                </div>
                <div class="flex justify-center align-center flex-col md:w-1/2 md:pl-4 md:mt-0 mt-4">
                    <span id="content-{{ $block->id }}" class="text-[12px] md:text-[14px] lg:text-[14px] font-light w-full two-line-text" style="color: {{ $block->content_color }}"></span>
                    <div class="flex items-end justify-between mt-8">
                        <a id="button-link-{{ $block->id }}" href="#" class="py-4 px-8 block-button-title text-center font-semibold leading-none hover:opacity-70 rounded" style="color: {{ $block->button_title_color }}; background-color: {{ $block->button_color }}">Saiba mais</a>
                        <div class="flex">
                            <button id="button-prev-{{ $block->id }}" class="flex justify-center align-center border-2 px-[14px] py-[10px] rounded-[8px] group me-[15px]" style="border-color: {{ $block->button_color }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 15 24" style="fill: {{ $block->button_color }}">
                                    <path d="M15.4561 2.544L6.00006 12L15.4561 21.456L12.9121 24L0.912056 12L12.9121 0L15.4561 2.544Z"/>
                                </svg>
                            </button>
                            <button id="button-next-{{ $block->id }}" class="flex justify-center align-center border-2 px-[14px] py-[10px] rounded-[8px] group" style="border-color: {{ $block->button_color }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 15 24" style="fill: {{ $block->button_color }}">
                                    <path d="M0.456055 2.544L9.91205 12L0.456055 21.456L3.00005 24L15.0001 12L3.00005 0L0.456055 2.544Z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script>
        let currentIndex = 0;
        const events = @json($events);
        const blockId = '{{ $block->id }}';

        function updateEvent(index) {
            const event = events[index];
            const timeElement = document.getElementById('time-' + blockId);
            const localElement = document.getElementById('local-' + blockId);
            const contentElement = document.getElementById('content-' + blockId);
            const bgImageElement = document.getElementById('section_{{ $i }}');

            let dateText = new Date(event.date).toLocaleDateString('pt-BR');
            if (event.end_date) {
                dateText += ' - ' + new Date(event.end_date).toLocaleDateString('pt-BR');
            }

            document.getElementById('date-' + blockId).innerText = dateText;
            document.getElementById('title-' + blockId).innerText = event.title;

            if (event.time) {
                timeElement.innerText = 'Horário: ' + event.time;
                timeElement.style.display = 'block';
            } else {
                timeElement.style.display = 'none';
            }

            if (event.local) {
                localElement.innerText = 'Local: ' + event.local;
                localElement.style.display = 'block';
            } else {
                localElement.style.display = 'none';
            }

            contentElement.innerHTML = event.description;

            bgImageElement.style.backgroundImage = "url('" + '{{asset('')}}' + (event.photo ? event.photo.replace('public/', 'storage/') : '') + "')";

            const buttonLink = document.getElementById('button-link-' + blockId);
            buttonLink.href = '{{ route('events.show', '_SLUG_') }}'.replace('_SLUG_', event.slug);
            buttonLink.style.display = 'block';
        }

        document.getElementById('button-next-' + blockId).addEventListener('click', function() {
            currentIndex = (currentIndex + 1) % events.length;
            updateEvent(currentIndex);
        });

        document.getElementById('button-prev-' + blockId).addEventListener('click', function() {
            currentIndex = (currentIndex - 1 + events.length) % events.length;
            updateEvent(currentIndex);
        });

        // Initialize with the first event
        updateEvent(currentIndex);

        // Automatic slide change every 8 seconds
        setInterval(function() {
            currentIndex = (currentIndex + 1) % events.length;
            updateEvent(currentIndex);
        }, 8000); // Interval increased to match transition duration

        window.addEventListener('resize', function() {
            updateEvent(currentIndex);
        });
    </script>
@endpush

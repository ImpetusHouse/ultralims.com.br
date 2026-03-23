@push('head')
    <style>
        .tab-content-{{ $block->id }} {
            visibility: hidden;
            opacity: 0;
            height: 0;
            overflow: hidden;
            transition: opacity 0.5s ease-in-out, visibility 0.5s ease-in-out, height 0.5s ease-in-out;
        }

        .tab-content-{{ $block->id }}.active {
            visibility: visible;
            opacity: 1;
            height: auto;
        }
    </style>
@endpush
<section id="section_{{ $i }}" class="overflow-hidden relative" style="background-color: {{ $block->background_color }}; padding-bottom: {{ $block->margin_bottom }}px; padding-top: {{ $block->margin_top }}px">
    @foreach($block->tabs->sortBy('tab') as $index => $tab)
        @push('head')
            @include('site.inc.styles.fonts', ['block' => $block, 'tab' => $tab])
        @endpush
        <div class="tab-content-{{ $block->id }} {{ $loop->first ? 'active' : '' }}" data-tab-index="{{ $index }}">
            <img class="absolute bottom-0 right-0" src="{{ asset($tab->image) }}" alt="{{ $tab->title }}">
            <div class="container mx-auto">
                <div class="relative">
                    <div class="container px-4 mx-auto pt-24 pb-20">
                        <div class="max-w-sm sm:max-w-md lg:max-w-lg">
                            <h2 class="font-black font-heading mb-8">
                                <span class="block-title-{{ $block->id }}-{{ $tab->id }}" style="color: {!! $tab->title_color !!}">{{ $tab->title }}</span>@if($tab->subtitle)<span class="block-subtitle-{{ $block->id }}-{{ $tab->id }}" style="color: {!! $tab->subtitle_color !!}">&nbsp;{{ $tab->subtitle }}</span>@endif
                            </h2>
                            <div class="max-w-sm lg:max-w-md block-description-{{$block->id}}-{{ $tab->id }} {{ $tab->button_display || $tab->button_display_1 ? 'mb-8':"" }}" style="color: {!! $block->content_color !!} !important;">
                                {!! $tab->content !!}
                            </div>
                            @if($tab->button_display || $tab->button_display_1)
                                <div class="flex items-center flex-wrap gap-6 {{ $block->tabs->count() > 1 ? 'mb-24' : '' }}">
                                    @if($tab->button_display)
                                        @include('site.inc.buttons.layout_1', ['item' => $tab])
                                    @endif
                                    @if($tab->button_display_1)
                                        @include('site.inc.buttons.layout_text_2', ['item' => $tab])
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @if($block->tabs->count() > 1)
        <div class="container mx-auto">
            <div class="relative">
                <div class="container px-4 mx-auto">
                    <div class="max-w-sm sm:max-w-md lg:max-w-xl">
                        <div class="flex gap-2" id="tabs-indicators-{{ $block->id }}">
                            @foreach($block->tabs as $index => $tab)
                                <svg data-tab-index="{{ $index }}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="tab-indicator @if($loop->first) active @endif cursor-pointer">
                                    <circle cx="8.00033" cy="7.99999" r="5.33333" @if($loop->first) fill="{{ $block->primary_color }}" @endif stroke="#6F7792" stroke-width="0.666667"></circle>
                                </svg>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabContents = document.querySelectorAll('.tab-content-{{ $block->id }}');
            const indicators = document.querySelectorAll('.tab-indicator');
            let currentIndex = 0;
            let interval;

            function showTab(index) {
                // Atualizar a aba ativa
                tabContents.forEach((content, i) => {
                    if (i === index) {
                        content.classList.add('active');
                    } else {
                        content.classList.remove('active');
                    }
                });

                // Atualizar os indicadores
                indicators.forEach((ind, i) => {
                    const circle = ind.querySelector('circle');
                    if (i === index) {
                        circle.setAttribute('fill', '{{ $block->primary_color }}');
                    } else {
                        circle.removeAttribute('fill');
                    }
                });
            }

            function nextTab() {
                currentIndex = (currentIndex + 1) % tabContents.length;
                showTab(currentIndex);
            }

            function resetInterval() {
                clearInterval(interval);
                interval = setInterval(nextTab, 8000);
            }

            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentIndex = index;
                    showTab(index);
                    resetInterval();  // Reiniciar o intervalo ao trocar manualmente
                });
            });

            // Iniciar o intervalo pela primeira vez
            interval = setInterval(nextTab, 8000);
        });
    </script>
@endpush

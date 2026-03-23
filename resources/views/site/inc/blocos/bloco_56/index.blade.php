@php
    /** @var TYPE_NAME $block */
    $svg = '
        <svg class="mr-2 w-6 h-6 text-green-400" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
    ';
    $block->content = str_replace('<li>', '<li class="flex mb-4">'.$svg, $block->content);
@endphp
@push('head')
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
    <style>
        #input-{{ $block->id }}{
            background-color: {{ $block->tag_color }};
            color: {{ $block->pdf_color }};
            --tw-border-opacity: 1;
            border-color: {{ $block->pdf_color }};
        }
        #input-{{ $block->id }}::placeholder {
            --tw-placeholder-opacity: 1;
            color: {{ $block->pdf_color }};
        }
        #input-{{ $block->id }}:focus{
            --tw-ring-opacity: 1;
            --tw-ring-color: rgb(96 167 170 / var(--tw-ring-opacity))
        }
        .loading-icon {
            display: none;
        }
        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 4px solid #fff;
            width: 20px;
            height: 20px;
            -webkit-animation: spin 1s linear infinite;
            animation: spin 1s linear infinite;
        }
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endpush
<section id="section_{{ $i }}" style="background-color: {{ $block->background_color }};">
    <div class="relative" style="padding-bottom: {{ $block->margin_bottom }}px; padding-top: {{ $block->margin_top }}px">
        @if($block->tabs->where('tab')->first()->display_content)
            <div class="hidden lg:block absolute inset-0 w-full h-full" style="background-image: url('{{ asset($block->image) }}'); background-size: cover; z-index: 0"></div>
        @endif
        <div class="relative container mx-auto px-4" style="z-index: 1">
            <div class="flex flex-wrap items-center">
                @for($i = 1; $i <= 2; $i++)
                    @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                        <div class="hidden md:flex w-full lg:w-1/2 flex-wrap md:-mx-4">
                            <div class="mb-8 lg:mb-0 w-full md:w-1/2 md:px-4">
                                @php $tab = $block->tabs->where('tab', 1)->first(); @endphp
                                <div class="mb-8 py-6 pl-6 pr-4 shadow-md rounded" style="background-color: {{ $tab->background_color }}">
                                    <span class="mb-4 inline-block p-3 rounded-lg" style="background-color: {{ $tab->icon_color }}">
                                        <img class="w-10 h-10" src="{{ asset($tab->image) }}"/>
                                    </span>
                                    <h4 class="mb-2 text-2xl font-bold font-heading" style="color: {{ $tab->title_color }}">{{ $tab->title }}</h4>
                                    <p style="color: {{ $tab->subtitle_color }}">{{ $tab->subtitle }}</p>
                                </div>
                                @php $tab = $block->tabs->where('tab', 2)->first(); @endphp
                                <div class="py-6 pl-6 pr-4 shadow-md rounded" style="background-color: {{ $tab->background_color }}">
                                    <span class="mb-4 inline-block p-3 rounded-lg" style="background-color: {{ $tab->icon_color }}">
                                        <img class="w-10 h-10" src="{{ asset($tab->image) }}"/>
                                    </span>
                                    <h4 class="mb-2 text-2xl font-bold font-heading" style="color: {{ $tab->title_color }}">{{ $tab->title }}</h4>
                                    <p style="color: {{ $tab->subtitle_color }}">{{ $tab->subtitle }}</p>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 lg:mt-20 md:px-4">
                                @php $tab = $block->tabs->where('tab', 3)->first(); @endphp
                                <div class="mb-8 py-6 pl-6 pr-4 shadow-md rounded-lg" style="background-color: {{ $tab->background_color }}">
                                    <span class="mb-4 inline-block p-3 rounded-lg" style="background-color: {{ $tab->icon_color }}">
                                        <img class="w-10 h-10" src="{{ asset($tab->image) }}"/>
                                    </span>
                                    <h4 class="mb-2 text-2xl font-bold font-heading" style="color: {{ $tab->title_color }}">{{ $tab->title }}</h4>
                                    <p style="color: {{ $tab->subtitle_color }}">{{ $tab->subtitle }}</p>
                                </div>
                                @php $tab = $block->tabs->where('tab', 4)->first(); @endphp
                                <div class="py-6 pl-6 pr-4 shadow-md rounded-lg" style="background-color: {{ $tab->background_color }}">
                                    <span class="mb-4 inline-block p-3 rounded-lg" style="background-color: {{ $tab->icon_color }}">
                                        <img class="w-10 h-10" src="{{ asset($tab->image) }}"/>
                                    </span>
                                    <h4 class="mb-2 text-2xl font-bold font-heading" style="color: {{ $tab->title_color }}">{{ $tab->title }}</h4>
                                    <p style="color: {{ $tab->subtitle_color }}">{{ $tab->subtitle }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="w-full lg:w-1/2">
                            <div class="lg:mx-auto">
                                @if($block->tag)
                                    <span class="font-bold" style="color: {{ $block->tag_title_color }}">{{ $block->tag }}</span>
                                @endif
                                <h2 class="font-black font-heading mb-4 mr:0 lg:mr-6">
                                    <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">&nbsp;{{ $block->subtitle }}</span>@endif
                                </h2>
                                <p class="block-description-{{ $block->id }} mb-12 mr:0 lg:mr-6" style="color: {{ $block->content_color }}">{!! $block->content !!}</p>
                                <div class="flex flex-wrap items-center justify-items-center">
                                    @if($block->button_display)
                                        <div class="flex flex-wrap items-center w-full lg:w-auto mr:0 lg:mr-6 mb-8 lg:mb-0">
                                            @include('site.inc.buttons.layout_'.$block->type, ['item' => $block, 'wfull' => 'w-full'])
                                        </div>
                                    @endif
                                    <div class="w-full lg:w-auto relative">
                                        <svg onclick="searchAnalysisGroups($('#input-{{ $block->id }}').val())"
                                             class="absolute transform -translate-y-1/2 cursor-pointer"
                                             width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                             style="top: 50%; right: 1rem; color: {{ $block->pdf_color }}">
                                            <path d="M21.07 16.83L19 14.71C18.5547 14.2868 17.9931 14.0063 17.3872 13.9047C16.7814 13.8032 16.159 13.8851 15.6 14.14L14.7 13.24C15.7606 11.8229 16.2449 10.0567 16.0555 8.29684C15.8662 6.537 15.0172 4.91423 13.6794 3.7552C12.3417 2.59618 10.6145 1.98696 8.84567 2.05019C7.0768 2.11341 5.39755 2.84439 4.14597 4.09597C2.8944 5.34755 2.16342 7.0268 2.10019 8.79567C2.03696 10.5645 2.64618 12.2917 3.80521 13.6294C4.96423 14.9672 6.587 15.8162 8.34684 16.0055C10.1067 16.1949 11.8729 15.7106 13.29 14.65L14.18 15.54C13.8951 16.0996 13.793 16.7346 13.8881 17.3553C13.9832 17.9761 14.2706 18.5513 14.71 19L16.83 21.12C17.3925 21.6818 18.155 21.9974 18.95 21.9974C19.745 21.9974 20.5075 21.6818 21.07 21.12C21.3557 20.8406 21.5828 20.5069 21.7378 20.1386C21.8928 19.7702 21.9726 19.3746 21.9726 18.975C21.9726 18.5754 21.8928 18.1798 21.7378 17.8114C21.5828 17.4431 21.3557 17.1094 21.07 16.83V16.83ZM12.59 12.59C11.8902 13.288 10.9993 13.763 10.0297 13.9549C9.06019 14.1468 8.0555 14.047 7.14261 13.6682C6.22971 13.2894 5.44957 12.6485 4.90072 11.8265C4.35187 11.0046 4.05894 10.0384 4.05894 9.05C4.05894 8.06163 4.35187 7.09544 4.90072 6.27347C5.44957 5.45149 6.22971 4.81062 7.14261 4.43182C8.0555 4.05301 9.06019 3.95325 10.0297 4.14515C10.9993 4.33706 11.8902 4.812 12.59 5.51C13.0556 5.97446 13.4251 6.52621 13.6771 7.13367C13.9292 7.74112 14.0589 8.39233 14.0589 9.05C14.0589 9.70768 13.9292 10.3589 13.6771 10.9663C13.4251 11.5738 13.0556 12.1255 12.59 12.59V12.59ZM19.66 19.66C19.567 19.7537 19.4564 19.8281 19.3346 19.8789C19.2127 19.9297 19.082 19.9558 18.95 19.9558C18.818 19.9558 18.6873 19.9297 18.5654 19.8789C18.4436 19.8281 18.333 19.7537 18.24 19.66L16.12 17.54C16.0263 17.447 15.9519 17.3364 15.9011 17.2146C15.8503 17.0927 15.8242 16.962 15.8242 16.83C15.8242 16.698 15.8503 16.5673 15.9011 16.4454C15.9519 16.3236 16.0263 16.213 16.12 16.12C16.213 16.0263 16.3236 15.9519 16.4454 15.9011C16.5673 15.8503 16.698 15.8242 16.83 15.8242C16.962 15.8242 17.0927 15.8503 17.2146 15.9011C17.3364 15.9519 17.447 16.0263 17.54 16.12L19.66 18.24C19.7537 18.333 19.8281 18.4436 19.8789 18.5654C19.9297 18.6873 19.9558 18.818 19.9558 18.95C19.9558 19.082 19.9297 19.2127 19.8789 19.3346C19.8281 19.4564 19.7537 19.567 19.66 19.66V19.66Z" fill="currentColor"/>
                                        </svg>
                                        <input id="input-{{ $block->id }}" name="search" value="{{ $_GET['search'] ?? '' }}" class="w-full h-full py-4 pl-4 pr-12 leading-tight border rounded-lg shadow-xsm focus:outline-none focus:ring-2 focus:ring-opacity-50" type="text" placeholder="Procurar análise" onkeypress="handleKeyPress(event)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </div>
    <div style="background-color: white;">
        <div class="container mx-auto px-4" style="display: none; padding-bottom: 2rem; padding-top: 2rem">
            <div class="text-[#293F57] text-lg mb-4">
                <span id="total-{{$block->id}}" class="font-black"></span> resultados encontrados
            </div>
            <div id="results-{{ $block->id }}"></div>
            <a id="load-more-{{ $block->id }}" class="flex items-center justify-center py-2 px-4 mx-auto text-sm leading-5 text-white font-medium hover:opacity-70 md:max-w-max rounded-xl load-more" href="javascript:void(0);" data-page="2" style="background-color: {{ env('PRIMARY_COLOR') }}">
                <span class="mr-3">Ver mais</span>
                <span class="loading-icon">
                    <div class="spinner"></div>
                </span>
                <svg class="arrow-icon text-green-50" width="12" height="10" viewbox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7583 4.40833C10.6809 4.33023 10.5887 4.26823 10.4871 4.22592C10.3856 4.18362 10.2767 4.16183 10.1667 4.16183C10.0567 4.16183 9.94773 4.18362 9.84619 4.22592C9.74464 4.26823 9.65247 4.33023 9.575 4.40833L6.83333 7.15833V0.833333C6.83333 0.61232 6.74554 0.400358 6.58926 0.244078C6.43297 0.0877975 6.22101 0 6 0C5.77899 0 5.56702 0.0877975 5.41074 0.244078C5.25446 0.400358 5.16667 0.61232 5.16667 0.833333V7.15833L2.425 4.40833C2.26808 4.25141 2.05525 4.16326 1.83333 4.16326C1.61141 4.16326 1.39859 4.25141 1.24167 4.40833C1.08475 4.56525 0.99659 4.77808 0.99659 5C0.99659 5.22192 1.08475 5.43475 1.24167 5.59167L5.40833 9.75833C5.48759 9.8342 5.58104 9.89367 5.68333 9.93333C5.78308 9.97742 5.89094 10.0002 6 10.0002C6.10906 10.0002 6.21692 9.97742 6.31667 9.93333C6.41896 9.89367 6.51241 9.8342 6.59167 9.75833L10.7583 5.59167C10.8364 5.5142 10.8984 5.42203 10.9407 5.32048C10.9831 5.21893 11.0048 5.11001 11.0048 5C11.0048 4.88999 10.9831 4.78107 10.9407 4.67952C10.8984 4.57797 10.8364 4.4858 10.7583 4.40833Z" fill="currentColor"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
@push('scripts')
    <script>
        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                const inputElement = document.getElementById('input-{{ $block->id }}');
                const inputVal = inputElement.value;
                searchAnalysisGroups(inputVal);
                inputElement.blur(); // Remove o foco do campo de entrada
            }
        }
        function searchAnalysisGroups(search){
            $.ajax({
                type: "GET",
                url: '{{ route('prolab.analysisgroups') }}',
                data: {
                    search: search,
                    page_id: '{{ $block->page_id }}'
                },
                success: function(data) {
                    if (data.success){
                        if (data.count > 0){
                            $('#total-{{ $block->id }}').html(data.total);
                            $('#results-{{ $block->id }}').html(data.html)
                            $('#results-{{ $block->id }}').parent().fadeIn(200);
                            if (data.count === 10){
                                $('#load-more-{{ $block->id }}').fadeIn(200).attr('data-page', 2);
                            }else{
                                $('#load-more-{{ $block->id }}').fadeOut(200).removeAttr('data-page');
                            }

                            var windowHeight = $(window).height();
                            var divTop = $('#total-{{ $block->id }}').offset().top;
                            var scrollPosition = divTop - (windowHeight / 2);
                            $('html, body').animate({scrollTop: scrollPosition}, 'slow');
                        }else{
                            $('#results-{{ $block->id }}').parent().fadeOut(200);
                            $('#load-more-{{ $block->id }}').fadeOut(200).removeAttr('data-page');
                        }
                    }else{
                        $('#results-{{ $block->id }}').parent().fadeOut(200);
                        $('#load-more-{{ $block->id }}').fadeOut(200).removeAttr('data-page');
                    }
                },
                error: function(xhr, status, error) {
                    $('#results-{{ $block->id }}').parent().fadeOut(200);
                    $('#load-more-{{ $block->id }}').fadeOut(200).data('page', null);
                }
            });
        }
        function buildLoadMoreUrl(page) {
            const currentUrl = new URL(window.location.href);
            const params = new URLSearchParams(currentUrl.search);
            // Atualiza o parâmetro da página para a próxima página
            params.set('page', page);
            params.set('page_id', {{ $block->page_id }});
            // Constrói a nova URL com os parâmetros atualizados
            return `{{ route('prolab.analysisgroups') }}?${params.toString()}`;
        }
        $('#load-more-{{ $block->id }}').click(function() {
            var page = $(this).attr('data-page');
            var loadMoreUrl = buildLoadMoreUrl(page);

            var btn = $(this);
            var loadingIcon = btn.find('.loading-icon');
            var arrowIcon = btn.find('.arrow-icon');

            loadingIcon.show();
            arrowIcon.hide();

            $.ajax({
                url: loadMoreUrl,
                type: 'GET',
                data: {
                    search: $('#input-{{ $block->id }}').val()
                },
                success: function(data) {
                    if (data.success){
                        if (data.count > 0){
                            $('#results-{{ $block->id }}').append(data.html)
                            if (data.count === 10){
                                $('#load-more-{{ $block->id }}').fadeIn(200).attr('data-page', parseInt(page) + 1);
                            }else{
                                $('#load-more-{{ $block->id }}').fadeOut(200).removeAttr('data-page');
                            }
                        }else{
                            $('#load-more-{{ $block->id }}').fadeOut(200).removeAttr('data-page');
                        }
                    }
                    loadingIcon.hide();
                    arrowIcon.show();
                },
                error: function (){
                    loadingIcon.hide();
                    arrowIcon.show();
                }
            });
        });
    </script>
@endpush

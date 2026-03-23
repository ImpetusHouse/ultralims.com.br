@extends('site.pages.ultralims.layout')
@push('head')
    <style>
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
        .wpp-button{
            display: none;
        }
    </style>
@endpush
@section('content')
    @include('site.inc.breadcrumb', ['breadcrumbs' => generateBreadcrumbs()])
    <section class="py-12 md:py-24" x-data="{ activeTab: 1 }">
        <div class="container px-4 mx-auto">
            <div class="max-w-lg mx-auto lg:max-w-6xl">
                <div class="flex flex-wrap mb-8 -mx-4">
                    <div class="w-full lg:w-1/2 p-4">
                        <div class="lg:max-w-md mb-6">
                            <img class="block w-full rounded-xl" src="{{ asset(str_replace('public/', 'storage/', $product->photo)) }}" alt="{{ $product->title }}">
                        </div>
                        <div class="lg:max-w-md flex -mx-2 flex-wrap">
                            <div class="w-9/12 md:w-10/12 px-2">
                                <a class="flex w-full px-3 py-4 rounded-lg text-center items-center justify-center text-white text-sm font-medium bg-[#01aef0] hover:bg-[#018bc0] transition duration-200"
                                   href="javascript:void(0);"
                                   id="eu-quero">
                                    <span class="mr-3">Eu quero</span>
                                    <span class="loading-icon">
                                            <div class="spinner"></div>
                                        </span>
                                </a>
                            </div>
                            <div class="w-3/12 md:w-2/12 px-2">
                                <a class="py-4 px-6 inline-flex items-center justify-center rounded-lg border-[#01aef0] {{ $wishlist == null ? 'text-[#01aef0] hover:bg-[#01aef0] hover:text-white':'bg-[#01aef0] hover:bg-white text-white hover:text-[#01aef0]' }} border transition duration-200"
                                   href="javascript:void(0);"
                                   id="wishlist">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewbox="0 0 16 17" fill="none">
                                        <g clip-path="url(#clip0_1925_4216)">
                                            <path d="M14.1942 3.24105C13.8537 2.90039 13.4494 2.63015 13.0045 2.44578C12.5595 2.2614 12.0826 2.1665 11.6009 2.1665C11.1192 2.1665 10.6423 2.2614 10.1973 2.44578C9.75236 2.63015 9.34807 2.90039 9.00757 3.24105L8.3009 3.94772L7.59423 3.24105C6.90644 2.55326 5.97359 2.16686 5.0009 2.16686C4.02821 2.16686 3.09536 2.55326 2.40757 3.24105C1.71977 3.92885 1.33337 4.8617 1.33337 5.83439C1.33337 6.80708 1.71977 7.73993 2.40757 8.42772L3.11423 9.13439L8.3009 14.3211L13.4876 9.13439L14.1942 8.42772C14.5349 8.08722 14.8051 7.68293 14.9895 7.23796C15.1739 6.79298 15.2688 6.31605 15.2688 5.83439C15.2688 5.35273 15.1739 4.87579 14.9895 4.43082C14.8051 3.98584 14.5349 3.58156 14.1942 3.24105V3.24105Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                        <defs>
                                            <clippath id="clip0_1925_4216">
                                                <rect width="16" height="16" fill="white" transform="translate(0 0.166504)"></rect>
                                            </clippath>
                                        </defs>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2 p-4">
                        <div class="max-w-lg lg:ml-auto">
                            <h1 class="text-[#0E1326] block-title font-black font-heading mb-2">{{ $product->title }}</h1>
                            <div class="block-description">{!! nl2br($product->description) !!}</div>
                        </div>
                    </div>
                </div>
                @if($product->benefits)
                    <div class="flex flex-wrap w-full mb-8">
                        {{--
                         <a class="group" href="#" x-on:click.prevent="activeTab = 1">
                             <p class="whitespace-nowrap block mb-4 text-sm px-4 pt-4 font-bold transition duration-200 text-[#0E1326] group-hover:text-rhino-700" :class="{'text-[#0E1326] group-hover:text-rhino-[#0E1326]': activeTab == 1, 'text-[#0E1326] group-hover:text-[#0E1326]': activeTab != 1}">
                                 Descrição
                             </p>
                             <div class="w-full h-px bg-[#01aef0] group-hover:bg-[#01aef0] transition duration-200" :class="{'bg-[#01aef0]': activeTab == 1, 'bg-gray-300': activeTab != 1}"></div>
                         </a>
                         --}}
                        @if($product->benefits)
                            <a class="group" href="#" x-on:click.prevent="activeTab = 2">
                                <p class="whitespace-nowrap block mb-4 text-sm px-4 pt-4 font-bold transition duration-200 text-[#0E1326] group-hover:text-rhino-700" :class="{'text-[#0E1326] group-hover:text-rhino-[#0E1326]': activeTab == 2, 'text-[#0E1326] group-hover:text-[#0E1326]': activeTab != 2}">
                                    Vantagens
                                </p>
                                <div class="w-full h-px bg-gray-300 group-hover:bg-[#01aef0] transition duration-200" :class="{'bg-[#01aef0]': activeTab == 2, 'bg-gray-300': activeTab != 2}"></div>
                            </a>
                        @endif
                        <div class="flex-1">
                            <div class="w-full h-full border-b border-gray-300"></div>
                        </div>
                    </div>
                    {{--
                    <div :class="{'block': activeTab == 1, 'hidden': activeTab != 1}">
                        <div class="block-description">{!! nl2br($product->description) !!}</div>
                    </div>
                    --}}
                    <div :class="{'block': activeTab == 2, 'hidden': activeTab != 2}">
                        <div class="block-description">{!! nl2br($product->benefits) !!}</div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
    <script>
        $('#eu-quero').click(function() {
            var btn = $(this);
            var loadingIcon = btn.find('.loading-icon');

            loadingIcon.show();
            $.ajax({
                url: '{{ route('ultralims.produtos.quero', $product->slug) }}',
                type: 'GET',
                success: function(data) {
                    loadingIcon.hide();
                    if (data.success){
                        Swal.fire('Sucesso', 'Sucesso ao demonstrar interesse em adquirir produto', 'success').then(function (){
                            location.reload();
                        });
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function (){
                    loadingIcon.hide();
                    Swal.fire('Erro', 'Falha, tente novamente', 'error');
                }
            });
        });
        $('#wishlist').click(function (){
            $.ajax({
                url: '{{ route('ultralims.produtos.wishlist', $product->slug) }}',
                type: 'GET',
                success: function(data) {
                    if (data.success){
                        location.reload();
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function (){
                    Swal.fire('Erro', 'Falha ao adicionar produto a lista de desejo, tente novamente', 'error');
                }
            });
        })
    </script>
    {{-- RocketChat --}}
    @if(Auth::guard('ultralims')->user() != null && Auth::guard('ultralims')->user()->chat)
        <script type="text/javascript">
            (function(w, d, s, u) {
                w.RocketChat = function(c) { w.RocketChat._.push(c) }; w.RocketChat._ = []; w.RocketChat.url = u;
                var h = d.getElementsByTagName(s)[0], j = d.createElement(s);
                j.async = true; j.src = 'https://atendimento.ultralims.com.br/livechat/rocketchat-livechat.min.js?_=201903270000';
                h.parentNode.insertBefore(j, h);
            })(window, document, 'script', 'https://atendimento.ultralims.com.br/livechat');
        </script>
    @endif
@endpush

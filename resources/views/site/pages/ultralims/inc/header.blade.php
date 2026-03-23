<style>
    .menu-item {
        color: #FFF;
    }
    .menu-item:hover {
        color: #03B7FC !important;
        border-color: #03B7FC !important;
    }

    .menu-arrow {
        transition: transform 0.3s ease;
    }

    .menu-arrow.rotate {
        transform: rotate(180deg);
    }

    /* Estilo padrão do submenu, oculto */
    .submenu {
        display: none;
        position: absolute;
        /* Outros estilos necessários para o posicionamento e a aparência */
    }

    /* Mostrar o submenu quando o pai é focado com o mouse */
    .menu-item:hover + .submenu,
    .menu-item:focus + .submenu,
    .submenu:hover {
        display: block;
    }
</style>
@php
    if(Auth::guard('ultralims')->user() != null){
        $url = Auth::guard('ultralims')->user()->urlRedirect;
    }else{
        $url = 'javascript:void(0);';
    }
@endphp
<header style="background-color: #0E1326; position: fixed; top: 0; width: 100%; z-index: 1000;">
    <div class="container px-4 mx-auto">
        <nav class="flex items-center py-4">
            <a class="text-3xl font-semibold leading-none" href="/">
                <img style="height: 3rem" src="{{ asset('images/logos/Ultra Lims.png') }}" alt="{{ env('APP_NAME') }}" width="auto">
            </a>
            <div class="lg:hidden ml-auto">
                <button class="navbar-burger flex items-center py-2 px-3 border rounded menu-item" style="color: #FFFFFF; border-color: #FFFFFF">
                    <svg class="fill-current h-4 w-4" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Mobile menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                    </svg>
                </button>
            </div>
            <ul class="hidden lg:flex items-center space-x-8 ml-auto">
                <li>
                    <a class="text-sm font-bold menu-item menu-bg" href="/">Site</a>
                </li>
                <li>
                    <a class="text-sm font-bold menu-item menu-bg" href="{{ route('ultralims.produtos') }}">Plugins Ultra LIMS</a>
                </li>
                <li>
                    <a class="text-sm font-bold menu-item menu-bg" onclick="openCodex()" href="javascript:void(0)">Codex</a>
                </li>
                <li class="relative">
                    <span class="text-sm font-bold menu-item inline-block cursor-pointer menu-bg">
                        Soluções LIMS
                    </span>
                    <div class="submenu absolute hidden rounded-lg" style="background-color: #0E1326; width: 10rem">
                        <ul class="py-1">
                            <li>
                                <a class="block px-4 py-3 text-xs font-semibold menu-item menu-bg" href="https://ultralims.com.br/produtos/ultra-enterprise">Ultra Enterprise</a>
                            </li>
                            <li>
                                <a class="block px-4 py-3 text-xs font-semibold menu-item menu-bg" href="https://ultralims.com.br/produtos/ultra-one">Ultra One</a>
                            </li>
                            <li>
                                <a class="block px-4 py-3 text-xs font-semibold menu-item menu-bg" href="https://ultralims.com.br/produtos/ultra-industrias-40">Ultra Indústria 4.0</a>
                            </li>
                            <li>
                                <a class="block px-4 py-3 text-xs font-semibold menu-item menu-bg" href="https://ultralims.com.br/produtos/ultra-consult">Ultra Consult</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="inline-block px-4 py-3 text-xs font-semibold leading-none hover:opacity-70 rounded" href="{{ route('ultralims.alerts.index') }}"
                       style="color: #FFFFFF; background-color: #ff4f3f">
                        Comunicados
                    </a>
                </li>
                <li>
                    <a class="inline-block px-4 py-3 text-xs font-semibold leading-none hover:opacity-70 rounded" href="{{ $url }}" style="color: #FFFFFF; background-color: #03B7FC" target="_blank">
                        Ir para o Ultra LIMS
                    </a>
                </li>
                @if(Auth::guard('ultralims')->user() != null)
                    <li class="flex items-center">
                        <div class="flex flex-wrap text-white font-bold">
                            <div class="mr-2">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.9529 15.3106C20.7062 14.6585 21.3104 13.8521 21.7245 12.9459C22.1386 12.0398 22.353 11.0551 22.3529 10.0588C22.3529 8.18671 21.6092 6.39127 20.2855 5.06748C18.9617 3.7437 17.1662 3 15.2941 3C13.422 3 11.6266 3.7437 10.3028 5.06748C8.97899 6.39127 8.23529 8.18671 8.23529 10.0588C8.23528 11.0551 8.4496 12.0398 8.86371 12.9459C9.27781 13.8521 9.88201 14.6585 10.6353 15.3106C8.65902 16.2055 6.9823 17.6506 5.80562 19.4732C4.62893 21.2958 4.00208 23.4188 4 25.5882C4 25.9627 4.14874 26.3217 4.4135 26.5865C4.67825 26.8513 5.03734 27 5.41176 27C5.78619 27 6.14528 26.8513 6.41003 26.5865C6.67479 26.3217 6.82353 25.9627 6.82353 25.5882C6.82353 23.3417 7.71596 21.1872 9.30451 19.5986C10.8931 18.0101 13.0476 17.1176 15.2941 17.1176C17.5407 17.1176 19.6952 18.0101 21.2837 19.5986C22.8723 21.1872 23.7647 23.3417 23.7647 25.5882C23.7647 25.9627 23.9134 26.3217 24.1782 26.5865C24.443 26.8513 24.8021 27 25.1765 27C25.5509 27 25.91 26.8513 26.1747 26.5865C26.4395 26.3217 26.5882 25.9627 26.5882 25.5882C26.5862 23.4188 25.9593 21.2958 24.7826 19.4732C23.6059 17.6506 21.9292 16.2055 19.9529 15.3106ZM15.2941 14.2941C14.4565 14.2941 13.6376 14.0457 12.9411 13.5803C12.2446 13.115 11.7018 12.4535 11.3812 11.6796C11.0607 10.9057 10.9768 10.0541 11.1402 9.23256C11.3036 8.41099 11.707 7.65634 12.2993 7.06402C12.8916 6.4717 13.6463 6.06833 14.4679 5.90491C15.2894 5.74149 16.141 5.82536 16.9149 6.14592C17.6888 6.46648 18.3503 7.00933 18.8156 7.70582C19.281 8.40231 19.5294 9.22116 19.5294 10.0588C19.5294 11.1821 19.0832 12.2594 18.2889 13.0536C17.4947 13.8479 16.4174 14.2941 15.2941 14.2941Z" fill="white"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs">
                                    Olá, {{ Auth::guard('ultralims')->user()->user }}
                                </div>
                                <div class="text-[0.65rem]">
                                    {{ Auth::guard('ultralims')->user()->laboratorio }}
                                </div>
                            </div>
                        </div>
                    </li>
                @endif
            </ul>
        </nav>
    </div>

    <div class="hidden navbar-menu fixed top-0 left-0 bottom-0 w-5/6 max-w-sm z-50">
        <div class="navbar-backdrop fixed inset-0 bg-blueGray-800 opacity-25"></div>
        <nav class="relative flex flex-col py-6 px-6 w-full h-full overflow-y-auto" style="background-color: #0E1326">
            <div class="flex items-center mb-8">
                <a class="mr-auto text-3xl font-semibold leading-none" href="/">
                    <img class="h-13" src="{{ asset('images/logos/Ultra Lims.png') }}" alt="{{ env('APP_NAME') }}" width="auto">
                </a>
                <button class="navbar-close menu-item" style="color: #FFFFFF">
                    <svg class="h-6 w-6 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div>
                <ul>
                    <li class="mb-1">
                        <a class="block p-4 text-sm font-bold menu-item" href="/">Site</a>
                    </li>
                    <li class="mb-1">
                        <a class="block p-4 text-sm font-bold menu-item" href="{{ route('ultralims.produtos') }}">Loja</a>
                    </li>
                    <li class="mb-1">
                        <a class="block p-4 text-sm font-bold menu-item" onclick="openCodex()" href="javascript:void(0)">Codex</a>
                    </li>
                    <span class="flex justify-between items-center p-4 text-sm font-semibold cursor-pointer menu-item" onclick="$(this).next().slideToggle(); $(this).children('.menu-arrow').toggleClass('rotate')">
                        Soluções LIMS
                        <svg class="menu-arrow h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </span>
                    <ul class="hidden pl-4">
                        <li class="mb-1">
                            <a class="block p-4 text-sm font-semibold menu-item" href="https://ultralims.com.br/produtos/ultra-enterprise">Ultra Enterprise</a>
                            <a class="block p-4 text-sm font-semibold menu-item" href="https://ultralims.com.br/produtos/ultra-one">Ultra One</a>
                            <a class="block p-4 text-sm font-semibold menu-item" href="https://ultralims.com.br/produtos/ultra-industrias-40">Ultra Indústria 4.0</a>
                            <a class="block p-4 text-sm font-semibold menu-item" href="https://ultralims.com.br/produtos/ultra-consult">Ultra Consult</a>
                        </li>
                    </ul>
                    <li class="mb-1">
                        <a class="block px-4 py-3 mb-3 text-xs text-center font-semibold leading-none hover:opacity-70 rounded" href="{{ $url }}" style="color: #FFFFFF; background-color: #03B7FC" target="_blank">
                            Ir para o Ultra LIMS
                        </a>
                    </li>
                    @if(Auth::guard('ultralims')->user() != null)
                        <li class="flex items-center">
                            <div class="flex flex-wrap text-white font-bold">
                                <div class="mr-2">
                                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.9529 15.3106C20.7062 14.6585 21.3104 13.8521 21.7245 12.9459C22.1386 12.0398 22.353 11.0551 22.3529 10.0588C22.3529 8.18671 21.6092 6.39127 20.2855 5.06748C18.9617 3.7437 17.1662 3 15.2941 3C13.422 3 11.6266 3.7437 10.3028 5.06748C8.97899 6.39127 8.23529 8.18671 8.23529 10.0588C8.23528 11.0551 8.4496 12.0398 8.86371 12.9459C9.27781 13.8521 9.88201 14.6585 10.6353 15.3106C8.65902 16.2055 6.9823 17.6506 5.80562 19.4732C4.62893 21.2958 4.00208 23.4188 4 25.5882C4 25.9627 4.14874 26.3217 4.4135 26.5865C4.67825 26.8513 5.03734 27 5.41176 27C5.78619 27 6.14528 26.8513 6.41003 26.5865C6.67479 26.3217 6.82353 25.9627 6.82353 25.5882C6.82353 23.3417 7.71596 21.1872 9.30451 19.5986C10.8931 18.0101 13.0476 17.1176 15.2941 17.1176C17.5407 17.1176 19.6952 18.0101 21.2837 19.5986C22.8723 21.1872 23.7647 23.3417 23.7647 25.5882C23.7647 25.9627 23.9134 26.3217 24.1782 26.5865C24.443 26.8513 24.8021 27 25.1765 27C25.5509 27 25.91 26.8513 26.1747 26.5865C26.4395 26.3217 26.5882 25.9627 26.5882 25.5882C26.5862 23.4188 25.9593 21.2958 24.7826 19.4732C23.6059 17.6506 21.9292 16.2055 19.9529 15.3106ZM15.2941 14.2941C14.4565 14.2941 13.6376 14.0457 12.9411 13.5803C12.2446 13.115 11.7018 12.4535 11.3812 11.6796C11.0607 10.9057 10.9768 10.0541 11.1402 9.23256C11.3036 8.41099 11.707 7.65634 12.2993 7.06402C12.8916 6.4717 13.6463 6.06833 14.4679 5.90491C15.2894 5.74149 16.141 5.82536 16.9149 6.14592C17.6888 6.46648 18.3503 7.00933 18.8156 7.70582C19.281 8.40231 19.5294 9.22116 19.5294 10.0588C19.5294 11.1821 19.0832 12.2594 18.2889 13.0536C17.4947 13.8479 16.4174 14.2941 15.2941 14.2941Z" fill="white"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs">
                                        Olá, {{ Auth::guard('ultralims')->user()->user }}
                                    </div>
                                    <div class="text-[0.65rem]">
                                        {{ Auth::guard('ultralims')->user()->laboratorio }}
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>

    @php
        $user = Auth::guard('ultralims')->user();
        $alerts = $user ? $user->unreadAlerts()->get() : collect();
    @endphp
    @if($alerts->isNotEmpty())
        <section class="relative overflow-hidden" style="height: 65px; background-color: #C50101">
            <div class="container mx-auto flex flex-wrap lg:flex-nowrap items-center justify-between" style="height: 100%">
                <div class="flex items-center" style="height: 100%">
                    <svg class="mr-2" width="32" height="30" viewBox="0 0 32 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.0003 21.3196C14.9513 21.3196 14.0996 22.1704 14.0996 23.2194C14.0996 24.2688 14.9513 25.1197 16.0003 25.1197C17.0493 25.1197 17.9001 24.2688 17.9001 23.2194C17.9002 22.1704 17.0494 21.3196 16.0003 21.3196Z" fill="white"/>
                        <path d="M31.5686 24.4449L18.7981 2.32557C18.2229 1.32907 17.1508 0.710129 15.9995 0.710129C14.8491 0.710129 13.778 1.32913 13.2028 2.32557L0.431391 24.444C-0.143797 25.4404 -0.143797 26.6784 0.431391 27.6749C1.00664 28.6713 2.07864 29.2899 3.22908 29.2899H28.771C29.9213 29.2899 30.9934 28.6713 31.5686 27.6749C32.1438 26.6784 32.1438 25.4404 31.5686 24.4449ZM29.0291 26.0253C28.8447 26.3443 28.5013 26.5419 28.1322 26.5419H3.86739C3.49914 26.5419 3.15527 26.3443 2.97183 26.0244C2.78658 25.705 2.78564 25.3091 2.97095 24.9901L15.1036 3.97513C15.2875 3.65619 15.6308 3.458 16.0005 3.458C16.3692 3.458 16.7121 3.65619 16.8965 3.97563L29.0291 24.9898C29.2135 25.3091 29.2135 25.7059 29.0291 26.0253Z" fill="white"/>
                        <path d="M16.0003 8.54494C14.9513 8.54494 14.0996 9.39575 14.0996 10.4452L14.8296 19.0382C14.8296 19.6848 15.3532 20.2084 16.0003 20.2084C16.6464 20.2084 17.171 19.6848 17.171 19.0382L17.9001 10.4452C17.9002 9.39569 17.0494 8.54494 16.0003 8.54494Z" fill="white"/>
                    </svg>
                    <span class="text-white">
                    {{ $alerts->first()->alert }}
                </span>
                </div>
                <div class="flex items-center">
                    <a href="http://www.inmetro.gov.br/credenciamento/organismos/doc_organismos.asp?tOrganismo=CalibEnsaios" target="_blank" class="py-1 px-2 mark-as-read" style="background-color: #C50101; border: white 1px solid; border-radius: 6px; color: white; margin-right: 6px; height: 100%">
                        <svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="Interface / External_Link">
                                <path id="Vector" d="M10.0002 5H8.2002C7.08009 5 6.51962 5 6.0918 5.21799C5.71547 5.40973 5.40973 5.71547 5.21799 6.0918C5 6.51962 5 7.08009 5 8.2002V15.8002C5 16.9203 5 17.4801 5.21799 17.9079C5.40973 18.2842 5.71547 18.5905 6.0918 18.7822C6.5192 19 7.07899 19 8.19691 19H15.8031C16.921 19 17.48 19 17.9074 18.7822C18.2837 18.5905 18.5905 18.2839 18.7822 17.9076C19 17.4802 19 16.921 19 15.8031V14M20 9V4M20 4H15M20 4L13 11" stroke="#FFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                        </svg>
                    </a>
                    <button class="py-1 px-2 mark-as-read" data-alert-id="{{ $alerts->first()->id }}" style="background-color: #C50101; border: white 1px solid; border-radius: 6px; color: white">
                        Estou ciente
                    </button>
                </div>
            </div>
        </section>
    @endif
</header>

@push('scripts')
    <script>
        window.addEventListener('load', function() {
            var headerHeight = document.querySelector('header').offsetHeight;
            document.body.style.marginTop = headerHeight + 'px';
        });
        // Burger menus
        document.addEventListener('DOMContentLoaded', function() {
            // open
            const burger = document.querySelectorAll('.navbar-burger');
            const menu = document.querySelectorAll('.navbar-menu');

            if (burger.length && menu.length) {
                for (var i = 0; i < burger.length; i++) {
                    burger[i].addEventListener('click', function() {
                        for (var j = 0; j < menu.length; j++) {
                            menu[j].classList.toggle('hidden');
                        }
                    });
                }
            }

            // close
            const close = document.querySelectorAll('.navbar-close');
            const backdrop = document.querySelectorAll('.navbar-backdrop');

            if (close.length) {
                for (var i = 0; i < close.length; i++) {
                    close[i].addEventListener('click', function() {
                        for (var j = 0; j < menu.length; j++) {
                            menu[j].classList.toggle('hidden');
                        }
                    });
                }
            }

            if (backdrop.length) {
                for (var i = 0; i < backdrop.length; i++) {
                    backdrop[i].addEventListener('click', function() {
                        for (var j = 0; j < menu.length; j++) {
                            menu[j].classList.toggle('hidden');
                        }
                    });
                }
            }
        });
    </script>
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.mark-as-read').forEach(button => {
                button.addEventListener('click', function () {
                    let alertId = this.getAttribute('data-alert-id');

                    fetch('{{ route('ultralims.alerts.read') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ alert_id: alertId })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                location.reload(); // Recarrega a página para esconder o alerta
                            }
                        })
                        .catch(error => console.error('Erro ao marcar como lido:', error));
                });
            });
        });

        function showLoader() {
            document.getElementById('global-loader').style.display = 'flex';
        }

        function hideLoader() {
            document.getElementById('global-loader').style.display = 'none';
        }
    </script>
@endpush

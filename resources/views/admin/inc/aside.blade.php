<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside"
     data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto"
     data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
    <!--begin::Logo-->
    <div class="aside-logo flex-column-auto pt-10 pt-lg-20" id="kt_aside_logo">
        <a href="{{route('admin.index')}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 66 66">
                <defs>
                    <style>
                        .logo-1 {
                            fill: #0e1326;
                        }

                        .logo-2 {
                            fill: #fff;
                        }

                        .logo-3 {
                            fill: #03b7fc;
                        }

                        .cls-1 {
                            fill: #FFFFFF !important;
                        }

                        .cls-2 {
                            fill: #FFFFFF !important;
                        }
                    </style>
                </defs>
                <g id="impetus_icone" transform="translate(14491 14018)">
                    <rect id="fundo" class="logo-1" width="66" height="66" rx="8" transform="translate(-14491 -14018)"/>
                    <g id="Grupo_181" data-name="Grupo 181" transform="translate(-103.906 -49.333)">
                        <path id="Caminho_15929" data-name="Caminho 15929" class="logo-2" d="M127.906,70.219v5.115h18v-14H136.58a8.782,8.782,0,0,0-8.674,8.885" transform="translate(-14491 -14018)"/>
                        <path id="Caminho_15930" data-name="Caminho 15930" class="logo-3" d="M145.906,224.67v-5.115h-18v14h9.326a8.782,8.782,0,0,0,8.674-8.885" transform="translate(-14491 -14148.222)"/>
                    </g>
                </g>
            </svg>
        </a>
    </div>
    <!--end::Logo-->
    <!--begin::Nav-->
    <div class="aside-menu flex-column-fluid pt-0 pb-7 py-lg-10" id="kt_aside_menu">
        <!--begin::Aside menu-->
        <div id="kt_aside_menu_wrapper" class="w-100 hover-scroll-overlay-y scroll-ps d-flex" data-kt-scroll="true"
             data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
             data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="0">
            <div id="kt_aside_menu"
                 class="menu menu-column menu-title-gray-600 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-icon-gray-400 menu-arrow-gray-400 fw-semibold fs-6 my-auto"
                 data-kt-menu="true">
                @if(Auth::user()->can('Publicações') ||
                    Auth::user()->can('Páginas') ||
                     Auth::user()->can('Cards') ||
                     Auth::user()->can('Comunicados') ||
                     Auth::user()->can('Depoimentos') ||
                     Auth::user()->can('Eventos') ||
                     Auth::user()->can('FAQ') ||
                     Auth::user()->can('Galerias') ||
                     Auth::user()->can('Logos') ||
                     Auth::user()->can('Mídias') ||
                     Auth::user()->can('Portfólios') ||
                     Auth::user()->can('Produtos') ||
                     Auth::user()->can('Revistas') ||
                     Auth::user()->can('Tópicos') ||
                     Auth::user()->can('Membros') ||
                     Auth::user()->can('Centros de pesquisa') ||
                     Auth::user()->can('Pesquisas/Plataformas') ||
                     Auth::user()->can('Banners'))
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                         class="menu-item
                         {{ str_contains(Route::currentRouteName(), 'admin.articles') ||
                            str_contains(Route::currentRouteName(), 'admin.pages') ||
                            str_contains(Route::currentRouteName(), 'admin.cards') ||
                            str_contains(Route::currentRouteName(), 'admin.alerts') ||
                            str_contains(Route::currentRouteName(), 'admin.testimonials') ||
                            str_contains(Route::currentRouteName(), 'admin.events'||
                            str_contains(Route::currentRouteName(), 'admin.faq') ||
                            str_contains(Route::currentRouteName(), 'admin.galleries') ||
                            str_contains(Route::currentRouteName(), 'admin.logosCategories') ||
                            str_contains(Route::currentRouteName(), 'admin.folders') ||
                            str_contains(Route::currentRouteName(), 'admin.portfolios') ||
                            str_contains(Route::currentRouteName(), 'admin.products') ||
                            str_contains(Route::currentRouteName(), 'admin.magazines') ||
                            str_contains(Route::currentRouteName(), 'admin.topics') ||
                            str_contains(Route::currentRouteName(), 'admin.members') ||
                            str_contains(Route::currentRouteName(), 'admin.researchCenters') ||
                            str_contains(Route::currentRouteName(), 'admin.researchs') ||
                            str_contains(Route::currentRouteName(), 'admin.banners') ? 'here show':'') }}
                         py-2">
                        <!--begin:Menu link-->
                        <span class="menu-link menu-center">
                            <span class="menu-icon me-0">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2x">
                                   <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor"></path>
                                       <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor"></path>
                                   </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-dropdown px-2 py-4 w-250px mh-75 overflow-auto">
                            @if(Auth::user()->can('Páginas'))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu content-->
                                    <div class="menu-content">
                                        <span class="menu-section fs-5 fw-bolder ps-1 py-1">Páginas</span>
                                    </div>
                                    <!--end:Menu content-->
                                </div>
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.pages') ? 'active':'' }}" href="{{ route('admin.pages.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                        <span class="menu-title">Todas as páginas</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endif

                            @if(Auth::user()->can('Publicações'))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu content-->
                                    <div class="menu-content">
                                        <span class="menu-section fs-5 fw-bolder ps-1 py-1">Publicações</span>
                                    </div>
                                    <!--end:Menu content-->
                                </div>
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.articles') && !str_contains(Route::currentRouteName(), 'admin.articles.ads') && !str_contains(Route::currentRouteName(), 'admin.articles.prompts') ? 'active':'' }}" href="{{ route('admin.articles.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Todas as publicações</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endif

                            @if(Auth::user()->can('Cards') ||
                                Auth::user()->can('Comunicados') ||
                                Auth::user()->can('Depoimentos') ||
                                Auth::user()->can('Eventos') ||
                                Auth::user()->can('FAQ') ||
                                Auth::user()->can('Galerias')  ||
                                Auth::user()->can('Logos') ||
                                Auth::user()->can('Mídias') ||
                                Auth::user()->can('Portfólios') ||
                                Auth::user()->can('Produtos') ||
                                Auth::user()->can('Revistas') ||
                                Auth::user()->can('Tópicos'))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu content-->
                                    <div class="menu-content">
                                        <span class="menu-section fs-5 fw-bolder ps-1 py-1">Geral</span>
                                    </div>
                                    <!--end:Menu content-->
                                </div>
                                @can('Cards')
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.cards') ? 'active':'' }}" href="{{ route('admin.cards.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Cards</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endcan
                                @can('Comunicados')
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.alerts') ? 'active':'' }}" href="{{ route('admin.alerts.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                            <span class="menu-title">Comunicados</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endcan
                                @can('Depoimentos')
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.testimonials') ? 'active':'' }}" href="{{ route('admin.testimonials.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Depoimentos</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endcan
                                @can('Eventos')
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.events') ? 'active':'' }}" href="{{ route('admin.events.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                            <span class="menu-title">Eventos</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endcan
                                @can('FAQ')
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.faq') ? 'active':'' }}" href="{{ route('admin.faq.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">FAQ</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endcan
                                @can('Galerias')
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.galleries') ? 'active':'' }}" href="{{ route('admin.galleries.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Galerias</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endcan
                                @can('Logos')
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.logosCategories') ? 'active':'' }}" href="{{ route('admin.logosCategories.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Logos</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endcan
                                @can('Mídias')
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.folders') ? 'active':'' }}" href="{{ route('admin.folders.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                            <span class="menu-title">Mídias</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endcan
                                @can('Portfólios')
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.portfolios') ? 'active':'' }}" href="{{ route('admin.portfolios.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Portfólios</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endcan
                                @can('Produtos')
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.products') ? 'active':'' }}" href="{{ route('admin.products.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                            <span class="menu-title">Produtos</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endcan
                                @can('Revistas')
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.magazines') ? 'active':'' }}" href="{{ route('admin.magazines.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                            <span class="menu-title">Revistas</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endcan
                                @can('Tópicos')
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.topics') ? 'active':'' }}" href="{{ route('admin.topics.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Tópicos</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endcan
                            @endif

                            @if(env('APP_NAME') == 'iii-INCT' && (Auth::user()->can('Membros') || Auth::user()->can('Centros de pesquisa') || Auth::user()->can('Pesquisas/Plataformas')))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu content-->
                                    <div class="menu-content">
                                        <span class="menu-section fs-5 fw-bolder ps-1 py-1">III</span>
                                    </div>
                                    <!--end:Menu content-->
                                </div>
                                @if(Auth::user()->can('Membros'))
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.members') ? 'active':'' }}" href="{{ route('admin.members.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Membros</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endif
                                @if(Auth::user()->can('Centros de pesquisa'))
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.researchCenters') ? 'active':'' }}" href="{{ route('admin.researchCenters.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Centros de pesquisa</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endif
                                @if(Auth::user()->can('Pesquisas/Plataformas'))
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.researchs') ? 'active':'' }}" href="{{ route('admin.researchs.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Pesquisas</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endif
                            @endif

                            @if(env('APP_NAME') == 'Ultra Lims' && (Auth::user()->can('Publicações') || Auth::user()->can('Banners') || Auth::user()->can('Cookies')))
                                <div class="menu-item">
                                    <!--begin:Menu content-->
                                    <div class="menu-content">
                                        <span class="menu-section fs-5 fw-bolder ps-1 py-1">Ultra Lims</span>
                                    </div>
                                    <!--end:Menu content-->
                                </div>
                                @if(Auth::user()->can('Publicações'))
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.ultralims.articles') ? 'active':'' }}" href="{{ route('admin.ultralims.articles.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Publicações</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endif
                                @if(Auth::user()->can('Banners'))
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.banners') ? 'active':'' }}" href="{{ route('admin.banners.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Banner</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endif
                                @if(Auth::user()->can('Cookies'))
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.ultralims.cookies') ? 'active':'' }}" href="{{ route('admin.ultralims.cookies.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Cookies</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endif
                            @endif
                            @if(env('APP_NAME') == 'Ultra Lims')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ str_contains(Route::currentRouteName(), 'admin.ultralims.chat') ? 'active':'' }}" href="{{ route('admin.ultralims.chat.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Chat</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endif
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endif
            </div>
        </div>
        <!--end::Aside menu-->
    </div>
    <!--end::Nav-->
    @if(Auth::user()->can('Configurações gerais') || Auth::user()->can('Usuários') || Auth::user()->can('Ticket Admin') || Auth::user()->can('Ticket Atendente'))
        <!--begin::Footer-->
        <div class="aside-footer flex-column-auto pb-5 pb-lg-10" id="kt_aside_footer">
            <!--begin::Menu-->
            <div class="d-flex flex-center w-100 scroll-px" data-bs-toggle="tooltip" data-bs-placement="right"
                 data-bs-dismiss="click" title="Ações rápidas">
                <button type="button" class="btn btn-custom" data-kt-menu-trigger="click" data-kt-menu-overflow="true"
                        data-kt-menu-placement="top-start">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr076.svg-->
                    <span class="svg-icon svg-icon-2x">
                       <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor"/>
                            <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2"
                                  fill="currentColor"/>
                            <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2"
                                  fill="currentColor"/>
                            <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2"
                                  fill="currentColor"/>
                       </svg>
                    </span>
                    <!--end::Svg Icon-->
                </button>
                <!--begin::Menu 2-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                    data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Ações rápidas</div>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator mb-3 opacity-75"></div>
                    <!--end::Menu separator-->
                    @if(Auth::user()->hasRole('Super-Admin'))
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 pb-3">
                            <a href="{{ route('admin.redirects.index') }}" class="menu-link px-3">Redirecionamentos</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 pb-3">
                            <a href="{{ route('admin.lgpd.index') }}" class="menu-link px-3">LGPD</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 pb-3">
                            <a href="{{ route('admin.emails.index') }}" class="menu-link px-3">E-mails</a>
                        </div>
                        <!--end::Menu item-->
                    @endif
                    <!--end::Menu separator-->
                    <!--end::Menu separator-->
                    @if(Auth::user()->can('Ticket Admin') || Auth::user()->can('Ticket Atendente'))
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 pb-3">
                            <a href="{{ route('admin.tickets.index') }}" class="menu-link px-3">Tickets</a>
                        </div>
                        <!--end::Menu item-->
                    @endif
                    <!--end::Menu separator-->
                    @can('Usuários')
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 pb-3">
                            <a href="{{ route('admin.users.index') }}" class="menu-link px-3">Usuários</a>
                        </div>
                        <!--end::Menu item-->
                    @endcan
                    <!--end::Menu separator-->
                    @can('Configurações gerais')
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 pb-3">
                            <a href="{{ route('admin.settings.index') }}" class="menu-link px-3">Configurações</a>
                        </div>
                        <!--end::Menu item-->
                    @endcan
                </div>
                <!--end::Menu 2-->
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Footer-->
    @endif
</div>

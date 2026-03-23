<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
@include('admin.inc.head')
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="page d-flex flex-row flex-column-fluid">
        <!--begin::Aside-->
        @include('admin.inc.aside')
        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            <!--begin::Header tablet and mobile-->
            <div class="header-mobile py-3">
                <!--begin::Container-->
                <div class="container d-flex flex-stack">
                    <!--begin::Mobile logo-->
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
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
                    <!--end::Mobile logo-->
                    <!--begin::Aside toggle-->
                    <button class="btn btn-icon btn-active-color-primary" id="kt_aside_toggle">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                        <span class="svg-icon svg-icon-2x me-n1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
                                <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>
                    <!--end::Aside toggle-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Header tablet and mobile-->
            <!--begin::Header-->
            @include('admin.inc.header')
            <!--end::Header-->
            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--begin::Container-->
                <div class="container-xxl" id="kt_content_container">
                    @yield('content')
                </div>
                <!--end::Container-->
            </div>
            <!--end::Content-->
            @include('admin.inc.footer')
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Root-->
<!--begin::Drawers-->
<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
    <span class="svg-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
            <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
        </svg>
    </span>
    <!--end::Svg Icon-->
</div>
<!--end::Scrolltop-->

<!--begin::Javascript-->
@include('admin.inc.scripts')
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>

<div id="kt_header" class="header bg-white align-items-stretch" style="left: 0;">
	<!--begin::Container-->
	<div class="container-xxl d-flex align-items-stretch justify-content-between">
		<!--begin::Aside mobile toggle-->
		<div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
			<div class="btn btn-icon btn-active-color-primary w-40px h-40px" id="kt_aside_toggle">
                <span class="svg-icon svg-icon-2x mt-1">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
						<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
				    </svg>
				</span>
			</div>
		</div>
		<!--end::Aside mobile toggle-->
		<!--begin::Mobile logo-->
		<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
			<a href="{{route('dashboard.index')}}" class="d-lg-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 66 66">
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
		<div class="d-flex align-items-center" id="kt_header_wrapper">
			<!--begin::Page title-->
			<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-10 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_wrapper'}">

				<h1 class="text-dark fw-bolder my-1 fs-3 lh-1">
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
                </h1>
			</div>
			<!--end::Page title=-->
		</div>
		<!--begin::Wrapper-->



		<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            <!--begin::navbar-->
            <div class="d-flex align-items-stretch" id="kt_header_nav">
                <!--begin::Menu wrapper-->
                <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                    <!--begin::Menu-->
                    <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-600 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold fs-6 my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">
                        <div class="menu-item">
                            <a class="menu-link {{ (request()->is('cliente')) ? 'active' : '' }} py-3" href="{{route('client.home')}}">
                                <span class="menu-title">Painel</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link {{ (request()->is('cliente/exclusivos')) ? 'active' : '' }} py-3" href="{{route('client.await')}}">
                                <span class="menu-title">Exclusivos</span>
                            </a>
                        </div>

                        <div class="menu-item d-none">
                            <a class="menu-link {{ (request()->is('cliente/loja')) ? 'active' : '' }} py-3" href="{{route('client.await')}}">
                                <span class="menu-title">Loja</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link {{ (request()->is('cliente/transparencia')) ? 'active' : '' }} py-3" href="{{route('client.await')}}">
                                <span class="menu-title">Transparência</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </a>
                        </div>

                        <div  class="menu-item">
                            <a class="menu-link {{ (request()->is('cliente/financeiro')) ? 'active' : '' }} py-3" href="{{route('client.finance')}}">
                                <span class="menu-title">Financeiro</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </a>
                        </div>
                        @if(Auth::user()->canPoll())
                            <div  class="menu-item">
                                <a class="menu-link {{ (request()->is('cliente/polls')) ? 'active' : '' }} py-3" href="{{route('client.polls.index')}}">
                                    <span class="menu-title">Eleições</span>
                                    <span class="menu-arrow d-lg-none"></span>
                                </a>
                            </div>
                        @endif

                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Menu wrapper-->
            </div>
            <!--end::navbar-->



			<!--begin::Topbar-->
			<div class="d-flex align-items-stretch justify-self-end flex-shrink-0">

                            <!--begin:chat-->
            <div class="d-flex align-items-center ms-1 ms-lg-3">
                <!--begin::Menu wrapper-->
                <div class="btn btn-icon btn-active-light-primary position-relative w-30px h-30px w-md-40px h-md-40px" id="kt_drawer_chat_toggle">
                    <!--begin::Svg Icon | path: icons/duotune/communication/com012.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="black"></path>
                            <rect x="6" y="12" width="7" height="2" rx="1" fill="black"></rect>
                            <rect x="6" y="7" width="12" height="2" rx="1" fill="black"></rect>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <span class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span>
                </div>
                <!--end::Menu wrapper-->
            </div>
            <!--end:chat-->

				<!--begin::Toolbar wrapper-->
				<div class="d-flex align-items-stretch flex-shrink-0">

					<!--begin::User-->
					<div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
						<!--begin::Menu wrapper-->
						<div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"> <img src="{{Auth::user()->photo == null ? asset('images/default.png') : asset(str_replace('public/','storage/', Auth::user()->photo)) }}" alt="{{Auth::user()->name}} {{Auth::user()->lastname ?? ''}}" /> </div>
						<!--begin::Menu-->
						<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
							<!--begin::Menu item-->
							<div class="menu-item px-3">
								<div class="menu-content d-flex align-items-center px-3">
									<!--begin::Avatar-->
									<div class="symbol symbol-50px me-5"> <img src="{{Auth::user()->photo == null ? asset('images/default.png') : asset(str_replace('public/','storage/', Auth::user()->photo)) }}" alt="{{Auth::user()->name}} {{Auth::user()->lastname ?? ''}}" /> </div>
									<!--end::Avatar-->
									<!--begin::Username-->
									<div class="d-flex flex-column">
										<div class="fw-bolder d-flex align-items-center fs-5">{{Auth::user()->name}}</span></div>
                                    </div>
									<!--end::Username-->
								</div>
							</div>
							<!--end::Menu item-->
							<!--begin::Menu separator-->
							<div class="separator my-2"></div>
							<!--end::Menu separator-->

							<!--begin::Menu item-->
							<div class="menu-item px-5 my-1"> <a href="{{route('client.my-account')}}" class="menu-link px-5">Minha conta</a> </div>
							<!--end::Menu item-->
							<!--begin::Menu item-->
							<div class="menu-item px-5"> <a href="{{route('auth.logout')}}" class="menu-link px-5">Sair</a> </div>
							<!--end::Menu item-->
						</div>
						<!--end::Menu-->
						<!--end::Menu wrapper-->
					</div>
					<!--end::User -->

				</div>
				<!--end::Toolbar wrapper-->
			</div>
			<!--end::Topbar-->

		</div>
		<!--end::Wrapper-->
	</div>
	<!--end::Container-->
</div>

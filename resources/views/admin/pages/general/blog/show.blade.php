@extends('admin.layout')

@section('content')
    <!--begin::Post card-->
    <div class="card">
        <!--begin::Body-->
        <div class="card-body p-lg-20 pb-lg-0">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-xl-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-xl-15">
                    <!--begin::Post content-->
                    <div class="mb-17">
                        <!--begin::Wrapper-->
                        <div class="mb-8">
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap mb-6">
                                <!--begin::Item-->
                                <div class="me-9 my-1">
                                    <!--begin::Icon-->
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                    <span class="svg-icon svg-icon-primary svg-icon-2 me-1">
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
																	<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
																	<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
																	<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
																</svg>
															</span>
                                    <!--end::Svg Icon-->
                                    <!--end::Icon-->
                                    <!--begin::Label-->
                                    <span class="fw-bold text-gray-400">{{ date('d M Y', strtotime($arrayBlog['published_at'])) }}</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="me-9 my-1">
                                    <!--begin::Icon-->
                                    <!--SVG file not found: icons/duotune/finance/fin006.svgFolder.svg-->
                                    <!--end::Icon-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="my-1">
                                    <!--begin::Icon-->
                                    <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
                                    {{--                                    <span class="svg-icon svg-icon-primary svg-icon-2 me-1">--}}
                                    {{--																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
                                    {{--																	<path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="currentColor" />--}}
                                    {{--																	<path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="currentColor" />--}}
                                    {{--																</svg>--}}
                                    {{--															</span>--}}
                                    <!--end::Svg Icon-->
                                    <!--end::Icon-->
                                    <!--begin::Label-->
                                    {{--                                    <span class="fw-bold text-gray-400">24 Comments</span>--}}
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                            </div>
                            <!--end::Info-->
                            <!--begin::Title-->
                            <a href="#" class="text-dark text-hover-primary fs-2 fw-bold">
                                {{ $arrayBlog['title'] }}
                            </a>
                            <!--end::Title-->
                            <!--begin::Container-->
                            <div class="overlay mt-8">
                                <!--begin::Image-->
                                <div class="d-flex align-items-end justify-content-center bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-350px"
                                     style="background-image:url('https://impetus.nucleonerd.com.br/{{ str_replace('public/', 'storage/', $arrayBlog['photo']) }}')">
                                    <div class="card-body">
                                        <span class="badge badge-light-primary fw-bold my-2" style="font-size: 1rem">{{  $arrayBlog['categories'][0]['title'] }}</span><br>
                                    </div>
                                </div>
                                <!--end::Image-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Description-->
                        <div class="fs-5 fw-semibold text-gray-600">
                            <!--begin::Text-->
                            <p class="mb-8">
                                {!! $arrayBlog['content']  !!}
                            </p>
                            <!--end::Text-->

                        </div>
                        <!--end::Description-->
                        <!--begin::Block-->
                        <div class="d-flex align-items-center border-1 border-dashed card-rounded p-5 p-lg-10 mb-14">
                            <!--begin::Section-->
                            <div class="text-center flex-shrink-0 me-7 me-lg-13">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-70px symbol-circle mb-2">
                                    <img src="https://impetus.nucleonerd.com.br/{{ str_replace('public/', 'storage/', $arrayBlog['published_by']['photo']) }}" class="" alt="" />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Info-->
                                <div class="mb-0">
                                    <a href="../../demo9/dist/pages/user-profile/overview.html" class="text-gray-700 fw-bold text-hover-primary">{{ $arrayBlog['published_by']['name'] }}</a>
                                    <span class="text-gray-400 fs-7 fw-semibold d-block mt-1">{{ $arrayBlog['published_by']['office'] }}</span>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Text-->
                            <div class="mb-0 fs-6">
                                <div class="text-muted fw-semibold lh-lg mb-2">
                                    {{ $arrayBlog['published_by']['description'] }}
                                </div>
                            </div>
                            <!--end::Text-->
                        </div>
                        <!--end::Block-->
                        <!--begin::Icons-->
                        <div class="d-flex flex-center">
                            <!--begin::Icon-->
                            <a href="#" class="mx-4">
                                <img src="assets/media/svg/brand-logos/facebook-4.svg" class="h-20px my-2" alt="" />
                            </a>
                            <!--end::Icon-->
                            <!--begin::Icon-->
                            <a href="#" class="mx-4">
                                <img src="assets/media/svg/brand-logos/instagram-2-1.svg" class="h-20px my-2" alt="" />
                            </a>
                            <!--end::Icon-->
                            <!--begin::Icon-->
                            <a href="#" class="mx-4">
                                <img src="assets/media/svg/brand-logos/github.svg" class="h-20px my-2" alt="" />
                            </a>
                            <!--end::Icon-->
                            <!--begin::Icon-->
                            <a href="#" class="mx-4">
                                <img src="assets/media/svg/brand-logos/behance.svg" class="h-20px my-2" alt="" />
                            </a>
                            <!--end::Icon-->
                            <!--begin::Icon-->
                            <a href="#" class="mx-4">
                                <img src="assets/media/svg/brand-logos/pinterest-p.svg" class="h-20px my-2" alt="" />
                            </a>
                            <!--end::Icon-->
                            <!--begin::Icon-->
                            <a href="#" class="mx-4">
                                <img src="assets/media/svg/brand-logos/twitter.svg" class="h-20px my-2" alt="" />
                            </a>
                            <!--end::Icon-->
                            <!--begin::Icon-->
                            <a href="#" class="mx-4">
                                <img src="assets/media/svg/brand-logos/dribbble-icon-1.svg" class="h-20px my-2" alt="" />
                            </a>
                            <!--end::Icon-->
                        </div>
                        <!--end::Icons-->
                    </div>
                    <!--end::Post content-->
                </div>
                <!--end::Content-->
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-100 w-xl-300px mb-10">
                    <!--begin::Search blog-->
{{--                    <div class="mb-16">--}}
{{--                        <h4 class="text-dark mb-7">Search Blog</h4>--}}
{{--                        <!--begin::Input group-->--}}
{{--                        <div class="position-relative">--}}
{{--                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->--}}
{{--                            <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">--}}
{{--														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--															<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />--}}
{{--															<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />--}}
{{--														</svg>--}}
{{--													</span>--}}
{{--                            <!--end::Svg Icon-->--}}
{{--                            <input type="text" class="form-control form-control-solid ps-10" name="search" value="" placeholder="Search" />--}}
{{--                        </div>--}}
{{--                        <!--end::Input group-->--}}
{{--                    </div>--}}
{{--                    <!--end::Search blog-->--}}
{{--                    <!--begin::Catigories-->--}}
{{--                    <div class="mb-16">--}}
{{--                        <h4 class="text-dark mb-7">Categories</h4>--}}
{{--                        <!--begin::Item-->--}}
{{--                        <div class="d-flex flex-stack fw-semibold fs-5 text-muted mb-4">--}}
{{--                            <!--begin::Text-->--}}
{{--                            <a href="#" class="text-muted text-hover-primary pe-2">SaaS Solutions</a>--}}
{{--                            <!--end::Text-->--}}
{{--                            <!--begin::Number-->--}}
{{--                            <div class="m-0">24</div>--}}
{{--                            <!--end::Number-->--}}
{{--                        </div>--}}
{{--                        <!--end::Item-->--}}

{{--                    </div>--}}
                    <!--end::Catigories-->
                    <!--begin::Recent posts-->
                    <div class="m-0">
                        <h4 class="text-dark mb-7">
                            Postagens recentes
                        </h4>
                        @for($i = 0;$i <= 5;$i++)
                            @if(isset($arrayBlogs[$i]) && $arrayBlogs[$i]['id'] != $arrayBlog['id'])
                                <!--begin::Item-->
                                <div class="d-flex flex-stack mb-7">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-60px symbol-2by3 me-4">
                                        <div class="symbol-label" style="background-image: url('https://impetus.nucleonerd.com.br/{{ str_replace('public/', 'storage/', $arrayBlogs[$i]['photo']) }}')"></div>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Title-->
                                    <div class="m-0 w-100">
                                        <a href="{{ route('admin.blog.show', $arrayBlogs[$i]['slug']) }}" class="text-dark fw-bold text-hover-primary fs-6">{{ $arrayBlogs[$i]['title'] }}</a>
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Item-->
                            @endif
                        @endfor
                    </div>
                    <!--end::Recent posts-->
                </div>
                <!--end::Sidebar-->
            </div>
            <!--end::Layout-->
            <!--begin::Section-->
            {{--            <div class="mb-17">--}}
            {{--                <!--begin::Content-->--}}
            {{--                <div class="d-flex flex-stack mb-5">--}}
            {{--                    <!--begin::Title-->--}}
            {{--                    <h3 class="text-dark">Video Tutorials</h3>--}}
            {{--                    <!--end::Title-->--}}
            {{--                    <!--begin::Link-->--}}
            {{--                    <a href="#" class="fs-6 fw-semibold link-primary">View All Videos</a>--}}
            {{--                    <!--end::Link-->--}}
            {{--                </div>--}}
            {{--                <!--end::Content-->--}}
            {{--                <!--begin::Separator-->--}}
            {{--                <div class="separator separator-dashed mb-9"></div>--}}
            {{--                <!--end::Separator-->--}}
            {{--                <!--begin::Row-->--}}
            {{--                <div class="row g-10">--}}
            {{--                    <!--begin::Col-->--}}
            {{--                    <div class="col-md-4">--}}
            {{--                        <!--begin::Feature post-->--}}
            {{--                        <div class="card-xl-stretch me-md-6">--}}
            {{--                            <!--begin::Image-->--}}
            {{--                            <a class="d-block bgi-no-repeat bgi-size-cover bgi-position-center card-rounded position-relative min-h-175px mb-5" style="background-image:url('assets/media/stock/600x400/img-73.jpg')" data-fslightbox="lightbox-video-tutorials" href="https://www.youtube.com/embed/btornGtLwIo">--}}
            {{--                                <img src="assets/media/svg/misc/video-play.svg" class="position-absolute top-50 start-50 translate-middle" alt="" />--}}
            {{--                            </a>--}}
            {{--                            <!--end::Image-->--}}
            {{--                            <!--begin::Body-->--}}
            {{--                            <div class="m-0">--}}
            {{--                                <!--begin::Title-->--}}
            {{--                                <a href="../../demo9/dist/pages/user-profile/overview.html" class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">Admin Panel - How To Started the Dashboard Tutorial</a>--}}
            {{--                                <!--end::Title-->--}}
            {{--                                <!--begin::Text-->--}}
            {{--                                <div class="fw-semibold fs-5 text-gray-600 text-dark my-4">We’ve been focused on making a the from also not been afraid to and step away been focused create eye</div>--}}
            {{--                                <!--end::Text-->--}}
            {{--                                <!--begin::Content-->--}}
            {{--                                <div class="fs-6 fw-bold">--}}
            {{--                                    <!--begin::Author-->--}}
            {{--                                    <a href="../../demo9/dist/pages/user-profile/overview.html" class="text-gray-700 text-hover-primary">Jane Miller</a>--}}
            {{--                                    <!--end::Author-->--}}
            {{--                                    <!--begin::Date-->--}}
            {{--                                    <span class="text-muted">on Mar 21 2021</span>--}}
            {{--                                    <!--end::Date-->--}}
            {{--                                </div>--}}
            {{--                                <!--end::Content-->--}}
            {{--                            </div>--}}
            {{--                            <!--end::Body-->--}}
            {{--                        </div>--}}
            {{--                        <!--end::Feature post-->--}}
            {{--                    </div>--}}
            {{--                    <!--end::Col-->--}}
            {{--                    <!--begin::Col-->--}}
            {{--                    <div class="col-md-4">--}}
            {{--                        <!--begin::Feature post-->--}}
            {{--                        <div class="card-xl-stretch mx-md-3">--}}
            {{--                            <!--begin::Image-->--}}
            {{--                            <a class="d-block bgi-no-repeat bgi-size-cover bgi-position-center card-rounded position-relative min-h-175px mb-5" style="background-image:url('assets/media/stock/600x400/img-74.jpg')" data-fslightbox="lightbox-video-tutorials" href="https://www.youtube.com/embed/btornGtLwIo">--}}
            {{--                                <img src="assets/media/svg/misc/video-play.svg" class="position-absolute top-50 start-50 translate-middle" alt="" />--}}
            {{--                            </a>--}}
            {{--                            <!--end::Image-->--}}
            {{--                            <!--begin::Body-->--}}
            {{--                            <div class="m-0">--}}
            {{--                                <!--begin::Title-->--}}
            {{--                                <a href="../../demo9/dist/pages/user-profile/overview.html" class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">Admin Panel - How To Started the Dashboard Tutorial</a>--}}
            {{--                                <!--end::Title-->--}}
            {{--                                <!--begin::Text-->--}}
            {{--                                <div class="fw-semibold fs-5 text-gray-600 text-dark my-4">We’ve been focused on making the from v4 to v5 but we have also not been afraid to step away been focused</div>--}}
            {{--                                <!--end::Text-->--}}
            {{--                                <!--begin::Content-->--}}
            {{--                                <div class="fs-6 fw-bold">--}}
            {{--                                    <!--begin::Author-->--}}
            {{--                                    <a href="../../demo9/dist/pages/user-profile/overview.html" class="text-gray-700 text-hover-primary">Cris Morgan</a>--}}
            {{--                                    <!--end::Author-->--}}
            {{--                                    <!--begin::Date-->--}}
            {{--                                    <span class="text-muted">on Apr 14 2021</span>--}}
            {{--                                    <!--end::Date-->--}}
            {{--                                </div>--}}
            {{--                                <!--end::Content-->--}}
            {{--                            </div>--}}
            {{--                            <!--end::Body-->--}}
            {{--                        </div>--}}
            {{--                        <!--end::Feature post-->--}}
            {{--                    </div>--}}
            {{--                    <!--end::Col-->--}}
            {{--                    <!--begin::Col-->--}}
            {{--                    <div class="col-md-4">--}}
            {{--                        <!--begin::Feature post-->--}}
            {{--                        <div class="card-xl-stretch ms-md-6">--}}
            {{--                            <!--begin::Image-->--}}
            {{--                            <a class="d-block bgi-no-repeat bgi-size-cover bgi-position-center card-rounded position-relative min-h-175px mb-5" style="background-image:url('assets/media/stock/600x400/img-47.jpg')" data-fslightbox="lightbox-video-tutorials" href="https://www.youtube.com/embed/TWdDZYNqlg4">--}}
            {{--                                <img src="assets/media/svg/misc/video-play.svg" class="position-absolute top-50 start-50 translate-middle" alt="" />--}}
            {{--                            </a>--}}
            {{--                            <!--end::Image-->--}}
            {{--                            <!--begin::Body-->--}}
            {{--                            <div class="m-0">--}}
            {{--                                <!--begin::Title-->--}}
            {{--                                <a href="../../demo9/dist/pages/user-profile/overview.html" class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">Admin Panel - How To Started the Dashboard Tutorial</a>--}}
            {{--                                <!--end::Title-->--}}
            {{--                                <!--begin::Text-->--}}
            {{--                                <div class="fw-semibold fs-5 text-gray-600 text-dark my-4">We’ve been focused on making the from v4 to v5 but we’ve also not been afraid to step away been focused</div>--}}
            {{--                                <!--end::Text-->--}}
            {{--                                <!--begin::Content-->--}}
            {{--                                <div class="fs-6 fw-bold">--}}
            {{--                                    <!--begin::Author-->--}}
            {{--                                    <a href="../../demo9/dist/pages/user-profile/overview.html" class="text-gray-700 text-hover-primary">Carles Nilson</a>--}}
            {{--                                    <!--end::Author-->--}}
            {{--                                    <!--begin::Date-->--}}
            {{--                                    <span class="text-muted">on May 14 2021</span>--}}
            {{--                                    <!--end::Date-->--}}
            {{--                                </div>--}}
            {{--                                <!--end::Content-->--}}
            {{--                            </div>--}}
            {{--                            <!--end::Body-->--}}
            {{--                        </div>--}}
            {{--                        <!--end::Feature post-->--}}
            {{--                    </div>--}}
            {{--                    <!--end::Col-->--}}
            {{--                </div>--}}
            {{--                <!--end::Row-->--}}
            {{--            </div>--}}
            <!--end::Section-->
            <!--begin::Section-->
            {{--            <div class="mb-17">--}}
            {{--                <!--begin::Content-->--}}
            {{--                <div class="d-flex flex-stack mb-5">--}}
            {{--                    <!--begin::Title-->--}}
            {{--                    <h3 class="text-dark">Hottest Bundles</h3>--}}
            {{--                    <!--end::Title-->--}}
            {{--                    <!--begin::Link-->--}}
            {{--                    <a href="#" class="fs-6 fw-semibold link-primary">View All Offers</a>--}}
            {{--                    <!--end::Link-->--}}
            {{--                </div>--}}
            {{--                <!--end::Content-->--}}
            {{--                <!--begin::Separator-->--}}
            {{--                <div class="separator separator-dashed mb-9"></div>--}}
            {{--                <!--end::Separator-->--}}
            {{--                <!--begin::Row-->--}}
            {{--                <div class="row g-10">--}}
            {{--                    <!--begin::Col-->--}}
            {{--                    <div class="col-md-4">--}}
            {{--                        <!--begin::Hot sales post-->--}}
            {{--                        <div class="card-xl-stretch me-md-6">--}}
            {{--                            <!--begin::Overlay-->--}}
            {{--                            <a class="d-block overlay" data-fslightbox="lightbox-hot-sales" href="assets/media/stock/600x400/img-23.jpg">--}}
            {{--                                <!--begin::Image-->--}}
            {{--                                <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px" style="background-image:url('assets/media/stock/600x400/img-23.jpg')"></div>--}}
            {{--                                <!--end::Image-->--}}
            {{--                                <!--begin::Action-->--}}
            {{--                                <div class="overlay-layer card-rounded bg-dark bg-opacity-25">--}}
            {{--                                    <i class="bi bi-eye-fill fs-2x text-white"></i>--}}
            {{--                                </div>--}}
            {{--                                <!--end::Action-->--}}
            {{--                            </a>--}}
            {{--                            <!--end::Overlay-->--}}
            {{--                            <!--begin::Body-->--}}
            {{--                            <div class="mt-5">--}}
            {{--                                <!--begin::Title-->--}}
            {{--                                <a href="#" class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">25 Products Mega Bundle with 50% off discount amazing</a>--}}
            {{--                                <!--end::Title-->--}}
            {{--                                <!--begin::Text-->--}}
            {{--                                <div class="fw-semibold fs-5 text-gray-600 text-dark mt-3">We’ve been focused on making a the from also not been eye</div>--}}
            {{--                                <!--end::Text-->--}}
            {{--                                <!--begin::Text-->--}}
            {{--                                <div class="fs-6 fw-bold mt-5 d-flex flex-stack">--}}
            {{--                                    <!--begin::Label-->--}}
            {{--                                    <span class="badge border border-dashed fs-2 fw-bold text-dark p-2">--}}
            {{--															<span class="fs-6 fw-semibold text-gray-400">$</span>28</span>--}}
            {{--                                    <!--end::Label-->--}}
            {{--                                    <!--begin::Action-->--}}
            {{--                                    <a href="#" class="btn btn-sm btn-primary">Purchase</a>--}}
            {{--                                    <!--end::Action-->--}}
            {{--                                </div>--}}
            {{--                                <!--end::Text-->--}}
            {{--                            </div>--}}
            {{--                            <!--end::Body-->--}}
            {{--                        </div>--}}
            {{--                        <!--end::Hot sales post-->--}}
            {{--                    </div>--}}
            {{--                    <!--end::Col-->--}}
            {{--                    <!--begin::Col-->--}}
            {{--                    <div class="col-md-4">--}}
            {{--                        <!--begin::Hot sales post-->--}}
            {{--                        <div class="card-xl-stretch mx-md-3">--}}
            {{--                            <!--begin::Overlay-->--}}
            {{--                            <a class="d-block overlay" data-fslightbox="lightbox-hot-sales" href="assets/media/stock/600x600/img-14.jpg">--}}
            {{--                                <!--begin::Image-->--}}
            {{--                                <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px" style="background-image:url('assets/media/stock/600x600/img-14.jpg')"></div>--}}
            {{--                                <!--end::Image-->--}}
            {{--                                <!--begin::Action-->--}}
            {{--                                <div class="overlay-layer card-rounded bg-dark bg-opacity-25">--}}
            {{--                                    <i class="bi bi-eye-fill fs-2x text-white"></i>--}}
            {{--                                </div>--}}
            {{--                                <!--end::Action-->--}}
            {{--                            </a>--}}
            {{--                            <!--end::Overlay-->--}}
            {{--                            <!--begin::Body-->--}}
            {{--                            <div class="mt-5">--}}
            {{--                                <!--begin::Title-->--}}
            {{--                                <a href="#" class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">25 Products Mega Bundle with 50% off discount amazing</a>--}}
            {{--                                <!--end::Title-->--}}
            {{--                                <!--begin::Text-->--}}
            {{--                                <div class="fw-semibold fs-5 text-gray-600 text-dark mt-3">We’ve been focused on making a the from also not been eye</div>--}}
            {{--                                <!--end::Text-->--}}
            {{--                                <!--begin::Text-->--}}
            {{--                                <div class="fs-6 fw-bold mt-5 d-flex flex-stack">--}}
            {{--                                    <!--begin::Label-->--}}
            {{--                                    <span class="badge border border-dashed fs-2 fw-bold text-dark p-2">--}}
            {{--															<span class="fs-6 fw-semibold text-gray-400">$</span>27</span>--}}
            {{--                                    <!--end::Label-->--}}
            {{--                                    <!--begin::Action-->--}}
            {{--                                    <a href="#" class="btn btn-sm btn-primary">Purchase</a>--}}
            {{--                                    <!--end::Action-->--}}
            {{--                                </div>--}}
            {{--                                <!--end::Text-->--}}
            {{--                            </div>--}}
            {{--                            <!--end::Body-->--}}
            {{--                        </div>--}}
            {{--                        <!--end::Hot sales post-->--}}
            {{--                    </div>--}}
            {{--                    <!--end::Col-->--}}
            {{--                    <!--begin::Col-->--}}
            {{--                    <div class="col-md-4">--}}
            {{--                        <!--begin::Hot sales post-->--}}
            {{--                        <div class="card-xl-stretch ms-md-6">--}}
            {{--                            <!--begin::Overlay-->--}}
            {{--                            <a class="d-block overlay" data-fslightbox="lightbox-hot-sales" href="assets/media/stock/600x400/img-71.jpg">--}}
            {{--                                <!--begin::Image-->--}}
            {{--                                <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px" style="background-image:url('assets/media/stock/600x400/img-71.jpg')"></div>--}}
            {{--                                <!--end::Image-->--}}
            {{--                                <!--begin::Action-->--}}
            {{--                                <div class="overlay-layer card-rounded bg-dark bg-opacity-25">--}}
            {{--                                    <i class="bi bi-eye-fill fs-2x text-white"></i>--}}
            {{--                                </div>--}}
            {{--                                <!--end::Action-->--}}
            {{--                            </a>--}}
            {{--                            <!--end::Overlay-->--}}
            {{--                            <!--begin::Body-->--}}
            {{--                            <div class="mt-5">--}}
            {{--                                <!--begin::Title-->--}}
            {{--                                <a href="#" class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">25 Products Mega Bundle with 50% off discount amazing</a>--}}
            {{--                                <!--end::Title-->--}}
            {{--                                <!--begin::Text-->--}}
            {{--                                <div class="fw-semibold fs-5 text-gray-600 text-dark mt-3">We’ve been focused on making a the from also not been eye</div>--}}
            {{--                                <!--end::Text-->--}}
            {{--                                <!--begin::Text-->--}}
            {{--                                <div class="fs-6 fw-bold mt-5 d-flex flex-stack">--}}
            {{--                                    <!--begin::Label-->--}}
            {{--                                    <span class="badge border border-dashed fs-2 fw-bold text-dark p-2">--}}
            {{--															<span class="fs-6 fw-semibold text-gray-400">$</span>25</span>--}}
            {{--                                    <!--end::Label-->--}}
            {{--                                    <!--begin::Action-->--}}
            {{--                                    <a href="#" class="btn btn-sm btn-primary">Purchase</a>--}}
            {{--                                    <!--end::Action-->--}}
            {{--                                </div>--}}
            {{--                                <!--end::Text-->--}}
            {{--                            </div>--}}
            {{--                            <!--end::Body-->--}}
            {{--                        </div>--}}
            {{--                        <!--end::Hot sales post-->--}}
            {{--                    </div>--}}
            {{--                    <!--end::Col-->--}}
            {{--                </div>--}}
            {{--                <!--end::Row-->--}}
            {{--            </div>--}}
            <!--end::Section-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Post card-->
@endsection

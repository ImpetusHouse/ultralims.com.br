@extends('admin.layout')

@section('content')
    <!--begin::Home card-->
    <div class="card">
        <!--begin::Body-->
        <div class="card-body p-lg-20">
            <!--begin::Section-->
            <div class="mb-17">
                <!--begin::Title-->
                <h3 class="text-dark mb-7">
                    Últimos artigos, notícias e atualizações
                </h3>
                <!--end::Title-->
                <!--begin::Separator-->
                <div class="separator separator-dashed mb-9"></div>
                <!--end::Separator-->
                <!--begin::Row-->
                <div class="row">
                    <!--begin::Col-->
                    <div class="col-md-6">
                        <!--begin::Feature post-->
                        <div class="h-100 d-flex flex-column justify-content-between pe-lg-6 mb-lg-0 mb-10">
                            <!--begin::Video-->
                            <div class="mb-3">
                                <img class="embed-responsive-item card-rounded h-275px w-100" src="https://impetus.nucleonerd.com.br/{{ str_replace('public/', 'storage/', $arrayBlogs[0]['photo']) }}" allowfullscreen="allowfullscreen"></img>
                            </div>
                            <!--end::Video-->
                            <!--begin::Body-->
                            <div class="mb-5">
                                <!--begin::Title-->
                                <a href="{{ route('admin.blog.show', $arrayBlogs[0]['slug']) }}" class="fs-2 text-dark fw-bold text-hover-primary text-dark lh-base">
                                    {{ $arrayBlogs[0]['title'] }}
                                </a>
                                <!--end::Title-->
                                <!--begin::Text-->
                                <div class="fw-semibold fs-5 text-gray-600 text-dark mt-4">
                                    {{ Str::limit(strip_tags(html_entity_decode($arrayBlogs[0]['content'])), 400, '...') }}
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Body-->
                            <!--begin::Footer-->
                            <div class="d-flex flex-stack flex-wrap">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center pe-2">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-35px symbol-circle me-3">
                                        <img alt="" src="https://impetus.nucleonerd.com.br/{{ str_replace('public/', 'storage/', $arrayBlogs[0]['published_by']['photo']) }}" />
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Text-->
                                    <div class="fs-5 fw-bold">
                                        <a href="#" class="text-gray-700 text-hover-primary">
                                           {{  $arrayBlogs[0]['published_by']['name'] }}
                                        </a>
                                        <span class="text-muted">
                                            em {{ date('d M Y', strtotime($arrayBlogs[0]['published_at'])) }}
                                        </span>
                                    </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Label-->
                                <span class="badge badge-light-primary fw-bold my-2">{{  $arrayBlogs[1]['categories'][0]['title'] }}</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Footer-->
                        </div>
                        <!--end::Feature post-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-md-6">
                        <!--begin::Feature post-->
                        <div class="h-100 d-flex flex-column justify-content-between pe-lg-6 mb-lg-0 mb-10">
                            <!--begin::Video-->
                            <div class="mb-3">
                                <img class="embed-responsive-item card-rounded h-275px w-100" src="https://impetus.nucleonerd.com.br/{{ str_replace('public/', 'storage/', $arrayBlogs[1]['photo']) }}" allowfullscreen="allowfullscreen"></img>
                            </div>
                            <!--end::Video-->
                            <!--begin::Body-->
                            <div class="mb-5">
                                <!--begin::Title-->
                                <a href="{{ route('admin.blog.show', $arrayBlogs[1]['slug']) }}" class="fs-2 text-dark fw-bold text-hover-primary text-dark lh-base">
                                    {{ $arrayBlogs[1]['title'] }}
                                </a>
                                <!--end::Title-->
                                <!--begin::Text-->
                                <div class="fw-semibold fs-5 text-gray-600 text-dark mt-4">
                                    {{ Str::limit(strip_tags(html_entity_decode($arrayBlogs[1]['content'])), 400, '...') }}
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Body-->
                            <!--begin::Footer-->
                            <div class="d-flex flex-stack flex-wrap">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center pe-2">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-35px symbol-circle me-3">
                                        <img alt="" src="https://impetus.nucleonerd.com.br/{{ str_replace('public/', 'storage/', $arrayBlogs[1]['published_by']['photo']) }}" />
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Text-->
                                    <div class="fs-5 fw-bold">
                                        <a href="#" class="text-gray-700 text-hover-primary">
                                            {{  $arrayBlogs[1]['published_by']['name'] }}
                                        </a>
                                        <span class="text-muted">
                                            em {{ date('d M Y', strtotime($arrayBlogs[1]['published_at'])) }}
                                        </span>
                                    </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Label-->
                                <span class="badge badge-light-primary fw-bold my-2">{{  $arrayBlogs[1]['categories'][0]['title'] }}</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Footer-->
                        </div>
                        <!--end::Feature post-->
                    </div>

                    <!--end::Col-->
                </div>
                <!--begin::Row-->
            </div>
            <!--end::Section-->
            <!--begin::Section-->
            <div class="mb-17">
                <!--begin::Content-->
                <div class="d-flex flex-stack mb-5">
                    <!--begin::Title-->
                    <h3 class="text-dark">Outras publicações</h3>
                    <!--end::Title-->
                </div>
                <!--end::Content-->
                <!--begin::Separator-->
                <div class="separator separator-dashed mb-9"></div>
                <!--end::Separator-->
                <!--begin::Row-->
                <div class="row g-10">
                    @for($i = 2;$i <= count($arrayBlogs) - 1;$i++ )
                        <!--begin::Col-->
                        <div class="col-md-4">
                            <!--begin::Feature post-->
                            <div class="card-xl-stretch me-md-6">
                                <!--begin::Image-->
                                <a class="d-block bgi-no-repeat bgi-size-cover bgi-position-center card-rounded position-relative min-h-175px mb-5"
                                   style="background-image:url('https://impetus.nucleonerd.com.br/{{ str_replace('public/', 'storage/', $arrayBlogs[$i]['photo']) }}')" data-fslightbox="lightbox-video-tutorials"
                                   href="{{ route('admin.blog.show', $arrayBlogs[$i]['slug']) }}">
                                </a>
                                <!--end::Image-->
                                <!--begin::Body-->
                                <div class="m-0">
                                    <!--begin::Title-->
                                    <a href="{{ route('admin.blog.show', $arrayBlogs[$i]['slug']) }}" class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">
                                        {{ $arrayBlogs[$i]['title'] }}
                                    </a>
                                    <!--end::Title-->
                                    <!--begin::Text-->
                                    <div class="fw-semibold fs-5 text-gray-600 text-dark my-4">
                                        {{ Str::limit(strip_tags(html_entity_decode($arrayBlogs[$i]['content'])), 200, '...') }}
                                    </div>
                                    <!--end::Text-->
                                    <!--begin::Content-->
                                    <div class="d-flex flex-stack flex-wrap">
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center pe-2">
                                            <!--begin::Text-->
                                            <div class="fs-5 fw-bold">
                                                <a href="#" class="text-gray-700 text-hover-primary">
                                                    {{  $arrayBlogs[1]['published_by']['name'] }}
                                                </a>
                                                <span class="text-muted">
                                            em {{ date('d M Y', strtotime($arrayBlogs[1]['published_at'])) }}
                                        </span>
                                            </div>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light-primary fw-bold my-2">{{  $arrayBlogs[$i]['categories'][0]['title'] }}</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Feature post-->
                        </div>
                        <!--end::Col-->
                    @endfor

                </div>
                <!--end::Row-->
            </div>
            <!--end::Section-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Home card-->
@endsection

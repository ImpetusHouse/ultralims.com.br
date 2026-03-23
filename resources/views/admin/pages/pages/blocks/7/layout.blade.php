<!--begin::LAYOUT 7-->
<div id="div-layout-7" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link active" data-bs-toggle="tab" href="#layout-7-0">Geral</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#layout-7-1">Aba 1</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#layout-7-2">Aba 2</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#layout-7-3">Aba 3</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#layout-7-4">Aba 4</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="layout-7-0" role="tabpanel">
            <!--begin::Input group-->
            <div class="row mb-12">
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Margin top</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="number" value="15" class="form-control" name="margin_top_7" id="margin_top_7" />
                    <!--end::Input-->
                </div>
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Margin bottom</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="number" value="15" class="form-control" name="margin_bottom_7" id="margin_bottom_7" />
                    <!--end::Input-->
                </div>
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Fundo</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Fundo
                        </p>
                        <div class="color-select" style="background-color: #151624" id="background_color_7"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="layout-7-1" role="tabpanel">
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Fundo</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Fundo
                        </p>
                        <div class="color-select" style="background-color: #151624" id="background_color_7_1"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Título
                        </p>
                        <div class="color-select" style="background-color: {{ $titleColor->color }}" id="title_color_7_1"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>Subtítulo</p>
                        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="subtitle_color_7_1"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Input group-->
        </div>
        <div class="tab-pane fade" id="layout-7-2" role="tabpanel">
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Fundo</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Fundo
                        </p>
                        <div class="color-select" style="background-color: #151624" id="background_color_7_2"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Título
                        </p>
                        <div class="color-select" style="background-color: {{ $titleColor->color }}" id="title_color_7_2"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>Subtítulo</p>
                        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="subtitle_color_7_2"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Input group-->
        </div>
        <div class="tab-pane fade" id="layout-7-3" role="tabpanel">
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Fundo</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Fundo
                        </p>
                        <div class="color-select" style="background-color: #151624" id="background_color_7_3"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Título
                        </p>
                        <div class="color-select" style="background-color: {{ $titleColor->color }}" id="title_color_7_3"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>Subtítulo</p>
                        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="subtitle_color_7_3"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Input group-->
        </div>
        <div class="tab-pane fade" id="layout-7-4" role="tabpanel">
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Fundo</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Fundo
                        </p>
                        <div class="color-select" style="background-color: #151624" id="background_color_7_4"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Título
                        </p>
                        <div class="color-select" style="background-color: {{ $titleColor->color }}" id="title_color_7_4"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>Subtítulo</p>
                        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="subtitle_color_7_4"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Input group-->
        </div>
    </div>
</div>
<!--end::LAYOUT 7-->

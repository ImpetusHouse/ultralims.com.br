<!--begin::LAYOUT 2-->
<div id="div-layout-2" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link active" data-bs-toggle="tab" href="#layout-2-0">Geral</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#layout-2-1">Aba 1</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#layout-2-2">Aba 2</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#layout-2-3">Aba 3</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#layout-2-4">Aba 4</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="layout-2-0" role="tabpanel">
            <!--begin::Input group-->
            <div class="row mb-12">
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Margin top</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="number" value="15" class="form-control" name="margin_top_2" id="margin_top_2" />
                    <!--end::Input-->
                </div>
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Margin bottom</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="number" value="15" class="form-control" name="margin_bottom_2" id="margin_bottom_2" />
                    <!--end::Input-->
                </div>
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Fundo</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Fundo
                        </p>
                        <div class="color-select" style="background-color: #151624" id="background_color_2"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>Título 1</p>
                        <div class="color-select" style="background-color: {{ $titleColor->color }}" id="title_color_2"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>Título 2</p>
                        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="subtitle_color_2"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>Conteúdo</p>
                        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="content_color_2"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="layout-2-1" role="tabpanel">
            <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Título
                        </p>
                        <div class="color-select" style="background-color: {{ $titleColor->color }}" id="title_color_2_1"></div>
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
                        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="subtitle_color_2_1"></div>
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
        <div class="tab-pane fade" id="layout-2-2" role="tabpanel">
            <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Título
                        </p>
                        <div class="color-select" style="background-color: {{ $titleColor->color }}" id="title_color_2_2"></div>
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
                        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="subtitle_color_2_2"></div>
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
        <div class="tab-pane fade" id="layout-2-3" role="tabpanel">
            <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Título
                        </p>
                        <div class="color-select" style="background-color: {{ $titleColor->color }}" id="title_color_2_3"></div>
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
                        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="subtitle_color_2_3"></div>
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
        <div class="tab-pane fade" id="layout-2-4" role="tabpanel">
            <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Título
                        </p>
                        <div class="color-select" style="background-color: {{ $titleColor->color }}" id="title_color_2_4"></div>
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
                        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="subtitle_color_2_4"></div>
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
<!--end::LAYOUT 2-->

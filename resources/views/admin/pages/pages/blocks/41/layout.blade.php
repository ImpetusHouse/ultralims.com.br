<!--begin::LAYOUT 41-->
<div id="div-layout-41" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link active" data-bs-toggle="tab" href="#layout-41-0">Geral</a>
        </li>
        @for($y = 1; $y <= 4; $y++)
            <li class="nav-item text-center" style="width: 20%">
                <a class="nav-link" data-bs-toggle="tab" href="#layout-41-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="layout-41-0" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-12">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Alinhamento (Imagens)</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" data-control="select2"
                        data-hide-search="true" data-placeholder="Selecione uma opção"
                        id="content_alignment_41" name="content_alignment_41">
                    <option></option>
                    <option value="left">Alinhado à esquerda</option>
                    <option value="right">Alinhado à direita</option>
                </select>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-12">
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Margin top</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="number" value="15" class="form-control" name="margin_top_41" id="margin_top_41" />
                    <!--end::Input-->
                </div>
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Margin bottom</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="number" value="15" class="form-control" name="margin_bottom_41" id="margin_bottom_41" />
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
                        <div class="color-select" style="background-color: #151624" id="background_color_41"></div>
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
                        <p>
                            Texto
                        </p>
                        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="tag_color_41"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Título 1
                        </p>
                        <div class="color-select" style="background-color: {{$titleColor->color}}" id="title_color_41"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Título 2
                        </p>
                        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="subtitle_color_41"></div>
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
        @for($y = 1; $y <= 4; $y++)
            <div class="tab-pane fade" id="layout-41-{{ $y }}" role="tabpanel">
                <h2 class="fw-bold text-dark mb-6">Fundo</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box mb-12">
                    <div class="color-box-parent">
                        <div class="color-box">
                            <p>
                                Fundo
                            </p>
                            <div class="color-select" style="background-color: #151624" id="background_color_41_{{ $y }}"></div>
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
                            <p>
                                Ícone
                            </p>
                            <div class="color-select" style="background-color: {{ $iconColor->color }}" id="icon_color_41_{{ $y }}"></div>
                            <div class="colors-box">
                                @foreach($colors as $color)
                                    <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="color-box-parent">
                        <div class="color-box">
                            <p>
                                Título
                            </p>
                            <div class="color-select" style="background-color: {{$titleColor->color}}" id="title_color_41_{{ $y }}"></div>
                            <div class="colors-box">
                                @foreach($colors as $color)
                                    <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="color-box-parent">
                        <div class="color-box">
                            <p>
                                Conteúdo
                            </p>
                            <div class="color-select" style="background-color: {{ $contentColor->color }}" id="subtitle_color_41_{{ $y }}"></div>
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
        @endfor
    </div>
</div>
<!--end::LAYOUT 41-->

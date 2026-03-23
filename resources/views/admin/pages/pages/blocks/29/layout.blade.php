<!--begin::LAYOUT 29-->
<div id="div-layout-29" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="row mb-12">
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2">Margin top</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="number" value="40" class="form-control" name="margin_top_29" id="margin_top_29" />
            <!--end::Input-->
        </div>
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2">Margin bottom</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="number" value="0" class="form-control" name="margin_bottom_29" id="margin_bottom_29" />
            <!--end::Input-->
        </div>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-12">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Tamanho do título</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="type_29" name="type_29">
            <option></option>
            <option value="text-sm">Pequeno</option>
            <option value="text-md">Médio</option>
            <option value="text-lg">Grande</option>
            <option value="block-title">Padrão</option>
        </select>
        <!--end::Input-->
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
                <div class="color-select" style="background-color: #151624" id="background_color_29"></div>
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
    <div class="colors-parent-box mb-12">
        <div class="color-box-parent">
            <div class="color-box">
                <p>
                    Título 1
                </p>
                <div class="color-select" style="background-color: {{$titleColor->color}}" id="title_color_29"></div>
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
                <div class="color-select" style="background-color: {{ $contentColor->color }}" id="subtitle_color_29"></div>
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
                    Descrição
                </p>
                <div class="color-select" style="background-color: {{ $contentColor->color }}" id="content_color_29"></div>
                <div class="colors-box">
                    @foreach($colors as $color)
                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Card</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        <div class="color-box-parent">
            <div class="color-box">
                <p>
                    Título
                </p>
                <div class="color-select" style="background-color: {{$titleColor->color}}" id="topics_color_29"></div>
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
                    Barra
                </p>
                <div class="color-select" style="background-color: {{ $contentColor->color }}" id="pdf_color_29"></div>
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
<!--end::LAYOUT 29-->

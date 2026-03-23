<!--begin::LAYOUT 38-->
<div id="div-layout-38" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="row mb-12">
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2">Alinhamento (Formulário)</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select class="form-select mb-2" data-control="select2"
                    data-hide-search="true" data-placeholder="Selecione uma opção"
                    id="content_alignment_38" name="content_alignment_38">
                <option></option>
                <option value="left">Alinhado à esquerda</option>
                <option value="right">Alinhado à direita</option>
            </select>
            <!--end::Input-->
        </div>
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2">Layout (Botão)</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="type_38" name="type_38">
                <option></option>
                <option value="1">Layout 1</option>
                <option value="2">Layout 2</option>
            </select>
            <!--end::Input-->
        </div>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="row mb-12">
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2">Margin top</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="number" value="15" class="form-control" name="margin_top_38" id="margin_top_38" />
            <!--end::Input-->
        </div>
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2">Margin bottom</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="number" value="15" class="form-control" name="margin_bottom_38" id="margin_bottom_38" />
            <!--end::Input-->
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
                <div class="color-select" style="background-color: {{$titleColor->color}}" id="title_color_38"></div>
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
                <div class="color-select" style="background-color: {{ $contentColor->color }}" id="subtitle_color_38"></div>
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
                <div class="color-select" style="background-color: {{ $contentColor->color }}" id="content_color_38"></div>
                <div class="colors-box">
                    @foreach($colors as $color)
                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Formulário</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        <div class="color-box-parent">
            <div class="color-box">
                <p>
                    Fundo
                </p>
                <div class="color-select" style="background-color: #151624" id="background_color_38"></div>
                <div class="colors-box">
                    @foreach($colors as $color)
                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="color-box-parent">
            <div class="color-box">
                <p>Título</p>
                <div class="color-select" style="background-color: {{ $titleColor->color }}" id="tag_title_color_38"></div>
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
                    Input
                </p>
                <div class="color-select" style="background-color: #151624" id="primary_color_38"></div>
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
                    Bordas
                </p>
                <div class="color-select" style="background-color: #151624" id="tag_color_38"></div>
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
                    Texto
                </p>
                <div class="color-select" style="background-color: {{ $contentColor->color }}" id="pdf_color_38"></div>
                <div class="colors-box">
                    @foreach($colors as $color)
                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        <div class="color-box-parent">
            <div class="color-box">
                <p>
                    Botão
                </p>
                <div class="color-select" style="background-color: #151624" id="button_color_38"></div>
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
                    Texto
                </p>
                <div class="color-select" style="background-color: #151624" id="button_title_color_38"></div>
                <div class="colors-box">
                    @foreach($colors as $color)
                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão 2</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        <div class="color-box-parent">
            <div class="color-box">
                <p>
                    Botão
                </p>
                <div class="color-select" style="background-color: #151624" id="button_color1_38"></div>
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
                    Texto
                </p>
                <div class="color-select" style="background-color: #151624" id="button_title_color1_38"></div>
                <div class="colors-box">
                    @foreach($colors as $color)
                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão (Formulário)</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        <div class="color-box-parent">
            <div class="color-box">
                <p>
                    Botão
                </p>
                <div class="color-select" style="background-color: #151624" id="button_color_38_1"></div>
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
                    Texto
                </p>
                <div class="color-select" style="background-color: #151624" id="button_title_color_38_1"></div>
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
<!--end::LAYOUT 9-->

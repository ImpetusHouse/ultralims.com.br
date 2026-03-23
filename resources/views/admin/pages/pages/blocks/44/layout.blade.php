<!--begin::LAYOUT 44-->
<div id="div-layout-44" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="row mb-12">
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2">Margin top</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="number" value="15" class="form-control" name="margin_top_44" id="margin_top_44" />
            <!--end::Input-->
        </div>
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2">Margin bottom</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="number" value="15" class="form-control" name="margin_bottom_44" id="margin_bottom_44" />
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
                <div class="color-select" style="background-color: #151624" id="background_color_44"></div>
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
                    Tag
                </p>
                <div class="color-select" style="background-color: {{$titleColor->color}}" id="tag_color_44"></div>
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
                <div class="color-select" style="background-color: {{$titleColor->color}}" id="title_color_44"></div>
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
                <div class="color-select" style="background-color: {{ $contentColor->color }}" id="subtitle_color_44"></div>
                <div class="colors-box">
                    @foreach($colors as $color)
                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Portfólio</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        <div class="color-box-parent">
            <div class="color-box">
                <p>
                    Tag
                </p>
                <div class="color-select" style="background-color: {{$titleColor->color}}" id="subtitle_color_44_1"></div>
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
                <div class="color-select" style="background-color: {{$titleColor->color}}" id="title_color_44_1"></div>
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
                <div class="color-select" style="background-color: {{ $contentColor->color }}" id="content_color_44_1"></div>
                <div class="colors-box">
                    @foreach($colors as $color)
                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão (Categorias)</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        <div class="color-box-parent">
            <div class="color-box">
                <p>
                    Botão
                </p>
                <div class="color-select" style="background-color: #151624" id="button_color_44_1"></div>
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
                <div class="color-select" style="background-color: #151624" id="button_title_color_44_1"></div>
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
                    Botão (Selecionado)
                </p>
                <div class="color-select" style="background-color: #151624" id="button_color1_44_1"></div>
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
                    Texto (Selecionado)
                </p>
                <div class="color-select" style="background-color: #151624" id="button_title_color1_44_1"></div>
                <div class="colors-box">
                    @foreach($colors as $color)
                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão (Portifólio)</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        <div class="color-box-parent">
            <div class="color-box">
                <p>
                    Botão
                </p>
                <div class="color-select" style="background-color: #151624" id="button_color_44"></div>
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
                <div class="color-select" style="background-color: #151624" id="button_title_color_44"></div>
                <div class="colors-box">
                    @foreach($colors as $color)
                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão (Ver todos)</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        <div class="color-box-parent">
            <div class="color-box">
                <p>
                    Botão
                </p>
                <div class="color-select" style="background-color: #151624" id="button_color1_44"></div>
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
                <div class="color-select" style="background-color: #151624" id="button_title_color1_44"></div>
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
<!--end::LAYOUT 44-->

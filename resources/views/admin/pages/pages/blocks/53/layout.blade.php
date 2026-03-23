<!--begin::LAYOUT 53-->
<div id="div-layout-53" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="row mb-12">
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2">Margin top</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="number" value="15" class="form-control" name="margin_top_53" id="margin_top_53" />
            <!--end::Input-->
        </div>
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2">Margin bottom</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="number" value="15" class="form-control" name="margin_bottom_53" id="margin_bottom_53" />
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
                <div class="color-select" style="background-color: #151624" id="background_color_53"></div>
                <div class="colors-box">
                    @foreach($colors as $color)
                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tag</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        <div class="color-box-parent">
            <div class="color-box">
                <p>
                    Fundo
                </p>
                <div class="color-select" style="background-color: {{$titleColor->color}}" id="tag_color_53"></div>
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
                <div class="color-select" style="background-color: {{ $contentColor->color }}" id="tag_title_color_53"></div>
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
                <div class="color-select" style="background-color: {{$titleColor->color}}" id="title_color_53"></div>
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
                <div class="color-select" style="background-color: {{ $contentColor->color }}" id="subtitle_color_53"></div>
                <div class="colors-box">
                    @foreach($colors as $color)
                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">FAQ's</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        <div class="color-box-parent">
            <div class="color-box">
                <p>
                    Título
                </p>
                <div class="color-select" style="background-color: {{ $titleColor->color }}" id="content_color_53"></div>
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
                    Título (Hover)
                </p>
                <div class="color-select" style="background-color: {{ $contentColor->color }}" id="primary_color_53"></div>
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
<!--end::LAYOUT 53-->

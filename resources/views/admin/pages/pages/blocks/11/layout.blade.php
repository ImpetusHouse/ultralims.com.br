<!--begin::LAYOUT 11-->
<div id="div-layout-11" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 11, 'required' => 'required', 'margin' => 'mb-9'])
    @include('admin.pages.pages.components.layout.content_alignment', ['blockNumber' => 11, 'required' => 'required', 'margin' => 'mb-9', 'titleLabel' => 'Alinhamento (Publicações)'])
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 11])
    </div>
    <!--end::Input group-->
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 11])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 11])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 11])
    </div>
    <!--end::Input group-->
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Blog</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        <div class="color-box-parent">
            <div class="color-box">
                <p>
                    Título
                </p>
                <div class="color-select" style="background-color: {{$titleColor->color}}" id="button_color_11"></div>
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
                <div class="color-select" style="background-color: {{ $contentColor->color }}" id="button_title_color_11"></div>
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
                    Ver todas...
                </p>
                <div class="color-select" style="background-color: #151624" id="primary_color_11"></div>
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
<!--end::LAYOUT 11-->

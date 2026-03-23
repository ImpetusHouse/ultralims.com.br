<!--begin::LAYOUT 54-->
<div id="div-layout-54" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 54, 'required' => 'required', 'margin' => 'mb-9'])
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 54])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 54])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 54])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 54])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Depoimento</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.primary_color', ['blockNumber' => 54, 'titleLabel' => 'Depoimento'])
        @include('admin.pages.pages.components.layout.tag', ['blockNumber' => 54, 'titleLabel' => 'Nome'])
        @include('admin.pages.pages.components.layout.tag-title', ['blockNumber' => 54, 'titleLabel' => 'Subtítulo'])
        <div class="color-box-parent">
            <div class="color-box">
                <p>
                    Divisor
                </p>
                <div class="color-select" style="background-color: {{ $contentColor->color }}" id="divider_color_54"></div>
                <div class="colors-box">
                    @foreach($colors as $color)
                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Paginação</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        <div class="color-box-parent">
            <div class="color-box">
                <p>
                    Ativo
                </p>
                <div class="color-select" style="background-color: {{ $titleColor->color }}" id="logo_background_color_54"></div>
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
                    Inativo
                </p>
                <div class="color-select" style="background-color: {{ $contentColor->color }}" id="logo_title_color_54"></div>
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
<!--end::LAYOUT 54-->

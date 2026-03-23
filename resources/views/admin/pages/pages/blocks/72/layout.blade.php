<!--begin::LAYOUT 72-->
<div id="div-layout-72" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 72, 'required' => 'required', 'margin' => 'mb-12'])
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 72])
    </div>
    <!--end::Input group-->
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 72])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 72])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Produto</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.primary_color', ['blockNumber' => 72, 'titleLabel' => 'Borda'])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 72, 'titleLabel' => 'Título'])
        @include('admin.pages.pages.components.layout.tag', ['blockNumber' => 72, 'titleLabel' => 'Preço'])
    </div>
    <!--end::Input group-->
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        @include('admin.pages.pages.components.layout.button', ['blockNumber' => 72])
        @include('admin.pages.pages.components.layout.button-hover', ['blockNumber' => 72])
        @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 72])
    </div>
    <!--end::Input group-->
</div>
<!--end::LAYOUT 72-->

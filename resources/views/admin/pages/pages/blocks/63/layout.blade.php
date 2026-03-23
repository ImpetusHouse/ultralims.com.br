<!--begin::LAYOUT 63-->
<div id="div-layout-63" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 63, 'required' => 'required', 'margin' => 'mb-9'])
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 63])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 63])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 63])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 63])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão</h2>
    <!--begin::Input group-->
    @include('admin.pages.pages.components.layout.type', ['blockNumber' => 63, 'required' => null, 'margin' => 'mb-4'])
    <div class="colors-parent-box">
        @include('admin.pages.pages.components.layout.button', ['blockNumber' => 63])
        @include('admin.pages.pages.components.layout.button-hover', ['blockNumber' => 63])
        @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 63])
    </div>
    <!--end::Input group-->
</div>
<!--end::LAYOUT 63-->

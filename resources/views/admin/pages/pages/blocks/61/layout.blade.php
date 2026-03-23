<!--begin::LAYOUT 61-->
<div id="div-layout-61" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 61, 'required' => 'required', 'margin' => 'mb-9'])
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 61])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 61, 'titleLabel' => 'Título'])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 61, 'titleLabel' => 'Subtítulo'])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.button', ['blockNumber' => 61])
        @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 61])
    </div>
    <!--end::Input group-->
</div>
<!--end::LAYOUT 61-->

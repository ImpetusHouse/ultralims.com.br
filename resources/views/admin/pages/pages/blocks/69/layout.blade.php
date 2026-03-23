<!--begin::LAYOUT 69-->
<div id="div-layout-69" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 69, 'required' => 'required', 'margin' => 'mb-9'])
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 69])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tag</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.tag', ['blockNumber' => 69])
        @include('admin.pages.pages.components.layout.tag-title', ['blockNumber' => 69])
    </div>
    <!--end::Input group-->
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 69])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 69])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 69])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão</h2>
    <!--begin::Input group-->
    @include('admin.pages.pages.components.layout.type', ['blockNumber' => 69, 'required' => null, 'margin' => 'mb-4'])
    <div class="colors-parent-box">
        @include('admin.pages.pages.components.layout.button', ['blockNumber' => 69])
        @include('admin.pages.pages.components.layout.button-hover', ['blockNumber' => 69])
        @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 69])
    </div>
    <!--end::Input group-->
</div>
<!--end::LAYOUT 69-->

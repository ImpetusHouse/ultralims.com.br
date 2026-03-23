<!--begin::LAYOUT 13-->
<div id="div-layout-13" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 13, 'required' => 'required', 'margin' => 'mb-12'])
    @include('admin.pages.pages.components.layout.content_alignment', ['blockNumber' => 13, 'required' => 'required', 'margin' => 'mb-12'])
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 13])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 13])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 13])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 13])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        @include('admin.pages.pages.components.layout.button', ['blockNumber' => 13])
        @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 13])
    </div>
    <!--end::Input group-->
</div>
<!--end::LAYOUT 13-->

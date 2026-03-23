<!--begin::LAYOUT 32-->
<div id="div-layout-32" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 32, 'required' => 'required', 'margin' => 'mb-9'])
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 32])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 32, 'titleLabel' => 'Título'])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 32])
    </div>
</div>
<!--end::LAYOUT 32-->

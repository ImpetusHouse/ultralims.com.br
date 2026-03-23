<!--begin::LAYOUT 65-->
<div id="div-layout-65" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 65, 'required' => 'required', 'margin' => 'mb-12'])
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 65])
        @include('admin.pages.pages.components.layout.primary_color', ['blockNumber' => 65, 'titleLabel' => 'Card'])
        @include('admin.pages.pages.components.layout.tag', ['blockNumber' => 65, 'titleLabel' => 'Logo'])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 65])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 65])
    </div>
    <!--end::Input group-->
</div>
<!--end::LAYOUT 65-->

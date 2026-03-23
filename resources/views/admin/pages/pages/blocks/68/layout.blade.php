<!--begin::LAYOUT 68-->
<div id="div-layout-68" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 68, 'required' => 'required', 'margin' => 'mb-9'])
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 68])
        @include('admin.pages.pages.components.layout.primary_color', ['blockNumber' => 68, 'titleLabel' => 'Card'])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tag</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.tag', ['blockNumber' => 68])
        @include('admin.pages.pages.components.layout.tag-title', ['blockNumber' => 68])
    </div>
    <!--end::Input group-->
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 68])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 68])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 68])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão</h2>
    <!--begin::Input group-->
    @include('admin.pages.pages.components.layout.type', ['blockNumber' => 68, 'required' => null, 'margin' => 'mb-4'])
    <div class="colors-parent-box">
        @include('admin.pages.pages.components.layout.button', ['blockNumber' => 68])
        @include('admin.pages.pages.components.layout.button-hover', ['blockNumber' => 68])
        @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 68])
    </div>
    <!--end::Input group-->
</div>
<!--end::LAYOUT 68-->

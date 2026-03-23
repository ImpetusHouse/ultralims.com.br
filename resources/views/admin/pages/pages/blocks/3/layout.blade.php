<!--begin::LAYOUT 3-->
<div id="div-layout-3" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 3, 'required' => 'required', 'margin' => 'mb-9'])
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 3])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 3])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 3])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão 1</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.button', ['blockNumber' => 3])
        @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 3])
    </div>
    <!--end::Input group-->
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão 2</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        @include('admin.pages.pages.components.layout.button', ['blockNumber' => 3, 'tabNumber' => 1])
        @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 3, 'tabNumber' => 1])
    </div>
    <!--end::Input group-->
</div>
<!--end::LAYOUT 3-->

<!--begin::LAYOUT 70-->
<div id="div-layout-70" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 70, 'required' => 'required', 'margin' => 'mb-12'])
    @include('admin.pages.pages.components.layout.content_alignment', ['blockNumber' => 70, 'required' => 'required', 'margin' => 'mb-12', 'center' => true])
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 70])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 70])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 70])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 70])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Pesquisa</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        @include('admin.pages.pages.components.layout.tag', ['blockNumber' => 70, 'titleLabel' => 'Fundo'])
        @include('admin.pages.pages.components.layout.pdf_color', ['blockNumber' => 70, 'titleLabel' => 'Texto'])
    </div>
    <!--end::Input group-->
</div>
<!--end::LAYOUT 70-->

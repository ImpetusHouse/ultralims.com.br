<!--begin::LAYOUT 62-->
<div id="div-layout-62" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 62, 'required' => 'required', 'margin' => 'mb-12'])
    <div class="row">
        <div class="col-6">
            @include('admin.pages.pages.components.layout.content_alignment', ['blockNumber' => 62, 'required' => 'required', 'margin' => 'mb-12'])
        </div>
        <div class="col-6">
            @include('admin.pages.pages.components.layout.display_content', ['blockNumber' => 62, 'required' => 'required', 'margin' => 'mb-12', 'titleLabel' => 'Exibir (Pattern)?'])
        </div>
    </div>
    @include('admin.pages.pages.components.layout.display_content', ['blockNumber' => 62, 'tabNumber' => 1, 'required' => 'required', 'margin' => 'mb-12', 'titleLabel' => 'Exibir imagem no mobile?'])
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 62])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 62])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 62])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 62])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão</h2>
    <!--begin::Input group-->
    @include('admin.pages.pages.components.layout.type', ['blockNumber' => 62, 'required' => null, 'margin' => 'mb-4'])
    <div class="colors-parent-box">
        @include('admin.pages.pages.components.layout.button', ['blockNumber' => 62])
        @include('admin.pages.pages.components.layout.button-hover', ['blockNumber' => 62])
        @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 62])
    </div>
    <!--end::Input group-->
</div>
<!--end::LAYOUT 62-->

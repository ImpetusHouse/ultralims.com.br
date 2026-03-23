<!--begin::LAYOUT 20-->
<div id="div-layout-20" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    @include('admin.pages.pages.components.layout.content_alignment', ['blockNumber' => 20, 'required' => 'required', 'margin' => 'mb-12', 'titleLabel' => "Alinhamento (Imagem)"])
    <!--end::Input group-->
    <!--begin::Input group-->
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 20, 'required' => 'required', 'margin' => 'mb-12'])
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 20, 'titleLabel' => 'Direito'])
        @include('admin.pages.pages.components.layout.primary_color', ['blockNumber' => 20, 'titleLabel' => 'Esquerdo'])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 20])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 20])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 20])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        @include('admin.pages.pages.components.layout.button', ['blockNumber' => 20])
        @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 20])
    </div>
    <!--end::Input group-->
</div>
<!--end::LAYOUT 20-->

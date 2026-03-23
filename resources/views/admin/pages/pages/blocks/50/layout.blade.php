<!--begin::LAYOUT 50-->
<div id="div-layout-50" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="row mb-12">
        <div class="col-4">
            @include('admin.pages.pages.components.layout.display_content', ['blockNumber' => 50, 'tabNumber' => 1, 'required' => 'required', 'title', 'titleLabel' => 'Exibir pattern? (Esquerda)', 'margin' => null])
        </div>
        <div class="col-4">
            @include('admin.pages.pages.components.layout.display_content', ['blockNumber' => 50, 'tabNumber' => 2, 'required' => 'required', 'title', 'titleLabel' => 'Exibir pattern? (Direita)', 'margin' => null])
        </div>
        <div class="col-4">
            @include('admin.pages.pages.components.layout.type', ['blockNumber' => 50, 'required' => 'required', 'margin' => null])
        </div>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 50, 'required' => 'required', 'margin' => 'mb-9'])
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 50, 'title', 'titleLabel' => 'Esquerda'])
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 50, 'tabNumber' => 1, 'title', 'titleLabel' => 'Direita'])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 50])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 50])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 50])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        @include('admin.pages.pages.components.layout.button', ['blockNumber' => 50])
        @include('admin.pages.pages.components.layout.button-hover', ['blockNumber' => 50])
        @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 50])
    </div>
    <!--end::Input group-->
</div>
<!--end::LAYOUT 9-->

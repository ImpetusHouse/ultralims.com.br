<!--begin::LAYOUT 40-->
<div id="div-layout-40" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 40, 'required' => 'required', 'margin' => 'mb-12'])
    <!--begin::Input group-->
    <div class="row mb-12">
        <div class="col-4">
            @include('admin.pages.pages.components.layout.content_alignment', ['blockNumber' => 40, 'required' => 'required', 'margin' => null, 'titleLabel' => 'Alinhamento (Imagem)'])
        </div>
        <div class="col-4">
            @include('admin.pages.pages.components.layout.type', ['blockNumber' => 40, 'required' => 'required', 'margin' => null])
        </div>
        <div class="col-4">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2">Exibir (Pattern)</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="display_content_40_1" name="display_content_40_1">
                <option></option>
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
            <!--end::Input-->
        </div>
    </div>
    @include('admin.pages.pages.components.layout.display_content', ['blockNumber' => 40, 'required' => 'required', 'margin' => 'mb-12', 'titleLabel' => 'Exibir imagem no mobile?'])
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 40])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 40])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 40])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 40])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.button', ['blockNumber' => 40])
        @include('admin.pages.pages.components.layout.button-hover', ['blockNumber' => 40])
        @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 40])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Botão 2</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        @include('admin.pages.pages.components.layout.button', ['blockNumber' => 40, 'buttonOne' => true])
        @include('admin.pages.pages.components.layout.button-hover', ['blockNumber' => 40, 'buttonOne' => true])
        @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 40, 'buttonOne' => true])
    </div>
    <!--end::Input group-->
</div>
<!--end::LAYOUT 9-->

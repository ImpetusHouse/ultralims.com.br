<!--begin::LAYOUT 31-->
<div id="div-layout-31" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 31, 'required' => 'required', 'margin' => 'mb-12'])
    <!--begin::Input group-->
    <div class="fv-row mb-12">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Alinhamento</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="content_alignment_31" name="content_alignment_31">
            <option></option>
            <option value="left">Esquerda</option>
            <option value="center">Centro</option>
        </select>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 31])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 31])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 31])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 31])
    </div>
    <!--end::Input group-->
</div>
<!--end::LAYOUT 31-->

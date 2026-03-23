<!--begin::CONTEÚDO 4-->
<div id="content-4" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Layout</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="type_4" name="type_4">
            <option></option>
            <option value="1">Com campo de e-mail</option>
            <option value="2">Sem campo de e-mail</option>
        </select>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Título 1</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="title_4" id="title_4" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Título 2</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="subtitle_4" id="subtitle_4" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Descrição</label>
        <!--end::Label-->
        <!--begin::Input-->
        <textarea class="form-control resize-none" name="content_4" id="content_4" rows="4" style="resize: none"></textarea>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2" id="label_content_type_4">Imagem</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="file" accept="image/*" class="form-control" name="image_4" id="image_4" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    @include('admin.pages.pages.components.button', ['blockNumber' => 4, 'titleBtn' => 'Botão (Layout 2)'])
</div>
<!--end::CONTEÚDO 4-->

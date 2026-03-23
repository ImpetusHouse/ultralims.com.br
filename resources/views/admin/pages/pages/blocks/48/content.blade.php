<!--begin::CONTEÚDO 48-->
<div id="content-48" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="row mb-9">
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2">Tipo do conteúdo</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="content_type_48" name="content_type_48" onchange="changeContentType(48, this)">
                <option></option>
                <option value="image">Imagem</option>
                <option value="youtube_embed">Youtube</option>
            </select>
            <!--end::Input-->
        </div>
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2" id="label_content_type_48">Imagem</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="file" accept="image/*" class="form-control" name="image_48" id="image_48" />
            <!--end::Input-->
        </div>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label id="label_url_48" class="fs-6 fw-semibold mb-2">URL</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="content_link_48" id="content_link_48">
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Título 1</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="title_48" id="title_48" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Título 2</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="subtitle_48" id="subtitle_48" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    @include('admin.pages.pages.components.button', ['blockNumber' => 48, 'margin' => 'mb-9'])
    @include('admin.pages.pages.components.button', ['blockNumber' => 48, 'buttonOne' => true, 'titleBtn' => 'Botão 2'])
</div>
<!--end::CONTEÚDO 48-->

<!--begin::CONTEÚDO 13-->
<div id="content-13" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="row mb-9">
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2">Tipo do conteúdo</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="content_type_13" name="content_type_13" onchange="changeContentType(13, this)">
                <option></option>
                <option value="image">Imagem</option>
                <option value="youtube_embed">Youtube</option>
            </select>
            <!--end::Input-->
        </div>
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2" id="label_content_type_13">Imagem</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="file" accept="image/*" class="form-control" name="image_13" id="image_13" />
            <!--end::Input-->
        </div>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label id="label_url_13" class="fs-6 fw-semibold mb-2">URL</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="content_link_13" id="content_link_13">
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    @include('admin.pages.pages.components.title', ['blockNumber' => 13, 'required' => 'required', 'margin' => 'mb-9'])
    <!--begin::Input group-->
    @include('admin.pages.pages.components.description', ['blockNumber' => 13, 'required' => 'required', 'margin' => 'mb-9'])
    <!--end::Input group-->
    @include('admin.pages.pages.components.button', ['blockNumber' => 13])
</div>
<!--end::CONTEÚDO 13-->

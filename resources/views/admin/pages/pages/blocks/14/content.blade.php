<!--begin::CONTEÚDO 14-->
<div id="content-14" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="row mb-9">
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2">Tipo do conteúdo</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="content_type_14" name="content_type_14" onchange="changeContentType(14, this)">
                <option></option>
                <option value="image">Imagem</option>
                <option value="video">Vídeo</option>
            </select>
            <!--end::Input-->
        </div>
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2" id="label_content_type_14">Imagem</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="file" accept="image/*" class="form-control" name="image_14" id="image_14" />
            <input type="file" accept="video/*" class="form-control" name="video_14" id="video_14" />
            <!--end::Input-->
        </div>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Título 1</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="title_14" id="title_14" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Título 2</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="subtitle_14" id="subtitle_14" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Descrição</label>
        <!--end::Label-->
        <!--begin::Input-->
        <textarea class="form-control resize-none" name="content_14" id="content_14" rows="4" style="resize: none"></textarea>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Imagem (Pattern)</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="file" accept="image/*" class="form-control" name="logo_14" id="logo_14" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    @include('admin.pages.pages.components.button', ['blockNumber' => 14, 'titleBtn' => 'Botão 1', 'margin' => 'mb-9'])
    @include('admin.pages.pages.components.button', ['blockNumber' => 14, 'tabNumber' => 1, 'titleBtn' => 'Botão 2'])
</div>
<!--end::CONTEÚDO 14-->

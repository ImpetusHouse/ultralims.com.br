<!--begin::CONTEÚDO 3-->
<div id="content-3" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="row mb-9">
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2">Tipo do conteúdo</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="content_type_3" name="content_type_3" onchange="changeContentType(3, this)">
                <option></option>
                <option value="image">Imagem</option>
                <option value="video">Vídeo</option>
            </select>
            <!--end::Input-->
        </div>
        <div class="col-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold required mb-2" id="label_content_type_3">Imagem</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="file" accept="image/*" class="form-control" name="image_3" id="image_3" />
            <input type="file" accept="video/*" class="form-control" name="video_3" id="video_3" />
            <!--end::Input-->
        </div>
    </div>
    <!--end::Input group-->
    @include('admin.pages.pages.components.title', ['blockNumber' => 3, 'required' => 'required', 'margin' => 'mb-9'])
    @include('admin.pages.pages.components.description', ['blockNumber' => 3, 'required' => 'required', 'margin' => 'mb-9'])
    @include('admin.pages.pages.components.button', ['blockNumber' => 3, 'titleBtn' => 'Botão 1', 'margin' => 'mb-9'])
    @include('admin.pages.pages.components.button', ['blockNumber' => 3, 'tabNumber' => 1, 'titleBtn' => 'Botão 2'])
</div>
<!--end::CONTEÚDO 3-->

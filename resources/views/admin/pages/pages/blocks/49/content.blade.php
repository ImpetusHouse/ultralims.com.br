<!--begin::CONTEÚDO 49-->
<div id="content-49" class="w-100 mw-600px" style="display: none">
    <input type="hidden" class="form-control" name="title_49_1" id="title_49_1" value="Banner" />
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Título 1</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="title_49" id="title_49" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Título 2</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="subtitle_49" id="subtitle_49" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2 required">Descrição</label>
        <!--end::Label-->
        <!--begin::Input-->
        <textarea class="form-control resize-none" name="content_49" id="content_49" rows="4" style="resize: none"></textarea>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Imagem</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="file" accept="image/*" class="form-control" name="image_49_1" id="image_49_1" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Fundo</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="file" accept="image/*" class="form-control" name="image_49" id="image_49" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    @include('admin.pages.pages.components.button', ['blockNumber' => 49, 'margin' => 'mb-9'])
    @include('admin.pages.pages.components.button', ['blockNumber' => 49, 'buttonOne' => true, 'titleBtn' => 'Botão 2'])
</div>
<!--end::CONTEÚDO 49-->

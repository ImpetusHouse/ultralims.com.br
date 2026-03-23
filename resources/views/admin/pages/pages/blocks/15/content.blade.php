<!--begin::CONTEÚDO 15-->
<div id="content-15" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link active" data-bs-toggle="tab" href="#content-15-0">Geral</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#content-15-1">Aba 1</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#content-15-2">Aba 2</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#content-15-3">Aba 3</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#content-15-4">Aba 4</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="content-15-0" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Título 1</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="title_15" id="title_15" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Título 2</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="subtitle_15" id="subtitle_15" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Conteúdo</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea type="text" class="form-control resize-none" name="content_15" id="content_15" rows="4"></textarea>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            @include('admin.pages.pages.components.button', ['blockNumber' => 15])
        </div>
        <div class="tab-pane fade" id="content-15-1" role="tabpanel">
            <!--begin::Input group-->
            <div class="row mb-9">
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Tipo do conteúdo</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="content_type_15_1" name="content_type_15_1" onchange="changeContentType(15, this, 1)">
                        <option></option>
                        <option value="image">Imagem</option>
                        <option value="youtube_embed">Youtube</option>
                    </select>
                    <!--end::Input-->
                </div>
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2" id="label_content_type_15_1">Imagem</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="file" accept="image/*" class="form-control" name="image_15_1" id="image_15_1" />
                    <!--end::Input-->
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row">
                <!--begin::Label-->
                <label id="label_url_15_1" class="fs-6 fw-semibold mb-2">URL</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="content_link_15_1" id="content_link_15_1">
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <div class="tab-pane fade" id="content-15-2" role="tabpanel">
            <!--begin::Input group-->
            <div class="row mb-9">
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Tipo do conteúdo</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="content_type_15_2" name="content_type_15_2" onchange="changeContentType(15, this, 2)">
                        <option></option>
                        <option value="image">Imagem</option>
                        <option value="youtube_embed">Youtube</option>
                    </select>
                    <!--end::Input-->
                </div>
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2" id="label_content_type_15_2">Imagem</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="file" accept="image/*" class="form-control" name="image_15_2" id="image_15_2" />
                    <!--end::Input-->
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row">
                <!--begin::Label-->
                <label id="label_url_15_2" class="fs-6 fw-semibold mb-2">URL</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="content_link_15_2" id="content_link_15_2">
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <div class="tab-pane fade" id="content-15-3" role="tabpanel">
            <!--begin::Input group-->
            <div class="row mb-9">
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Tipo do conteúdo</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="content_type_15_3" name="content_type_15_3" onchange="changeContentType(15, this, 3)">
                        <option></option>
                        <option value="image">Imagem</option>
                        <option value="youtube_embed">Youtube</option>
                    </select>
                    <!--end::Input-->
                </div>
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2" id="label_content_type_15_3">Imagem</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="file" accept="image/*" class="form-control" name="image_15_3" id="image_15_3" />
                    <!--end::Input-->
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row">
                <!--begin::Label-->
                <label id="label_url_15_3" class="fs-6 fw-semibold mb-2">URL</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="content_link_15_3" id="content_link_15_3">
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <div class="tab-pane fade" id="content-15-4" role="tabpanel">
            <!--begin::Input group-->
            <div class="row mb-9">
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Tipo do conteúdo</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="content_type_15_4" name="content_type_15_4" onchange="changeContentType(15, this, 4)">
                        <option></option>
                        <option value="image">Imagem</option>
                        <option value="youtube_embed">Youtube</option>
                    </select>
                    <!--end::Input-->
                </div>
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2" id="label_content_type_15_4">Imagem</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="file" accept="image/*" class="form-control" name="image_15_4" id="image_15_4" />
                    <!--end::Input-->
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row">
                <!--begin::Label-->
                <label id="label_url_15_4" class="fs-6 fw-semibold mb-2">URL</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="content_link_15_4" id="content_link_15_4">
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
    </div>
</div>
<!--end::CONTEÚDO 15-->

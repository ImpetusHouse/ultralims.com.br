<!--begin::CONTEÚDO 5-->
<div id="content-5" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link active" data-bs-toggle="tab" href="#content-5-0">Geral</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#content-5-1">Aba 1</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#content-5-2">Aba 2</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#content-5-3">Aba 3</a>
        </li>
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link" data-bs-toggle="tab" href="#content-5-4">Aba 4</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="content-5-0" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Tag</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="tag_5" id="tag_5" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Título 1</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="title_5" id="title_5" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Título 2</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="subtitle_5" id="subtitle_5" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Conteúdo</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea type="text" class="form-control resize-none" name="content_5" id="content_5" rows="4"></textarea>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <div class="tab-pane fade" id="content-5-1" role="tabpanel">
            <!--begin::Input group-->
            <div class="row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Exibir</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="display_content_5_1" name="display_content_5_1">
                    <option></option>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row">
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Tipo do conteúdo</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="content_type_5_1" name="content_type_5_1" onchange="changeContentType(5, this, 1)">
                        <option></option>
                        <option value="image">Imagem</option>
                        <option value="video">Vídeo</option>
                    </select>
                    <!--end::Input-->
                </div>
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2" id="label_content_type_5_1">Imagem</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="file" accept="image/*" class="form-control" name="image_5_1" id="image_5_1" />
                    <input type="file" accept="video/*" class="form-control" name="video_5_1" id="video_5_1" />
                    <!--end::Input-->
                </div>
            </div>
            <!--end::Input group-->
        </div>
        <div class="tab-pane fade" id="content-5-2" role="tabpanel">
            <!--begin::Input group-->
            <div class="row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Exibir</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="display_content_5_2" name="display_content_5_2">
                    <option></option>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row">
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Tipo do conteúdo</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="content_type_5_2" name="content_type_5_2" onchange="changeContentType(5, this, 2)">
                        <option></option>
                        <option value="image">Imagem</option>
                        <option value="video">Vídeo</option>
                    </select>
                    <!--end::Input-->
                </div>
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2" id="label_content_type_5_2">Imagem</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="file" accept="image/*" class="form-control" name="image_5_2" id="image_5_2" />
                    <input type="file" accept="video/*" class="form-control" name="video_5_2" id="video_5_2" />
                    <!--end::Input-->
                </div>
            </div>
            <!--end::Input group-->
        </div>
        <div class="tab-pane fade" id="content-5-3" role="tabpanel">
            <!--begin::Input group-->
            <div class="row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Exibir</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="display_content_5_3" name="display_content_5_3">
                    <option></option>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row">
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Tipo do conteúdo</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="content_type_5_3" name="content_type_5_3" onchange="changeContentType(5, this, 3)">
                        <option></option>
                        <option value="image">Imagem</option>
                        <option value="video">Vídeo</option>
                    </select>
                    <!--end::Input-->
                </div>
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2" id="label_content_type_5_3">Imagem</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="file" accept="image/*" class="form-control" name="image_5_3" id="image_5_3" />
                    <input type="file" accept="video/*" class="form-control" name="video_5_3" id="video_5_3" />
                    <!--end::Input-->
                </div>
            </div>
            <!--end::Input group-->
        </div>
        <div class="tab-pane fade" id="content-5-4" role="tabpanel">
            <!--begin::Input group-->
            <div class="row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Exibir</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="display_content_5_4" name="display_content_5_4">
                    <option></option>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row">
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Tipo do conteúdo</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="content_type_5_4" name="content_type_5_4" onchange="changeContentType(5, this, 4)">
                        <option></option>
                        <option value="image">Imagem</option>
                        <option value="video">Vídeo</option>
                    </select>
                    <!--end::Input-->
                </div>
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2" id="label_content_type_5_4">Imagem</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="file" accept="image/*" class="form-control" name="image_5_4" id="image_5_4" />
                    <input type="file" accept="video/*" class="form-control" name="video_5_4" id="video_5_4" />
                    <!--end::Input-->
                </div>
            </div>
            <!--end::Input group-->
        </div>
    </div>
</div>
<!--end::CONTEÚDO 5-->

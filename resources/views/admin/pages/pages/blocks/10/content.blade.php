<!--begin::CONTEÚDO 10-->
<div id="content-10" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 16%">
            <a class="nav-link active" data-bs-toggle="tab" href="#content-10-0">Geral</a>
        </li>
        <li class="nav-item text-center" style="width: 14%">
            <a class="nav-link" data-bs-toggle="tab" href="#content-10-1">Aba 1</a>
        </li>
        <li class="nav-item text-center" style="width: 14%">
            <a class="nav-link" data-bs-toggle="tab" href="#content-10-2">Aba 2</a>
        </li>
        <li class="nav-item text-center" style="width: 14%">
            <a class="nav-link" data-bs-toggle="tab" href="#content-10-3">Aba 3</a>
        </li>
        <li class="nav-item text-center" style="width: 14%">
            <a class="nav-link" data-bs-toggle="tab" href="#content-10-4">Aba 4</a>
        </li>
        <li class="nav-item text-center" style="width: 14%">
            <a class="nav-link" data-bs-toggle="tab" href="#content-10-5">Aba 5</a>
        </li>
        <li class="nav-item text-center" style="width: 14%">
            <a class="nav-link" data-bs-toggle="tab" href="#content-10-6">Aba 6</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="content-10-0" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Título 1</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="title_10" id="title_10" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Título 2</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="subtitle_10" id="subtitle_10" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Conteúdo</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea type="text" class="form-control resize-none" name="content_10" id="content_10" rows="4"></textarea>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <div class="tab-pane fade" id="content-10-1" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Título</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="title_10_1" id="title_10_1" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Subtítulo</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea type="text" class="form-control resize-none" name="subtitle_10_1" id="subtitle_10_1" rows="4"></textarea>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required required mb-2">Imagem</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="file" accept="image/*" class="form-control" name="image_10_1" id="image_10_1" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            @include('admin.pages.pages.components.button', ['blockNumber' => 10, 'tabNumber' => 1, 'titleBtn' => 'Link'])
        </div>
        <div class="tab-pane fade" id="content-10-2" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Título</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="title_10_2" id="title_10_2" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Subtítulo</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea type="text" class="form-control resize-none" name="subtitle_10_2" id="subtitle_10_2" rows="4"></textarea>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Imagem</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="file" accept="image/*" class="form-control" name="image_10_2" id="image_10_2" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            @include('admin.pages.pages.components.button', ['blockNumber' => 10, 'tabNumber' => 2, 'titleBtn' => 'Link'])
        </div>
        <div class="tab-pane fade" id="content-10-3" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Título</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="title_10_3" id="title_10_3" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Subtítulo</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea type="text" class="form-control resize-none" name="subtitle_10_3" id="subtitle_10_3" rows="4"></textarea>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Imagem</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="file" accept="image/*" class="form-control" name="image_10_3" id="image_10_3" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            @include('admin.pages.pages.components.button', ['blockNumber' => 10, 'tabNumber' => 3, 'titleBtn' => 'Link'])
        </div>
        <div class="tab-pane fade" id="content-10-4" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Título</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="title_10_4" id="title_10_4" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Subtítulo</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea type="text" class="form-control resize-none" name="subtitle_10_4" id="subtitle_10_4" rows="4"></textarea>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Imagem</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="file" accept="image/*" class="form-control" name="image_10_4" id="image_10_4" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            @include('admin.pages.pages.components.button', ['blockNumber' => 10, 'tabNumber' => 4, 'titleBtn' => 'Link'])
        </div>
        <div class="tab-pane fade" id="content-10-5" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Título</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="title_10_5" id="title_10_5" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Subtítulo</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea type="text" class="form-control resize-none" name="subtitle_10_5" id="subtitle_10_5" rows="4"></textarea>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Imagem</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="file" accept="image/*" class="form-control" name="image_10_5" id="image_10_5" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            @include('admin.pages.pages.components.button', ['blockNumber' => 10, 'tabNumber' => 5, 'titleBtn' => 'Link'])
        </div>
        <div class="tab-pane fade" id="content-10-6" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Título</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="title_10_6" id="title_10_6" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Subtítulo</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea type="text" class="form-control resize-none" name="subtitle_10_6" id="subtitle_10_6" rows="4"></textarea>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Imagem</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="file" accept="image/*" class="form-control" name="image_10_6" id="image_10_6" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            @include('admin.pages.pages.components.button', ['blockNumber' => 10, 'tabNumber' => 6, 'titleBtn' => 'Link'])
        </div>
    </div>
</div>
<!--end::CONTEÚDO 10-->

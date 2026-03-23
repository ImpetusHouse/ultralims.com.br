<!--begin::CONTEÚDO 41-->
<div id="content-41" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link active" data-bs-toggle="tab" href="#content-41-0">Geral</a>
        </li>
        @for($y = 1; $y <= 4; $y++)
            <li class="nav-item text-center" style="width: 20%">
                <a class="nav-link" data-bs-toggle="tab" href="#content-41-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="content-41-0" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Texto</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="tag_41" id="tag_41" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Título 1</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="title_41" id="title_41" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Título 2</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="subtitle_41" id="subtitle_41" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2 required">Descrição</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea class="form-control resize-none" name="content_41" id="content_41" rows="4" style="resize: none"></textarea>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        @for($y = 1; $y <= 4; $y++)
            <div class="tab-pane fade" id="content-41-{{ $y }}" role="tabpanel">
                <!--begin::Input group-->
                <div class="fv-row mb-9">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Título</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control" name="title_41_{{ $y }}" id="title_41_{{ $y }}" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row mb-9">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Conteúdo</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea rows="3" type="text" class="form-control resize-none" name="subtitle_41_{{ $y }}" id="subtitle_41_{{ $y }}"></textarea>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row mb-9">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Imagem</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="file" accept="image/*" class="form-control" name="image_41_{{ $y }}" id="image_41_{{ $y }}" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
            </div>
        @endfor
    </div>
</div>
<!--end::CONTEÚDO 41-->

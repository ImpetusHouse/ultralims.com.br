<!--begin::CONTEÚDO 12-->
<div id="content-12" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 50%">
            <a class="nav-link active" data-bs-toggle="tab" href="#content-12-0">Geral</a>
        </li>
        <li class="nav-item text-center" style="width: 50%">
            <a class="nav-link" data-bs-toggle="tab" href="#content-12-1">Aba 1</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="content-12-0" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Título 1</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="title_12" id="title_12" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Título 2</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="subtitle_12" id="subtitle_12" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Conteúdo</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea type="text" class="form-control resize-none" name="content_12" id="content_12" rows="4"></textarea>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Link (Termos de privacidade)</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="button_link_12" id="button_link_12" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">E-mail</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select" data-control="select2" data-placeholder="Selecione uma categoria" name="email_12" id="email_12">
                    <option></option>
                    @foreach(\App\Models\Settings\Email::orderBy('title')->where('status', true)->get() as $email)
                        <option value="{{ $email->id }}">{{ $email->title }}</option>
                    @endforeach
                </select>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <div class="tab-pane fade" id="content-12-1" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Título</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="title_12_1" id="title_12_1" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Subtítulo</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea type="text" class="form-control resize-none" name="subtitle_12_1" id="subtitle_12_1" rows="4"></textarea>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Imagem</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="file" accept="image/*" class="form-control" name="image_12_1" id="image_12_1" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
    </div>
</div>
<!--end::CONTEÚDO 12-->

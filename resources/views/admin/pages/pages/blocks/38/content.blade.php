<!--begin::CONTEÚDO 38-->
<div id="content-38" class="w-100 mw-600px" style="display: none">
    <input type="hidden" name="title_38_1" value="Formulário">
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Título (Formulário)</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="tag_38" id="tag_38" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Título 1</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="title_38" id="title_38" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Título 2</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="subtitle_38" id="subtitle_38" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2 required">Descrição</label>
        <!--end::Label-->
        <!--begin::Input-->
        <textarea class="form-control resize-none" name="content_38" id="content_38" rows="4" style="resize: none"></textarea>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Fundo</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="file" accept="image/*" class="form-control" name="image_38" id="image_38" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">E-mail</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select" data-control="select2" data-placeholder="Selecione uma categoria" name="email_38" id="email_38">
            <option></option>
            @foreach(\App\Models\Settings\Email::orderBy('title')->where('status', true)->get() as $email)
                <option value="{{ $email->id }}">{{ $email->title }}</option>
            @endforeach
        </select>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    @include('admin.pages.pages.components.button', ['blockNumber' => 38, 'margin' => 'mb-9'])
    @include('admin.pages.pages.components.button', ['blockNumber' => 38, 'buttonOne' => true, 'titleBtn' => 'Botão 2', 'margin' => 'mb-9'])
    @include('admin.pages.pages.components.button', ['blockNumber' => 38, 'tabNumber' => 1, 'titleBtn' => 'Formulário'])
</div>
<!--end::CONTEÚDO 18-->

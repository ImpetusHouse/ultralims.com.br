<!--begin::CONTEÚDO 27-->
<div id="content-27" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Exibir título e descrição?</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="type_27" name="type_27">
            <option></option>
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Título 1</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="title_27" id="title_27" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Título 2</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="subtitle_27" id="subtitle_27" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Descrição</label>
        <!--end::Label-->
        <!--begin::Input-->
        <textarea class="form-control resize-none" name="content_27" id="content_27" rows="4" style="resize: none"></textarea>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Comunicados</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select" data-control="select2" data-placeholder="Selecione um evento" multiple="multiple" name="alerts_27[]" id="alerts_27">
            <option></option>
            @foreach(\App\Models\General\Alerts\Alert::orderBy('title')->get() as $alert)
                <option value="{{ $alert->id }}">{{ $alert->title }}</option>
            @endforeach
        </select>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
</div>
<!--end::CONTEÚDO 27-->

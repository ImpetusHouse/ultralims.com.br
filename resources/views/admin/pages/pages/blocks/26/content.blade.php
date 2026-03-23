<!--begin::CONTEÚDO 26-->
<div id="content-26" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Título 1</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="title_26" id="title_26" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Título 2</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="subtitle_26" id="subtitle_26" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Descrição</label>
        <!--end::Label-->
        <!--begin::Input-->
        <textarea class="form-control resize-none" name="content_26" id="content_26" rows="4" style="resize: none"></textarea>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Galerias</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select" data-control="select2" data-placeholder="Selecione uma galeria" multiple="multiple" name="galleries_26[]" id="galleries_26">
            <option></option>
            @foreach(\App\Models\General\Galleries\Gallery::orderBy('title')->get() as $gallery)
                <option value="{{ $gallery->id }}">{{ $gallery->title }}</option>
            @endforeach
        </select>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
</div>
<!--end::CONTEÚDO 26-->

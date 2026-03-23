<!--begin::CONTEÚDO 43-->
<div id="content-43" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Título 1</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="title_43" id="title_43" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Título 2</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="subtitle_43" id="subtitle_43" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Logos (Categoria)</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select" data-control="select2" data-placeholder="Selecione uma página" name="logos_category_43" id="logos_category_43">
            <option></option>
            @foreach(\App\Models\General\Logos\Category::orderBy('title')->get() as $item)
                <option value="{{ $item->id }}">{{ $item->title }}</option>
            @endforeach
        </select>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
</div>
<!--end::CONTEÚDO 43-->

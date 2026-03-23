<!--begin::CONTEÚDO 45-->
<div id="content-45" class="w-100 mw-600px" style="display: none">
    <input type="hidden" name="title_45_1" value="Portfólios">
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Tag</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="tag_45" id="tag_45" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Título 1</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="title_45" id="title_45" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Título 2</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="subtitle_45" id="subtitle_45" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Portfólios</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select" data-control="select2" data-placeholder="Selecione um portfólio" name="portfolios_45[]" id="portfolios_45" multiple="multiple">
            @foreach(\App\Models\General\Portfolios\Portfolio::orderBy('title')->get() as $item)
                <option value="{{ $item->id }}">{{ $item->title }}</option>
            @endforeach
        </select>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
</div>
<!--end::CONTEÚDO 45-->

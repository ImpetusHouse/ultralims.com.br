<!--begin::CONTEÚDO 9-->
<div id="content-9" class="w-100 mw-600px" style="display: none">
    <input type="hidden" name="title_9_1" value="Depoimentos">
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Título 1</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="title_9" id="title_9" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Título 2</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="subtitle_9" id="subtitle_9" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2 required">Descrição</label>
        <!--end::Label-->
        <!--begin::Input-->
        <textarea class="form-control resize-none" name="content_9" id="content_9" rows="4" style="resize: none"></textarea>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Depoimentos</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select" name="testimonials_9[]" id="testimonials_9" data-control="select2" data-placeholder="Selecione uma opção" multiple="multiple">
            @foreach(\App\Models\General\Testimonials\Testimonial::where('status', true)->orderBy('client')->get() as $testimonial)
                <option value="{{ $testimonial->id }}">{{ $testimonial->client }}</option>
            @endforeach
        </select>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
</div>
<!--end::CONTEÚDO 9-->

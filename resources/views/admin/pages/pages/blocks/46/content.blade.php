<!--begin::CONTEÚDO 46-->
<div id="content-46" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="fv-row">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Depoimentos</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select" name="testimonials_46[]" id="testimonials_46" data-control="select2" data-placeholder="Selecione uma opção" multiple="multiple">
            @foreach(\App\Models\General\Testimonials\Testimonial::where('status', true)->orderBy('client')->get() as $testimonial)
                <option value="{{ $testimonial->id }}">{{ $testimonial->client }}</option>
            @endforeach
        </select>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
</div>
<!--end::CONTEÚDO 46-->

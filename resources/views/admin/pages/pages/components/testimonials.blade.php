<!--begin::Input group-->
<div class="fv-row {{ $margin }}">
    <!--begin::Label-->
    <label class="fs-6 fw-semibold mb-2 {{ $required }}">{{ $titleLabel ?? 'Depoimento' }}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <select class="form-select" name="testimonials_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}[]" id="testimonials_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" multiple="multiple" {!! isset($select2) ? 'data-control="select2" data-placeholder="Selecione um depoimento"':'' !!}>
        @foreach(\App\Models\General\Testimonials\Testimonial::where('status', true)->orderBy('client')->get() as $testimonial)
            <option value="{{ $testimonial->id }}">{{ $testimonial->client }}</option>
        @endforeach
    </select>
    <!--end::Input-->
</div>
<!--end::Input group-->

<!--begin::Input group-->
<div class="fv-row {{ $margin }}">
    <!--begin::Label-->
    <label class="fs-6 fw-semibold {{ $required }} mb-2">{{ $titleLabel ?? 'PDF' }}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="file" accept="image/*" class="form-control" name="pdf_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="pdf_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" />
    <!--end::Input-->
</div>
<!--end::Input group-->

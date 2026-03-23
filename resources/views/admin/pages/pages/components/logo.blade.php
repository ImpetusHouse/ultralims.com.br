<!--begin::Input group-->
<div class="fv-row {{ $margin }}">
    <!--begin::Label-->
    <label class="fs-6 fw-semibold {{ $required }} mb-2">{{ $titleLabel ?? 'Logo' }}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="file" accept="image/*" class="form-control" name="logo_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="logo_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" />
    <!--end::Input-->
</div>
<!--end::Input group-->

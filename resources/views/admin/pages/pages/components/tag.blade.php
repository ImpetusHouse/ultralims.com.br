<!--begin::Input group-->
<div class="fv-row {{ $margin }}">
    <!--begin::Label-->
    <label class="fs-6 fw-semibold mb-2">{{$titleLabel ?? "Tag"}}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" class="form-control" name="tag_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="tag_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" />
    <!--end::Input-->
</div>
<!--end::Input group-->

<!--begin::Input group-->
<div class="row {{ $margin }}">
    <div class="col-6">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold {{ $required }} mb-2">Margin top</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="number" value="15" class="form-control" name="margin_top_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="margin_top_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" />
        <!--end::Input-->
    </div>
    <div class="col-6">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold {{ $required }} mb-2">Margin bottom</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="number" value="15" class="form-control" name="margin_bottom_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="margin_bottom_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" />
        <!--end::Input-->
    </div>
</div>
<!--end::Input group-->

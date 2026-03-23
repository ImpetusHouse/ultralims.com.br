<!--begin::Input group-->
<div class="fv-row {{ $margin }}">
    <!--begin::Label-->
    <label class="fs-6 fw-semibold mb-2" id="label_url_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}">{{$titleLabel ?? "URL"}}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" class="form-control" name="content_link_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="content_link_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" />
    <!--end::Input-->
</div>
<!--end::Input group-->

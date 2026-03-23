<!--begin::Input group-->
<div class="fv-row {{ $margin }}">
    <!--begin::Label-->
    <div class="w-full d-flex justify-content-between">
        <label class="fs-6 fw-semibold {{ $required }} mb-2 d-flex justify-content-between">
            Descrição
            <span id="selected-font-description_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" class="ml-2"></span>
        </label>
        <div class="d-flex align-items-center">
            @include('admin.pages.pages.components.font', ['blockNumber' => $blockNumber, 'tabNumber' => ($tabNumber ?? null), 'type' => 'description', 'input' => 'description'])
        </div>
    </div>
    <!--end::Label-->
    <!--begin::Input-->
    <textarea class="form-control resize-none" name="content_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="content_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" rows="4" style="resize: none"></textarea>
    <!--end::Input-->
</div>
<!--end::Input group-->

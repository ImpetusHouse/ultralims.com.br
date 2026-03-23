<div class="fv-row {{ $margin }}">
    <!--begin::Label-->
    <div class="w-full d-flex justify-content-between">
        <label class="fs-6 fw-semibold {{ $required }} mb-2 d-flex justify-content-between">
            Título
            <span id="selected-font-title_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" class="ml-2"></span>
        </label>
        <div class="d-flex align-items-center">
            @include('admin.pages.pages.components.font', ['blockNumber' => $blockNumber, 'tabNumber' => ($tabNumber ?? null), 'type' => 'title', 'input' => 'title'])
        </div>
    </div>
    <!--end::Label-->
    <input type="text" class="form-control" name="title_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="title_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" />
    <!--end::Input-->
</div>

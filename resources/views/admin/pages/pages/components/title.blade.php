<div class="row {{ $margin }}">
    <div class="col-6">
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
    <div class="col-6">
        <!--begin::Label-->
        <div class="w-full d-flex justify-content-between">
            <label class="fs-6 fw-semibold mb-2 d-flex align-items-center">
                Título 2
                <span id="selected-font-subtitle_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" class="ml-2"></span>
            </label>
            <div>
                <div class="d-flex align-items-center">
                    @include('admin.pages.pages.components.font', ['blockNumber' => $blockNumber, 'tabNumber' => ($tabNumber ?? null), 'type' => 'title', 'input' => 'subtitle'])
                </div>
            </div>
        </div>
        <!--begin::Input-->
        <input type="text" class="form-control" name="subtitle_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="subtitle_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" />
        <!--end::Input-->
    </div>
</div>

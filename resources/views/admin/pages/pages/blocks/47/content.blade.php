<!--begin::CONTEÚDO 47-->
<div id="content-47" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 14.28%">
            <a class="nav-link active" data-bs-toggle="tab" href="#content-47-0">Geral</a>
        </li>
        @for($y = 1; $y <= 6; $y++)
            <li class="nav-item text-center" style="width: 14.28%">
                <a class="nav-link" data-bs-toggle="tab" href="#content-47-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="content-47-0" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Tag</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="tag_47" id="tag_47" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Título 1</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="title_47" id="title_47" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Título 2</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="subtitle_47" id="subtitle_47" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        @for($y = 1; $y <= 6; $y++)
            <div class="tab-pane fade" id="content-47-{{ $y }}" role="tabpanel">
                <!--begin::Input group-->
                <div class="fv-row mb-9">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Título</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control" name="title_47_{{ $y }}" id="title_47_{{ $y }}" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row mb-9">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Conteúdo</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea rows="3" type="text" class="form-control resize-none" name="subtitle_47_{{ $y }}" id="subtitle_47_{{ $y }}"></textarea>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
            </div>
        @endfor
    </div>
</div>
<!--end::CONTEÚDO 47-->

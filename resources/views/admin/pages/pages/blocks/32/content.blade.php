<!--begin::CONTEÚDO 32-->
<div id="content-32" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        @for($y = 1; $y <= 6; $y++)
            <li class="nav-item text-center" style="width: 16.66%">
                <a class="nav-link {{ $y == 1 ? 'active':'' }}" data-bs-toggle="tab" href="#content-32-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        @for($y = 1; $y <= 6; $y++)
            <div class="tab-pane fade {{ $y == 1 ? 'show active':'' }}" id="content-32-{{ $y }}" role="tabpanel">
                @include('admin.pages.pages.components.title-single', ['blockNumber' => 32, 'tabNumber' => $y, 'required' => ($y == 1 ? 'required':''), 'margin' => 'mb-9'])
                <!--begin::Input group-->
                <div class="fv-row mb-9">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold {{ $y == 1 ? 'required':'' }} mb-2">Conteúdo</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea type="text" class="form-control resize-none" name="content_32_{{ $y }}" id="content_32_{{ $y }}" rows="4"></textarea>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">Cards (Categorias)</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select" data-control="select2" data-placeholder="Selecione uma categoria" name="cards_categories_32_{{ $y }}[]" id="cards_categories_32_{{ $y }}">
                        <option></option>
                        <option value="0">Nenhuma</option>
                        @foreach(\App\Models\General\Cards\Category::orderBy('title')->get() as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
            </div>
        @endfor
    </div>
</div>
<!--end::CONTEÚDO 32-->

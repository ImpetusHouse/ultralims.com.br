<!--begin::Input group-->
<div class="fv-row {{ $margin }}">
    <!--begin::Label-->
    <label class="fs-6 fw-semibold mb-2 {{ $required }}">{{ $titleLabel ?? 'Logos (Categoria)' }}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <select class="form-select" data-control="select2" data-placeholder="Selecione uma categoria" name="logos_category_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="logos_category_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}">
        @foreach(\App\Models\General\Logos\Category::orderBy('title')->get() as $category)
            <option value="{{ $category->id }}">{{ $category->title }}</option>
        @endforeach
    </select>
    <!--end::Input-->
</div>
<!--end::Input group-->

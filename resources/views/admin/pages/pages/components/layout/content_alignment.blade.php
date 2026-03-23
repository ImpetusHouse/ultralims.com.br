<!--begin::Input group-->
<div class="fv-row {{ $margin }}">
    <!--begin::Label-->
    <label class="fs-6 fw-semibold mb-2 {{ $required ?? '' }}">{{ $titleLabel ?? 'Alinhamento (Imagens)' }}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <select class="form-select mb-2" data-control="select2"
            data-hide-search="true" data-placeholder="Selecione uma opção"
            id="content_alignment_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" name="content_alignment_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}">
        <option></option>
        <option value="left">Alinhado à esquerda</option>
        @if(isset($center))
            <option value="center">Alinhado ao centro</option>
        @else
            <option value="right">Alinhado à direita</option>
        @endif
    </select>
    <!--end::Input-->
</div>
<!--end::Input group-->

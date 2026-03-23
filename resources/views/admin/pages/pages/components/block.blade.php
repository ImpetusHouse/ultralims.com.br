<!--begin::Option-->
<div class="col-3">
    <label id="layout-{{ $i }}" class="m-6 btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6">
        <!--begin::Input-->
        <input class="btn-check" type="radio" name="layout" value="{{ $i }}" />
        <!--end::Input-->
        <!--begin::Label-->
        <span class="d-flex align-items-center">
            <!--begin::Icon-->
            <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
            <img id="img-layout-{{ $i }}" height="64px" />
            <!--end::Svg Icon-->
            <!--end::Icon-->
            <!--begin::Info-->
            <span class="ms-4">
                <span class="fs-3 fw-bold text-gray-900 mb-2 d-block">Bloco {{ $i < 10 ? '0'.$i:$i}}</span>
            </span>
            <!--end::Info-->
        </span>
        <!--end::Label-->
    </label>
</div>
<!--end::Option-->

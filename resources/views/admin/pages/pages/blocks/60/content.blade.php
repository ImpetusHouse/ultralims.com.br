<!--begin::CONTEÚDO 60-->
<div id="content-60" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        @for($y = 1; $y <= 2; $y++)
            <li class="nav-item text-center" style="width: 50%">
                <a class="nav-link {{ $y == 1 ? 'active':'' }}" data-bs-toggle="tab" href="#content-60-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        @for($y = 1; $y <= 2; $y++)
            <div class="tab-pane fade {{ $y == 1 ? 'show active':'' }}" id="content-60-{{ $y }}" role="tabpanel">
                @include('admin.pages.pages.components.title-single', ['blockNumber' => 60, 'tabNumber' => $y, 'required' => 'required', 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.image', ['blockNumber' => 60, 'tabNumber' => $y, 'required' => 'required', 'margin' => 'mb-9', 'titleLabel' => 'Imagem'])
                @include('admin.pages.pages.components.button', ['blockNumber' => 60, 'tabNumber' => $y])
            </div>
        @endfor
    </div>
</div>
<!--end::CONTEÚDO 60-->

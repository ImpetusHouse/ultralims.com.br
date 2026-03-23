<!--begin::CONTEÚDO 67-->
<div id="content-67" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        @for($y = 1; $y <= 4; $y++)
            <li class="nav-item text-center" style="width: 25%">
                <a class="nav-link {{ $y == 1 ? 'active':'' }}" data-bs-toggle="tab" href="#content-67-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        @for($y = 1; $y <= 4; $y++)
            <div class="tab-pane fade {{ $y == 1 ? 'show active':'' }}" id="content-67-{{ $y }}" role="tabpanel">
                @include('admin.pages.pages.components.title-single', ['blockNumber' => 67, 'tabNumber' => $y, 'required' => ($y == 1 ? 'required' : ''), 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.subtitle-textarea', ['blockNumber' => 67, 'tabNumber' => $y, 'required' => ($y == 1 ? 'required' : ''), 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.image', ['blockNumber' => 67, 'tabNumber' => $y, 'required' => ($y == 1 ? 'required' : ''), 'margin' => null, 'titleLabel' => 'Ícone'])
            </div>
        @endfor
    </div>
</div>
<!--end::CONTEÚDO 67-->

<!--begin::CONTEÚDO 66-->
<div id="content-66" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        @for($y = 1; $y <= 5; $y++)
            <li class="nav-item text-center" style="width: 20%">
                <a class="nav-link {{ $y == 1 ? 'active':'' }}" data-bs-toggle="tab" href="#content-66-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        @for($y = 1; $y <= 5; $y++)
            <div class="tab-pane fade {{ $y == 1 ? 'show active':'' }}" id="content-66-{{ $y }}" role="tabpanel">
                @include('admin.pages.pages.components.title', ['blockNumber' => 66, 'tabNumber' => $y, 'required' => ($y == 1 ? 'required' : ''), 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.description', ['blockNumber' => 66, 'tabNumber' => $y, 'required' => ($y == 1 ? 'required' : ''), 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.image', ['blockNumber' => 66, 'tabNumber' => $y, 'required' => ($y == 1 ? 'required' : ''), 'margin' => 'mb-9', 'titleLabel' => 'Imagem'])
                @include('admin.pages.pages.components.button', ['blockNumber' => 66, 'tabNumber' => $y, 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.button', ['blockNumber' => 66, 'tabNumber' => $y, 'buttonOne' => true, 'titleBtn' => 'Botão 2'])
            </div>
        @endfor
    </div>
</div>
<!--end::CONTEÚDO 66-->

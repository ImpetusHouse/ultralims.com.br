<div class="color-box-parent">
    <div class="color-box">
        <p>
            Botão
        </p>
        <div class="color-select" style="background-color: #151624" id="button_color{{isset($buttonOne) ? '1':''}}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}"></div>
        <div class="colors-box">
            @foreach($colors as $color)
                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
            @endforeach
        </div>
    </div>
</div>

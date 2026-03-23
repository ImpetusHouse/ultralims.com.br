<span class="text-gray-600 me-1" id="font_{{ $input }}_text_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}"></span>
<i class="fas fa-cog ml-2 cursor-pointer text-hover-primary"
    data-input="{{ $input }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}"
    id="font_{{ $input }}_selector_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}"></i>
<!-- Hidden Select2 Elements -->
<select name="font_{{ $input }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="font_{{ $input }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" class="form-control d-none">
    <option></option>
    @foreach ($fonts->where('type', $type) as $font)
        <option value="{{ $font->id }}" data-title="{{ $font->profile }}" {{ $font->default ? 'selected':'' }}>{{ $font->profile }}</option>
    @endforeach
</select>
<!--begin::Input-->

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#font_{{ $input }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}').select2({
                dropdownAutoWidth: true,
                width: 'auto',
                dropdownParent: $('body'), // Ensure the dropdown is appended to the body
                placeholder: 'Selecione um perfil'
            }).on('select2:select', function(e) {
                var selectedOption = $(e.currentTarget).find('option:selected');
                var selectedTitle = selectedOption.data('title');
                $('#font_{{ $input }}_text_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}').text(selectedTitle);
                $(this).select2('close');
            });

            $('#font_{{ $input }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}').trigger('select2:select');

            $('#font_{{ $input }}_selector_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}').on('click', function() {
                var inputElement = $(this);
                var selectElement = $('#font_{{ $input }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}');
                selectElement.data('inputElement', inputElement);
                selectElement.select2('open');

                selectElement.on('select2:open', function() {
                    $('.select2-container--open').css('z-index', 9999); // Ensure the dropdown is visible
                });
            });
        });
    </script>
@endpush

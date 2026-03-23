<div class="overlayer">
    <div class="body">
        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60">
            <defs>
                <style>
                    .cls-1 {
                        fill: #316aff;
                    }
                </style>
            </defs>
            <path id="Icon_open-reload" data-name="Icon open-reload" class="cls-1" d="M30.038,0A30,30,0,1,0,51.364,51.3l-5.407-5.4A22.53,22.53,0,1,1,29.962,7.5a21.858,21.858,0,0,1,15.695,6.825L37.472,22.5H60V0L51.064,8.925A29.888,29.888,0,0,0,29.962,0Z"/>
        </svg>
        <span>
            Aguarde...
        </span>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>var hostUrl = "{{asset('assets/')}}/";</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{asset('assets/plugins/custom/leaflet/leaflet.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{asset('assets/js/custom/utilities/modals/select-location.js')}}"></script>
<script src="{{asset('assets/js/custom/widgets.js')}}"></script>
<script src="{{asset('assets/js/custom/apps/chat/chat.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}"></script>
<!--end::Page Custom Javascript-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js" integrity="sha512-mVkLPLQVfOWLRlC2ZJuyX5+0XrTlbW2cyAwyqgPkLGxhoaHNSWesYMlcUjX8X+k45YB8q90s88O7sos86636NQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset('assets/js/custom/apps/support-center/tickets/create.js')}}"></script>
<script>

    $(window).on('load', function(){
        $('.loading').fadeOut();
    })

    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : '{{csrf_token()}}'
        }
    });
    $.extend({
        keyCount : function(o) {
            if(typeof o == "object") {
                var i, count = 0;
                for(i in o) {
                    if(o.hasOwnProperty(i)) {
                        count++;
                    }
                }
                return count;
            } else {
                return false;
            }
        }
    });

    @if(Session::has('success'))
        Swal.fire({
            title: 'Sucesso!',
            text: "{{session::get('success')}}",
            icon: 'success',
            showCancelButton: 0,
            buttonsStyling: !1,
            confirmButtonText: "Ok!",
            customClass: {
                confirmButton: "btn fw-bold btn-primary"
            }
        });
    @endif

    $('.formAjax').on('submit', this, function (e){
        e.preventDefault();
        var _this = $(this);
        var _form = new FormData(this);;
        var _method = $(this).attr('method');
        var _url = $(this).attr('target');
        $('.overlayer').addClass('show').fadeIn();
        $.ajax({
            url: _url,
            method: _method,
            data: _form,
            async: false,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            dataType: "JSON",
            success: function (data) {

                if(data.success == true){

                    if(typeof data.reloaded && data.reloaded == true){
                        location.reload();
                        return;
                    }

                    if(typeof data.redirectUrl != 'undefined'){
                        location.href = data.redirectUrl;
                        return;
                    }

                    if(typeof data.resetForm != 'undefined' && data.resetForm == true){
                        $(_this).trigger("reset");
                        Swal.fire('sucesso!', data.message, 'success');
                        return;
                    }

                    if(typeof data.message != 'undefined'){
                        Swal.fire('Sucesso!', data.message, 'success');
                        return;
                    }



                }else{
                    Swal.fire('Erro!', data.message, 'error');
                }

                $('.overlayer').removeClass('show').fadeOut();
            },
            error: function (e) {
                Swal.fire('Erro!', 'Falha ao processar os dados', 'error');
                $('.overlayer').removeClass('show').fadeOut();
            }
        }).done(function (data){
            $('.overlayer').removeClass('show').fadeOut();
        });
    })
    $('.mask-date').mask('00/00/0000');
    $('.mask-percentage').mask('00,00', {reverse: true});
    $('.mask-currency').mask("#.##0,00", {reverse: true});
    $('.mask-number').mask('0#');
    $('.mask-cep').mask('00000-000');
    $('.mask-cpf').mask('000.000.000-00', {reverse: true});
    $('.mask-hour').mask('00:00');
    var CpfCnpjMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length <= 11 ? '000.000.000-009' : '00.000.000/0000-00';
        },
        cpfCnpjpOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(CpfCnpjMaskBehavior.apply({}, arguments), options);
            }
        };
    $('.mask-cpf-cnpj').mask(CpfCnpjMaskBehavior, cpfCnpjpOptions);
    var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

    $('.mask-tel').mask(SPMaskBehavior, spOptions);
    $(".mask-slug").mask('XXXXXXXXXXXXXXXXXXXX', {
        translation: {
            'X': {
                pattern: /[A-Za-z0-9]/, optional: true
            }
        }
    });
</script>

@stack('scripts')
@yield('scripts')

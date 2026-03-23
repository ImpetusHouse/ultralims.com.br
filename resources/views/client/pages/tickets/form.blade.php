<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Abrir ticket prolab</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #FFF;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        form{
            padding: 1.2rem 1.8rem;
        }
        input{
            outline: 0 !important;
        }

        form .form-group{
            position: relative;
            overflow: hidden;
        }

        form .form-group .form-control-custom{
            border-radius: 3px;
            background: #FFF;
            padding: 0.65rem .5rem;
            border:0;
            border-bottom: 2px solid #C9D0DF;
            outline: 0 !important;
            width: 100%;
            transition: all 0.3s ease-in-out;
            position: relative;
            color: #788AAF !important;
        }
        form .form-group .form-control-custom:hover{
            border-color: #60A7AA90;
        }
        form .form-group .form-control-custom::placeholder{
            transition: all 0.3s ease-in-out;
            color: #788AAF !important;
        }
        form .form-group .form-control-custom:focus {
            border-color: #60A7AA !important;
            background: rgba(255,255,255,1);
        }
        form .form-group .form-control-custom:focus,
        form .form-group .form-control-custom:focus::placeholder{
            outline: 0 !important;
            color: #60A7AA !important;
        }
        form .form-group input.form-control-custom,
        form .form-group select.form-control-custom{
            padding: 0.65rem .5rem;
            color: #788AAF !important;
        }
        /*Invalid Forms */
        form .form-group .form-control-custom.invalid{
            border-bottom-width: 4px;
            border-color: #E62E2E !important;
            color: #E62E2E !important;
            background: rgba(255, 255, 255, 1);
        }
        form .form-group .error{
            position: absolute;
            top: 0;
            bottom: 0;
            height: 100%;
            transform: translateX(101%);
            background: #FFF;
            color:#E62E2E;
            right: 0;
            padding: 4px 12px;
            border-radius: 0 3px 3px 0;
            border-right: 4px solid #E62E2E;
            border-bottom: 4px solid #E62E2E;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        form .form-group .form-control-custom.invalid +.error{
            transform: translateX(0);
        }
        form .form-group .form-control-custom.invalid,
        form .form-group .form-control-custom.invalid::placeholder,
        form .form-group .form-control-custom.invalid:focus,
        form .form-group .form-control-custom.invalid:focus::placeholder{
            color: #E62E2E !important;
        }
        form .form-group .form-control-custom.invalid:focus +.error {
            transform:translateX(101%);
        }

        form .btn-icon {
            height: 43.75px;
        }

        .btn:focus {
            outline: none !important;
        }
        .btn:focus,.btn:active:focus,.btn.active:focus,
        .btn.focus,.btn:active.focus,.btn.active.focus {
            outline: none;
        }

        .btn-file:focus,
        .btn-file:active
        .btn-file {
            outline: 0 !important;
        }

        .btn-primary{
            background:#60A7AA;
            border-color:#60A7AA;
        }
        .btn-primary:hover{
            background:#60A7AA90;
            border-color:transparent;
        }

        .badge.bg-primary{
            background:#60A7AA20 !important;
            color: #60A7AA;
            font-size: 13px;
        }

        form .btn-file {
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <div class="container">
        <form action="#" id="sendThis" enctype="multipart/form-data" method="post">
            <div class="row">
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <input type="text" name="company" placeholder="Empresa" class="form-control-custom">
                        <div class="error"></div>
                    </div>
                </div>

                <div class="col-6 mb-4">
                    <div class="form-group ">
                        <input type="text" name="document" placeholder="CPF/CNPJ*" class="form-control-custom">
                        <div class="error"></div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Nome completo*" class="form-control-custom">
                        <div class="error"></div>
                    </div>
                </div>

                <div class="col-6 mb-4">
                    <div class="form-group">
                        <input type="email" name="email" placeholder="E-mail*" class="form-control-custom">
                        <div class="error"></div>
                    </div>
                </div>

                <div class="col-6 mb-4">
                    <div class="form-group">
                        <input type="text" name="phone" placeholder="Telefone*" class="form-control-custom">
                        <div class="error"></div>
                    </div>
                </div>

                <div class="col-6 mb-4">
                    <div class="form-group">
                        <select name="state" id="states" class="form-control-custom">
                            <option value="" disabled selected>Selecione o estado*</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->uf }}">{{ $state->state }}</option>
                            @endforeach
                        </select>
                        <div class="error"></div>
                    </div>
                </div>

                <div class="col-6 mb-4">
                    <div class="form-group">
                        <select name="city" id="city" class="form-control-custom">
                            <option value="" disabled selected>Selecione o estado*</option>
                        </select>
                        <div class="error"></div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <select name="service_category" id="service_category" class="form-control-custom" required>
                            <option value="" selected disabled>Selecione a categoria</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->service }}</option>
                            @endforeach
                        </select>
                        <div class="error"></div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <select name="service_type" id="service" class="form-control-custom" required>
                            <option value="" selected disabled>Selecione a categoria</option>
                        </select>
                        <div class="error"></div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="form-group">
                        <input type="text" name="title" placeholder="Finalidade da análise*" class="form-control-custom" required>
                        <div class="error"></div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="form-group">
                        <textarea name="description" id="description" placeholder="Observação" class="form-control-custom textarea"></textarea>
                    </div>
                </div>


                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="number" name="quantity" placeholder="Quantidade de amostras*" min="1" class="form-control-custom" required>
                        <div class="error"></div>
                    </div>
                </div>

                <div class="col-9">
                    <div class="form-group d-flex w-100">
                        <input type="file" multiple name="file[]" class="d-none" id="attach">
                        <button type="button" class="btn btn-primary btn-file btn-icon me-2" id="attach_button" style="width: 145px !important; min-width: 145px !important;"><i class="fa fa-paperclip" style="margin-right: 8px;"></i> Anexar arquivo</button>
                        <div class="attach_filename d-flex justify-content-start flex-wrap" style="flex: 1 1 auto;">

                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.8/jquery.mask.min.js" integrity="sha512-hAJgR+pK6+s492clbGlnrRnt2J1CJK6kZ82FZy08tm6XG2Xl/ex9oVZLE6Krz+W+Iv4Gsr8U2mGMdh0ckRH61Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

        $('#service_category').on("change", function(e){
            e.preventDefault();
            var category = $(this).val();
            $.ajax({
                url: "{{ route('service.get') }}",
                type: "GET",
                data: {
                    category: category
                },
                success: function(data){
                    $('#service').html(data);
                }
            });
        })

        function montaCidade(estado, pais){
            $('#city').html('<option value="" disabled selected>Aguarde</option>');
            $.ajax({
                type:'GET',
                url:'https://api.londrinaweb.com.br/PUC/Cidades/'+estado+'/'+pais+'/0/10000',
                contentType: "application/json; charset=utf-8",
                dataType: "jsonp",
                async:false
            }).done(function(response){
                cidades='';
                $.each(response, function(c, cidade){
                    cidades+='<option value="'+cidade+'">'+cidade+'</option>';
                });

                // PREENCHE AS CIDADES DE ACORDO COM O ESTADO
                $('#city').html(cidades);

            });
        }

        $('#states').on("change", function(e){

            e.preventDefault();
            var state = $(this).val();
            montaCidade(state, 'br');
        });

        $("textarea").each(function () {
            this.setAttribute("style", "height: 45.7px;overflow-y:hidden;");
        }).on("input", function () {
            this.style.height = "45.7px;";
            this.style.height = (this.scrollHeight) + "px";
        });


        $('#sendThis').on('submit', this, function(e){
            e.preventDefault();
            var form = new FormData(this);
            form.append('dettach', dettachFiles);
            $.ajax({
                url: '{{ route('teste_form') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    if(data.success){
                        $('#sendThis')[0].reset();
                        location.reload();
                    }else{
                        $('.error').html('');
                        $('.success').html('');
                        $.each(data.errors, function(index, el){
                            $(`[name="${index}"]`).parent().find('.error').html(el);
                        });
                    }
                }
            });
        })

        $('#attach_button').on('click', function(){
            $('#attach').click();
        });
        $('#attach').on('change', function(){
            let files = $(this)[0].files;
            var els = '';
            $.each(files, function(index, el){
                els += `<span class="badge bg-primary d-flex align-items-center mx-2 mb-2">${el.name}<span style="margin-left: 5px; cursor:pointer" class="badge bg-danger dettach" data-id="${index}">X</span></span>`;
            });

            $('.attach_filename').html(els).fadeIn();
        });

        var dettachFiles = new Array();

        $('body').on('click', '.dettach', function(){

            let dettach = $(this).data('id');

            if(dettachFiles.length > 0){
                let files = dettachFiles;
            }else{
                let files = $('#attach')[0].files;
            }

            var els = '';
            var $i = 0;

            $.each(files, function(index, el){

                if(index != dettach){
                    dettachFiles.push(el);
                    els += `<span class="badge bg-primary d-flex align-items-center mx-2 mb-2">${el.name}<span style="margin-left: 5px; cursor:pointer" class="badge bg-danger dettach" data-id="${index}">x</span></span>`;
                    $i ++;
                }

            });
            $('.attach_filename').html(els).fadeIn();
        });

        //MASK INPUTS
        $('input[name="document"]').on('keyup', function (e){
            e.preventDefault();
            if($(this).val().length > 14){
                $(this).mask('00.000.000/0000-00');
            }else if($(this).val().length <= 14){
                $(this).mask('000.000.000-00#');
            }
        });

        $('input[name="phone"]').on('keyup', function (e){
            e.preventDefault();
            if($(this).val().length > 14){
                $(this).mask('(00) 0 0000-0000');
            }else if($(this).val().length <= 14){
                $(this).mask('(00) 0000-00009');
            }
        });
        //END MASK INPUTS

        let LockForm = false;

        //Form validation
        function validateEmail($email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,5})?$/;
            return emailReg.test( $email );
        }

        $('input[name="document"]').on('focusout', this, function(e){
            e.preventDefault();

            //If has value
            if($(this).val() == ''){
                $(this).parent().find('.error').html('Campo obrigatório');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }else{
                $(this).parent().find('.error').html('');
                $(this).removeClass('invalid');
                LockForm = false;
            }

            //if contains only numbers and is valid document
            var doc = $(this).val();
            isDoc = /^\d*$/.test(doc.replace(/[^0-9]/gi, ''));
            if(!isDoc){
                $(this).parent().find('.error').html('CPF/CNPJ deve conter apenas números');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }else{
                $(this).parent().find('.error').html('');
                $(this).removeClass('invalid');
                LockForm = false;
            }
            doc = doc.replace(/[^0-9]/gi, '');
            if(doc.length != 11 && doc.length != 14){
                $(this).parent().find('.error').html('CPF/CNPJ inválido');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }

            if(!validaCpfCnpj(doc)){
                $(this).parent().find('.error').html('CPF/CNPJ inválido');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }
        })

        $('input[name="name"]').on('focusout', this, function(e){
            e.preventDefault();

            //If has value
            if($(this).val() == ''){
                $(this).parent().find('.error').html('Campo obrigatório');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }else{
                $(this).parent().find('.error').html('');
                $(this).removeClass('invalid');
                LockForm = false;
            }
        })

        $('input[name="email"]').on('focusout', this, function(e){
            e.preventDefault();

            //If has value
            if($(this).val() == ''){
                $(this).parent().find('.error').html('Campo obrigatório');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }else{
                $(this).parent().find('.error').html('');
                $(this).removeClass('invalid');
                LockForm = false;
            }

            if(!validateEmail($(this).val())){
                $(this).parent().find('.error').html('Email inválido');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }else{
                $(this).parent().find('.error').html('');
                $(this).removeClass('invalid');
                LockForm = false;
            }
        })

        $('input[name="phone"]').on('focusout', this, function(e){
            e.preventDefault();

            //If has value
            if($(this).val() == ''){
                $(this).parent().find('.error').html('Campo obrigatório');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }else{
                $(this).parent().find('.error').html('');
                $(this).removeClass('invalid');
                LockForm = false;
            }

            //if contains only numbers and is valid document
            var phone = $(this).val();
            isPhone = /^\d*$/.test(phone.replace(/[^0-9]/gi, ''));
            if(!isPhone){
                $(this).parent().find('.error').html('O telefone deve conter apenas números');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }else{
                $(this).parent().find('.error').html('');
                $(this).removeClass('invalid');
                LockForm = false;
            }
            phone = phone.replace(/[^0-9]/gi, '');
            if(phone.length != 10 && phone.length != 11){
                $(this).parent().find('.error').html('Número de telefone inválido');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }
        })

        $('select[name="state"]').on('blur change focusout', this, function(e){
            e.preventDefault();

            //If has value
            if($(this).val() == '' || $(this).val() == null ){
                $(this).parent().find('.error').html('Campo obrigatório');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }else{
                $(this).parent().find('.error').html('');
                $(this).removeClass('invalid');
                LockForm = false;
            }
        })

        $('select[name="service"]').on('blur change focusout', this, function(e){
            e.preventDefault();

            //If has value
            if($(this).val() == '' || $(this).val() == null ){
                $(this).parent().find('.error').html('Campo obrigatório');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }else{
                $(this).parent().find('.error').html('');
                $(this).removeClass('invalid');
                LockForm = false;
            }
        })

        $('input[name="city"]').on('focusout', this, function(e){
            e.preventDefault();

            //If has value
            if($(this).val() == ''){
                $(this).parent().find('.error').html('Campo obrigatório');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }else{
                $(this).parent().find('.error').html('');
                $(this).removeClass('invalid');
                LockForm = false;
            }
        })

        $('input[name="title"]').on('focusout', this, function(e){
            e.preventDefault();

            //If has value
            if($(this).val() == ''){
                $(this).parent().find('.error').html('Campo obrigatório');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }else{
                $(this).parent().find('.error').html('');
                $(this).removeClass('invalid');
                LockForm = false;
            }
        })

        $('textarea[name="description"]').on('focusout', this, function(e){
            e.preventDefault();
            /*
            //If has value
            if($(this).val() == ''){
                $(this).parent().find('.error').html('Campo obrigatório');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }else{
                $(this).parent().find('.error').html('');
                $(this).removeClass('invalid');
                LockForm = false;
            }
            */
        })

        $('input[name="quantity"]').on('focusout', this, function(e){
            e.preventDefault();

            //If has value
            if($(this).val() == ''){
                $(this).parent().find('.error').html('Campo obrigatório');
                $(this).addClass('invalid');
                LockForm = true;
                return false;
            }else{
                $(this).parent().find('.error').html('');
                $(this).removeClass('invalid');
                LockForm = false;
            }
        })

        function validaCpfCnpj(val) {
            if (val.length == 11) {
                var cpf = val.trim();

                cpf = cpf.replace(/\./g, '');
                cpf = cpf.replace('-', '');
                cpf = cpf.split('');

                var v1 = 0;
                var v2 = 0;
                var aux = false;

                for (var i = 1; cpf.length > i; i++) {
                    if (cpf[i - 1] != cpf[i]) {
                        aux = true;
                    }
                }

                if (aux == false) {
                    return false;
                }

                for (var i = 0, p = 10; (cpf.length - 2) > i; i++, p--) {
                    v1 += cpf[i] * p;
                }

                v1 = ((v1 * 10) % 11);

                if (v1 == 10) {
                    v1 = 0;
                }

                if (v1 != cpf[9]) {
                    return false;
                }

                for (var i = 0, p = 11; (cpf.length - 1) > i; i++, p--) {
                    v2 += cpf[i] * p;
                }

                v2 = ((v2 * 10) % 11);

                if (v2 == 10) {
                    v2 = 0;
                }

                if (v2 != cpf[10]) {
                    return false;
                } else {
                    return true;
                }
            } else if (val.length == 14) {
                var cnpj = val.trim();

                cnpj = cnpj.replace(/\./g, '');
                cnpj = cnpj.replace('-', '');
                cnpj = cnpj.replace('/', '');
                cnpj = cnpj.split('');

                var v1 = 0;
                var v2 = 0;
                var aux = false;

                for (var i = 1; cnpj.length > i; i++) {
                    if (cnpj[i - 1] != cnpj[i]) {
                        aux = true;
                    }
                }

                if (aux == false) {
                    return false;
                }

                for (var i = 0, p1 = 5, p2 = 13; (cnpj.length - 2) > i; i++, p1--, p2--) {
                    if (p1 >= 2) {
                        v1 += cnpj[i] * p1;
                    } else {
                        v1 += cnpj[i] * p2;
                    }
                }

                v1 = (v1 % 11);

                if (v1 < 2) {
                    v1 = 0;
                } else {
                    v1 = (11 - v1);
                }

                if (v1 != cnpj[12]) {
                    return false;
                }

                for (var i = 0, p1 = 6, p2 = 14; (cnpj.length - 1) > i; i++, p1--, p2--) {
                    if (p1 >= 2) {
                        v2 += cnpj[i] * p1;
                    } else {
                        v2 += cnpj[i] * p2;
                    }
                }

                v2 = (v2 % 11);

                if (v2 < 2) {
                    v2 = 0;
                } else {
                    v2 = (11 - v2);
                }

                if (v2 != cnpj[13]) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }

        //End form validation

    </script>
</body>
</html>

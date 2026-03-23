<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <title>{{env('APP_NAME')}} - Autenticação</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            text-align: center;
            box-sizing: border-box !important;
        }
        body {
            background: #f3f6f9;
        }
        .container {
            max-width: 750px;
            min-height: 100vh;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        @media screen and (max-width: 750px) {
            .container {
                width: 100%;
            }
            section{
                width: 98% !important;
            }
            section > * {
                max-width: 90% !important;
            }
        }


        figure{
            margin: 0;
            padding: 0;
            margin-bottom: 50px;
        }

        button {
            display: block;
            text-align: center;
            padding: 12px 16px;
            width: 100%;
            margin: 10px 0;
            border: 0;
            cursor: pointer;
            background: {{ env('PRIMARY_COLOR') }} 0% 0% no-repeat padding-box;
            font: normal normal 600 14px/21px Poppins;
            border-radius: 6px;
            color: #FFF;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        button:hover {
            box-shadow: none !important;
        }

        .link-group {
            width: 100%;
            margin-top: 40px !important;
            display: flex;
            justify-content: space-evenly;
        }

        .link-group a {
            text-decoration: none;
            color: {{ env('PRIMARY_COLOR') }};
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
        }
        .link-group a:hover{
            text-decoration: underline;
        }
    </style>

</head>
<body>

<div class="container">

    <section style="display:flex; align-items:center; flex-direction:column; box-shadow: 0 0 20px 0 rgb(76 87 125 / 2%); border-radius: 13px; background: #FFF; padding: 50px 30px;">
        <h3 style="font: normal normal bold 24px/45px Poppins;
        letter-spacing: 0px;
        color: #181C32;">Acesso ao Ticket</h3>

        <p style="font: normal normal normal 15px/23px Poppins; letter-spacing: 0px; color: #A1A5B7; width: 630px;">
            Bem-vindo à área de acesso ao ticket! Para visualizar e acompanhar o status do seu ticket, basta fornecer seu e-mail no campo abaixo. Com um processo simples e seguro, garantimos que você possa acessar as informações necessárias rapidamente. Insira seu e-mail e clique em "Acessar" para continuar.
        </p>

        <form class="customForm" style="margin-top: 50px; width: 380px; ">
            <div style="text-align:left;">
                <label style="font: normal normal 500 14px/21px Poppins;
                letter-spacing: 0px; text-align:left;
                color: #181C32; display:block; margin-bottom: 5px;">E-mail</label>
                <input type="text" name="email" id="email" placeholder="E-mail" style="background: #F4F5F6 0% 0% no-repeat padding-box;
                border-radius: 6px; border:0;
                text-align:start !important;
                padding:12px 10px; width: 100%;
                font: normal normal 400 12px/21px Poppins;">
                <button type="submit">Acessar</button>
            </div>
        </form>
    </section>

    <div
    style="margin: 15px 0;" class="link-group">
        <a href="#">Politica de privacidade</a>
        <a href="#">Proteção de dados</a>
    </div>
</div>

<!-- load sweetalert cdn -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<!-- load jquery cdn -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.8/jquery.mask.min.js" integrity="sha512-hAJgR+pK6+s492clbGlnrRnt2J1CJK6kZ82FZy08tm6XG2Xl/ex9oVZLE6Krz+W+Iv4Gsr8U2mGMdh0ckRH61Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

$('.customForm').on('submit', this, function(e){
    e.preventDefault();
    var email = $('#email').val();
    $.ajax({
        url: '{{route('ticket.login', $ticket->hash_id)}}',
        type: 'POST',
        data: {email: email},
        headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
        },
        success: function(response){
            if(response.success){
                location.reload();
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: response.message,
                })
            }
        }
    })
})
</script>
</body>
</html>

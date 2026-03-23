<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    /* Estilos base do modal (adaptados para o layout de duas colunas) */
    .form-modal {
        display: none; /* O usuário irá controlar a exibição */
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        align-items: center;
        justify-content: center;
    }

    .form-modal-content {
        position: relative;
        display: flex; /* Habilita o layout de duas colunas */
        max-width: 1100px; /* Aumentado para acomodar as duas colunas */
        max-height: 90%;
        border-radius: 8px;
        overflow: hidden;
        background-color: #fff; /* Fundo principal branco */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        font-family: 'Poppins', sans-serif;
    }

    /* Coluna da Imagem (Esquerda) */
    .form-modal-left {
        flex: 0 0 45%; /* 40% da largura para a imagem */
        background-color: #0C1425; /* Cor de fundo escura da imagem */
        color: #FFFFFF;
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        justify-content: start;
        align-items: center;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .form-modal-left h2 {
        font-family: 'Poppins', sans-serif;
        font-size: 29px;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 10px;
        z-index: 2; /* Para ficar acima da imagem de fundo */
    }

    .form-modal-left .ultra-text {
        color: #01AEF0; /* Cor azul para destaque */
    }

    .form-modal-left img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.3; /* Opacidade para a imagem de fundo */
        z-index: 1;
    }

    /* Coluna do Formulário (Direita) */
    .form-modal-right {
        flex: 1; /* Ocupa o restante do espaço (60%) */
        padding: 30px;
        display: flex;
        flex-direction: column;
    }

    .form-modal-right h3 {
        font-family: 'Poppins', sans-serif;
        color: #16213E;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-modal-right p {
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
        font-size: 14px;
        color: #16213EB2;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-row {
        display: flex;
        gap: 14px;
        margin-bottom: 15px;
    }

    .form-row > div {
        flex: 1;
    }

    .form-control, .form-select {
        width: 100%;
        padding: 10px 15px;
        border-radius: 5px;
        background-color: #16213E1A; /* Fundo cinza claro como na imagem */
        font-size: 14px;
        box-sizing: border-box;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus, .form-select:focus {
        border-color: #01AEF0;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(1, 174, 240, 0.25);
    }

    .form-select {
        -webkit-appearance: none; /* Remove a seta padrão no Chrome/Safari */
        -moz-appearance: none; /* Remove a seta padrão no Firefox */
        appearance: none; /* Remove a seta padrão */
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%2316213E' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center; /* Ajusta a posição da seta para a esquerda */
        background-size: 16px 12px;
        padding-right: 3rem; /* Aumenta o padding para evitar sobreposição com a seta */
    }

    .form-label-group {
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: bold;
        color: #16213E;
        margin-bottom: 10px;
    }

    /* Botão de Envio */
    .btn-submit {
        font-family: 'Poppins', sans-serif;
        background-color: #01AEF0;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: background-color 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-submit:hover {
        background-color: #0095cc;
    }

    /* Estilo para o spinner */
    .spinner-border {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        vertical-align: text-bottom;
        border: 0.15em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border .75s linear infinite;
        margin-right: 8px;
    }

    @keyframes spinner-border {
        to { transform: rotate(360deg); }
    }

    .d-none {
        display: none !important;
    }

    /* Botão de Fechar */
    .form-modal-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background: none;
        border: none;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        color: #343a40;
        z-index: 10;
        line-height: 1;
    }

    .form-modal-close:hover {
        color: #000;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .form-modal-content {
            flex-direction: column;
            max-width: 95%;
            max-height: 95%;
            overflow-y: auto;
        }

        .form-modal-left {
            flex: 0 0 auto;
            padding: 20px;
        }

        .form-modal-right {
            padding: 20px;
        }

        .form-row {
            flex-direction: column;
            gap: 0;
        }
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

{{-- Estrutura do Modal --}}
<div id="updateFormModal" class="form-modal">
    <div class="form-modal-content">
        {{-- Botão de fechar --}}
        <button class="form-modal-close" onclick="document.getElementById('updateFormModal').style.display='none'">&times;</button>

        {{-- Coluna da Imagem (Esquerda) --}}
        <div class="form-modal-left">
            <h2>
                Uma melhor experiência para nossos <span class="ultra-text">Ultra clientes</span>
            </h2>
            {{-- Placeholder da Imagem. O usuário irá preencher o src correto. --}}
            <img src="{{ asset('images/modal/form.png') }}" alt="Melhor experiência para Ultra clientes">
        </div>

        {{-- Coluna do Formulário (Direita) --}}
        <div class="form-modal-right">
            <h3>Queremos evoluir com você!</h3>
            <p>
                A Ultra Lims está entrando em uma fase de grandes novidades, eventos, lançamentos exclusivos e um novo layout para 2026. Para que você receba tudo da melhor forma, precisamos entender como prefere se comunicar.
                <br><br>
                Preencha o formulário e nos ajude a melhorar nossos canais de comunicação.
                Sua opinião é essencial para que você receba novidades e conteúdos exclusivos em primeira mão, do jeito que mais combina com você.
            </p>

            <form id="updateUserForm" action="{{ route('ultralims.form') }}" method="POST">
                @csrf {{-- Diretiva Blade para proteção CSRF --}}

                {{-- Dados da empresa --}}
                <div class="form-label-group">Dados da empresa</div>
                <div class="form-row">
                    <div>
                        <input value="{{ \Illuminate\Support\Facades\Auth::guard('ultralims')->user()->laboratorio }}" type="text" id="empresa" name="company" class="form-control" placeholder="Empresa*" required>
                    </div>
                    <div>
                        <input type="text" id="cnpj" name="cnpj" class="form-control" placeholder="CNPJ">
                    </div>
                </div>

                {{-- Dados do usuário --}}
                <div class="form-label-group">Dados do usuário</div>
                <div class="form-row">
                    <div>
                        <input type="text" id="nome" name="name" class="form-control" placeholder="Nome*" required>
                    </div>
                    <div>
                        <input type="text" id="cargo" name="office" class="form-control" placeholder="Cargo*" required>
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <input type="email" id="email" name="email" class="form-control" placeholder="E-mail*" required>
                    </div>
                    <div>
                        <input type="text" id="whatsapp" name="phone" class="form-control" placeholder="Whatsapp*">
                    </div>
                </div>

                {{-- Preferência de Alertas --}}
                <div class="form-group">
                    <select id="preferencia_alertas" name="notify_on" class="form-select" required>
                        <option value="" disabled selected>Por onde prefiro receber comunicados</option>
                        <option value="email">E-mail</option>
                        <option value="phone">Whatsapp</option>
                        <option value="all">Ambos</option>
                    </select>
                </div>

                {{-- Botão de Envio --}}
                <div class="form-group" style="display: flex; justify-content: end; text-align: right; margin-top: 20px;">
                    <button type="submit" id="submitButton" class="btn-submit">
                        <span id="spinner" class="spinner-border d-none" role="status" aria-hidden="true"></span>
                        <span id="buttonText">Enviar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Lógica JavaScript/AJAX para o envio do formulário e efeito de loading
    document.getElementById('updateUserForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Previne o envio padrão do formulário

        const form = e.target;
        const button = document.getElementById('submitButton');
        const buttonText = document.getElementById('buttonText');
        const spinner = document.getElementById('spinner');

        // 1. Efeito de "Enviando..." e Spinner
        button.disabled = true;
        buttonText.textContent = 'Enviando...';
        spinner.classList.remove('d-none');

        // 2. Coleta dos dados do formulário
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        // 3. Requisição AJAX
        // A URL de destino é definida no atributo 'action' do formulário
        const url = form.action;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': data['_token'] // Inclui o token CSRF do Laravel
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                // Verifica se a resposta foi bem-sucedida (status 200-299)
                if (!response.ok) {
                    // Lança um erro para ser pego no .catch()
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(result => {
                // Lógica de sucesso (ex: fechar modal, mostrar mensagem de sucesso)
                console.log('Sucesso:', result);
                //alert('Dados atualizados com sucesso!');
                // Fechar o modal após o sucesso
                document.getElementById('updateFormModal').style.display='none';
            })
            .catch(error => {
                // Lógica de erro (ex: mostrar mensagem de erro)
                console.error('Erro:', error);
                alert('Ocorreu um erro ao enviar os dados. Tente novamente.');
            })
            .finally(() => {
                // 4. Reverte o efeito do botão, independentemente do sucesso ou falha
                button.disabled = false;
                buttonText.textContent = 'Enviar';
                spinner.classList.add('d-none');
            });
    });

    // Função para abrir o modal (agora chamada pelo layout.blade.php)
    function openUpdateFormModal() {
        document.getElementById('updateFormModal').style.display='flex';
    }

    // Aplica as máscaras de formatação
    $(document).ready(function(){
        // Máscara para CNPJ: 99.999.999/9999-99
        $('#cnpj').mask('00.000.000/0000-00', {reverse: true});

        // Máscara para WhatsApp/Telefone (com 9º dígito opcional)
        var SPMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };

        $('#whatsapp').mask(SPMaskBehavior, spOptions);
    });

    // REMOVIDO: openUpdateFormModal() - A chamada agora é controlada pelo layout.blade.php
</script>

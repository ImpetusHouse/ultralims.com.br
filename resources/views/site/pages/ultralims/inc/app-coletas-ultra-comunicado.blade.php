<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
    .comunicado-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        align-items: center;
        justify-content: center;
    }

    .comunicado-modal.show {
        display: flex;
        opacity: 1;
    }

    .comunicado-modal.closing {
        display: flex;
        opacity: 0;
    }

    .comunicado-modal-content {
        position: relative;
        max-width: 700px; /* Ajustado para um tamanho mais comum de modal de comunicado */
        max-height: 90%;
        transform: scale(0.8) translateY(-20px);
        transition: transform 0.3s ease-in-out;
        border-radius: 8px;
        overflow: hidden; /* Para garantir que o conteúdo e a imagem respeitem o border-radius */
    }

    .comunicado-modal.show .comunicado-modal-content {
        transform: scale(1) translateY(0);
    }

    .comunicado-modal.closing .comunicado-modal-content {
        transform: scale(0.9) translateY(-10px);
    }

    .comunicado-modal-image {
        width: 100%;
        height: auto;
        display: block;
    }

    .comunicado-modal-body {
        background-color: #0C1425;
        color: #FFFFFF;
        padding: 20px;
        font-family: 'Poppins', sans-serif; /* Adicionado para melhor legibilidade */
        line-height: 1.6;
        font-size: 12px;
        font-weight: 400;
    }

    .comunicado-modal-body p {
        margin-bottom: 15px;
    }

    .comunicado-modal-close {
        position: absolute;
        top: 10px; /* Posição ajustada para ficar sobre a imagem ou no canto do modal */
        right: 10px;
        background: rgba(0, 0, 0, 0.5);
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #FFF;
        z-index: 10000;
        transition: background 0.2s ease;
    }

    .comunicado-modal-close:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    @media (max-width: 768px) {
        .comunicado-modal-content {
            max-width: 95%;
            margin: 20px;
        }
    }
</style>

{{-- MODAL COMUNICADO COLETAS ULTRA --}}
<div id="coletasUltraModal" class="comunicado-modal">
    <div class="comunicado-modal-content">
        {{-- Botão de fechar posicionado sobre o conteúdo --}}
        <button class="comunicado-modal-close" onclick="closeColetasUltraModal()">&times;</button>

        {{-- Imagem no topo com o caminho fornecido --}}
        <img src="{{ asset('images/modal/coletas-ultra-header.full.png') }}" alt="Aplicativo de coletas Ultra" class="comunicado-modal-image">

        {{-- Corpo do modal com a cor de fundo #0C1425 e o texto --}}
        <div class="comunicado-modal-body">
            <p>
                Prezados,
            </p>
            <p>
                Informamos que o Aplicativo de Coletas Ultra apresenta indisponibilidade em dispositivos Xiaomi, cuja utilização não é recomendada até a conclusão das correções.
            </p>
            <p>
                Para os demais dispositivos, será necessário realizar o processo de validação, a fim de garantir uma análise técnica adequada.
            </p>
            <p>
                A versão 4.0.16, corrigida e homologada em aparelhos Samsung, será disponibilizada na segunda-feira, <span style="color: #01AEF0; font-weight: bold">02/12</span>.
            </p>
            <p>
                <b>Medida temporária:</b> as coletas em campo deverão ser registradas manualmente até a normalização do aplicativo.
            </p>
            <p>
                Nossa Equipe de Engenharia permanece disponível para suporte.
            </p>
            <p>
                Um novo comunicado será enviado em <span style="color: #01AEF0; font-weight: bold">02/12</span> com as atualizações.
            </p>
            <p>
                Atenciosamente,<br>
                Equipe Ultra
            </p>
        </div>
    </div>
</div>

<script>
    // Função para verificar se o modal deve ser exibido
    function shouldShowColetasUltraModal() {
        // Usando um nome diferente para o localStorage para não conflitar com o modal original
        // A chave 'coletasUltraModalClosedPermanently' será usada para indicar que o modal foi fechado permanentemente.
        const closedPermanently = localStorage.getItem('coletasUltraModalClosedPermanently');

        // Se a chave existir, o modal não deve ser exibido.
        return !closedPermanently;
    }

    // Função para fechar o modal
    function closeColetasUltraModal() {
        const modal = document.getElementById('coletasUltraModal');
        modal.classList.add('closing');
        modal.classList.remove('show');

        // Salvar chave para indicar que o modal foi fechado permanentemente
        localStorage.setItem('coletasUltraModalClosedPermanently', 'true');

        setTimeout(() => {
            modal.style.display = 'none';
            modal.classList.remove('closing');

            // CHAMA A FUNÇÃO PARA EXIBIR O PRÓXIMO MODAL
            if (typeof showNextModal === 'function') {
                showNextModal();
            }
        }, 300);
    }

    // Função para mostrar o modal
    function showColetasUltraModal() {
        const modal = document.getElementById('coletasUltraModal');
        modal.style.display = 'flex';
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }

    // Fechar modal ao clicar fora do conteúdo
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('coletasUltraModal');

        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeColetasUltraModal();
                }
            });
        }
    });

    // Fechar modal com tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('coletasUltraModal');
            if (modal && modal.classList.contains('show')) {
                closeColetasUltraModal();
            }
        }
    });
</script>

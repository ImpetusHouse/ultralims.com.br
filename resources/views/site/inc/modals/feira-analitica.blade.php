<style>
    .feira-modal {
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

    .feira-modal.show {
        display: flex;
        opacity: 1;
    }

    .feira-modal.closing {
        display: flex;
        opacity: 0;
    }

    .feira-modal-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
        transform: scale(0.8) translateY(-20px);
        transition: transform 0.3s ease-in-out;
    }

    .feira-modal.show .feira-modal-content {
        transform: scale(1) translateY(0);
    }

    .feira-modal.closing .feira-modal-content {
        transform: scale(0.9) translateY(-10px);
    }

    .feira-modal-image {
        width: 100%;
        height: auto;
    }

    .feira-modal-close {
        position: absolute;
        top: -25px;
        right: -25px;
        background: transparent;
        border: none;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transition: all 0.2s ease;
        color: #FFF;
        z-index: 10000;
    }

    .feira-modal-close:hover {
        background: transparent;
        color: #EAEAEA;
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        .feira-modal-content {
            max-width: 95%;
            margin: 20px;
        }

        .feira-modal-close {
            top: -20px;
            right: -20px;
            width: 30px;
            height: 30px;
            font-size: 18px;
        }
    }
</style>

{{-- MODAL FEIRA ANALÍTICA --}}
<div id="feiraAnaliticaModal" class="feira-modal">
    <div class="feira-modal-content">
        <button class="feira-modal-close" onclick="closeFeiraModal()">&times;</button>
        <a href="https://home.analiticanet.com.br/" target="_blank">
        <img src="{{ asset('images/modal/feira-analitica-2025.png') }}" alt="Feira Analítica 2025" class="feira-modal-image">
        </a>
    </div>
</div>

<script>
    // Função para verificar se o modal deve ser exibido
    function shouldShowFeiraModal() {
        const lastClosed = localStorage.getItem('feiraModalLastClosed');
        if (!lastClosed) return true;

        const oneHour = 60 * 60 * 1000; // 1 hora em milissegundos
        const now = new Date().getTime();
        const lastClosedTime = parseInt(lastClosed);

        return (now - lastClosedTime) > oneHour;
    }

    // Função para fechar o modal
    function closeFeiraModal() {
        const modal = document.getElementById('feiraAnaliticaModal');
        modal.classList.add('closing');
        modal.classList.remove('show');

        // Salvar timestamp do fechamento
        localStorage.setItem('feiraModalLastClosed', new Date().getTime().toString());

        setTimeout(() => {
            modal.style.display = 'none';
            modal.classList.remove('closing');
        }, 300);
    }

    // Função para mostrar o modal
    function showFeiraModal() {
        const modal = document.getElementById('feiraAnaliticaModal');
        modal.style.display = 'flex';
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }

    // Fechar modal ao clicar fora da imagem
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('feiraAnaliticaModal');

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeFeiraModal();
            }
        });

        // Verificar se deve mostrar o modal ao carregar a página
        if (shouldShowFeiraModal()) {
            setTimeout(showFeiraModal, 1000); // Mostrar após 1 segundo
        }
    });

    // Fechar modal com tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('feiraAnaliticaModal');
            if (modal.classList.contains('show')) {
                closeFeiraModal();
            }
        }
    });
</script>

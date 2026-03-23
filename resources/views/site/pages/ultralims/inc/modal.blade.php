<style>
    /* Estilo para o input */
    .form-item {
        padding: 8px 16px;
        background-color: #00000040;
        color: #FFFFFF40;
        border: 2px solid transparent;
        border-radius: 10px;
        transition: border-color 0.3s ease;
    }

    /* Estilo para quando o input estiver em foco */
    .form-item:focus {
        outline: none;
        border-color: #03B7FC;
        color: #FFFFFF;
    }

    /* Estilo para o texto do placeholder */
    .form-item::placeholder {
        color: #FFFFFF40;
        opacity: 1;
    }

    /* Altera a cor do placeholder ao focar no input */
    .form-item:focus::placeholder {
        color: #FFFFFF80;
    }

    /* Estilo para o botão de fechar */
    #btn-close {
        background: transparent;
        border: none;
        cursor: pointer;
    }

    #btn-close svg {
        fill: #FFFFFF80;
        transition: fill 0.2s ease;
    }

    #btn-close:hover svg {
        fill: #FFFFFF;
    }

    /* Animação da bolinha */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    #loading-spinner {
        display: none;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top: 2px solid #03B7FC;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-left: 10px;
    }
</style>

<style>
    .ck-editor{
        border-radius: 10px !important;
    }
    .ck-content{
        border-bottom-left-radius: 10px !important;
        border-bottom-right-radius: 10px !important;
    }
    .ck.ck-editor__editable > .ck-placeholder::before {
        color: #FFFFFF40;
    }
    .ck-content.ck-focused{
        border-color: #03B7FC !important;
    }
    .ck-content p{
        color: #FFFFFF40;
    }
    .ck-editor__editable_inline {
        min-height: 144px; /* Define a altura mínima para o editor */
        max-height: 144px; /* Define a altura máxima */
        overflow-y: auto;  /* Adiciona rolagem se o conteúdo for maior que 144px */
    }

    :root{
        /* Helper variables to avoid duplication in the colors. */
        --ck-custom-background: #00000040 !important; /* COR FUNDO TOOLBAR */
        --ck-custom-foreground: #323248 !important; /* COR ITEM SELECIONADO */
        --ck-custom-border: #00000040 !important; /* BORDA TOOLBAR */
        --ck-color-base-border: #00000040 !important; /* BORDA TEXTO */
        --ck-custom-white: hsl(0, 0%, 100%) !important;
        --ck-color-base-background: #00000040 !important; /* COR FUNDO TEXTO */
        --ck-color-base-active: #474761 !important; /* COR DA BORDA QUANDO ATIVADO */

        /* -- Overrides generic colors. ------------------------------------------------------------- */

        --ck-color-base-foreground: var(--ck-custom-background) !important;
        --ck-color-focus-border: #474761 !important;
        --ck-color-text: #92929F !important;
        --ck-color-shadow-drop: hsla(0, 0%, 0%, 0.2) !important;
        --ck-color-shadow-inner: hsla(0, 0%, 0%, 0.1) !important;

        /* -- Overrides the default .ck-button class colors. ---------------------------------------- */

        --ck-color-button-default-background: 000000100 !important;
        --ck-color-button-default-hover-background: #323248 !important;
        --ck-color-button-default-active-background: #323248 !important;
        --ck-color-button-default-active-shadow: hsl(270, 2%, 23%) !important;
        --ck-color-button-default-disabled-background: var(--ck-custom-background) !important;

        --ck-color-button-on-background: var(--ck-custom-foreground) !important;
        --ck-color-button-on-hover-background: #323248 !important;
        --ck-color-button-on-active-background: #323248 !important;
        --ck-color-button-on-active-shadow: hsl(240, 3%, 19%) !important;
        --ck-color-button-on-disabled-background: var(--ck-custom-foreground) !important;

        --ck-color-button-action-background: hsl(168, 76%, 42%) !important;
        --ck-color-button-action-hover-background: hsl(168, 76%, 38%) !important;
        --ck-color-button-action-active-background: hsl(168, 76%, 36%) !important;
        --ck-color-button-action-active-shadow: hsl(168, 75%, 34%) !important;
        --ck-color-button-action-disabled-background: hsl(168, 76%, 42%) !important;
        --ck-color-button-action-text: var(--ck-custom-white) !important;

        --ck-color-button-save: hsl(120, 100%, 46%) !important;
        --ck-color-button-cancel: hsl(15, 100%, 56%) !important;

        /* -- Overrides the default .ck-dropdown class colors. -------------------------------------- */

        --ck-color-dropdown-panel-background: var(--ck-custom-background) !important;
        --ck-color-dropdown-panel-border: var(--ck-custom-foreground) !important;

        /* -- Overrides the default .ck-splitbutton class colors. ----------------------------------- */

        --ck-color-split-button-hover-background: var(--ck-color-button-default-hover-background) !important;
        --ck-color-split-button-hover-border: var(--ck-custom-foreground) !important;

        /* -- Overrides the default .ck-input class colors. ----------------------------------------- */

        --ck-color-input-background: var(--ck-custom-background) !important;
        --ck-color-input-border: hsl(257, 3%, 43%) !important;
        --ck-color-input-text: hsl(0, 0%, 98%) !important;
        --ck-color-input-disabled-background: hsl(255, 4%, 21%) !important;
        --ck-color-input-disabled-border: hsl(250, 3%, 38%) !important;
        --ck-color-input-disabled-text: hsl(0, 0%, 78%) !important;

        /* -- Overrides the default .ck-labeled-field-view class colors. ---------------------------- */

        --ck-color-labeled-field-label-background: var(--ck-custom-background) !important;

        /* -- Overrides the default .ck-list class colors. ------------------------------------------ */

        --ck-color-list-background: var(--ck-custom-background) !important;
        --ck-color-list-button-hover-background: var(--ck-custom-foreground) !important;
        --ck-color-list-button-on-background: #01AEF0 !important;
        --ck-color-list-button-on-text: var(--ck-custom-white) !important;

        /* -- Overrides the default .ck-balloon-panel class colors. --------------------------------- */

        --ck-color-panel-background: var(--ck-custom-background) !important;
        --ck-color-panel-border: var(--ck-custom-border) !important;

        /* -- Overrides the default .ck-toolbar class colors. --------------------------------------- */

        --ck-color-toolbar-background: var(--ck-custom-background) !important;
        --ck-color-toolbar-border: var(--ck-custom-border) !important;

        /* -- Overrides the default .ck-tooltip class colors. --------------------------------------- */

        --ck-color-tooltip-background: hsl(252, 7%, 14%) !important;
        --ck-color-tooltip-text: hsl(0, 0%, 93%) !important;

        /* -- Overrides the default colors used by the ckeditor5-image package. --------------------- */

        --ck-color-image-caption-background: hsl(0, 0%, 97%) !important;
        --ck-color-image-caption-text: hsl(0, 0%, 20%) !important;

        /* -- Overrides the default colors used by the ckeditor5-widget package. -------------------- */

        --ck-color-widget-blurred-border: hsl(0, 0%, 87%) !important;
        --ck-color-widget-hover-border: hsl(43, 100%, 68%) !important;
        --ck-color-widget-editable-focus-background: var(--ck-custom-white) !important;

        /* -- Overrides the default colors used by the ckeditor5-link package. ---------------------- */

        --ck-color-link-default: #01AEF0 !important;
    }

    .ck-powered-by-balloon{
        display: none !important;
    }
</style>

<div id="modal-container" class="z-50 fixed top-0 left-0 right-0 bottom-0 flex items-center w-full h-full p-4 bg-gray-800 bg-opacity-80 overflow-y-auto hidden">
    <div class="max-w-4xl w-full mx-auto p-6 rounded-xl bg-[#0E1326] relative">
        <div class="overflow-hidden">
            <div class="whitespace-nowrap transition-transform duration-500 ease-in-out">
                <div class="w-full whitespace-normal">
                    <!-- Título fixo -->
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-2xl font-bold flex items-center">
                            <span class="text-[#FFFFFF]">Criar </span>
                            <span class="text-[#03B7FC] ml-2">comunicado</span>
                        </h4>
                        <button id="btn-close" type="button" class="text-[#FFFFFF] hover:text-[#03B7FC]" onclick="closeAlertModal()">
                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <!-- Formulário -->
                    <form id="form-alerts" action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="alert-id">
                        <!-- Input de título -->
                        <div class="w-full mb-4">
                            <input class="w-full form-item" type="text" name="title" placeholder="Título" id="input-title" required>
                        </div>
                        <!-- Textarea de conteúdo -->
                        <div class="w-full mb-4">
                            <textarea class="w-full form-item" placeholder="Inserir conteúdo" id="input-content" style="resize: none"></textarea>
                        </div>
                        <!-- Input file / Datas -->
                        <div class="w-full block md:flex mb-16">
                            <div class="w-full md:w-2/5 flex">
                                <div class="w-1/2 pr-1">
                                    <input class="form-item w-full" type="date" name="start_date" placeholder="Data inicial" id="input-date-start" required>
                                </div>
                                <div class="w-1/2 pl-1">
                                    <input class="form-item w-full" type="date" name="end_date" placeholder="Data final" id="input-date-end" required>
                                </div>
                            </div>
                            <div class="w-full md:w-3/5 flex items-center gap-2 pr-2 mb-0 {{--mb-4 md:mb-0--}}">
                                {{--
                                <input type="file" id="input-file" name="photo" style="display: none">
                                <button id="btn-file" type="button" class="w-[180px] inline-block py-2 px-5 text-center font-semibold leading-6 text-[#03B7FC] hover:text-[#FFFFFF] bg-[#03B7FC20] hover:bg-[#03B7FC] rounded-lg transition duration-200">
                                    Enviar arquivo
                                </button>
                                <div id="div-file" class="text-[16px] text-[#FFFFFF40] one-line-text"></div>
                                --}}}
                            </div>
                        </div>
                        <!-- Botão -->
                        <div class="flex flex-wrap -mx-3">
                            <div class="px-3 mb-2 sm:mb-0">
                                <button id="btn-save" type="submit" class="py-2 px-5 text-center font-semibold leading-6 text-gray-200 bg-[#03B7FC] hover:bg-[#0596D1] rounded-lg transition duration-200 flex items-center justify-center">
                                    Salvar
                                    <div id="loading-spinner"></div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('ckeditor-page/build/ckeditor.js')}}"></script>
<script>
    /*
    // Associa o clique do botão "Enviar arquivo" ao clique no input de arquivo
    document.getElementById('btn-file').onclick = function() {
        document.getElementById('input-file').click(); // Simula o clique no input file
    };
    // Exibe o nome do arquivo carregado na div correspondente
    document.getElementById('input-file').onchange = function() {
        var fileName = this.files[0].name; // Pega o nome do arquivo
        document.getElementById('div-file').innerText = fileName; // Exibe o nome do arquivo na div
    };
     */

    let editor;
    ClassicEditor.create(document.querySelector( '#input-content' ), {
        language: 'pt-br',
        removePlugins: ['Title'],
        placeholder: '',
        height: 144,
        link: {
            addTargetToExternalLinks: true // Esta configuração adiciona target="_blank" a todos os links externos.
        }
    }).then( newEditor => {
        newEditor.model.document.on('change', () => {
            const data = editor.getData();
        });
        editor = newEditor;
    }).catch( error => {});

    // Animação de salvamento
    document.getElementById('form-alerts').onsubmit = function(event) {
        event.preventDefault(); // Impede o envio normal do formulário

        // Exibe a bolinha de carregamento dentro do botão
        var spinner = document.getElementById('loading-spinner');
        spinner.style.display = 'block';

        // Cria um objeto FormData para pegar os dados do formulário
        var formData = new FormData(document.getElementById('form-alerts'));

        var id = $('#alert-id').val();
        if(id > 0){
            formData.append('_method', 'PUT');
        }
        formData.append('content', editor.getData());

        // Faz a requisição AJAX usando fetch
        $.ajax({
            url: id > 0 ? '{{ route('ultralims.alerts.update', '_ID_') }}'.replace('_ID_', id) : '{{ route('ultralims.alerts.store') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){
                spinner.style.display = 'none'; // Esconde o spinner

                if (data.success) {
                    //alert('Salvo com sucesso!');
                    location.reload();
                    document.getElementById('modal-container').classList.add('hidden');
                } else {
                    alert('Erro ao salvar: ' + (data.message || 'Verifique os dados e tente novamente.'));
                }
            },
            error: function(data){
                spinner.style.display = 'none';
                alert('Ocorreu um erro ao processar a solicitação. Tente novamente mais tarde.');
                console.error('Erro:', data);
            }
        });
    }
    // Função para formatar a data no formato YYYY-MM-DD
    function formatDate(dateString) {
        var date = new Date(dateString);
        var year = date.getFullYear();
        var month = ('0' + (date.getMonth() + 1)).slice(-2); // Adiciona o zero à esquerda, se necessário
        var day = ('0' + date.getDate()).slice(-2); // Adiciona o zero à esquerda, se necessário
        return `${year}-${month}-${day}`;
    }
    // Função para abrir o modal de edição
    function editAlert(id){
        $.ajax({
            url: '{{ route('ultralims.alerts.edit', '_ID_') }}'.replace('_ID_', id),
            type: 'GET',
            processData: false,
            contentType: false,
            success: function(data){
                if (data.success) {
                    // Ajusta os inputs do modal, formatando as datas corretamente
                    $('#alert-id').val(id);
                    $('#input-title').val(data.alert.title);
                    editor.setData(data.alert.content);
                    $('#input-date-start').val(formatDate(data.alert.start_date));
                    $('#input-date-end').val(formatDate(data.alert.end_date));
                    openCreateAlertModal();
                } else {
                    alert(data.message);
                }
            },
            error: function(data){
                alert('Ocorreu um erro ao processar a solicitação. Tente novamente mais tarde.');
                console.error('Erro:', data);
            }
        });
    }
    //Exclui um comunicado
    function deleteAlert(id) {
        // Pergunta ao usuário se ele realmente quer excluir o comunicado
        if (confirm('Você realmente deseja excluir este comunicado?')) {
            $.ajax({
                url: '{{ route('ultralims.alerts.destroy', '_ID_') }}'.replace('_ID_', id),
                type: 'DELETE',
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                },
                error: function (data) {
                    alert('Ocorreu um erro ao processar a solicitação. Tente novamente mais tarde.');
                    console.error('Erro:', data);
                }
            });
        }
    }

    // Função para abrir o modal
    function openCreateAlertModal() {
        document.getElementById('modal-container').classList.remove('hidden');
    }
    // Função para fechar o modal
    function closeAlertModal() {
        document.getElementById('modal-container').classList.add('hidden');
        $('#alert-id').val(null);
        $('#input-title').val(null);
        $('#input-content').val(null);
        $('#input-date-start').val(null);
        $('#input-date-end').val(null);
    }
</script>

<div id="modal-card" class="p-4 fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden flex items-center justify-center" tabindex="-1" role="dialog" style="z-index: 1000">
    <div class="mx-auto p-5 border w-96 shadow-lg rounded-md bg-white rounded-xl transition-opacity opacity-0 modal-card-content">
        <div class="flex justify-between">
            <div></div>
            <button onclick="closeModalCard()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="flex items-center mt-3 text-center" style="min-height: 10rem;">
            <div id="modal-card-content" class="text-left p-2 h-full">
                <!-- Conteúdo do modal será inserido aqui -->
            </div>
        </div>
    </div>
</div>

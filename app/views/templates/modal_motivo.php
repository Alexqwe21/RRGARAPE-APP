<!-- Modal Cancelar Agendamento -->
<div id="modal_motivo" class="modal-overlay hidden" aria-hidden="true">
    <div class="modal-content">
        <button class="close-btn" onclick="fecharModalMotivo()" aria-label="Fechar Modal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M6 6L18 18M6 18L18 6" stroke="#fff" stroke-width="2" stroke-linecap="round" />
            </svg>
        </button>

        <div class="modal-icon">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none">
                <path d="M12 9v4m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>

        <h2>Motivo do Cancelamento</h2>
        <p id="texto_motivo">Motivo aqui</p>

        <div class="modal-actions">
            <button class="btn-fechar" onclick="fecharModalMotivo()">Fechar</button>
        </div>
    </div>
</div>

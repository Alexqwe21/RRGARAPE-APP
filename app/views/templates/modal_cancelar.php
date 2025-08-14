<!-- Modal Cancelar Agendamento -->
<div id="modalCancelar" class="modal-overlay hidden" aria-hidden="true">
    <div class="modal-content">
        <button class="close-btn" onclick="fecharModal()" aria-label="Fechar Modal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M6 6L18 18M6 18L18 6" stroke="#fff" stroke-width="2" stroke-linecap="round" />
            </svg>
        </button>

        <div class="modal-icon">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none">
                <path d="M12 9v4m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>

        <h2>Cancelar Agendamento?</h2>
        <p>Tem certeza que deseja cancelar este agendamento? Essa ação não poderá ser desfeita.</p>

        <div class="modal-actions">
            <form id="formCancelar" method="POST">
                <input type="hidden" id="id_agendamento" name="id_agendamento" value="">
                <button type="submit" class="btn-cancelar">Sim, Cancelar</button>
            </form>
            <button class="btn-fechar" onclick="fecharModal()">Não, Voltar</button>
        </div>
    </div>
</div>
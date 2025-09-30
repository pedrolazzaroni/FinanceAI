// Modal Manager
window.modalManager = {
    activeModal: null,
    callbacks: {},

    open: function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            this.activeModal = modalId;
            
            // Para modais com classe .modal (dashboard style)
            if (modal.classList.contains('modal')) {
                modal.classList.remove('hidden');
                modal.classList.add('show');
            } else {
                // Para novos modais com .modal-overlay
                modal.classList.add('active');
            }
            
            document.body.style.overflow = 'hidden';
            
            // Executar callback se existir
            if (this.callbacks[modalId] && this.callbacks[modalId].onOpen) {
                this.callbacks[modalId].onOpen();
            }
        }
    },

    close: function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            // Para modais com classe .modal (dashboard style)
            if (modal.classList.contains('modal')) {
                modal.classList.remove('show');
                modal.classList.add('hidden');
            } else {
                // Para novos modais com .modal-overlay
                modal.classList.remove('active');
            }
            
            document.body.style.overflow = '';
            this.activeModal = null;
            
            // Executar callback se existir
            if (this.callbacks[modalId] && this.callbacks[modalId].onClose) {
                this.callbacks[modalId].onClose();
            }
        }
    },

    closeActive: function() {
        if (this.activeModal) {
            this.close(this.activeModal);
        }
    },

    onOpen: function(modalId, callback) {
        if (!this.callbacks[modalId]) {
            this.callbacks[modalId] = {};
        }
        this.callbacks[modalId].onOpen = callback;
    },

    onClose: function(modalId, callback) {
        if (!this.callbacks[modalId]) {
            this.callbacks[modalId] = {};
        }
        this.callbacks[modalId].onClose = callback;
    }
};

// Fechar modal com ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && window.modalManager.activeModal) {
        window.modalManager.closeActive();
    }
});

// Fechar modal clicando fora
document.addEventListener('click', function(e) {
    if ((e.target.classList.contains('modal-overlay') || e.target.classList.contains('modal-backdrop')) && window.modalManager.activeModal) {
        window.modalManager.closeActive();
    }
});
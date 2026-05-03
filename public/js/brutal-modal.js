(function() {
    const initModal = () => {
        window.BrutalModal = {
            overlay: document.getElementById('brutal-modal-overlay'),
            container: document.getElementById('brutal-modal-container'),
            title: document.getElementById('modal-title'),
            message: document.getElementById('modal-message'),
            tag: document.getElementById('modal-tag'),
            actions: document.getElementById('modal-actions'),
            
            show: function(config) {
                if (!this.overlay) this.refreshElements();
                
                this.title.innerText = config.title || 'SYSTEM_ALERT';
                this.message.innerText = config.message || 'Proceed with action?';
                this.tag.innerText = config.tag || 'SYSTEM_PROMPT';
                
                // Clear actions
                this.actions.innerHTML = '';
                
                // Add buttons
                if (config.actions) {
                    config.actions.forEach(action => {
                        const btn = document.createElement('button');
                        btn.className = 'brutal-button';
                        btn.innerText = action.label;
                        btn.style.fontSize = '0.9rem';
                        btn.style.padding = '12px';
                        btn.style.width = '100%';
                        if (action.style === 'danger') {
                            btn.style.background = '#FF0000';
                            btn.style.color = 'white';
                        } else if (action.style === 'neutral') {
                            btn.style.background = 'white';
                        }
                        
                        btn.onclick = () => {
                            if (action.onClick) action.onClick();
                            this.close();
                        };
                        this.actions.appendChild(btn);
                    });
                } else {
                    // Default OK button
                    const btn = document.createElement('button');
                    btn.className = 'brutal-button';
                    btn.innerText = 'ACKNOWLEDGE';
                    btn.style.width = '100%';
                    btn.onclick = () => this.close();
                    this.actions.style.gridTemplateColumns = '1fr';
                    this.actions.appendChild(btn);
                }

                this.overlay.style.display = 'flex';
                setTimeout(() => {
                    this.overlay.style.opacity = '1';
                    this.container.style.transform = 'scale(1) rotate(0deg)';
                }, 10);
            },
            
            close: function() {
                if (!this.overlay) this.refreshElements();
                this.overlay.style.opacity = '0';
                this.container.style.transform = 'scale(0.9) rotate(-2deg)';
                setTimeout(() => {
                    this.overlay.style.display = 'none';
                }, 200);
            },

            confirm: function(title, message, onConfirm, okLabel = 'CONFIRM', cancelLabel = 'ABORT') {
                this.show({
                    title: title,
                    message: message,
                    tag: 'CRITICAL_ACTION',
                    actions: [
                        { label: cancelLabel, style: 'neutral', onClick: null },
                        { label: okLabel, style: 'danger', onClick: onConfirm }
                    ]
                });
            },

            refreshElements: function() {
                this.overlay = document.getElementById('brutal-modal-overlay');
                this.container = document.getElementById('brutal-modal-container');
                this.title = document.getElementById('modal-title');
                this.message = document.getElementById('modal-message');
                this.tag = document.getElementById('modal-tag');
                this.actions = document.getElementById('modal-actions');
            }
        };

        // Close on ESC
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && window.BrutalModal) window.BrutalModal.close();
        });

        // Close on overlay click
        const overlay = document.getElementById('brutal-modal-overlay');
        if (overlay) {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay && window.BrutalModal) window.BrutalModal.close();
            });
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initModal);
    } else {
        initModal();
    }
})();

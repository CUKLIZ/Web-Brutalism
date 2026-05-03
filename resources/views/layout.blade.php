<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOOT VAULT | NEO-BRUTALIST E-COMMERCE</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <%- include('partials/navbar.blade.php') %>
    
    <!-- BRUTAL MODAL SYSTEM -->
    <div id="brutal-modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 9999; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.2s ease;">
        <div id="brutal-modal-container" class="brutal-card" style="max-width: 500px; width: 90%; transform: scale(0.9) rotate(-1deg); transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275); background: var(--gallery-white); padding: 0; overflow: hidden;">
            <!-- Header/Tag -->
            <div id="modal-tag-row" style="background: var(--brutal-black); color: white; padding: 5px 15px; display: flex; justify-content: space-between; align-items: center;">
                <span id="modal-tag" style="font-size: 0.7rem; font-weight: 900; letter-spacing: 1px;">SYSTEM_PROMPT</span>
                <button onclick="window.BrutalModal.close()" style="background: none; border: none; color: white; font-weight: 900; cursor: pointer; padding: 5px;">[X]</button>
            </div>
            
            <div style="padding: 30px;">
                <h2 id="modal-title" style="font-size: 2.5rem; line-height: 1; margin-bottom: 10px; text-shadow: 4px 4px 0px rgba(0,0,0,0.1);">PROMPT_TITLE</h2>
                <p id="modal-message" style="font-weight: 700; margin-bottom: 30px; opacity: 0.8;">Message goes here...</p>
                
                <div id="modal-actions" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <!-- Buttons injected here -->
                </div>
            </div>

            <!-- Corner Decoration -->
            <div style="position: absolute; bottom: -10px; right: -10px; width: 40px; height: 40px; background: var(--accent-yellow); border: 4px solid black; transform: rotate(45deg); z-index: -1;"></div>
        </div>
    </div>

    <script>
        window.BrutalModal = {
            overlay: document.getElementById('brutal-modal-overlay'),
            container: document.getElementById('brutal-modal-container'),
            title: document.getElementById('modal-title'),
            message: document.getElementById('modal-message'),
            tag: document.getElementById('modal-tag'),
            actions: document.getElementById('modal-actions'),
            
            show: function(config) {
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
            }
        };

        // Close on ESC
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') window.BrutalModal.close();
        });

        // Close on overlay click
        window.BrutalModal.overlay.addEventListener('click', (e) => {
            if (e.target === window.BrutalModal.overlay) window.BrutalModal.close();
        });
    </script>

    <main>
        <%- body %>
    </main>

    <%- include('partials/footer.blade.php') %>

    <script src="/js/app.js"></script>
</body>
</html>

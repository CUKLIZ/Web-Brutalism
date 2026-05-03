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

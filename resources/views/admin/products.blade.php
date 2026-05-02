<% layout('admin/layout') %>

<div class="flex-between" style="margin-bottom: 40px; align-items: flex-end;">
    <div>
        <h1 style="font-size: 3.5rem; font-weight: 900; line-height: 0.8; letter-spacing: -2px; margin-bottom: 20px;">PRODUCT_DATABASE</h1>
        <div style="display: flex; gap: 10px; align-items: center;">
            <div style="background: black; color: white; padding: 12px 15px; font-weight: 900; font-size: 0.7rem; border: 4px solid black;">[SEARCH_QUERY]</div>
            <input type="text" id="admin-search-input" placeholder="SEARCH_PRODUCT_NAME / ID / CATEGORY" 
                   style="border: 4px solid black; padding: 10px 20px; width: 400px; font-weight: 900; outline: none; background: #fff; font-family: inherit;">
        </div>
    </div>
    <a href="/admin/add-product" class="brutal-button" style="background: var(--neon-green); padding: 8px 25px; text-decoration: none; color: #000; font-size: 0.9rem;">+ ADD_NEW_ITEM</a>
</div>

<div class="grid" id="admin-product-list" style="grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px;">
    <% products.forEach(p => { %>
        <div class="admin-product-wrapper" data-search="<%= `${p.id} ${p.name.toLowerCase()} ${p.category.toLowerCase()}` %>">
            <%- include('../components/product-card.blade.php', { product: p, isAdmin: true }) %>
        </div>
    <% }) %>
</div>

<!-- Deletion Confirmation Modal -->
<div id="delete-confirm-modal" class="modal-overlay" style="background: rgba(0, 0, 0, 0.95);">
    <div class="modal-content" style="max-width: 500px; text-align: center; border-color: var(--accent-pink); box-shadow: 15px 15px 0px var(--accent-pink);">
        <div style="background: var(--accent-pink); color: white; padding: 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 30px; display: inline-block;">[CRITICAL_STRIKE_WARNING]</div>
        <h2 style="font-size: 3rem; line-height: 0.9; margin-bottom: 20px; font-weight: 900;">PERMANENT_ERASURE?</h2>
        <p class="brutal-font" style="margin-bottom: 40px; font-size: 1.1rem;">YOU ARE ABOUT TO PURGE <span id="delete-item-name" style="background: black; color: white; padding: 0 5px;"></span> FROM THE VAULT DATABANKS.</p>
        
        <div class="flex" style="gap: 20px;">
            <button id="cancel-delete" class="brutal-button" style="flex: 1; background: #fff; color: black; font-size: 1.2rem;">CANCEL_OPS</button>
            <button id="confirm-delete" class="brutal-button" style="flex: 1; background: var(--accent-pink); color: #fff; font-size: 1.2rem; border-color: #000;">CONFIRM_PURGE</button>
        </div>
        
        <div style="margin-top: 30px; font-size: 0.6rem; font-weight: 900; opacity: 0.4;">ERROR_CODE: DESTRUCT_SEQUENCE_09</div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('admin-search-input');
        const wrappers = document.querySelectorAll('.admin-product-wrapper');
        
        const deleteModal = document.getElementById('delete-confirm-modal');
        const itemNameSpan = document.getElementById('delete-item-name');
        const confirmBtn = document.getElementById('confirm-delete');
        const cancelBtn = document.getElementById('cancel-delete');
        
        let activeDeleteId = null;

        // Search logic
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.toLowerCase().trim();
                wrappers.forEach(wrapper => {
                    const searchData = wrapper.getAttribute('data-search');
                    if (searchData.includes(query)) {
                        wrapper.style.display = '';
                    } else {
                        wrapper.style.display = 'none';
                    }
                });
            });
        }

        // Delete confirmation logic (using delegation because buttons are in component)
        document.addEventListener('click', (e) => {
            const deleteBtn = e.target.closest('.delete-product-btn');
            if (deleteBtn) {
                const { id, name } = deleteBtn.dataset;
                activeDeleteId = id;
                itemNameSpan.textContent = `[${name}]`;
                deleteModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });

        const closeDeleteModal = () => {
            deleteModal.style.display = 'none';
            document.body.style.overflow = '';
            activeDeleteId = null;
        };

        cancelBtn.addEventListener('click', closeDeleteModal);

        confirmBtn.addEventListener('click', () => {
            if (activeDeleteId) {
                // Find and remove the wrapper
                wrappers.forEach(wrapper => {
                    if (wrapper.getAttribute('data-search').startsWith(activeDeleteId)) {
                        const card = wrapper.querySelector('.product-card');
                        if (card) {
                            card.style.background = 'var(--accent-pink)';
                            card.style.opacity = '0.5';
                            card.style.transition = 'all 0.5s';
                        }
                        setTimeout(() => wrapper.remove(), 500);
                    }
                });
                
                console.log(`PURGING ITEM: ${activeDeleteId}`);
                closeDeleteModal();
                
                const feedback = document.createElement('div');
                feedback.innerHTML = '[SYNC_OK] ITEM_PURGED_SUCCESSFULLY';
                feedback.style.cssText = 'position: fixed; bottom: 20px; right: 20px; background: black; color: var(--neon-green); padding: 15px 25px; border: 4px solid var(--neon-green); font-weight: 900; z-index: 9999; box-shadow: 10px 10px 0px black;';
                document.body.appendChild(feedback);
                setTimeout(() => feedback.remove(), 3000);
            }
        });
    });
</script>

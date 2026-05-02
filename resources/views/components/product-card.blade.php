<div class="brutal-card product-card <%= (typeof className !== 'undefined' ? className : (typeof locals.class !== 'undefined' ? locals.class : '')) %>" 
     <% if (typeof useDataAttrs !== 'undefined' && useDataAttrs) { %>
     data-name="<%= product.name.toLowerCase() %>" 
     data-category="<%= product.category %>"
     <% } %>>
    <img src="<%= product.image %>" alt="<%= product.name %>" style="width: 100%; height: 250px; object-fit: cover; border-bottom: 4px solid black;">
    
    <div class="flex-between" style="padding: 15px; background: #fff;">
        <div>
            <h3 style="font-size: 1.5rem; margin-bottom: 5px; font-weight: 900;"><%= product.name %></h3>
            <p class="brutal-font" style="font-size: 1.2rem; font-weight: 900; color: #000;"><%= formatPrice(product.price) %></p>
        </div>
        <div style="text-align: right;">
            <span style="font-size: 0.7rem; font-weight: 900; opacity: 0.5; display: block;">[<%= product.category %>]</span>
            <% if (typeof isAdmin !== 'undefined' && isAdmin && product.stock) { %>
                <% const stockInfo = typeof product.stock === 'string' ? product.stock : Object.entries(product.stock).map(([s, q]) => `${s}:${q}`).join(' '); %>
                <span style="font-size: 0.5rem; font-weight: 900; display: block; margin-top: 5px; color: var(--neon-green); background: #000; padding: 2px 5px; white-space: nowrap;"><%= stockInfo %></span>
            <% } else if (typeof isAdmin !== 'undefined' && isAdmin) { %>
                <span style="font-size: 0.6rem; font-weight: 900; display: block; margin-top: 5px; color: var(--neon-green); background: #000; padding: 2px 5px;">STOCK: 24_UNIT</span>
            <% } else { %>
                <span class="badge" style="background: var(--neon-green); color: black;">NEW</span>
            <% } %>
        </div>
    </div>

    <div class="flex" style="gap: 10px; padding: 15px; padding-top: 0; background: #fff;">
        <% if (typeof isAdmin !== 'undefined' && isAdmin) { %>
            <a href="/admin/edit-product/<%= product.id %>" class="brutal-button" style="flex: 1; text-align: center; padding: 0.6rem; background: var(--accent-yellow); font-size: 0.8rem; text-decoration: none; color: black; font-weight: 900;">EDIT_INTEL</a>
            <button class="brutal-button delete-product-btn" 
                    data-id="<%= product.id %>" 
                    data-name="<%= product.name %>" 
                    style="flex: 1; padding: 0.6rem; background: var(--accent-pink); font-size: 0.8rem; color: white; border-color: #000; font-weight: 900;">PURGE</button>
        <% } else { %>
            <button class="brutal-button quick-view-btn" 
                    data-id="<%= product.id %>"
                    data-name="<%= product.name %>"
                    data-price="<%= product.price %>"
                    data-image="<%= product.image %>"
                    data-category="<%= product.category %>"
                    style="flex: 1; padding: 0.6rem; background: var(--accent-yellow); font-size: 0.8rem; font-weight: 900;">QUICK</button>
            <a href="/product/<%= product.id %>" class="brutal-button" style="flex: 1; text-align: center; padding: 0.6rem; background: #fff; font-size: 0.8rem; text-decoration: none; color: black; font-weight: 900;">FULL</a>
            <button class="brutal-button buy-btn" 
                    data-id="<%= product.id %>"
                    data-name="<%= product.name %>"
                    data-price="<%= product.price %>"
                    data-image="<%= product.image %>"
                    data-category="<%= product.category %>"
                    style="flex: 1; padding: 0.6rem; background: var(--accent-pink); font-size: 0.8rem; color: white; font-weight: 900;">LOOT</button>
        <% } %>
    </div>
</div>

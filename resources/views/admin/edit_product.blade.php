<% layout('admin/layout') %>

<div style="margin-bottom: 40px;">
    <h1 style="font-size: 3.5rem; font-weight: 900; line-height: 0.8; letter-spacing: -2px;">EDIT_PRODUCT_INTEL</h1>
    <p class="brutal-font" style="font-size: 1rem; background: #000; color: var(--neon-green); display: inline-block; padding: 4px 12px; margin-top: 15px; font-weight: 900;">
        [EDIT_MODE_ACTIVE] // ID: #<%= product.id %>
    </p>
</div>

<div class="admin-stat-card" style="max-width: 700px;">
    <form action="/admin/products" method="GET" style="display: flex; flex-direction: column; gap: 20px;">
        <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 15px;">
            <div>
                <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 6px;">[PRODUCT_NAME]</label>
                <input type="text" value="<%= product.name %>" 
                       style="width: 100%; border: 3px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: #f0f0f0; font-size: 0.9rem;">
            </div>
            <div>
                <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 6px;">[PRICE_IDR]</label>
                <input type="number" value="<%= product.price %>" 
                       style="width: 100%; border: 3px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: #f0f0f0; font-size: 0.9rem;">
            </div>
        </div>

        <div>
            <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 6px;">[CATEGORY]</label>
            <select style="width: 100%; border: 3px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: #f0f0f0; font-size: 0.9rem;">
                <option <%= product.category === 'T-SHIRT' ? 'selected' : '' %>>T-SHIRT</option>
                <option <%= product.category === 'OUTERWEAR' ? 'selected' : '' %>>OUTERWEAR</option>
                <option <%= product.category === 'PANTS' ? 'selected' : '' %>>PANTS</option>
                <option <%= product.category === 'ACCESSORIES' ? 'selected' : '' %>>ACCESSORIES</option>
                <option <%= product.category === 'SHOES' ? 'selected' : '' %>>SHOES</option>
            </select>
        </div>

        <div>
            <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 6px;">[SIZE_STOCK_MATRIX]</label>
            <div class="grid" style="grid-template-columns: repeat(4, 1fr); gap: 8px;">
                <div>
                    <span style="font-size: 0.6rem; font-weight: 900; display: block; margin-bottom: 4px;">S</span>
                    <input type="number" value="<%= product.stock.s %>" style="width: 100%; border: 2px solid black; padding: 8px; font-weight: 900; font-size: 0.8rem;">
                </div>
                <div>
                    <span style="font-size: 0.6rem; font-weight: 900; display: block; margin-bottom: 4px;">M</span>
                    <input type="number" value="<%= product.stock.m %>" style="width: 100%; border: 2px solid black; padding: 8px; font-weight: 900; font-size: 0.8rem;">
                </div>
                <div>
                    <span style="font-size: 0.6rem; font-weight: 900; display: block; margin-bottom: 4px;">L</span>
                    <input type="number" value="<%= product.stock.l %>" style="width: 100%; border: 2px solid black; padding: 8px; font-weight: 900; font-size: 0.8rem;">
                </div>
                <div>
                    <span style="font-size: 0.6rem; font-weight: 900; display: block; margin-bottom: 4px;">XL</span>
                    <input type="number" value="<%= product.stock.xl %>" style="width: 100%; border: 2px solid black; padding: 8px; font-weight: 900; font-size: 0.8rem;">
                </div>
            </div>
        </div>

        <div>
            <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 12px;">[IMAGE_SOURCE_CONTROL]</label>
            <script>
                function previewImage(event, id) {
                    const reader = new FileReader();
                    reader.onload = function() {
                        const output = document.getElementById('img-preview-' + id);
                        const label = document.getElementById('label-' + id);
                        output.src = reader.result;
                        output.style.display = 'block';
                        label.style.display = 'none';
                    }
                    reader.readAsDataURL(event.target.files[0]);
                }
            </script>
            <div class="grid" style="grid-template-columns: 1.4fr 1fr; grid-template-rows: 150px 150px; gap: 15px;">
                <!-- Main Image Slot -->
                <div style="grid-row: span 2; border: 4px solid black; padding: 15px; text-align: center; background: #fff; position: relative;">
                    <div style="position: absolute; top: 0; left: 0; background: #000; color: #fff; padding: 2px 8px; font-size: 0.55rem; font-weight: 900; z-index: 5;">[IMAGE_01_PRIMARY]</div>
                    <div style="border: 2px dashed #999; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 10px;">
                        <img id="img-preview-1" src="https://images.unsplash.com/photo-1550009158-9ebf69173e03" style="max-width: 100%; max-height: 100px; display: block; object-fit: contain; margin-bottom: 10px; border: 2px solid black;">
                        <p id="label-1" style="font-weight: 900; opacity: 0.5; font-size: 0.7rem; line-height: 1.4; display: none;">UPLOAD_RAW_IMAGE<br>OR DROP_FILE</p>
                        <input type="file" onchange="previewImage(event, 1)" style="margin-top: 15px; font-size: 0.7rem; width: 100%;">
                    </div>
                </div>
                
                <!-- Secondary Image 02 -->
                <div style="border: 4px solid black; padding: 12px; text-align: center; background: #f0f0f0; position: relative;">
                    <div style="position: absolute; top: 0; left: 0; background: #000; color: #fff; padding: 2px 8px; font-size: 0.55rem; font-weight: 900; z-index: 5;">[IMAGE_02]</div>
                    <div style="border: 2px dashed #bbb; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <img id="img-preview-2" src="" style="max-width: 100%; max-height: 50px; display: none; object-fit: contain; margin-bottom: 5px; border: 1px solid black;">
                        <p id="label-2" style="font-weight: 900; opacity: 0.5; font-size: 0.6rem;">ALT_VIEW_01</p>
                        <input type="file" onchange="previewImage(event, 2)" style="margin-top: 10px; font-size: 0.65rem; width: 100%;">
                    </div>
                </div>

                <!-- Secondary Image 03 -->
                <div style="border: 4px solid black; padding: 12px; text-align: center; background: #f0f0f0; position: relative;">
                    <div style="position: absolute; top: 0; left: 0; background: #000; color: #fff; padding: 2px 8px; font-size: 0.55rem; font-weight: 900; z-index: 5;">[IMAGE_03]</div>
                    <div style="border: 2px dashed #bbb; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <img id="img-preview-3" src="" style="max-width: 100%; max-height: 50px; display: none; object-fit: contain; margin-bottom: 5px; border: 1px solid black;">
                        <p id="label-3" style="font-weight: 900; opacity: 0.5; font-size: 0.6rem;">ALT_VIEW_02</p>
                        <input type="file" onchange="previewImage(event, 3)" style="margin-top: 10px; font-size: 0.65rem; width: 100%;">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="brutal-button" 
                style="width: 100%; background: var(--neon-green); color: black; font-size: 1.5rem; padding: 20px 0; font-weight: 900; margin-top: 15px; border: 4px solid black;">
            UPDATE_PRODUCT_DATA [SYNC_V2]
        </button>
        
        <a href="/admin/products" style="text-align: center; font-weight: 900; font-size: 0.7rem; color: #555; text-decoration: underline;">CANCEL_AND_RETURN</a>
    </form>
</div>

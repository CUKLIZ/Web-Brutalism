<% layout('admin/layout') %>

<div style="margin-bottom: 40px;">
    <h1 style="font-size: 3.5rem; font-weight: 900; line-height: 0.8; letter-spacing: -2px;">EDIT_PRODUCT_INTEL</h1>
    <p class="brutal-font" style="font-size: 1rem; background: #000; color: var(--neon-green); display: inline-block; padding: 4px 12px; margin-top: 15px; font-weight: 900;">
        [EDIT_MODE_ACTIVE] // ID: #<%= product.id %>
    </p>
</div>

<form action="/admin/products" method="GET" style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px; align-items: start;">
    <div style="display: grid; gap: 30px;">
        <!-- PRODUCT_INFO SECTION -->
        <div class="admin-stat-card">
            <div style="background: black; color: white; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ PRODUCT_INFO ]</div>
            
            <div style="display: grid; gap: 20px;">
                <div>
                    <label style="display: block; font-weight: 900; font-size: 0.8rem; margin-bottom: 8px;">PRODUCT_NAME</label>
                    <input type="text" name="product_name" value="<%= product.name %>" 
                           style="width: 100%; border: 4px solid black; padding: 15px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 1.1rem; box-shadow: 4px 4px 0px black;">
                </div>

                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 8px;">CATEGORY</label>
                        <select name="category" style="width: 100%; border: 4px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 0.9rem; appearance: none; cursor: pointer;">
                            <option <%= product.category === 'T-SHIRT' ? 'selected' : '' %>>T-SHIRT</option>
                            <option <%= product.category === 'OUTERWEAR' ? 'selected' : '' %>>OUTERWEAR</option>
                            <option <%= product.category === 'PANTS' ? 'selected' : '' %>>PANTS</option>
                            <option <%= product.category === 'ACCESSORIES' ? 'selected' : '' %>>ACCESSORIES</option>
                            <option <%= product.category === 'SHOES' ? 'selected' : '' %>>SHOES</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 8px;">COLLECTION</label>
                        <input type="text" name="collection" value="<%= product.collection || 'GENESIS_DROP_01' %>" 
                               style="width: 100%; border: 4px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 0.9rem;">
                    </div>
                </div>

                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 8px;">GENDER</label>
                        <select name="gender" style="width: 100%; border: 4px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 0.9rem; appearance: none; cursor: pointer;">
                            <option <%= product.gender === 'UNISEX' ? 'selected' : '' %>>UNISEX</option>
                            <option <%= product.gender === 'MALE' ? 'selected' : '' %>>MALE</option>
                            <option <%= product.gender === 'FEMALE' ? 'selected' : '' %>>FEMALE</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 8px;">TAGS (COMMA SEPARATED)</label>
                        <input type="text" name="tags" value="<%= product.tags || 'STREETWEAR, BOXFIT' %>" 
                               style="width: 100%; border: 4px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 0.9rem;">
                    </div>
                </div>

                <div>
                    <label style="display: block; font-weight: 900; font-size: 0.8rem; margin-bottom: 8px;">DESCRIPTION</label>
                    <textarea name="description" 
                              style="width: 100%; border: 4px solid black; padding: 15px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 1rem; min-height: 120px; resize: none;"><%= product.description || 'A MASTERPIECE OF RAW AESTHETICS AND VOID COMFORT.' %></textarea>
                </div>
            </div>
        </div>

        <!-- PRODUCT_SPECS SECTION -->
        <div class="admin-stat-card">
            <div style="background: black; color: white; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ PRODUCT_SPECS ]</div>
            
            <div style="display: grid; gap: 20px;">
                <div class="grid" style="grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    <div>
                        <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 8px;">WEIGHT (G)</label>
                        <input type="number" name="weight" value="<%= product.weight || 400 %>" 
                               style="width: 100%; border: 3px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 0.9rem;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 8px;">WIDTH (CM)</label>
                        <input type="number" name="width" value="<%= product.width || 60 %>" 
                               style="width: 100%; border: 3px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 0.9rem;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 8px;">PRIMARY_COLOR</label>
                        <input type="text" name="color" value="<%= product.color %>" 
                               style="width: 100%; border: 4px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 0.9rem;">
                    </div>
                </div>

                <div>
                    <label style="display: block; font-weight: 900; font-size: 0.8rem; margin-bottom: 12px;">CONTENT / MATERIAL</label>
                    <textarea name="material" 
                              style="width: 100%; border: 4px solid black; padding: 15px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 1rem; min-height: 80px; resize: none;"><%= product.material || '100% HEAVY COTTON WITH RAW STITCH FINISH.' %></textarea>
                </div>

                <div>
                    <label style="display: block; font-weight: 900; font-size: 0.8rem; margin-bottom: 12px;">CARE_INSTRUCTIONS</label>
                    <textarea name="care" 
                              style="width: 100%; border: 4px solid black; padding: 15px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 1rem; min-height: 80px; resize: none;"><%= product.care_instructions || 'MACHINE WASH COLD. HANG DRY. DO NOT IRON PRINT.' %></textarea>
                </div>
            </div>
        </div>

        <!-- INVENTORY SECTION -->
        <div class="admin-stat-card">
            <div style="background: black; color: white; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ INVENTORY ]</div>
            
            <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <label style="display: block; font-weight: 900; font-size: 0.8rem; margin-bottom: 12px;">STOCK_BY_SIZE</label>
                    <div class="grid" style="grid-template-columns: repeat(4, 1fr); gap: 10px;">
                        <div>
                            <span style="font-size: 0.6rem; font-weight: 900;">S</span>
                            <input type="number" name="stock_s" value="<%= product.stock.s %>" style="width: 100%; border: 3px solid black; padding: 10px; font-weight: 900; outline: none;">
                        </div>
                        <div>
                            <span style="font-size: 0.6rem; font-weight: 900;">M</span>
                            <input type="number" name="stock_m" value="<%= product.stock.m %>" style="width: 100%; border: 3px solid black; padding: 10px; font-weight: 900; outline: none;">
                        </div>
                        <div>
                            <span style="font-size: 0.6rem; font-weight: 900;">L</span>
                            <input type="number" name="stock_l" value="<%= product.stock.l %>" style="width: 100%; border: 3px solid black; padding: 10px; font-weight: 900; outline: none;">
                        </div>
                        <div>
                            <span style="font-size: 0.6rem; font-weight: 900;">XL</span>
                            <input type="number" name="stock_xl" value="<%= product.stock.xl %>" style="width: 100%; border: 3px solid black; padding: 10px; font-weight: 900; outline: none;">
                        </div>
                    </div>
                </div>
                <div>
                    <label style="display: block; font-weight: 900; font-size: 0.8rem; margin-bottom: 12px;">PRICE_POINT (IDR)</label>
                    <input type="number" name="price" value="<%= product.price %>" 
                           style="width: 100%; border: 4px solid black; padding: 15px; font-family: inherit; font-weight: 900; outline: none; background: var(--neon-green); color: black; font-size: 1.5rem; box-shadow: 4px 4px 0px black;">
                </div>
            </div>
        </div>
    </div>

    <div style="display: grid; gap: 30px; position: sticky; top: 30px;">
        <!-- IMAGE_SOURCE_CONTROL -->
        <div class="admin-stat-card">
            <div style="background: black; color: white; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ ASSET_VAULT ]</div>
            
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
            
            <div style="display: grid; gap: 15px;">
                <!-- Main Image -->
                <div style="border: 4px solid black; padding: 15px; text-align: center; background: #fff; position: relative; aspect-ratio: 1/1; display: flex; align-items: center; justify-content: center;">
                    <div style="position: absolute; top: 0; left: 0; background: #000; color: #fff; padding: 2px 8px; font-size: 0.55rem; font-weight: 900; z-index: 5;">[PRIMARY_ASSET]</div>
                    <div style="border: 2px dashed #999; width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 10px;">
                        <img id="img-preview-1" src="<%= product.image %>" style="max-width: 100%; max-height: 100%; display: block; object-fit: contain; border: 2px solid black;">
                        <p id="label-1" style="font-weight: 900; opacity: 0.5; font-size: 0.7rem; line-height: 1.4; display: none;">DROP_MASTER_FILE</p>
                        <input type="file" onchange="previewImage(event, 1)" style="margin-top: 15px; font-size: 0.7rem; width: 100%;">
                    </div>
                </div>

                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div style="border: 3px solid black; padding: 10px; text-align: center; background: #f0f0f0; position: relative; aspect-ratio: 1/1; display: flex; align-items: center; justify-content: center;">
                        <div style="border: 2px dashed #bbb; width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <img id="img-preview-2" src="" style="max-width: 100%; max-height: 100%; display: none; object-fit: contain; border: 1px solid black;">
                            <p id="label-2" style="font-weight: 900; opacity: 0.5; font-size: 0.55rem;">ALT_V_01</p>
                            <input type="file" onchange="previewImage(event, 2)" style="margin-top: 8px; font-size: 0.5rem; width: 100%;">
                        </div>
                    </div>
                    <div style="border: 3px solid black; padding: 10px; text-align: center; background: #f0f0f0; position: relative; aspect-ratio: 1/1; display: flex; align-items: center; justify-content: center;">
                        <div style="border: 2px dashed #bbb; width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <img id="img-preview-3" src="" style="max-width: 100%; max-height: 100%; display: none; object-fit: contain; border: 1px solid black;">
                            <p id="label-3" style="font-weight: 900; opacity: 0.5; font-size: 0.55rem;">ALT_V_02</p>
                            <input type="file" onchange="previewImage(event, 3)" style="margin-top: 8px; font-size: 0.5rem; width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PRODUCT PREVIEW CARD -->
        <div class="admin-stat-card" style="background: #000; color: #fff;">
            <div style="background: var(--neon-green); color: #000; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ PREVIEW_OUTPUT ]</div>
            
            <div style="border: 3px solid white; padding: 15px; background: #111;">
                <div style="aspect-ratio: 1/1; background: #222; margin-bottom: 15px; border: 2px solid white; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    <img id="preview-card-img" src="<%= product.image %>" style="width: 100%; height: 100%; object-fit: cover; <%= product.image ? 'display: block;' : 'display: none;' %>">
                    <span id="preview-card-placeholder" style="font-size: 0.6rem; color: #444; font-weight: 900; <%= product.image ? 'display: none;' : 'display: block;' %>">[NO_IMAGE_SOURCE]</span>
                </div>
                <h3 id="preview-card-name" style="font-size: 1.2rem; font-weight: 900; margin-bottom: 5px; text-transform: uppercase;"><%= product.name %></h3>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span id="preview-card-price" style="color: var(--neon-green); font-weight: 900; font-size: 1.1rem;">IDR <%= product.price.toLocaleString() %></span>
                    <span style="background: white; color: black; padding: 2px 6px; font-size: 0.6rem; font-weight: 900;">STS: LIVE</span>
                </div>
            </div>
            
            <script>
                // Live preview card logic
                document.addEventListener('DOMContentLoaded', () => {
                    const nameInput = document.querySelector('input[name="product_name"]');
                    const priceInput = document.querySelector('input[name="price"]');
                    
                    const cardName = document.getElementById('preview-card-name');
                    const cardPrice = document.getElementById('preview-card-price');
                    const cardImg = document.getElementById('preview-card-img');
                    const cardPlaceholder = document.getElementById('preview-card-placeholder');

                    nameInput.addEventListener('input', (e) => {
                        cardName.innerText = e.target.value || 'VOID_ITEM';
                    });

                    priceInput.addEventListener('input', (e) => {
                        const val = parseInt(e.target.value) || 0;
                        cardPrice.innerText = 'IDR ' + val.toLocaleString();
                    });

                    const oldPreview = window.previewImage;
                    window.previewImage = function(event, id) {
                        oldPreview(event, id);
                        if (id === 1) {
                            const reader = new FileReader();
                            reader.onload = function() {
                                cardImg.src = reader.result;
                                cardImg.style.display = 'block';
                                cardPlaceholder.style.display = 'none';
                            }
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    };
                });
            </script>
        </div>

        <div style="display: grid; gap: 10px;">
            <button type="submit" class="brutal-button" 
                    style="width: 100%; background: var(--neon-green); color: black; font-size: 1.5rem; padding: 25px 0; font-weight: 900; border-color: black; box-shadow: 6px 6px 0px black;">
                SYNC_UPDATE_TO_VAULT
            </button>
            <a href="/admin/products" class="brutal-button" style="text-align: center; background: white; color: black; text-decoration: none; padding: 15px 0; font-weight: 900; font-size: 0.9rem; border-color: black;">
                ABORT_MISSION_(CANCEL)
            </a>
        </div>
    </div>
</form>


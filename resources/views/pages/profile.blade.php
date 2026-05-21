<% layout('layout') %>

<style>
    .loot-table tbody tr {
        transition: background-color 0.1s ease;
        cursor: default;
    }
    .loot-table tbody tr:hover {
        background-color: var(--accent-yellow) !important;
    }
    .address-card-header {
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .address-card-header:hover {
        background: rgba(0,0,0,0.05);
    }
    .address-details {
        max-height: 1000px;
        overflow: hidden;
        transition: max-height 0.3s ease, margin-top 0.3s ease, opacity 0.3s ease;
    }
    .address-details.collapsed {
        max-height: 0;
        margin-top: 0 !important;
        opacity: 0;
        pointer-events: none;
    }
    .profile-split-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 40px;
    }
    @media (min-width: 992px) {
        .profile-split-row {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>

<div class="container" style="padding-top: 60px; padding-bottom: 100px;">
    <div style="margin-bottom: 60px;">
        <h1 style="font-size: 5rem; line-height: 0.9; margin-bottom: 20px; text-shadow: 6px 6px 0px var(--brutal-black);">USER_PROFILE</h1>
        <div style="background: var(--accent-pink); border: 4px solid black; padding: 10px 20px; display: inline-block; font-weight: 900; box-shadow: 6px 6px 0px black;">
            [STATUS: AUTHENTICATED]
        </div>
    </div>

    <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 40px; align-items: start;">
        <!-- Left Side: User Info -->
        <div class="grid" style="gap: 40px;">
            <!-- Section 00: AVATAR UPLOAD -->
            <section class="brutal-card" style="background: var(--neon-green); display: flex; align-items: center; gap: 30px;">
                <div style="width: 120px; height: 120px; border: 4px solid black; background: white; flex-shrink: 0; display: flex; justify-content: center; align-items: center; box-shadow: 4px 4px 0px black;">
                    <span style="font-weight: 900; font-size: 0.7rem; text-align: center;">[NO_IMAGE_DATA]</span>
                </div>
                <div style="flex-grow: 1;">
                    <h2 style="font-size: 1.5rem; border-bottom: 4px solid black; padding-bottom: 5px; margin-bottom: 15px;">00_IDENTITY_VISUAL</h2>
                    <div style="display: grid; gap: 10px;">
                        <input type="file" id="avatar-input" style="display: none;">
                        <label for="avatar-input" class="brutal-button" style="display: block; width: 100%; text-align: center; font-size: 0.8rem; cursor: pointer; padding: 10px;">SELECT_LOCAL_FILE</label>
                        <button class="brutal-button" style="background: black; color: white; width: 100%; font-size: 0.8rem; padding: 10px;">TRIGGER_UPLOAD</button>
                    </div>
                </div>
            </section>

            <!-- Section A: USER INFO -->
            <section class="brutal-card" style="background: var(--accent-yellow);">
                <h2 style="font-size: 2rem; border-bottom: 4px solid black; padding-bottom: 10px; margin-bottom: 20px;">01_PERSONAL_DATA</h2>
                <div style="display: grid; gap: 15px;">
                    <div>
                        <span style="display: block; font-weight: 900; font-size: 0.8rem; color: rgba(0,0,0,0.6);">ID_TAG</span>
                        <span class="brutal-font" id="profile-username" style="font-size: 1.5rem;">USERNAME_EXAMPLE</span>
                    </div>
                    <div>
                        <span style="display: block; font-weight: 900; font-size: 0.8rem; color: rgba(0,0,0,0.6);">COMM_CHANNEL</span>
                        <span class="brutal-font" id="profile-email" style="font-size: 1.5rem;">EMAIL_EXAMPLE</span>
                    </div>
                    <div>
                        <span style="display: block; font-weight: 900; font-size: 0.8rem; color: rgba(0,0,0,0.6);">CLEARANCE_LEVEL</span>
                        <span id="profile-clearance" style="background: black; color: var(--neon-green); padding: 4px 12px; font-weight: 900; font-size: 1rem; border: 2px solid black; display: inline-block; margin-top: 5px;">CUSTOMER</span>
                    </div>
                </div>
            </section>
        </div>

        <!-- Right Side: Transaction History -->
        <div class="grid">
            <!-- Section C: TRANSACTION HISTORY -->
            <section class="brutal-card" style="padding: 0; overflow: hidden;">
                <div style="background: var(--brutal-black); color: white; padding: 20px;">
                    <h2 style="font-size: 2rem;">03_TRANSACTION_LOG</h2>
                    <p style="font-size: 0.8rem; font-weight: 900; margin-top: 5px; opacity: 0.7;">RECENT DATA ENTRIES IN VAULT HISTORY</p>
                </div>
                <div style="padding: 20px; overflow-x: auto;">
                    <table class="loot-table" style="margin: 0; border: none; width: 100%;">
                        <thead>
                            <tr>
                                <th style="border-left: none; border-top: none; font-size: 0.7rem; padding: 10px;">ORDER_ID</th>
                                <th style="font-size: 0.7rem; padding: 10px;">TOTAL</th>
                                <th style="font-size: 0.7rem; padding: 10px;">STATUS</th>
                                <th style="border-right: none; border-top: none; font-size: 0.7rem; padding: 10px;">DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border-left: none; font-family: monospace; font-weight: 900;">#VX-2091</td>
                                <td class="brutal-font"><%= formatPrice(1800000) %></td>
                                <td><span class="badge" style="background: var(--neon-green);">COMPLETED</span></td>
                                <td style="border-right: none; font-size: 0.8rem; font-weight: 700;">2024-03-12</td>
                            </tr>
                            <tr>
                                <td style="border-left: none; font-family: monospace; font-weight: 900;">#VX-3042</td>
                                <td class="brutal-font"><%= formatPrice(675000) %></td>
                                <td><span class="badge" style="background: var(--accent-yellow);">PAID</span></td>
                                <td style="border-right: none; font-size: 0.8rem; font-weight: 700;">2024-03-15</td>
                            </tr>
                            <tr>
                                <td style="border-left: none; font-family: monospace; font-weight: 900;">#VX-1182</td>
                                <td class="brutal-font"><%= formatPrice(1425000) %></td>
                                <td><span class="badge" style="background: var(--accent-pink); color: white;">PENDING</span></td>
                                <td style="border-right: none; font-size: 0.8rem; font-weight: 700;">2024-03-20</td>
                            </tr>
                            <tr>
                                <td style="border-left: none; font-family: monospace; font-weight: 900;">#VX-9904</td>
                                <td class="brutal-font"><%= formatPrice(3150000) %></td>
                                <td><span class="badge" style="background: var(--neon-green);">COMPLETED</span></td>
                                <td style="border-right: none; font-size: 0.8rem; font-weight: 700;">2024-03-22</td>
                            </tr>
                            <tr>
                                <td style="border-left: none; border-bottom: none; font-family: monospace; font-weight: 900;">#VX-5521</td>
                                <td class="brutal-font" style="border-bottom: none;"><%= formatPrice(1275000) %></td>
                                <td style="border-bottom: none;"><span class="badge" style="background: var(--neon-green);">COMPLETED</span></td>
                                <td style="border-right: none; border-bottom: none; font-size: 0.8rem; font-weight: 700;">2024-03-25</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <!-- SIDE-BY-SIDE SECTION WRAPPERS (FULL WIDTH ROW ON DESKTOP) -->
    <div class="profile-split-row" style="align-items: start; margin-top: 40px;">
        <!-- Section B: EDIT PROFILE FORM -->
        <section class="brutal-card">
            <h2 style="font-size: 2rem; border-bottom: 4px solid black; padding-bottom: 10px; margin-bottom: 20px;">02_UPDATE_PROFILE</h2>
            <div style="display: grid; gap: 20px;">
                <div style="display: grid; gap: 8px;">
                    <label class="brutal-font" style="font-size: 1rem;">USERNAME</label>
                    <input type="text" id="edit-username" value="USERNAME_EXAMPLE" style="width: 100%; border: 4px solid black; padding: 15px; font-family: inherit; font-weight: 900; outline: none;">
                </div>
                <div style="display: grid; gap: 8px;">
                    <label class="brutal-font" style="font-size: 1rem;">EMAIL_ADDRESS</label>
                    <input type="email" id="edit-email" value="EMAIL_EXAMPLE" style="width: 100%; border: 4px solid black; padding: 15px; font-family: inherit; font-weight: 900; outline: none;">
                </div>
                <div style="display: grid; gap: 8px;">
                    <label class="brutal-font" style="font-size: 1rem;">PASSWORD (SECURE_ENCRYPTION)</label>
                    <input type="password" placeholder="********" style="width: 100%; border: 4px solid black; padding: 15px; font-family: inherit; font-weight: 900; outline: none;">
                </div>
                <button onclick="saveProfile()" class="brutal-button" style="width: 100%; margin-top: 10px;">SAVE_CHANGES</button>
            </div>
        </section>

        <!-- Section 04: ADDRESS_BOOK -->
        <section class="brutal-card" style="background: var(--gallery-white);">
            <h2 style="font-size: 2rem; border-bottom: 4px solid black; padding-bottom: 10px; margin-bottom: 20px;">04_ADDRESS_BOOK</h2>
            
            <!-- Address List -->
            <div style="display: grid; gap: 20px; margin-bottom: 40px;">
                <div class="address-card" style="border: 4px solid var(--neon-green); padding: 20px; background: white; position: relative;">
                    <div style="position: absolute; top: -15px; right: 10px; background: var(--neon-green); border: 2px solid black; padding: 2px 10px; font-weight: 900; font-size: 0.6rem; box-shadow: 2px 2px 0px black;">DEFAULT_LOCATION</div>
                    <div class="address-card-header" onclick="toggleAddress(this)">
                        <div style="font-weight: 900; font-size: 1.2rem;">JOHN_DOE_HOME</div>
                        <div style="font-weight: 900; font-size: 1.2rem;">[+/-]</div>
                    </div>
                    <div class="address-details">
                        <div style="font-weight: 700; opacity: 0.7; margin-top: 10px; margin-bottom: 5px;">+62 812-3456-7890</div>
                        <div style="font-weight: 500; line-height: 1.4;">Jl. Gatot Subroto No. 123, Jakarta Selatan, 12710</div>
                        <div style="display: flex; gap: 10px; margin-top: 15px; flex-wrap: wrap;">
                            <button style="border: 2px solid black; background: var(--neon-green); color: black; padding: 5px 12px; font-weight: 900; font-size: 0.7rem; cursor: default;">[IS_DEFAULT]</button>
                            <button style="border: 2px solid black; background: black; color: white; padding: 5px 12px; font-weight: 900; font-size: 0.7rem; cursor: pointer;">EDIT</button>
                            <button onclick="window.BrutalModal.confirm('DELETE_ADDRESS?', 'THIS ACTION CANNOT BE UNDONE.', () => { console.log('Address deleted'); }, 'DELETE', 'CANCEL')" style="border: 2px solid black; background: #FF0000; color: white; padding: 5px 12px; font-weight: 900; font-size: 0.7rem; cursor: pointer;">DELETE</button>
                        </div>
                    </div>
                </div>
                <div class="address-card" style="border: 4px solid black; padding: 20px; background: white; position: relative;">
                    <div class="address-card-header" onclick="toggleAddress(this)">
                        <div style="font-weight: 900; font-size: 1.2rem;">OFFICE_HQ</div>
                        <div style="font-weight: 900; font-size: 1.2rem;">[+/-]</div>
                    </div>
                    <div class="address-details">
                        <div style="font-weight: 700; opacity: 0.7; margin-top: 10px; margin-bottom: 5px;">+62 899-8877-6655</div>
                        <div style="font-weight: 500; line-height: 1.4;">Green Office Park 9, BSD City, Tangerang, 15345</div>
                        <div style="display: flex; gap: 10px; margin-top: 15px; flex-wrap: wrap;">
                            <button style="border: 2px solid black; background: white; color: black; padding: 5px 12px; font-weight: 900; font-size: 0.7rem; cursor: pointer;">SET_AS_DEFAULT</button>
                            <button style="border: 2px solid black; background: black; color: white; padding: 5px 12px; font-weight: 900; font-size: 0.7rem; cursor: pointer;">EDIT</button>
                            <button onclick="window.BrutalModal.confirm('DELETE_ADDRESS?', 'THIS ACTION CANNOT BE UNDONE.', () => { console.log('Address deleted'); }, 'DELETE', 'CANCEL')" style="border: 2px solid black; background: #FF0000; color: white; padding: 5px 12px; font-weight: 900; font-size: 0.7rem; cursor: pointer;">DELETE</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function toggleAddress(header) {
                    const details = header.nextElementSibling;
                    details.classList.toggle('collapsed');
                }
            </script>

            <!-- Add Address Form -->
            <div style="border: 4px solid black; background: var(--accent-pink); padding: 25px;">
                <h3 style="font-size: 1.2rem; font-weight: 900; margin-bottom: 20px;">[+]_NEW_DISPATCH_LOCATION</h3>
                <div style="display: grid; gap: 15px;">
                    <div style="display: grid; gap: 5px;">
                        <label style="font-weight: 900; font-size: 0.8rem;">FULL_NAME</label>
                        <input type="text" placeholder="RECIPIENT_NAME" style="width: 100%; border: 3px solid black; padding: 10px; font-family: inherit; font-weight: 900; outline: none;">
                    </div>
                    <div style="display: grid; gap: 5px;">
                        <label style="font-weight: 900; font-size: 0.8rem;">PHONE_NUMBER</label>
                        <input type="text" placeholder="+62 ..." style="width: 100%; border: 3px solid black; padding: 10px; font-family: inherit; font-weight: 900; outline: none;">
                    </div>
                    <div style="display: grid; gap: 5px;">
                        <label style="font-weight: 900; font-size: 0.8rem;">STREET_ADDRESS</label>
                        <textarea placeholder="FULL_ADDRESS_DETAILS" style="width: 100%; border: 3px solid black; padding: 10px; font-family: inherit; font-weight: 900; outline: none; min-height: 80px; resize: vertical;"></textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div style="display: grid; gap: 5px;">
                            <label style="font-weight: 900; font-size: 0.8rem;">CITY</label>
                            <input type="text" placeholder="METROPOLIS" style="width: 100%; border: 3px solid black; padding: 10px; font-family: inherit; font-weight: 900; outline: none;">
                        </div>
                        <div style="display: grid; gap: 5px;">
                            <label style="font-weight: 900; font-size: 0.8rem;">POSTAL_CODE</label>
                            <input type="text" placeholder="XXXXX" style="width: 100%; border: 3px solid black; padding: 10px; font-family: inherit; font-weight: 900; outline: none;">
                        </div>
                    </div>
                    <button class="brutal-button" style="width: 100%; margin-top: 10px; background: black; color: white;">ADD_ADDRESS</button>
                </div>
            </div>
        </section>
    </div>

    <!-- Section D: ACTION SECTION (BOTTOM) -->
    <div style="margin-top: 40px;">
        <section class="brutal-card" style="background: var(--brutal-black); color: white;">
            <h2 style="font-size: 2rem; border-bottom: 4px solid var(--gallery-white); padding-bottom: 10px; margin-bottom: 20px;">05_DANGER_ZONE</h2>
            <p style="margin-bottom: 20px; font-weight: 700; opacity: 0.8;">DISCONNECT FROM SYSTEM VAULT TEMPORARILY.</p>
            <button onclick="window.BrutalModal.confirm('EXIT_VAULT?', 'YOUR SESSION WILL BE TERMINATED.', () => { localStorage.removeItem('currentUser'); window.location.href='/login'; }, 'ABORT_SESSION', 'STAY_LINKED')" class="brutal-button" style="background: #FF0000; color: white; width: 100%; border-color: white;">ABORT_SESSION_(LOGOUT)</button>
        </section>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        loadProfileData();
    });

    function loadProfileData() {
        const user = JSON.parse(localStorage.getItem('currentUser') || '{"username": "ANON_VOID", "email": "anon@void.st"}');
        
        // Display credentials safely
        const displayUsername = document.getElementById('profile-username');
        const displayEmail = document.getElementById('profile-email');
        const displayClearance = document.getElementById('profile-clearance');
        
        const inputUsername = document.getElementById('edit-username');
        const inputEmail = document.getElementById('edit-email');

        if (displayUsername) displayUsername.innerText = user.username.toUpperCase();
        if (displayEmail) displayEmail.innerText = user.email.toUpperCase();
        if (displayClearance) {
            // If they are logged in, make them a VERIFIED agent!
            displayClearance.innerText = user.username === 'ANON_VOID' ? 'UNASSIGNED_ACCESS' : 'VERIFIED_AGENT';
        }

        if (inputUsername) inputUsername.value = user.username;
        if (inputEmail) inputEmail.value = user.email;
    }

    function saveProfile() {
        const inputUsername = document.getElementById('edit-username').value.trim();
        const inputEmail = document.getElementById('edit-email').value.trim();

        if (!inputUsername || !inputEmail) {
            window.BrutalModal.show({
                title: 'INPUT_ERROR',
                message: 'USERNAME_AND_EMAIL_FIELDS_CANNOT_BE_EMPTY.',
                tag: 'VAL_CHECK_FAILED'
            });
            return;
        }

        const updatedUser = { username: inputUsername, email: inputEmail };
        localStorage.setItem('currentUser', JSON.stringify(updatedUser));
        
        loadProfileData();

        window.BrutalModal.show({
            title: 'DATA_WRITE_CONFIRMED',
            message: 'YOUR CREDENTIAL DATABASE IN COLD STORAGE HAS BEEN OVERWRITTEN.',
            tag: 'SECURE_STORAGE_SYNCED'
        });
    }
</script>

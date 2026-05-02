<% layout('layout') %>

<style>
    .loot-table tbody tr {
        transition: background-color 0.1s ease;
        cursor: default;
    }
    .loot-table tbody tr:hover {
        background-color: var(--accent-yellow) !important;
    }
    /* Ensure the last row doesn't lose its border logic if needed */
</style>

<div class="container" style="padding-top: 60px; padding-bottom: 100px;">
    <div style="margin-bottom: 60px;">
        <h1 style="font-size: 5rem; line-height: 0.9; margin-bottom: 20px; text-shadow: 6px 6px 0px var(--brutal-black);">USER_PROFILE</h1>
        <div style="background: var(--accent-pink); border: 4px solid black; padding: 10px 20px; display: inline-block; font-weight: 900; box-shadow: 6px 6px 0px black;">
            [STATUS: AUTHENTICATED]
        </div>
    </div>

    <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 40px; align-items: start;">
        <!-- Left Side: User Info & Form -->
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
                        <span class="brutal-font" style="font-size: 1.5rem;">USERNAME_EXAMPLE</span>
                    </div>
                    <div>
                        <span style="display: block; font-weight: 900; font-size: 0.8rem; color: rgba(0,0,0,0.6);">COMM_CHANNEL</span>
                        <span class="brutal-font" style="font-size: 1.5rem;">EMAIL_EXAMPLE</span>
                    </div>
                    <div>
                        <span style="display: block; font-weight: 900; font-size: 0.8rem; color: rgba(0,0,0,0.6);">CLEARANCE_LEVEL</span>
                        <span style="background: black; color: var(--neon-green); padding: 4px 12px; font-weight: 900; font-size: 1rem; border: 2px solid black; display: inline-block; margin-top: 5px;">CUSTOMER</span>
                    </div>
                </div>
            </section>

            <!-- Section B: EDIT PROFILE FORM -->
            <section class="brutal-card">
                <h2 style="font-size: 2rem; border-bottom: 4px solid black; padding-bottom: 10px; margin-bottom: 20px;">02_UPDATE_PROFILE</h2>
                <div style="display: grid; gap: 20px;">
                    <div style="display: grid; gap: 8px;">
                        <label class="brutal-font" style="font-size: 1rem;">USERNAME</label>
                        <input type="text" value="USERNAME_EXAMPLE" style="width: 100%; border: 4px solid black; padding: 15px; font-family: inherit; font-weight: 900; outline: none;">
                    </div>
                    <div style="display: grid; gap: 8px;">
                        <label class="brutal-font" style="font-size: 1rem;">EMAIL_ADDRESS</label>
                        <input type="email" value="EMAIL_EXAMPLE" style="width: 100%; border: 4px solid black; padding: 15px; font-family: inherit; font-weight: 900; outline: none;">
                    </div>
                    <div style="display: grid; gap: 8px;">
                        <label class="brutal-font" style="font-size: 1rem;">PASSWORD (SECURE_ENCRYPTION)</label>
                        <input type="password" placeholder="********" style="width: 100%; border: 4px solid black; padding: 15px; font-family: inherit; font-weight: 900; outline: none;">
                    </div>
                    <button class="brutal-button" style="width: 100%; margin-top: 10px;">SAVE_CHANGES</button>
                </div>
            </section>

            <!-- Section D: ACTION SECTION -->
            <section class="brutal-card" style="background: var(--brutal-black); color: white;">
                <h2 style="font-size: 2rem; border-bottom: 4px solid var(--gallery-white); padding-bottom: 10px; margin-bottom: 20px;">04_DANGER_ZONE</h2>
                <p style="margin-bottom: 20px; font-weight: 700; opacity: 0.8;">DISCONNECT FROM SYSTEM VAULT TEMPORARILY.</p>
                <button class="brutal-button" style="background: #FF0000; color: white; width: 100%; border-color: white;">ABORT_SESSION_(LOGOUT)</button>
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
                <div style="padding: 20px;">
                    <table class="loot-table" style="margin: 0; border: none;">
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
</div>

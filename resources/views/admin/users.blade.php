<% layout('admin/layout') %>

<div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <div style="background: black; color: white; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 10px;">[ ACCESS_LEVEL: ROOT ]</div>
        <h1 style="font-size: 3.5rem; font-weight: 900; line-height: 0.8; letter-spacing: -2px; margin: 0;">USER_ARCHIVE</h1>
        <p style="font-weight: 900; opacity: 0.6; margin-top: 10px; font-size: 0.9rem;">MANAGING_VOIDS_AND_NOMADS_IN_THE_SYSTEM.</p>
    </div>
    
    <div style="display: flex; gap: 15px;">
        <div class="admin-stat-card" style="padding: 10px 20px; box-shadow: 4px 4px 0px black;">
            <span style="font-size: 0.55rem; font-weight: 900; color: #666; display: block;">TOTAL_USERS</span>
            <span style="font-size: 1.5rem; font-weight: 900;"><%= users.length %></span>
        </div>
        <div class="admin-stat-card" style="padding: 10px 20px; box-shadow: 4px 4px 0px black; border-color: var(--neon-green);">
            <span style="font-size: 0.55rem; font-weight: 900; color: #666; display: block;">ACTIVE_CYCLES</span>
            <span style="font-size: 1.5rem; font-weight: 900; color: var(--neon-green); text-shadow: 1px 1px 0px black;">4</span>
        </div>
    </div>
</div>

<!-- SEARCH & FILTER BAR -->
<div class="admin-stat-card" style="margin-bottom: 30px; display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; background: #eee;">
    <div>
        <label style="display: block; font-weight: 900; font-size: 0.6rem; margin-bottom: 5px;">SEARCH_BY_IDENTITY</label>
        <input type="text" placeholder="USERNAME_OR_EMAIL..." 
               style="width: 100%; border: 3px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white;">
    </div>
    <div>
        <label style="display: block; font-weight: 900; font-size: 0.6rem; margin-bottom: 5px;">ROLE_PROTOCOL</label>
        <select style="width: 100%; border: 3px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; appearance: none; cursor: pointer;">
            <option>ALL_ROLES</option>
            <option>ADMIN</option>
            <option>VERIFIED</option>
            <option>USER</option>
        </select>
    </div>
    <div>
        <label style="display: block; font-weight: 900; font-size: 0.6rem; margin-bottom: 5px;">STATUS_FILTER</label>
        <select style="width: 100%; border: 3px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; appearance: none; cursor: pointer;">
            <option>ANY_STATUS</option>
            <option>ACTIVE</option>
            <option>BANNED</option>
            <option>PENDING</option>
        </select>
    </div>
</div>

<!-- USER LIST TABLE -->
<div class="admin-stat-card" style="padding: 0; overflow: hidden; border-width: 5px;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: black; color: white;">
                <th style="padding: 20px; font-weight: 900; font-size: 0.7rem; border-right: 2px solid #333;">01_IDENT</th>
                <th style="padding: 20px; font-weight: 900; font-size: 0.7rem; border-right: 2px solid #333;">02_ROLE_STAT</th>
                <th style="padding: 20px; font-weight: 900; font-size: 0.7rem; border-right: 2px solid #333;">03_ACTIVITY</th>
                <th style="padding: 20px; font-weight: 900; font-size: 0.7rem; border-right: 2px solid #333;">04_LOGS</th>
                <th style="padding: 20px; font-weight: 900; font-size: 0.7rem; text-align: right;">05_OPERATE</th>
            </tr>
        </thead>
        <tbody>
            <% if (users.length === 0) { %>
                <tr>
                    <td colspan="5" style="padding: 100px 20px; text-align: center;">
                        <div style="border: 4px dashed #999; padding: 40px; display: inline-block;">
                            <h2 style="font-weight: 900; margin: 0; color: #999;">NO_USERS_INSIDE_THE_VAULT</h2>
                            <p style="font-size: 0.7rem; font-weight: 900; color: #bbb; margin-top: 10px;">RE-INITIALIZE_SCAN_PARAMETER</p>
                        </div>
                    </td>
                </tr>
            <% } else { %>
                <% users.forEach((user, index) => { %>
                    <tr style="border-bottom: 4px solid black; background: <%= index % 2 === 0 ? '#fff' : '#f9f9f9' %>; transition: background 0.1s;"
                        onmouseover="this.style.background='var(--gallery-white)'" 
                        onmouseout="this.style.background='<%= index % 2 === 0 ? '#fff' : '#f9f9f9' %>'">
                        
                        <td style="padding: 20px; border-right: 3px solid black;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 45px; height: 45px; background: <%= user.role === 'ADMIN' ? 'var(--neon-green)' : '#000' %>; border: 3px solid black; display: flex; align-items: center; justify-content: center; color: <%= user.role === 'ADMIN' ? '#000' : '#fff' %>; font-weight: 900; font-size: 1.2rem;">
                                    <%= user.username[0] %>
                                </div>
                                <div>
                                    <div style="font-weight: 900; font-size: 1.1rem; line-height: 1;"><%= user.username %></div>
                                    <div style="font-size: 0.65rem; font-weight: 900; opacity: 0.5; margin-top: 4px;"><%= user.email %></div>
                                </div>
                            </div>
                        </td>
                        
                        <td style="padding: 20px; border-right: 3px solid black;">
                            <div style="margin-bottom: 8px;">
                                <span style="background: <%= user.role === 'ADMIN' ? 'black' : '#ddd' %>; color: <%= user.role === 'ADMIN' ? 'white' : 'black' %>; padding: 3px 8px; font-size: 0.6rem; font-weight: 900;">
                                    <%= user.role %>
                                </span>
                            </div>
                            <div>
                                <span style="font-size: 0.55rem; font-weight: 900; color: <%= user.status === 'ACTIVE' ? 'var(--neon-green)' : '#f00' %>; display: flex; align-items: center; gap: 5px;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></span>
                                    <%= user.status %>
                                </span>
                            </div>
                        </td>
                        
                        <td style="padding: 20px; border-right: 3px solid black;">
                            <div style="font-size: 0.55rem; font-weight: 900; color: #666; margin-bottom: 4px;">JOINED_DATE:</div>
                            <div style="font-weight: 900; font-size: 0.8rem;"><%= user.joined %></div>
                            <div style="font-size: 0.55rem; font-weight: 900; color: #666; margin-top: 8px; margin-bottom: 4px;">LAST_ACTIVE:</div>
                            <div style="font-weight: 900; font-size: 0.8rem; color: <%= user.lastActive === 'NOW' ? 'var(--neon-green)' : 'inherit' %>;"><%= user.lastActive %></div>
                        </td>
                        
                        <td style="padding: 20px; border-right: 3px solid black;">
                            <div style="font-size: 0.55rem; font-weight: 900; color: #666; margin-bottom: 4px;">ORDER_COUNT:</div>
                            <div style="font-size: 1.8rem; font-weight: 900; line-height: 1;"><%= user.orders %></div>
                        </td>
                        
                        <td style="padding: 20px; text-align: right;">
                            <div style="display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                                <button class="brutal-button" style="padding: 8px 12px; font-size: 0.65rem; width: 80px; background: white;">VIEW</button>
                                <div style="display: flex; gap: 8px;">
                                    <button class="brutal-button" style="padding: 8px 12px; font-size: 0.65rem; background: var(--accent-yellow);">BAN</button>
                                    <button class="brutal-button" style="padding: 8px 12px; font-size: 0.65rem; background: #f00; color: white;">PURGE</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                <% }) %>
            <% } %>
        </tbody>
    </table>
</div>

<style>
    .brutal-button {
        border: 3px solid black;
        font-family: inherit;
        font-weight: 900;
        cursor: pointer;
        transition: all 0.1s;
        text-transform: uppercase;
        display: inline-block;
        text-align: center;
    }
    .brutal-button:hover {
        transform: translate(-2px, -2px);
        box-shadow: 3px 3px 0px black;
    }
    .brutal-button:active {
        transform: translate(0, 0);
        box-shadow: 0px 0px 0px black;
    }

    @media (max-width: 992px) {
        table thead { display: none; }
        table tbody tr {
            display: flex;
            flex-direction: column;
            border-bottom: 8px solid black !important;
            padding: 20px;
        }
        table tbody td {
            border: none !important;
            padding: 10px 0 !important;
        }
        table tbody td:last-child {
            padding-top: 20px !important;
            border-top: 3px solid black !important;
        }
    }
</style>

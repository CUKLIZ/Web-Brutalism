<% layout('layout') %>

<style>
    .banned-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        background: #0a0a0a;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .warning-stripe {
        position: absolute;
        width: 200%;
        height: 60px;
        background: repeating-linear-gradient(
            45deg,
            #ff0000,
            #ff0000 20px,
            #000 20px,
            #000 40px
        );
        z-index: 1;
        opacity: 0.8;
    }

    .stripe-top { top: 0; transform: rotate(-2deg); }
    .stripe-bottom { bottom: 0; transform: rotate(2deg); }

    .banned-card {
        background: #000;
        border: 10px solid #ff0000;
        padding: 60px 40px;
        max-width: 800px;
        width: 100%;
        position: relative;
        z-index: 10;
        box-shadow: 20px 20px 0px rgba(255, 0, 0, 0.3);
    }

    .banned-card::before {
        content: "";
        position: absolute;
        top: -20px;
        left: -20px;
        right: -20px;
        bottom: -20px;
        border: 2px solid #ff0000;
        z-index: -1;
        pointer-events: none;
    }

    .access-denied-header {
        font-size: 6rem;
        font-weight: 950;
        line-height: 0.8;
        letter-spacing: -4px;
        color: #ff0000;
        margin-bottom: 20px;
        text-transform: uppercase;
        font-style: italic;
    }

    .account-terminated {
        font-size: 2.5rem;
        font-weight: 900;
        background: #ff0000;
        color: black;
        display: inline-block;
        padding: 5px 20px;
        margin-bottom: 30px;
        transform: skewX(-10deg);
    }

    .banned-label {
        font-family: var(--font-mono);
        font-size: 0.8rem;
        font-weight: 900;
        border: 2px solid white;
        padding: 4px 12px;
        display: inline-block;
        margin-bottom: 40px;
    }

    .banned-description {
        font-size: 1.2rem;
        font-weight: 800;
        line-height: 1.4;
        margin-bottom: 40px;
        max-width: 600px;
        opacity: 0.9;
    }

    .terminal-block {
        background: #111;
        border: 2px solid #555;
        padding: 20px;
        font-family: var(--font-mono);
        font-size: 0.75rem;
        color: #ff0000;
        margin-bottom: 40px;
        position: relative;
    }

    .terminal-block::after {
        content: "";
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06));
        background-size: 100% 2px, 3px 100%;
        pointer-events: none;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 40px;
        border-top: 2px solid #333;
        padding-top: 20px;
    }

    .info-item label {
        display: block;
        font-size: 0.6rem;
        font-weight: 900;
        color: #888;
        margin-bottom: 5px;
    }

    .info-item span {
        font-weight: 900;
        font-size: 0.9rem;
    }

    .banned-actions {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .btn-banned {
        padding: 15px 30px;
        font-weight: 900;
        font-size: 1rem;
        border: 4px solid white;
        background: transparent;
        color: white;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-banned:hover {
        background: white;
        color: black;
        transform: translate(-4px, -4px);
        box-shadow: 8px 8px 0px #ff0000;
    }

    .btn-red {
        border-color: #ff0000;
        color: #ff0000;
    }

    .btn-red:hover {
        background: #ff0000;
        color: white;
        box-shadow: 8px 8px 0px white;
    }

    @media (max-width: 768px) {
        .access-denied-header { font-size: 3.5rem; letter-spacing: -2px; }
        .account-terminated { font-size: 1.5rem; }
        .banned-card { padding: 40px 20px; text-align: center; }
        .info-grid { grid-template-columns: 1fr; text-align: center; }
        .banned-actions { justify-content: center; }
        .banned-description { font-size: 1rem; }
    }
</style>

<div class="banned-container">
    <div class="warning-stripe stripe-top"></div>
    
    <div class="banned-card">
        <div class="banned-label">[ BANNED_BY_SYSTEM ]</div>
        
        <h1 class="access-denied-header">ACCESS_DENIED</h1>
        <div class="account-terminated">ACCOUNT_TERMINATED</div>
        
        <p class="banned-description">
            Your access to VOID_STREET has been restricted by the system.
            <br><br>
            If you believe this was a mistake, contact support to submit an appeal request.
        </p>

        <div class="terminal-block">
            <div>> ACCESS NODE BLOCKED</div>
            <div>> USER PRIVILEGES REMOVED</div>
            <div>> IDENTITY_UUID: DB82-X9-NULL</div>
            <div>> SYSTEM LOCK ACTIVE</div>
            <div>> TRACE_CODE: 403_RESTRICTED</div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <label>STATUS</label>
                <span style="color: #ff0000;">RESTRICTED</span>
            </div>
            <div class="info-item">
                <label>ACCOUNT_FLAG</label>
                <span>ACTIVE</span>
            </div>
            <div class="info-item">
                <label>SECURITY_LEVEL</label>
                <span style="color: #ff0000;">HIGH</span>
            </div>
        </div>

        <div class="banned-actions">
            <a href="mailto:support@void.st" class="btn-banned btn-red">CONTACT_SUPPORT</a>
            <a href="/" class="btn-banned">RETURN_HOME</a>
            <button onclick="localStorage.clear(); window.location.href='/login';" class="btn-banned" style="opacity: 0.6; border-width: 2px; font-size: 0.8rem;">LOGOUT</button>
        </div>
    </div>

    <div class="warning-stripe stripe-bottom"></div>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 // VOID_STREET</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .error-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background: var(--gallery-white);
            position: relative;
            overflow: hidden;
        }

        .error-grid-overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-image: linear-gradient(rgba(0,0,0,0.05) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(0,0,0,0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .error-card {
            background: white;
            border: 8px solid black;
            padding: 60px 40px;
            max-width: 800px;
            width: 100%;
            position: relative;
            z-index: 10;
            box-shadow: 20px 20px 0px rgba(0,0,0,1);
            transform: rotate(-1deg);
        }

        .glitch-text {
            font-size: 12rem;
            font-weight: 950;
            line-height: 0.7;
            letter-spacing: -10px;
            color: black;
            margin-bottom: 20px;
            text-transform: uppercase;
            position: relative;
            display: inline-block;
        }

        .glitch-text::after {
            content: "404";
            position: absolute;
            top: 4px; left: 4px;
            color: var(--neon-green);
            z-index: -1;
        }

        .error-header {
            font-size: 4rem;
            font-weight: 900;
            background: black;
            color: white;
            display: inline-block;
            padding: 5px 20px;
            margin-bottom: 30px;
            letter-spacing: -2px;
        }

        .system-label {
            font-family: var(--font-mono);
            font-size: 0.8rem;
            font-weight: 900;
            background: var(--neon-green);
            color: black;
            padding: 4px 12px;
            display: inline-block;
            margin-bottom: 40px;
            border: 2px solid black;
        }

        .error-description {
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 40px;
            max-width: 500px;
        }

        .terminal-output {
            font-family: var(--font-mono);
            font-size: 0.8rem;
            font-weight: 900;
            color: #666;
            margin-bottom: 40px;
            border-left: 4px solid var(--neon-green);
            padding-left: 15px;
        }

        .error-actions {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn-error {
            padding: 15px 30px;
            font-weight: 900;
            font-size: 1rem;
            border: 4px solid black;
            background: white;
            color: black;
            cursor: pointer;
            transition: all 0.1s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            font-family: inherit;
        }

        .btn-error:hover {
            transform: translate(-4px, -4px);
            box-shadow: 8px 8px 0px black;
        }

        .btn-primary-error {
            background: black;
            color: white;
        }

        .btn-primary-error:hover {
            background: var(--neon-green);
            color: black;
            box-shadow: 8px 8px 0px black;
        }

        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.8; }
            100% { opacity: 1; }
        }

        .flicker {
            animation: blink 0.1s infinite;
            background: #f00;
            width: 10px;
            height: 20px;
            display: inline-block;
            vertical-align: middle;
            margin-left: 5px;
        }

        @media (max-width: 768px) {
            .glitch-text { font-size: 6rem; letter-spacing: -5px; }
            .error-header { font-size: 2rem; }
            .error-card { padding: 40px 20px; transform: rotate(0deg); }
            .error-description { font-size: 1.1rem; }
            .error-actions { flex-direction: column; }
            .btn-error { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-grid-overlay"></div>

        <div class="error-card">
            <div class="system-label">[ SIGNAL_LOST_404 ]</div>

            <div>
                <span class="glitch-text">404</span>
            </div>

            <h1 class="error-header">PAGE_NOT_FOUND</h1>

            <p class="error-description">
                THE PAGE YOU ARE TRYING TO ACCESS DOES NOT EXIST INSIDE THE VAULT.
            </p>

            <div class="terminal-output">
                <div>> ROUTE_DESTROYED</div>
                <div>> SIGNAL_LOST</div>
                <div>> DATA_FRAGMENT_MISSING <span class="flicker"></span></div>
            </div>

            <div class="error-actions">
                <a href="/" class="btn-error btn-primary-error">RETURN_HOME</a>
                <a href="/products" class="btn-error">BACK_TO_VAULT</a>
                <button onclick="window.history.back()" class="btn-error">GO_BACK</button>
                <a href="mailto:admin@voidstreet.com" class="btn-error" style="border-style: dashed; opacity: 0.7;">REPORT_SYSTEM_ERROR</a>
            </div>
        </div>
    </div>
</body>
</html>
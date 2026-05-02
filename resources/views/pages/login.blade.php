<% layout('layout') %>

<section class="container" style="padding: 100px 0; background: #D9D9D9; min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div style="width: 100%; max-width: 500px; background: white; border: 6px solid black; box-shadow: 15px 15px 0px black; padding: 40px;">
        <div style="margin-bottom: 40px; border-bottom: 6px solid black; padding-bottom: 10px;">
            <h1 style="font-size: 3.5rem; line-height: 1; font-weight: 900; letter-spacing: -2px; margin: 0;">LOGIN_PORTAL</h1>
        </div>

        <form action="#" method="POST" style="display: flex; flex-direction: column; gap: 25px;">
            <div>
                <label style="display: block; font-weight: 900; font-size: 0.8rem; margin-bottom: 8px;">[EMAIL_OR_USERNAME]</label>
                <input type="text" placeholder="ENTER_IDENTITY..." 
                       style="width: 100%; border: 4px solid black; padding: 15px; font-family: inherit; font-weight: 900; outline: none; background: #f0f0f0;">
            </div>

            <div>
                <label style="display: block; font-weight: 900; font-size: 0.8rem; margin-bottom: 8px;">[PASSWORD]</label>
                <input type="password" placeholder="••••••••" 
                       style="width: 100%; border: 4px solid black; padding: 15px; font-family: inherit; font-weight: 900; outline: none; background: #f0f0f0;">
            </div>

            <button type="submit" class="brutal-button" 
                    style="width: 100%; background: var(--neon-green); color: black; font-size: 1.5rem; padding: 20px 0; font-weight: 900; margin-top: 10px;">
                LOGIN_NOW
            </button>
        </form>

        <div style="margin-top: 30px; text-align: center;">
            <a href="/register" class="brutal-font" style="text-decoration: none; color: black; font-size: 0.8rem; font-weight: 900; border-bottom: 2px solid black;">
                NO_ACCOUNT? CREATE_ACCOUNT
            </a>
        </div>
    </div>
</section>

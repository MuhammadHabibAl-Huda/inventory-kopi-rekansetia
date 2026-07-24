<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Kedai Kopi Rekan Setia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            margin: 0; padding: 0; box-sizing: border-box;
        }

        :root {
            /* === Shared with dashboard === */
            --accent:          #d97706;
            --accent-dark:     #92400e;
            --accent-glow:     rgba(217, 119, 6, 0.35);
            --sidebar-bg:      #0f172a;

            /* === Glass tokens === */
            --glass-bg:        rgba(15, 23, 42, 0.55);
            --glass-border:    rgba(255, 255, 255, 0.12);
            --input-bg:        rgba(255, 255, 255, 0.07);
            --input-border:    rgba(255, 255, 255, 0.18);
            --input-focus-bg:  rgba(255, 255, 255, 0.12);
            --text-primary:    #f8fafc;
            --text-secondary:  rgba(248, 250, 252, 0.65);
            --text-muted:      rgba(248, 250, 252, 0.38);
            --danger-bg:       rgba(239, 68, 68, 0.10);
            --danger-border:   rgba(239, 68, 68, 0.35);
            --transition:      all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }

        html, body {
            width: 100%; height: 100%;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* ─── Background image ─── */
        .bg-image {
            position: fixed;
            inset: 0;
            background-image: url('{{ asset("images/logo.jpeg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(4px) brightness(0.45) saturate(1.1);
            transform: scale(1.06);
            z-index: 0;
        }

        /* ─── Overlay gradient ─── */
        .bg-overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(
                160deg,
                rgba(15, 23, 42, 0.60) 0%,
                rgba(30, 15, 5, 0.45)  50%,
                rgba(15, 23, 42, 0.65) 100%
            );
            z-index: 1;
        }

        /* ─── Glass card ─── */
        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 412px;
            padding: 44px 40px 36px;
            background: var(--glass-bg);
            backdrop-filter: blur(32px) saturate(160%);
            -webkit-backdrop-filter: blur(32px) saturate(160%);
            border: 1px solid var(--glass-border);
            border-top-color: rgba(255, 255, 255, 0.20);
            border-radius: 20px;
            box-shadow:
                0 24px 64px rgba(0, 0, 0, 0.45),
                0 0 0 1px rgba(255, 255, 255, 0.04) inset;
            animation: cardEntrance 0.65s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes cardEntrance {
            from { opacity: 0; transform: translateY(28px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0)    scale(1);    }
        }

        /* ─── Header ─── */
        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-logo {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            overflow: hidden;
            margin: 0 auto 16px;
            border: 1.5px solid rgba(255, 255, 255, 0.20);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.30);
            animation: logoIn 0.55s ease-out 0.15s both;
        }

        .login-logo img {
            width: 100%; height: 100%; object-fit: cover; display: block;
        }

        @keyframes logoIn {
            from { opacity: 0; transform: scale(0.78); }
            to   { opacity: 1; transform: scale(1);    }
        }

        .login-header h1 {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.4px;
            line-height: 1.3;
            animation: fadeUp 0.5s ease-out 0.25s both;
        }

        .login-header h1 span {
            background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-header p {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 5px;
            font-weight: 400;
            animation: fadeUp 0.5s ease-out 0.35s both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0);    }
        }

        /* ─── Divider ─── */
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.12), transparent);
            margin-bottom: 28px;
        }

        /* ─── Error alert ─── */
        .alert-error {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 14px;
            background: var(--danger-bg);
            border: 1px solid var(--danger-border);
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 500;
            color: #fca5a5;
            animation: shakeIn 0.45s ease;
        }

        .alert-error svg { flex-shrink: 0; }

        @keyframes shakeIn {
            0%   { transform: translateX(-6px); opacity: 0; }
            40%  { transform: translateX(4px);  }
            70%  { transform: translateX(-2px); }
            100% { transform: translateX(0);    opacity: 1; }
        }

        /* ─── Form ─── */
        .login-form { animation: fadeUp 0.5s ease-out 0.45s both; }

        .form-group { margin-bottom: 16px; }

        .form-label {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--text-secondary);
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: 0.7px;
        }

        .input-wrapper { position: relative; }

        .input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.35);
            pointer-events: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
        }

        .form-input {
            width: 100%;
            padding: 11px 42px;
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            color: var(--text-primary);
            transition: var(--transition);
            outline: none;
        }

        .form-input::placeholder { color: var(--text-muted); font-weight: 400; }

        .form-input:focus {
            background: var(--input-focus-bg);
            border-color: rgba(217, 119, 6, 0.65);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .form-input:focus ~ .input-icon { color: rgba(217, 119, 6, 0.8); }

        /* Password right icon */
        .input-icon-right {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 4px;
            cursor: pointer;
            color: rgba(255,255,255,0.35);
            transition: var(--transition);
            display: flex;
            align-items: center;
        }

        .input-icon-right:hover { color: rgba(255,255,255,0.75); }

        /* ─── Remember me ─── */
        .form-options { display: flex; align-items: center; margin-bottom: 22px; }

        .checkbox-wrap { display: flex; align-items: center; gap: 8px; cursor: pointer; }

        .checkbox-wrap input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: var(--accent); cursor: pointer;
        }

        .checkbox-wrap span { font-size: 13px; color: var(--text-secondary); font-weight: 500; }

        /* ─── Submit button ─── */
        .btn-login {
            width: 100%;
            padding: 12px 20px;
            background: linear-gradient(135deg, var(--accent-dark) 0%, var(--accent) 100%);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            letter-spacing: 0.3px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 18px rgba(146, 64, 14, 0.40),
                        0 1px 0 rgba(255,255,255,0.12) inset;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #78350f 0%, #b45309 100%);
            transform: translateY(-1.5px);
            box-shadow: 0 8px 26px rgba(146, 64, 14, 0.50),
                        0 1px 0 rgba(255,255,255,0.12) inset;
        }

        .btn-login:active { transform: translateY(0); }

        /* ─── Footer ─── */
        .login-footer {
            margin-top: 26px;
            text-align: center;
            animation: fadeUp 0.5s ease-out 0.55s both;
        }

        .login-footer p { font-size: 11px; color: var(--text-muted); }

        /* ─── Responsive ─── */
        @media (max-width: 480px) {
            .login-card { margin: 16px; padding: 32px 22px 28px; border-radius: 16px; }
        }
    </style>
</head>
<body>

    <div class="bg-image"></div>
    <div class="bg-overlay"></div>

    <div class="login-card">

        <!-- Header -->
        <div class="login-header">
            <div class="login-logo">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Kedai Kopi Rekan Setia">
            </div>
            <h1>Kedai Kopi <span>Rekan Setia</span></h1>
            <p>Masuk untuk mengakses sistem inventory</p>
        </div>

        <div class="divider"></div>

        {{-- Error Alert --}}
        @if ($errors->any())
        <div class="alert-error">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('login.process') }}" class="login-form">
            @csrf

            <div class="form-group">
                <label class="form-label">Alamat Email</label>
                <div class="input-wrapper">
                    <input
                        type="email"
                        name="email"
                        class="form-input"
                        placeholder="nama@rekansetia.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    <span class="input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Kata Sandi</label>
                <div class="input-wrapper">
                    <input
                        type="password"
                        name="password"
                        class="form-input"
                        id="passwordInput"
                        placeholder="Masukkan kata sandi"
                        required
                    >
                    <span class="input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>
                    <button type="button" class="input-icon-right" onclick="togglePassword()" id="toggleBtn" aria-label="Toggle password">
                        <svg id="eyeOpen" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg id="eyeClosed" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-options">
                <label class="checkbox-wrap">
                    <input type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit" class="btn-login">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Masuk ke Dashboard
            </button>
        </form>

        <div class="login-footer">
            <p>© {{ date('Y') }} Kedai Kopi Rekan Setia &nbsp;&middot;&nbsp; Inventory Management System</p>
        </div>

    </div>

    <script>
        function togglePassword() {
            const input  = document.getElementById('passwordInput');
            const eyeOn  = document.getElementById('eyeOpen');
            const eyeOff = document.getElementById('eyeClosed');
            if (input.type === 'password') {
                input.type = 'text';
                eyeOn.style.display  = 'none';
                eyeOff.style.display = 'block';
            } else {
                input.type = 'password';
                eyeOn.style.display  = 'block';
                eyeOff.style.display = 'none';
            }
        }
    </script>
</body>
</html>

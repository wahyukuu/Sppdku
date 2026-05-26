<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SPPDKU</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lucide Icons -->
    
    <style>
        :root {
            --font-display: 'Outfit', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        body {
            font-family: var(--font-body);
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #311042 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        /* Decorative glowing orbs */
        .orb-1 {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.4) 0%, rgba(0, 0, 0, 0) 70%);
            top: 15%;
            left: 15%;
            z-index: 1;
            animation: float 8s infinite alternate ease-in-out;
        }

        .orb-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(236, 72, 153, 0.3) 0%, rgba(0, 0, 0, 0) 70%);
            bottom: 10%;
            right: 15%;
            z-index: 1;
            animation: float 10s infinite alternate-reverse ease-in-out;
        }

        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            100% { transform: translateY(20px) scale(1.1); }
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            z-index: 10;
        }

        .login-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            color: #ffffff;
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-logo i, .brand-logo svg {
            width: 48px;
            height: 48px;
            color: #a5b4fc;
            margin: 0 auto 10px auto;
        }

        .brand-title {
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 0.5px;
            background: linear-gradient(to right, #ffffff, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-label {
            font-size: 13px;
            font-weight: 500;
            color: #94a3b8;
            margin-bottom: 8px;
        }

        .input-group-custom {
            position: relative;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .input-group-custom:focus-within {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
        }

        .input-group-custom i, .input-group-custom svg {
            margin-left: 16px;
            margin-right: 12px;
            color: #64748b;
            width: 20px;
            height: 20px;
        }

        .input-group-custom .form-control {
            background: transparent;
            border: none;
            color: #ffffff;
            padding: 14px 16px 14px 0;
            font-size: 14px;
        }

        .input-group-custom .form-control:focus {
            box-shadow: none;
            outline: none;
            background: transparent;
            color: #ffffff;
        }

        .btn-login {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border: none;
            color: #ffffff;
            padding: 14px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            font-family: var(--font-display);
            width: 100%;
            transition: all 0.2s ease;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(99, 102, 241, 0.4);
            opacity: 0.95;
        }

        .alert-custom {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border-radius: 12px;
            font-size: 13px;
            padding: 12px 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>

    <div class="orb-1"></div>
    <div class="orb-2"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="brand-logo">
                <i data-lucide="plane-takeoff" class="d-block mx-auto mb-2"></i>
                <span class="brand-title">SPPDKU</span>
                <p class="text-sky-200  mt-2" style="font-size:13px;">Sistem Perjalanan Dinas Premium</p>
            </div>
            
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert-custom">
                    <i data-lucide="circle"></i>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>
            
            <form action="<?=base_url('login/process')?>" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group-custom">
                        <i data-lucide="user"></i>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username admin" required autocomplete="off">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group-custom">
                        <i data-lucide="lock"></i>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                </div>
                
                <button type="submit" class="btn-login">Masuk Aplikasi</button>
            </form>
            
            <div class="text-center mt-4">
                <small style="color: #64748b; font-size:11px;">Gunakan <b>admin</b> / <b>password123</b> untuk demo.</small>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Lucide Icons script -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>

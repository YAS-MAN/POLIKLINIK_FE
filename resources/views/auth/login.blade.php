<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem | Poliklinik Al-Azhar</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            background-color: #383B57;
            background-image: radial-gradient(circle at 10% 20%, rgba(79, 88, 186, 0.4), transparent 60%), radial-gradient(circle at 90% 80%, rgba(99, 102, 241, 0.3), transparent 60%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            width: 440px;
            max-width: 100%;
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #383B57, #4F58BA);
            color: #ffffff;
            padding: 32px 28px;
            text-align: center;
        }

        .login-logo {
            width: 64px;
            height: 64px;
            object-fit: contain;
            margin-bottom: 12px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
        }

        .login-title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .login-subtitle {
            font-size: 13px;
            opacity: 0.85;
            margin-top: 4px;
        }

        .login-body {
            padding: 28px;
        }

        .quick-accounts-box {
            background-color: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .quick-accounts-title {
            font-size: 12px;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .account-btn {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            background: #ffffff;
            color: var(--text-color);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .account-btn:last-child {
            margin-bottom: 0;
        }

        .account-btn:hover {
            border-color: var(--primary-color);
            background-color: var(--primary-light);
            color: var(--primary-color);
        }

        .account-role-badge {
            font-size: 10.5px;
            padding: 2px 8px;
            border-radius: 12px;
            background-color: var(--primary-light);
            color: var(--primary-color);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <img src="https://al-azhar.or.id/wp-content/uploads/2021/04/Logo-Al-Azhar-Official-1024x1024.png" alt="Logo Poliklinik Al-Azhar" class="login-logo">
        <h2 class="login-title">POLIKLINIK AL-AZHAR</h2>
        <p class="login-subtitle">Masuk Ke Portal Manajemen Medis & Logistik Obat</p>
    </div>

    <div class="login-body">
        <!-- QUICK TESTING ACCOUNT SWITCHER -->
        <div class="quick-accounts-box">
            <div class="quick-accounts-title">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                </svg>
                <span>Akun Testing (Pilih Untuk Masuk Langsung):</span>
            </div>
            
            <button type="button" class="account-btn" onclick="fillLogin('admin.pusat@alazhar.ac.id', 'Super Admin (Pusat)')">
                <span>Super Admin (Pusat)</span>
                <span class="account-role-badge">Super Admin</span>
            </button>
            <button type="button" class="account-btn" onclick="fillLogin('admin.kebayoran@alazhar.ac.id', 'Admin Kampus Kebayoran Baru')">
                <span>Admin Kampus Kebayoran Baru</span>
                <span class="account-role-badge">Admin Cabang</span>
            </button>
            <button type="button" class="account-btn" onclick="fillLogin('admin.bintaro@alazhar.ac.id', 'Admin Kampus Bintaro')">
                <span>Admin Kampus Bintaro</span>
                <span class="account-role-badge">Admin Cabang</span>
            </button>
        </div>

        <form action="{{ route('login.perform') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Alamat Email / ID Pengguna</label>
                <input type="email" id="email" name="email" value="admin.pusat@alazhar.ac.id" placeholder="Masukkan email anda..." required>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" value="password123" placeholder="Masukkan kata sandi..." required>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; font-size: 13px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 500;">
                    <input type="checkbox" name="remember" checked style="width: 16px; height: 16px; accent-color: var(--primary-color);">
                    <span>Ingat Saya</span>
                </label>
                <a href="#" style="color: var(--primary-color); font-weight: 600;">Lupa Sandi?</a>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 13px; font-size: 15px;">
                <span>Masuk Ke Sistem &rsaquo;</span>
            </button>
        </form>
    </div>
</div>

<script>
    function fillLogin(email, role) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = 'password123';
        alert('Akun pengujian dipilih: ' + role + '\nEmail: ' + email);
    }
</script>

</body>
</html>

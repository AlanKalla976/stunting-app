<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Petugas - SPK Stunting</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --deep-teal: #0B2545;
            --teal: #14487F;
            --teal-light: #4C7EB5;
            --sage: #E9EFF7;
            --sand: #F6F8FB;
            --gold: #7AA9D6;
            --gold-soft: #EAF3FC;
            --ink: #1F2937;
            --ink-soft: #6B7280;
            --line: #E4E9F0;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--sand);
            color: var(--ink);
            min-height: 100vh;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
        }

        .auth-brand {
            flex: 1;
            background: linear-gradient(165deg, var(--deep-teal) 0%, var(--teal) 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        .auth-brand::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 600 900' fill='none'%3E%3Cpath d='M-40 760 C 100 720, 160 560, 240 460 C 330 350, 320 220, 440 120 C 500 70, 540 40, 620 -20' stroke='%23FFFFFF' stroke-opacity='0.06' stroke-width='4'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: bottom left;
            background-size: cover;
            pointer-events: none;
        }

        .auth-brand-top {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 1.15rem;
        }

        .auth-brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(122, 169, 214, 0.18);
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .auth-brand-body {
            position: relative;
            max-width: 380px;
            margin: 0 auto;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .auth-logo-badge {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            background: rgba(122, 169, 214, 0.16);
            border: 1px solid rgba(122, 169, 214, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .auth-brand-body h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1.9rem;
            line-height: 1.25;
            margin-bottom: 14px;
        }

        .auth-brand-body p {
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .auth-brand-steps {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .auth-brand-steps .step {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .auth-brand-steps .step-num {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: rgba(122, 169, 214, 0.22);
            color: var(--gold);
            font-size: 0.72rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .auth-form-panel {
            width: 460px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
            background-color: white;
            overflow-y: auto;
        }

        .auth-form-inner {
            width: 100%;
            max-width: 340px;
            padding: 24px 0;
        }

        .auth-form-inner .eyebrow {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: var(--teal-light);
            margin-bottom: 6px;
            display: block;
        }

        .auth-form-inner h4 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: var(--deep-teal);
            margin-bottom: 6px;
        }

        .auth-form-inner .subtitle {
            color: var(--ink-soft);
            font-size: 0.88rem;
            margin-bottom: 26px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--ink);
        }

        .form-hint {
            font-size: 0.76rem;
            color: var(--ink-soft);
            margin-top: 4px;
        }

        .input-icon-group {
            position: relative;
        }

        .input-icon-group i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--ink-soft);
            font-size: 0.95rem;
        }

        .input-icon-group .form-control {
            padding-left: 40px;
        }

        .input-icon-group .toggle-password {
            position: absolute;
            right: 12px;
            left: auto;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            background: none;
            border: none;
            color: var(--ink-soft);
            padding: 0;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid var(--line);
            padding: 10px 14px;
            font-size: 0.92rem;
        }

        .form-control:focus {
            border-color: var(--teal-light);
            box-shadow: 0 0 0 3px rgba(76, 154, 121, 0.15);
        }

        .btn-auth {
            background-color: var(--teal);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            padding: 11px;
            transition: background-color 0.2s ease;
        }

        .btn-auth:hover {
            background-color: var(--deep-teal);
            color: white;
        }

        .alert-danger {
            border-radius: 10px;
            border: none;
            background-color: #FBEAEA;
            color: #A32C2C;
            font-size: 0.85rem;
        }

        .switch-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.88rem;
            color: var(--ink-soft);
        }

        .switch-link a {
            color: var(--teal);
            font-weight: 600;
            text-decoration: none;
        }

        .switch-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 900px) {
            .auth-brand { display: none; }
            .auth-form-panel { width: 100%; }
        }
    </style>
</head>
<body>

    <div class="auth-wrapper">

        <!-- Panel kiri: identitas & keterangan langkah -->
        <div class="auth-brand">
            <div class="auth-brand-top">
                <span class="auth-brand-icon"><i class="bi bi-activity"></i></span>
                SPK Stunting
            </div>

            <div class="auth-brand-body">
                <div class="auth-logo-badge">
                    <!-- Lambang gizi: daun + hati, melambangkan nutrisi & kesehatan anak -->
                    <svg width="38" height="38" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24 40C24 40 8 30.5 8 18.5C8 12.7 12.7 8 18.5 8C21.1 8 23.5 9 24 11C24.5 9 26.9 8 29.5 8C35.3 8 40 12.7 40 18.5C40 30.5 24 40 24 40Z" stroke="#7AA9D6" stroke-width="2.4" stroke-linejoin="round"/>
                        <path d="M17 20C19 15 24 13 28 15" stroke="#7AA9D6" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h2>Bergabung sebagai petugas Puskesmas Losari.</h2>
                <p>Akun petugas memberi akses untuk mendata balita dan memantau hasil penilaian gizi di wilayah kerja Anda.</p>
            </div>

            <div class="auth-brand-steps">
                <div class="step">
                    <span class="step-num">1</span> Isi data diri dan email aktif Anda
                </div>
                <div class="step">
                    <span class="step-num">2</span> Buat password yang aman
                </div>
                <div class="step">
                    <span class="step-num">3</span> Login dan mulai input data balita
                </div>
            </div>
        </div>

        <!-- Panel kanan: form registrasi -->
        <div class="auth-form-panel">
            <div class="auth-form-inner">
                <span class="eyebrow">Area Petugas</span>
                <h4>Buat akun baru</h4>
                <p class="subtitle">Lengkapi data di bawah untuk mendaftar sebagai petugas.</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('petugas.register.post') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <div class="input-icon-group">
                            <i class="bi bi-person"></i>
                            <input type="text" name="name" id="name" class="form-control"
                                   placeholder="Nama sesuai identitas"
                                   value="{{ old('name') }}" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-icon-group">
                            <i class="bi bi-envelope"></i>
                            <input type="email" name="email" id="email" class="form-control"
                                   placeholder="nama@puskesmaslosari.go.id"
                                   value="{{ old('email') }}" required>
                        </div>
                        <div class="form-hint">Gunakan email aktif, akan dipakai untuk login.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-icon-group">
                            <i class="bi bi-lock"></i>
                            <input type="password" name="password" id="password" class="form-control"
                                   placeholder="Minimal 8 karakter" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <div class="input-icon-group">
                            <i class="bi bi-lock-fill"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control" placeholder="Ulangi password" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-auth w-100">Daftar</button>

                    <p class="switch-link">
                        Sudah punya akun? <a href="{{ route('petugas.login') }}">Login di sini</a>
                    </p>
                </form>
            </div>
        </div>

    </div>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        }
    </script>
</body>
</html>
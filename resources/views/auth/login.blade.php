<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ចូលប្រព័ន្ធ | វិទ្យាស្ថាន សន្តប៉ូល</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
    <!-- Custom Font for Khmer -->
    <link href="https://fonts.googleapis.com/css2?family=Battambang:wght@400;700&family=Moul&display=swap" rel="stylesheet">

    <style>
        /* =====================================================
           1. VARIABLES (Light Green palette)
        ===================================================== */
        :root {
            --green-50:  #F0FDF4;
            --green-100: #DCFCE7;
            --green-200: #BBF7D0;
            --green-300: #86EFAC;
            --green-400: #4ADE80;
            --green-500: #22C55E;
            --green-600: #16A34A;
            --green-700: #15803D;
            --green-800: #166534;
            --green-900: #14532D;
            --danger:    #EF4444;

            /* Replace this image to change the background (1920x1080 .webp) */
            --login-bg-image: url('{{ asset('backend/dist/img/Saint.jpg') }}');
        }


        /* =====================================================
           2. PAGE + BACKGROUND IMAGE + OVERLAY
        ===================================================== */
        body.login-page-modern {
            position: relative;
            min-height: 100vh;
            margin: 0;
            padding: 24px 16px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-family: 'Battambang', sans-serif;
            color: var(--green-900);

            background-color: var(--green-50);            /* fallback */
            background-image: var(--login-bg-image);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;                 /* light parallax */
        }

      body.login-page-modern::before {
    content: "";
    position: fixed;
    inset: 0;
    z-index: 0;
    pointer-events: none;

    background:
        radial-gradient(ellipse at center, rgba(255, 255, 255, 0) 30%, rgba(20, 83, 45, 0.25) 100%),
        linear-gradient(
            135deg,
            rgba(240, 253, 244, 0.45) 0%,
            rgba(134, 239, 172, 0.30) 55%,
            rgba(34, 197, 94, 0.35) 100%
        );
}


        /* =====================================================
           3. LOGIN CARD (glassmorphism, high-opacity white)
        ===================================================== */
.login-box {
    position: relative;
    z-index: 1;

    width: 100%;
    max-width: 440px;
    padding: 32px;

    background: linear-gradient(
        145deg,
        rgba(255, 255, 255, 0.78) 0%,
        rgba(255, 255, 255, 0.62) 100%
    );
    backdrop-filter: blur(16px) saturate(170%);
    -webkit-backdrop-filter: blur(16px) saturate(170%);

    border: 1px solid rgba(255, 255, 255, 0.7);
    border-radius: 8px;
    box-shadow:
        0 20px 50px rgba(20, 83, 45, 0.28),
        inset 0 1px 0 rgba(255, 255, 255, 0.8);
}

        .login-logo {
            margin-bottom: 12px;
            text-align: center;
        }

        .login-logo img {
            max-width: 108px;
            height: auto;
        }

        .login-title {
            margin: 0 0 6px;
            text-align: center;
            color: var(--green-900);
            font-family: 'Khmer OS Muol', 'Moul', 'Battambang', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.6;
        }

        .login-subtitle {
            margin-bottom: 24px;
            text-align: center;
            color: var(--green-800);
            font-size: 0.95rem;
            font-weight: 400;
        }


        /* =====================================================
           4. FORM FIELDS
        ===================================================== */
        .form-group label {
            margin-bottom: 6px;
            color: var(--green-900);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .text-danger {
            color: var(--danger);
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .input-icon {
            position: absolute;
            top: 50%;
            left: 14px;
            width: 18px;
            height: 18px;
            transform: translateY(-50%);
            color: var(--green-700);
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .input-wrap .form-control {
            height: auto;
            padding: 12px 14px 12px 42px;

            background-color: rgba(240, 253, 244, 0.8);
            border: 1px solid var(--green-200);
            border-radius: 8px;
            color: var(--green-900);

            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }

        .input-wrap .form-control:focus {
            background-color: var(--green-50);
            border-color: var(--green-400);
            box-shadow: 0 0 0 3px rgba(74, 222, 128, 0.3);
            outline: none;
        }

        .input-wrap:focus-within .input-icon {
            color: var(--green-600);
        }

        /* Error state */
        .input-wrap .form-control.is-invalid {
            border-color: var(--danger);
            background-image: none;
        }

        .input-wrap .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.25);
        }

        .error-text {
            display: block;
            margin-top: 6px;
            color: var(--danger);
            font-size: 0.8rem;
        }


        /* =====================================================
           5. BUTTON
        ===================================================== */
        .btn-login {
            margin-top: 12px;
            min-height: 46px;
            padding: 11px 12px;

            background: linear-gradient(135deg, var(--green-400), var(--green-600));
            border: none;
            border-radius: 8px;
            color: #fff;

            font-size: 1rem;
            font-weight: 600;

            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .btn-login:hover {
            background: var(--green-600);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(22, 163, 74, 0.35);
        }

        .btn-login:active {
            background: var(--green-700);
            transform: scale(0.98);
            box-shadow: none;
        }

        .btn-login:focus-visible,
        .input-wrap .form-control:focus-visible {
            outline: 3px solid var(--green-700);
            outline-offset: 2px;
        }


        /* =====================================================
           6. RESPONSIVE
        ===================================================== */
        @media (max-width: 575px) {
            .login-box {
                padding: 24px 20px;
                border-radius: 8px;
            }

            .login-title {
                font-size: 1.3rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .btn-login,
            .input-wrap .form-control,
            .input-wrap .input-icon {
                transition: none;
            }
        }
    </style>
</head>
<body class="login-page-modern">

<div class="login-box">
    <div class="login-logo">
        <img src="{{ asset('backend/dist/img/spilogo.png') }}" alt="SPI Logo">
    </div>

    <h1 class="login-title">ចូលប្រព័ន្ធ</h1>

    <div class="login-subtitle">
        សូមបញ្ចូលព័ត៌មានអ្នកប្រើប្រាស់របស់អ្នក!!!
    </div>

    <form action="{{ route('login.post') }}" method="post">
        @csrf
        <div class="form-group mb-3">
            <label for="email">ឈ្មោះគណនី (អ៊ីមែល) <span class="text-danger">*</span></label>
            <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                    <path d="m3 7 9 6 9-6"></path>
                </svg>
                <input type="email" id="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       autocomplete="email"
                       @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                       required autofocus>
            </div>
            @error('email')
                <span class="error-text" id="email-error" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password">លេខសម្ងាត់ <span class="text-danger">*</span></label>
            <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="4" y="11" width="16" height="10" rx="2"></rect>
                    <path d="M8 11V7a4 4 0 0 1 8 0v4"></path>
                </svg>
                <input type="password" id="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       autocomplete="current-password"
                       @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                       required>
            </div>
            @error('password')
                <span class="error-text" id="password-error" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-login btn-block">ចូល</button>
    </form>
</div>

</body>
</html>
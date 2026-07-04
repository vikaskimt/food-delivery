<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tadka — small kitchens, straight to your door</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#221C15">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@500;600;700&family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        :root {
            --ink: #221C15;
            --ink-soft: #3A2E22;
            --paper: #FBF3E7;
            --card: #FFFDF9;
            --chili: #E1502E;
            --chili-deep: #B93E22;
            --turmeric: #F2A93B;
            --gold-text: #F3C877;
            --curry: #3F7451;
            --text: #2A2118;
            --text-muted: #8B7A64;
            --line: #ECDFC9;
            --danger: #C1402A;
            --sizzle: linear-gradient(135deg, var(--turmeric), var(--chili));
        }
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        html, body { margin: 0; }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background: #E8DCC5;
            color: var(--text);
        }
        .app {
            max-width: 480px; margin: 0 auto; min-height: 100vh; background: var(--paper);
            display: flex; flex-direction: column; position: relative;
        }
        .screen { padding: 18px 18px 28px; flex: 1; animation: fadeSlideUp .28s ease both; }
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (prefers-reduced-motion: reduce) {
            .screen, .pop path, .pop circle { animation: none !important; }
        }

        /* ---------- Topbar ---------- */
        .topbar {
            display: flex; align-items: center; justify-content: space-between; gap: 10px;
            padding: 15px 18px; border-bottom: 1px solid var(--line); position: sticky; top: 0;
            background: rgba(251,243,231,0.94); backdrop-filter: blur(6px); z-index: 5;
        }
        .topbar h1 {
            font-family: 'Instrument Serif', Georgia, serif; font-style: italic; font-weight: 400;
            font-size: 22px; margin: 0; color: var(--ink); display: flex; align-items: center; gap: 8px;
        }
        .topbar h1 svg { width: 22px; height: 22px; flex-shrink: 0; }
        .icon-btn {
            width: 36px; height: 36px; border-radius: 50%; border: 1px solid var(--line); background: var(--card);
            display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--ink);
            flex-shrink: 0; transition: border-color .15s ease, background .15s ease;
        }
        .icon-btn:hover { border-color: var(--turmeric); background: #FBF0DB; }
        .icon-btn svg { width: 18px; height: 18px; }
        .cart-chip {
            display: flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 700; color: var(--ink);
            background: #F6E4C4; border: 1px solid #E9CE95; padding: 6px 11px; border-radius: 20px; white-space: nowrap;
        }
        .cart-chip svg { width: 14px; height: 14px; }
        .spacer-36 { width: 36px; flex-shrink: 0; }

        /* ---------- Inputs (post-auth, light theme) ---------- */
        .field-label {
            display: block; font-size: 11.5px; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase;
            color: var(--text-muted); margin: 0 0 6px 2px;
        }
        input[type=text], input[type=tel], input[type=email] {
            width: 100%; padding: 13px 14px; border: 1.5px solid var(--line); border-radius: 12px;
            font-size: 15px; margin-bottom: 12px; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text);
            background: var(--card); outline: none; transition: border-color .15s ease, box-shadow .15s ease;
        }
        input[type=text]:focus, input[type=tel]:focus, input[type=email]:focus {
            border-color: var(--turmeric); box-shadow: 0 0 0 4px rgba(242,169,59,0.16);
        }
        input::placeholder { color: #BBA98D; }

        /* ---------- Buttons (shared across app) ---------- */
        button { font-family: 'Plus Jakarta Sans', sans-serif; }
        button.primary {
            width: 100%; padding: 15px; border: none; border-radius: 14px; cursor: pointer;
            background: var(--sizzle); color: var(--ink);
            font-size: 15.5px; font-weight: 800; letter-spacing: 0.2px;
            box-shadow: 0 10px 22px -10px rgba(225,80,46,0.5);
            transition: transform .15s ease, box-shadow .15s ease, opacity .15s ease;
        }
        button.primary:active { transform: scale(0.98); }
        button.primary:disabled { opacity: 0.45; box-shadow: none; cursor: default; }
        button.primary.danger {
            background: none; border: 1.5px solid #E8C1B3; color: var(--danger); box-shadow: none; font-weight: 700;
        }
        button.secondary {
            background: var(--card); border: 1.5px solid var(--line); padding: 11px 14px; border-radius: 12px;
            cursor: pointer; font-weight: 700; font-size: 14px; color: var(--ink);
            transition: border-color .15s ease, background .15s ease;
        }
        button.secondary:hover { border-color: var(--turmeric); }
        button.pill-add {
            display: flex; align-items: center; gap: 5px; background: var(--card); border: 1.5px solid var(--chili);
            color: var(--chili-deep); font-weight: 800; font-size: 12.5px; padding: 8px 14px; border-radius: 20px;
            cursor: pointer; white-space: nowrap; transition: background .15s ease;
        }
        button.pill-add:hover { background: #FDEEE6; }
        button.pill-add svg { width: 13px; height: 13px; }

        /* ---------- Category / food cards ---------- */
        .category-title {
            font-family: 'Instrument Serif', Georgia, serif; font-style: italic; font-weight: 400;
            font-size: 20px; color: var(--ink); margin: 26px 0 12px; position: relative; padding-bottom: 7px;
            display: inline-block;
        }
        .category-title:first-child { margin-top: 2px; }
        .category-title::after {
            content: ''; position: absolute; left: 0; bottom: 0; width: 32px; height: 2px;
            background: var(--chili); border-radius: 2px;
        }

        .food-card {
            display: flex; justify-content: space-between; align-items: center; gap: 12px;
            padding: 13px 14px; margin-bottom: 8px; background: var(--card); border: 1px solid var(--line);
            border-radius: 14px;
        }
        .food-info { display: flex; gap: 10px; align-items: flex-start; min-width: 0; }
        .veg-dot {
            width: 14px; height: 14px; border: 1.5px solid var(--curry); border-radius: 3px; flex-shrink: 0; margin-top: 3px;
            display: flex; align-items: center; justify-content: center;
        }
        .veg-dot::after { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--curry); }
        .veg-dot.nonveg { border-color: var(--chili-deep); }
        .veg-dot.nonveg::after { background: var(--chili-deep); border-radius: 0; clip-path: polygon(50% 0%, 0% 100%, 100% 100%); width: 8px; height: 7px; }
        .food-name { font-weight: 700; font-size: 14.5px; color: var(--text); line-height: 1.3; }

        /* ticket-style price tag: a mono "chit" torn off the kitchen order spike */
        .price-tag {
            font-family: 'IBM Plex Mono', monospace; font-weight: 600; font-size: 13px;
            color: var(--chili-deep); border-left: 2px dashed var(--chili); padding-left: 7px; margin-top: 4px;
            display: inline-block;
        }

        .stepper { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .qty-btn {
            width: 28px; height: 28px; border-radius: 50%; border: 1.5px solid var(--chili); background: var(--card);
            cursor: pointer; color: var(--chili-deep); display: flex; align-items: center; justify-content: center;
            font-size: 15px; line-height: 1; transition: background .15s ease;
        }
        .qty-btn:hover { background: #FDEEE6; }
        .qty-value { font-weight: 800; font-size: 14px; min-width: 14px; text-align: center; font-family: 'IBM Plex Mono', monospace; }

        /* ---------- Cart / totals ---------- */
        .row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 14px; color: var(--text); }
        .row.total {
            font-weight: 800; font-size: 17px; font-family: 'IBM Plex Mono', monospace; color: var(--chili-deep);
        }
        .totals-card {
            margin-top: 18px; background: var(--card); border-top: 2px dashed var(--line); border-bottom: 2px dashed var(--line);
            padding: 16px 4px;
        }
        .coupon-row { display: flex; gap: 8px; margin-top: 18px; }
        .coupon-row input { margin-bottom: 0; }
        .error { color: var(--danger); font-size: 13px; margin: 6px 0 0; }

        /* ---------- Address cards ---------- */
        .address-card {
            border: 1.5px solid var(--line); border-radius: 14px; padding: 13px 14px; margin-bottom: 10px;
            cursor: pointer; background: var(--card); transition: border-color .15s ease, background .15s ease;
        }
        .address-card.selected { border-color: var(--chili); background: #FDF1E7; }
        .address-label { font-weight: 700; font-size: 14px; color: var(--ink); }
        .address-text { font-size: 13.5px; color: var(--text-muted); margin-top: 3px; }
        .section-heading {
            font-family: 'Instrument Serif', Georgia, serif; font-style: italic; font-weight: 400; font-size: 17px;
            color: var(--ink); margin: 22px 0 10px;
        }

        /* ---------- Status badges ---------- */
        .status-badge {
            font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: capitalize;
            letter-spacing: 0.02em; white-space: nowrap; font-family: 'IBM Plex Mono', monospace;
        }
        .st-pending { background: #F5E6C8; color: #8A5F1E; }
        .st-confirmed { background: #DCE7F5; color: #2C5590; }
        .st-preparing { background: #FCE3C0; color: #B0590F; }
        .st-out { background: #E7DEF5; color: #6B3FA0; }
        .st-delivered { background: #DDEFE0; color: var(--curry); }
        .st-cancelled { background: #F7DCD3; color: var(--danger); }

        /* ---------- Bottom nav: floating dark pill ---------- */
        .bottom-nav {
            display: flex; position: sticky; bottom: 12px; background: var(--ink);
            margin: 6px 16px 0; border-radius: 20px; padding: 7px;
            box-shadow: 0 16px 34px -14px rgba(34,28,21,0.55);
        }
        .bottom-nav button {
            flex: 1; padding: 9px 4px 8px; background: none; border: none; font-size: 11px; font-weight: 700;
            cursor: pointer; color: rgba(251,243,231,0.5); display: flex; flex-direction: column; align-items: center; gap: 4px;
            border-radius: 14px; transition: color .15s ease, background .15s ease;
        }
        .bottom-nav button svg { width: 20px; height: 20px; }
        .bottom-nav button.active { color: var(--gold-text); background: rgba(255,255,255,0.07); }

        /* ---------- Cart FAB ---------- */
        .cart-fab {
            position: sticky; bottom: 84px; margin: 0 18px 0; background: var(--sizzle);
            color: var(--ink); padding: 13px 16px; border-radius: 14px; display: flex; justify-content: space-between;
            align-items: center; cursor: pointer; box-shadow: 0 10px 24px -10px rgba(225,80,46,0.5); font-weight: 800; font-size: 13.5px;
        }
        .cart-fab svg { width: 15px; height: 15px; margin-left: 6px; }

        /* ---------- Empty states ---------- */
        .empty-state { text-align: center; padding: 60px 20px 20px; color: var(--text-muted); }
        .empty-state svg { width: 50px; height: 50px; color: var(--chili); opacity: 0.75; margin-bottom: 14px; }
        .empty-state p { font-size: 14px; margin: 0; }
        .empty-state .sub { font-size: 12.5px; margin-top: 4px; color: #BBA98D; }

        /* ---------- Confirmation + order tracker ---------- */
        .confirm-wrap { text-align: center; padding-top: 52px; }
        .confirm-ring {
            width: 84px; height: 84px; margin: 0 auto 20px; border-radius: 50%;
            background: radial-gradient(circle at 32% 28%, rgba(63,116,81,0.18), rgba(63,116,81,0.04));
            border: 1.5px solid rgba(63,116,81,0.4); display: flex; align-items: center; justify-content: center;
        }
        .confirm-ring svg { width: 38px; height: 38px; color: var(--curry); }
        .confirm-wrap h1 { font-family: 'Instrument Serif', serif; font-style: italic; font-weight: 400; font-size: 26px; margin: 0 0 6px; color: var(--ink); }
        .confirm-order-no {
            font-family: 'IBM Plex Mono', monospace; font-size: 13px; color: var(--chili-deep); font-weight: 600;
            border-left: 2px dashed var(--chili); padding-left: 7px; display: inline-block;
        }

        .tracker { display: flex; justify-content: space-between; position: relative; margin: 34px 0 4px; padding: 0 8px; text-align: left; }
        .tracker::before {
            content: ''; position: absolute; top: 7px; left: 24px; right: 24px; height: 2px; background: var(--line); z-index: 0;
        }
        .tracker-step { position: relative; z-index: 1; display: flex; flex-direction: column; align-items: center; gap: 7px; flex: 1; }
        .tracker-dot { width: 16px; height: 16px; border-radius: 50%; background: var(--card); border: 2px solid var(--line); }
        .tracker-step.done .tracker-dot { background: var(--sizzle); border-color: transparent; }
        .tracker-label { font-size: 10px; font-weight: 700; color: var(--text-muted); text-align: center; line-height: 1.25; }
        .tracker-step.done .tracker-label { color: var(--chili-deep); }
        .cancelled-banner {
            margin-top: 24px; background: #F7DCD3; color: var(--danger); border-radius: 12px; padding: 12px 16px;
            font-size: 13.5px; font-weight: 700; text-align: center;
        }

        /* ---------- Auth screens ---------- */
        .auth-screen {
            min-height: 100vh; position: relative; overflow: hidden;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 48px 28px; color: #F6EFE3;
            background: radial-gradient(ellipse 120% 80% at 50% -10%, #4A3420 0%, #241A12 55%, #140F0A 100%);
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        }
        .auth-screen::before, .auth-screen::after {
            content: ''; position: absolute; border-radius: 50%; border: 1px solid rgba(242,169,59,0.10);
        }
        .auth-screen::before { width: 520px; height: 520px; top: -140px; right: -180px; }
        .auth-screen::after { width: 340px; height: 340px; bottom: -110px; left: -120px; border-color: rgba(225,80,46,0.08); }

        .auth-card { width: 100%; max-width: 320px; text-align: center; position: relative; z-index: 1; }

        .logo-ring {
            width: 78px; height: 78px; margin: 0 auto 18px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: radial-gradient(circle at 32% 28%, rgba(242,169,59,0.30), rgba(225,80,46,0.05));
            border: 1.5px solid rgba(242,169,59,0.5);
            box-shadow: 0 0 42px -6px rgba(225,80,46,0.4);
        }
        .logo-ring svg { width: 42px; height: 42px; }
        .pop circle { animation: popPulse 2.6s ease-in-out infinite; transform-origin: center; }
        .pop circle:nth-child(2) { animation-delay: .35s; }
        .pop circle:nth-child(3) { animation-delay: .7s; }
        @keyframes popPulse {
            0%, 100% { transform: scale(1); opacity: .7; }
            50% { transform: scale(1.35); opacity: 1; }
        }

        .brand-name {
            font-family: 'Instrument Serif', Georgia, serif; font-style: italic; font-weight: 400; font-size: 36px;
            letter-spacing: 0.2px; color: var(--gold-text); margin: 0;
        }
        .brand-tag {
            font-size: 13.5px; color: rgba(246,239,227,0.6); font-weight: 500;
            margin: 8px 0 0; letter-spacing: 0.15px;
        }

        .divider { display: flex; align-items: center; gap: 10px; margin: 30px 0 26px; }
        .divider-line { flex: 1; height: 1px; background: linear-gradient(90deg, transparent, rgba(242,169,59,0.4), transparent); }
        .divider-dot { width: 4px; height: 4px; border-radius: 50%; background: var(--chili); flex-shrink: 0; }

        .auth-heading { font-family: 'Instrument Serif', Georgia, serif; font-style: italic; font-weight: 400; font-size: 23px; color: #F6EFE3; margin: 0 0 6px; }
        .auth-sub { font-size: 13.5px; color: rgba(246,239,227,0.6); margin: 0 0 24px; }
        .auth-sub b { color: var(--gold-text); font-weight: 700; }

        .auth-label {
            display: block; text-align: left; font-size: 11.5px; font-weight: 700; letter-spacing: 0.09em;
            text-transform: uppercase; color: rgba(246,239,227,0.5); margin: 0 0 8px 2px;
        }

        .phone-field {
            display: flex; align-items: center; background: rgba(255,255,255,0.055);
            border: 1px solid rgba(242,169,59,0.35); border-radius: 14px; padding: 4px 16px;
            margin-bottom: 22px; transition: border-color .15s ease, background .15s ease;
        }
        .phone-field:focus-within { border-color: var(--turmeric); background: rgba(242,169,59,0.09); }
        .phone-field .prefix {
            color: var(--gold-text); font-weight: 700; font-size: 15.5px; padding-right: 10px;
            border-right: 1px solid rgba(242,169,59,0.28); margin-right: 10px; white-space: nowrap;
        }
        .phone-field input {
            background: transparent; border: none; outline: none; color: #F6EFE3;
            font-size: 16.5px; letter-spacing: 0.4px; padding: 14px 0; width: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif; margin-bottom: 0;
        }
        .phone-field input::placeholder { color: rgba(246,239,227,0.32); }

        .otp-katoris { display: flex; justify-content: center; gap: 12px; margin: 4px 0 26px; }
        .otp-katoris input {
            width: 54px; height: 54px; border-radius: 50%; text-align: center;
            font-family: 'IBM Plex Mono', monospace; font-size: 20px; font-weight: 600; color: #F6EFE3;
            background: rgba(255,255,255,0.055); border: 1.5px solid rgba(242,169,59,0.38);
            outline: none; transition: all .18s ease; margin-bottom: 0; padding: 0;
        }
        .otp-katoris input:focus {
            border-color: var(--turmeric); background: rgba(242,169,59,0.13);
            box-shadow: 0 0 0 5px rgba(242,169,59,0.14);
        }
        .otp-katoris input.filled { border-color: var(--turmeric); }

        .btn-tadka {
            width: 100%; padding: 16px; border: none; border-radius: 14px; cursor: pointer;
            background: var(--sizzle); color: var(--ink);
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 16px; letter-spacing: 0.2px;
            box-shadow: 0 12px 26px -10px rgba(225,80,46,0.6);
            transition: transform .15s ease, box-shadow .15s ease, opacity .15s ease;
        }
        .btn-tadka:active { transform: scale(0.98); }
        .btn-tadka:disabled { opacity: 0.45; box-shadow: none; cursor: default; }

        .link-ghost {
            display: inline-block; margin-top: 18px; background: none; border: none; cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 600;
            color: rgba(246,239,227,0.65); text-decoration: none; padding: 6px;
        }
        .link-ghost:hover { color: var(--gold-text); }
        .link-ghost:disabled { opacity: 0.4; cursor: default; color: rgba(246,239,227,0.4); }

        .auth-error {
            text-align: left; font-size: 13px; color: #FFA6B4; background: rgba(255,76,110,0.12);
            border: 1px solid rgba(255,76,110,0.32); border-radius: 10px; padding: 10px 12px; margin: -6px 0 16px;
        }
        .auth-footnote {
            font-size: 12px; color: rgba(246,239,227,0.4); margin-top: 22px; line-height: 1.5;
        }
    </style>
</head>
<body>
<div class="app" x-data="foodApp()" x-init="init()">

    <!-- PHONE ENTRY -->
    <template x-if="screen === 'phone'">
        <div class="auth-screen">
            <div class="auth-card">
                <div class="logo-ring">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g class="pop" fill="#F2A93B">
                            <circle cx="17" cy="11" r="1.8"/>
                            <circle cx="24" cy="7" r="2"/>
                            <circle cx="31" cy="11" r="1.6" fill="#E1502E"/>
                        </g>
                        <path d="M6 22h36" stroke="#F2A93B" stroke-width="2" stroke-linecap="round"/>
                        <path d="M9 22c0 9 6.7 16 15 16s15-7 15-16" stroke="#F2A93B" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h1 class="brand-name">Tadka</h1>
                <p class="brand-tag">small kitchens, straight to your door</p>

                <div class="divider"><span class="divider-line"></span><span class="divider-dot"></span><span class="divider-line"></span></div>

                <h2 class="auth-heading">What's cooking today?</h2>
                <p class="auth-sub">Enter your number — we'll sign you in or set up an account in seconds.</p>

                <label class="auth-label">Phone number</label>
                <div class="phone-field">
                    <span class="prefix">+91</span>
                    <input type="tel" inputmode="numeric" placeholder="98765 43210" x-model="phone" maxlength="10" @keyup.enter="sendOtp()">
                </div>

                <p class="auth-error" x-show="error" x-text="error"></p>

                <button class="btn-tadka" :disabled="loading || phone.length < 10" @click="sendOtp()">
                    <span x-text="loading ? 'Sending code…' : 'Send OTP'"></span>
                </button>

                <p class="auth-footnote">We'll text a one-time code to verify it's you.<br>No spam, no passwords to remember.</p>
            </div>
        </div>
    </template>

    <!-- OTP ENTRY -->
    <template x-if="screen === 'otp'">
        <div class="auth-screen">
            <div class="auth-card">
                <div class="logo-ring">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g class="pop" fill="#F2A93B">
                            <circle cx="17" cy="11" r="1.8"/>
                            <circle cx="24" cy="7" r="2"/>
                            <circle cx="31" cy="11" r="1.6" fill="#E1502E"/>
                        </g>
                        <path d="M6 22h36" stroke="#F2A93B" stroke-width="2" stroke-linecap="round"/>
                        <path d="M9 22c0 9 6.7 16 15 16s15-7 15-16" stroke="#F2A93B" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>

                <h2 class="auth-heading">Enter the code</h2>
                <p class="auth-sub">Sent to <b>+91 <span x-text="phone"></span></b></p>

                <div class="otp-katoris" @paste.prevent="handleOtpPaste($event)">
                    <template x-for="(d, i) in otpDigits" :key="i">
                        <input
                            type="text" inputmode="numeric" maxlength="1"
                            :x-ref="'otp' + i"
                            :class="{ filled: otpDigits[i] }"
                            x-model="otpDigits[i]"
                            @input="onOtpInput(i, $event)"
                            @keydown.backspace="onOtpBackspace(i, $event)">
                    </template>
                </div>

                <p class="auth-error" x-show="error" x-text="error"></p>

                <button class="btn-tadka" :disabled="loading || otpCode.length < otpDigits.length" @click="verifyOtp()">
                    <span x-text="loading ? 'Verifying…' : 'Verify & Continue'"></span>
                </button>

                <div>
                    <button class="link-ghost" :disabled="resendCooldown > 0" @click="sendOtp(true)">
                        <span x-text="resendCooldown > 0 ? 'Resend code in ' + resendCooldown + 's' : 'Resend code'"></span>
                    </button>
                    <span style="color:rgba(246,239,227,0.3);">·</span>
                    <button class="link-ghost" @click="screen='phone'">Change number</button>
                </div>
            </div>
        </div>
    </template>

    <!-- MENU -->
    <template x-if="screen === 'menu'">
        <div>
            <div class="topbar">
                <h1>
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g fill="#F2A93B"><circle cx="17" cy="11" r="1.8"/><circle cx="24" cy="7" r="2"/><circle cx="31" cy="11" r="1.6" fill="#E1502E"/></g>
                        <path d="M6 22h36" stroke="#221C15" stroke-width="2.4" stroke-linecap="round"/>
                        <path d="M9 22c0 9 6.7 16 15 16s15-7 15-16" stroke="#221C15" stroke-width="2.4" stroke-linecap="round"/>
                    </svg>
                    Tadka
                </h1>
                <div class="cart-chip">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    <span x-text="cartCount"></span>
                </div>
            </div>
            <div class="screen" style="padding-bottom:0;">
                <template x-if="categories.length === 0">
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M17 2c-2.5 2.5-2.5 7 0 9.5V22"/></svg>
                        <p>Loading today's menu…</p>
                    </div>
                </template>
                <template x-for="cat in categories" :key="cat.id">
                    <div>
                        <div class="category-title" x-text="cat.name"></div>
                        <template x-for="item in cat.food_items" :key="item.id">
                            <div class="food-card">
                                <div class="food-info">
                                    <span class="veg-dot" :class="{ nonveg: !item.is_veg }"></span>
                                    <div>
                                        <div class="food-name" x-text="item.name"></div>
                                        <div class="price-tag" x-text="'₹' + item.price"></div>
                                    </div>
                                </div>
                                <template x-if="cartQtyFor(item) === 0">
                                    <button class="pill-add" @click="addToCart(item)">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                                        Add
                                    </button>
                                </template>
                                <template x-if="cartQtyFor(item) > 0">
                                    <div class="stepper">
                                        <button class="qty-btn" @click="updateQty(cartItemFor(item), cartQtyFor(item) - 1)">−</button>
                                        <span class="qty-value" x-text="cartQtyFor(item)"></span>
                                        <button class="qty-btn" @click="updateQty(cartItemFor(item), cartQtyFor(item) + 1)">+</button>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            <div class="cart-fab" x-show="cartCount > 0" @click="goToCart()">
                <span x-text="cartCount + (cartCount === 1 ? ' item in cart' : ' items in cart')"></span>
                <span style="display:flex;align-items:center;">View Cart
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </span>
            </div>

            <div class="bottom-nav">
                <button class="active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M17 2c-2.5 2.5-2.5 7 0 9.5V22"/></svg>
                    Menu
                </button>
                <button @click="goToOrders()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h4m0-11v11m0-11h6m-6 11h6m0-11h4a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-4m0-11v11"/></svg>
                    Orders
                </button>
                <button @click="goToAccount()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
                    Account
                </button>
            </div>
        </div>
    </template>

    <!-- CART -->
    <template x-if="screen === 'cart'">
        <div>
            <div class="topbar">
                <button class="icon-btn" @click="screen='menu'">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </button>
                <h1 style="font-size:19px;">Your Cart</h1>
                <span class="spacer-36"></span>
            </div>
            <div class="screen">
                <template x-if="cart.items && cart.items.length === 0">
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        <p>Nothing here yet.</p>
                        <p class="sub">Browse the menu and add a dish or two.</p>
                    </div>
                </template>
                <template x-for="ci in cart.items" :key="ci.id">
                    <div class="food-card">
                        <div class="food-info">
                            <div>
                                <div class="food-name" x-text="ci.food_item.name"></div>
                                <div class="price-tag" x-text="'₹' + ci.price_snapshot + ' × ' + ci.quantity"></div>
                            </div>
                        </div>
                        <div class="stepper">
                            <button class="qty-btn" @click="updateQty(ci, ci.quantity - 1)">−</button>
                            <span class="qty-value" x-text="ci.quantity"></span>
                            <button class="qty-btn" @click="updateQty(ci, ci.quantity + 1)">+</button>
                        </div>
                    </div>
                </template>

                <template x-if="cart.items && cart.items.length > 0">
                    <div>
                        <div class="coupon-row">
                            <input type="text" placeholder="Coupon code" x-model="couponCode">
                            <button class="secondary" @click="applyCoupon()">Apply</button>
                        </div>
                        <p class="error" x-show="couponError" x-text="couponError"></p>

                        <div class="totals-card">
                            <div class="row"><span>Subtotal</span><span x-text="'₹' + cart.subtotal"></span></div>
                            <div class="row" x-show="cart.discount > 0"><span>Discount</span><span x-text="'−₹' + cart.discount"></span></div>
                            <div class="row total"><span>Total</span><span x-text="'₹' + cart.total"></span></div>
                        </div>

                        <button class="primary" style="margin-top:16px;" @click="goToAddress()">
                            Proceed to Address
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </template>

    <!-- ADDRESS / PLACE ORDER -->
    <template x-if="screen === 'address'">
        <div>
            <div class="topbar">
                <button class="icon-btn" @click="screen='cart'">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </button>
                <h1 style="font-size:19px;">Delivery Address</h1>
                <span class="spacer-36"></span>
            </div>
            <div class="screen">
                <template x-for="addr in addresses" :key="addr.id">
                    <div class="address-card" :class="selectedAddressId === addr.id ? 'selected' : ''" @click="selectedAddressId = addr.id">
                        <div class="address-label" x-text="addr.label"></div>
                        <div class="address-text" x-text="addr.full_address"></div>
                    </div>
                </template>

                <div class="section-heading">Add new address</div>
                <input type="text" placeholder="Label (Home / Work / Other)" x-model="newAddress.label">
                <input type="text" placeholder="Full address" x-model="newAddress.full_address">
                <input type="text" placeholder="Landmark (optional)" x-model="newAddress.landmark">
                <button class="secondary" style="width:100%;" @click="addAddress()">+ Save Address</button>

                <p class="error" x-show="error" x-text="error"></p>
                <button class="primary" style="margin-top:18px;" :disabled="!selectedAddressId || loading" @click="placeOrder()">
                    <span x-text="loading ? 'Placing order...' : 'Place Order'"></span>
                </button>
            </div>
        </div>
    </template>

    <!-- ORDER CONFIRMATION -->
    <template x-if="screen === 'confirmation'">
        <div class="screen confirm-wrap">
            <div class="confirm-ring">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
            </div>
            <h1>Order placed!</h1>
            <span class="confirm-order-no" x-text="'#' + lastOrder.order_number"></span>

            <template x-if="lastOrder.status !== 'cancelled'">
                <div class="tracker">
                    <template x-for="(st, idx) in stages" :key="st">
                        <div class="tracker-step" :class="{ done: stageIndex(lastOrder.status) >= idx }">
                            <span class="tracker-dot"></span>
                            <span class="tracker-label" x-text="stageLabel(st)"></span>
                        </div>
                    </template>
                </div>
            </template>
            <template x-if="lastOrder.status === 'cancelled'">
                <div class="cancelled-banner">This order was cancelled.</div>
            </template>

            <button class="primary" style="margin-top:32px;" @click="goToOrders()">View My Orders</button>
        </div>
    </template>

    <!-- ORDER HISTORY -->
    <template x-if="screen === 'orders'">
        <div>
            <div class="topbar"><h1 style="font-size:19px;">My Orders</h1><span class="spacer-36"></span></div>
            <div class="screen">
                <template x-if="orders.length === 0">
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h4m0-11v11m0-11h6m-6 11h6m0-11h4a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-4m0-11v11"/></svg>
                        <p>No orders yet.</p>
                        <p class="sub">Once you place one, it'll show up here.</p>
                    </div>
                </template>
                <template x-for="order in orders" :key="order.id">
                    <div class="address-card" style="cursor:default;">
                        <div class="row" style="padding:0 0 4px;">
                            <span class="address-label" x-text="'#' + order.order_number"></span>
                            <span class="status-badge" :class="statusClass(order.status)" x-text="order.status.replaceAll('_',' ')"></span>
                        </div>
                        <div class="address-text" x-text="'₹' + order.total + ' · ' + order.created_at.substring(0,10)"></div>
                    </div>
                </template>
            </div>
            <div class="bottom-nav">
                <button @click="goToMenuFromNav()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M17 2c-2.5 2.5-2.5 7 0 9.5V22"/></svg>
                    Menu
                </button>
                <button class="active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h4m0-11v11m0-11h6m-6 11h6m0-11h4a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-4m0-11v11"/></svg>
                    Orders
                </button>
                <button @click="goToAccount()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
                    Account
                </button>
            </div>
        </div>
    </template>

    <!-- ACCOUNT -->
    <template x-if="screen === 'account'">
        <div>
            <div class="topbar"><h1 style="font-size:19px;">Account</h1><span class="spacer-36"></span></div>
            <div class="screen">
                <label class="field-label">Name</label>
                <input type="text" placeholder="Your name" x-model="profile.name">
                <label class="field-label">Email</label>
                <input type="email" placeholder="Email (optional)" x-model="profile.email">
                <button class="secondary" style="width:100%;margin-bottom:8px;" @click="saveProfile()">Save Profile</button>

                <div class="section-heading">Saved Addresses</div>
                <template x-if="addresses.length === 0">
                    <p style="font-size:13.5px;color:var(--text-muted);">No saved addresses yet.</p>
                </template>
                <template x-for="addr in addresses" :key="addr.id">
                    <div class="address-card" style="cursor:default;">
                        <div class="row" style="padding:0 0 4px;">
                            <span class="address-label" x-text="addr.label"></span>
                            <button class="icon-btn" style="width:30px;height:30px;" @click="deleteAddress(addr.id)">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
                            </button>
                        </div>
                        <div class="address-text" x-text="addr.full_address"></div>
                    </div>
                </template>

                <button class="primary danger" style="margin-top:22px;" @click="logout()">Log out</button>
            </div>
            <div class="bottom-nav">
                <button @click="goToMenuFromNav()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M17 2c-2.5 2.5-2.5 7 0 9.5V22"/></svg>
                    Menu
                </button>
                <button @click="goToOrders()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h4m0-11v11m0-11h6m-6 11h6m0-11h4a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-4m0-11v11"/></svg>
                    Orders
                </button>
                <button class="active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
                    Account
                </button>
            </div>
        </div>
    </template>
</div>

<script>
function foodApp() {
    return {
        screen: 'phone',
        loading: false,
        error: '',
        couponError: '',
        phone: '',
        otpDigits: ['', '', '', ''],
        resendCooldown: 0,
        token: null,
        categories: [],
        cart: { items: [], subtotal: 0, discount: 0, total: 0 },
        couponCode: '',
        addresses: [],
        selectedAddressId: null,
        newAddress: { label: 'Home', full_address: '', landmark: '' },
        orders: [],
        profile: { name: '', email: '' },
        lastOrder: {},
        stages: ['pending', 'confirmed', 'preparing', 'out_for_delivery', 'delivered'],

        get cartCount() {
            return (this.cart.items || []).reduce((sum, i) => sum + i.quantity, 0);
        },

        get otpCode() {
            return this.otpDigits.join('');
        },

        // Returns the quantity of a given menu item already in the cart, or 0.
        cartQtyFor(item) {
            const ci = (this.cart.items || []).find(c => c.food_item && c.food_item.id === item.id);
            return ci ? ci.quantity : 0;
        },

        // Returns the cart-item object matching a given menu item, so the
        // stepper can call updateQty() with the correct cart item id.
        cartItemFor(item) {
            return (this.cart.items || []).find(c => c.food_item && c.food_item.id === item.id);
        },

        // Maps an order status to a CSS class for the colored status badge.
        statusClass(status) {
            const map = {
                pending: 'st-pending', confirmed: 'st-confirmed', preparing: 'st-preparing',
                out_for_delivery: 'st-out', delivered: 'st-delivered', cancelled: 'st-cancelled',
            };
            return map[status] || 'st-pending';
        },

        // Index of a status within the delivery pipeline, used by the tracker.
        stageIndex(status) {
            return this.stages.indexOf(status);
        },

        // Friendly label for each tracker stage.
        stageLabel(stage) {
            const map = {
                pending: 'Placed', confirmed: 'Confirmed', preparing: 'Preparing',
                out_for_delivery: 'On the way', delivered: 'Delivered',
            };
            return map[stage] || stage;
        },

        async api(path, options = {}) {
            const headers = { 'Content-Type': 'application/json', 'Accept': 'application/json' };
            if (this.token) headers['Authorization'] = 'Bearer ' + this.token;
            const res = await fetch('/api' + path, { ...options, headers: { ...headers, ...(options.headers || {}) } });
            const data = await res.json().catch(() => ({}));
            if (!res.ok) throw data;
            return data;
        },

        async init() {
            this.token = localStorage.getItem('auth_token');
            if (this.token) {
                try {
                    await this.api('/me');
                    await this.loadMenu();
                    await this.loadCart();
                    this.screen = 'menu';
                    return;
                } catch (e) {
                    localStorage.removeItem('auth_token');
                    this.token = null;
                }
            }
            this.screen = 'phone';
        },

        async sendOtp(isResend = false) {
            this.error = ''; this.loading = true;
            try {
                await this.api('/auth/send-otp', { method: 'POST', body: JSON.stringify({ phone: this.phone }) });
                this.otpDigits = this.otpDigits.map(() => '');
                this.screen = 'otp';
                this.startResendCooldown();
                if (isResend) {
                    this.$nextTick(() => this.$refs.otp0 && this.$refs.otp0.focus());
                }
            } catch (e) {
                this.error = e.message || 'Could not send OTP. Check the number and try again.';
            } finally { this.loading = false; }
        },

        startResendCooldown() {
            this.resendCooldown = 30;
            const timer = setInterval(() => {
                this.resendCooldown--;
                if (this.resendCooldown <= 0) clearInterval(timer);
            }, 1000);
        },

        onOtpInput(index, event) {
            const val = event.target.value.replace(/[^0-9]/g, '').slice(-1);
            this.otpDigits[index] = val;
            if (val && index < this.otpDigits.length - 1) {
                this.$nextTick(() => this.$refs['otp' + (index + 1)]?.focus());
            }
            if (this.otpCode.length === this.otpDigits.length) {
                this.$nextTick(() => this.verifyOtp());
            }
        },

        onOtpBackspace(index, event) {
            if (!this.otpDigits[index] && index > 0) {
                this.$refs['otp' + (index - 1)]?.focus();
            }
        },

        handleOtpPaste(event) {
            const pasted = (event.clipboardData.getData('text') || '').replace(/[^0-9]/g, '');
            if (!pasted) return;
            this.otpDigits = this.otpDigits.map((_, i) => pasted[i] || '');
            const lastFilled = Math.min(pasted.length, this.otpDigits.length) - 1;
            this.$nextTick(() => this.$refs['otp' + Math.max(lastFilled, 0)]?.focus());
            if (this.otpCode.length === this.otpDigits.length) {
                this.$nextTick(() => this.verifyOtp());
            }
        },

        async verifyOtp() {
            this.error = ''; this.loading = true;
            try {
                const data = await this.api('/auth/verify-otp', {
                    method: 'POST', body: JSON.stringify({ phone: this.phone, code: this.otpCode }),
                });
                this.token = data.token;
                localStorage.setItem('auth_token', this.token);
                await this.loadMenu();
                await this.loadCart();
                this.screen = 'menu';
            } catch (e) {
                this.error = e.message || 'Invalid OTP.';
                this.otpDigits = this.otpDigits.map(() => '');
                this.$nextTick(() => this.$refs.otp0 && this.$refs.otp0.focus());
            } finally { this.loading = false; }
        },

        async loadMenu() {
            this.categories = await this.api('/menu');
        },

        async loadCart() {
            this.cart = await this.api('/cart');
        },

        async addToCart(item) {
            this.cart = await this.api('/cart/items', {
                method: 'POST', body: JSON.stringify({ food_item_id: item.id, quantity: 1 }),
            });
        },

        async updateQty(cartItem, qty) {
            if (qty < 1) {
                this.cart = await this.api('/cart/items/' + cartItem.id, { method: 'DELETE' });
            } else {
                this.cart = await this.api('/cart/items/' + cartItem.id, {
                    method: 'PUT', body: JSON.stringify({ quantity: qty }),
                });
            }
        },

        async applyCoupon() {
            this.couponError = '';
            try {
                this.cart = await this.api('/cart/apply-coupon', {
                    method: 'POST', body: JSON.stringify({ code: this.couponCode }),
                });
            } catch (e) {
                this.couponError = e.message || 'Invalid coupon.';
            }
        },

        async goToCart() {
            await this.loadCart();
            this.screen = 'cart';
        },

        async goToAddress() {
            this.addresses = await this.api('/addresses');
            if (this.addresses.length) this.selectedAddressId = this.addresses[0].id;
            this.screen = 'address';
        },

        async addAddress() {
            if (!this.newAddress.full_address) return;
            const addr = await this.api('/addresses', { method: 'POST', body: JSON.stringify(this.newAddress) });
            this.addresses.push(addr);
            this.selectedAddressId = addr.id;
            this.newAddress = { label: 'Home', full_address: '', landmark: '' };
        },

        async deleteAddress(id) {
            await this.api('/addresses/' + id, { method: 'DELETE' });
            this.addresses = this.addresses.filter(a => a.id !== id);
        },

        async placeOrder() {
            this.error = ''; this.loading = true;
            try {
                const order = await this.api('/orders', {
                    method: 'POST', body: JSON.stringify({ address_id: this.selectedAddressId }),
                });
                this.lastOrder = order;
                this.cart = { items: [], subtotal: 0, discount: 0, total: 0 };
                this.screen = 'confirmation';
            } catch (e) {
                this.error = e.message || 'Could not place order.';
            } finally { this.loading = false; }
        },

        async goToOrders() {
            this.orders = (await this.api('/orders')).data || [];
            this.screen = 'orders';
        },

        async goToMenuFromNav() {
            await this.loadMenu();
            await this.loadCart();
            this.screen = 'menu';
        },

        async goToAccount() {
            const me = await this.api('/profile');
            this.profile = { name: me.name || '', email: me.email || '' };
            this.addresses = await this.api('/addresses');
            this.screen = 'account';
        },

        async saveProfile() {
            await this.api('/profile', { method: 'PUT', body: JSON.stringify(this.profile) });
        },

        async logout() {
            try { await this.api('/auth/logout', { method: 'POST' }); } catch (e) {}
            localStorage.removeItem('auth_token');
            this.token = null;
            this.phone = ''; this.otpDigits = this.otpDigits.map(() => '');
            this.screen = 'phone';
        },
    };
}

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => navigator.serviceWorker.register('/sw.js'));
}
</script>
</body>
</html>
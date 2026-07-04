<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bhojan — home-style food, on the way</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#5C1A2B">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;1,9..144,500&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; margin: 0; background: #f7f7f8; color: #1a1a1a; }
        .app { max-width: 480px; margin: 0 auto; min-height: 100vh; background: #fff; display: flex; flex-direction: column; }
        .screen { padding: 20px; flex: 1; }
        .topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid #eee; position: sticky; top: 0; background: #fff; z-index: 5; }
        .topbar h1 { font-size: 18px; margin: 0; }
        input[type=text], input[type=tel], input[type=email] {
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; margin-bottom: 12px;
        }
        button.primary {
            width: 100%; padding: 14px; background: #4f46e5; color: #fff; border: none; border-radius: 8px;
            font-size: 16px; font-weight: 600; cursor: pointer;
        }
        button.primary:disabled { opacity: 0.5; }
        button.secondary { background: none; border: 1px solid #ddd; padding: 10px 14px; border-radius: 8px; cursor: pointer; }
        .category-title { font-weight: 700; margin: 18px 0 8px; }
        .food-card { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f0f0f0; }
        .food-name { font-weight: 600; }
        .food-price { color: #555; font-size: 14px; }
        .qty-btn { width: 30px; height: 30px; border-radius: 6px; border: 1px solid #ddd; background: #fff; cursor: pointer; }
        .bottom-nav { display: flex; border-top: 1px solid #eee; position: sticky; bottom: 0; background: #fff; }
        .bottom-nav button { flex: 1; padding: 10px; background: none; border: none; font-size: 12px; cursor: pointer; }
        .bottom-nav button.active { color: #4f46e5; font-weight: 700; }
        .cart-fab {
            position: sticky; bottom: 56px; margin: 10px 20px; background: #4f46e5; color: #fff;
            padding: 12px 16px; border-radius: 10px; display: flex; justify-content: space-between; cursor: pointer;
        }
        .row { display: flex; justify-content: space-between; padding: 6px 0; }
        .address-card { border: 1px solid #eee; border-radius: 8px; padding: 12px; margin-bottom: 10px; cursor: pointer; }
        .address-card.selected { border-color: #4f46e5; background: #f5f4ff; }
        .status-badge { font-size: 12px; padding: 3px 8px; border-radius: 20px; background: #eef2ff; color: #4338ca; }
        .otp-boxes { display: flex; gap: 8px; margin-bottom: 12px; }
        .otp-boxes input { text-align: center; font-size: 20px; padding: 12px 0; }
        .error { color: #dc2626; font-size: 14px; margin-bottom: 8px; }

        /* ---------- Bhojan auth screens (phone + OTP) ---------- */
        .auth-screen {
            min-height: 100vh; position: relative; overflow: hidden;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 48px 28px; color: #F6EFE3;
            background: radial-gradient(ellipse 120% 80% at 50% -10%, #6E2A3E 0%, #4A1120 55%, #33101A 100%);
            font-family: 'Manrope', system-ui, sans-serif;
        }
        .auth-screen::before, .auth-screen::after {
            content: ''; position: absolute; border-radius: 50%; border: 1px solid rgba(232,184,75,0.10);
        }
        .auth-screen::before { width: 520px; height: 520px; top: -140px; right: -180px; }
        .auth-screen::after { width: 340px; height: 340px; bottom: -110px; left: -120px; border-color: rgba(232,184,75,0.07); }

        .auth-card { width: 100%; max-width: 320px; text-align: center; position: relative; z-index: 1; }

        .logo-ring {
            width: 78px; height: 78px; margin: 0 auto 18px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: radial-gradient(circle at 32% 28%, rgba(232,184,75,0.32), rgba(232,184,75,0.04));
            border: 1.5px solid rgba(232,184,75,0.55);
            box-shadow: 0 0 42px -6px rgba(232,184,75,0.4);
        }
        .logo-ring svg { width: 40px; height: 40px; }
        .steam path { animation: steamFloat 3.2s ease-in-out infinite; transform-origin: bottom center; }
        .steam path:nth-child(2) { animation-delay: .55s; }
        @keyframes steamFloat {
            0%, 100% { transform: translateY(0) scaleX(1); opacity: .5; }
            50% { transform: translateY(-3px) scaleX(1.08); opacity: .95; }
        }

        .brand-name {
            font-family: 'Fraunces', Georgia, serif; font-weight: 600; font-size: 32px;
            letter-spacing: 0.2px; color: #F1C065; margin: 0;
        }
        .brand-tag {
            font-style: italic; font-size: 13.5px; color: rgba(246,239,227,0.62);
            margin: 6px 0 0; letter-spacing: 0.15px;
        }

        .divider { display: flex; align-items: center; gap: 10px; margin: 30px 0 26px; }
        .divider-line { flex: 1; height: 1px; background: linear-gradient(90deg, transparent, rgba(232,184,75,0.45), transparent); }
        .divider-dot { width: 4px; height: 4px; border-radius: 50%; background: #E8B84B; flex-shrink: 0; }

        .auth-heading { font-family: 'Fraunces', Georgia, serif; font-size: 21px; font-weight: 500; color: #F6EFE3; margin: 0 0 6px; }
        .auth-sub { font-size: 13.5px; color: rgba(246,239,227,0.6); margin: 0 0 24px; }
        .auth-sub b { color: #F1C065; font-weight: 700; }

        .auth-label {
            display: block; text-align: left; font-size: 11.5px; font-weight: 700; letter-spacing: 0.09em;
            text-transform: uppercase; color: rgba(246,239,227,0.5); margin: 0 0 8px 2px;
        }

        .phone-field {
            display: flex; align-items: center; background: rgba(255,255,255,0.055);
            border: 1px solid rgba(232,184,75,0.35); border-radius: 14px; padding: 4px 16px;
            margin-bottom: 22px; transition: border-color .15s ease, background .15s ease;
        }
        .phone-field:focus-within { border-color: #E8B84B; background: rgba(232,184,75,0.09); }
        .phone-field .prefix {
            color: #E8B84B; font-weight: 700; font-size: 15.5px; padding-right: 10px;
            border-right: 1px solid rgba(232,184,75,0.28); margin-right: 10px; white-space: nowrap;
        }
        .phone-field input {
            background: transparent; border: none; outline: none; color: #F6EFE3;
            font-size: 16.5px; letter-spacing: 0.4px; padding: 14px 0; width: 100%;
            font-family: 'Manrope', sans-serif;
        }
        .phone-field input::placeholder { color: rgba(246,239,227,0.32); }

        .otp-katoris { display: flex; justify-content: center; gap: 12px; margin: 4px 0 26px; }
        .otp-katoris input {
            width: 54px; height: 54px; border-radius: 50%; text-align: center;
            font-family: 'Fraunces', serif; font-size: 22px; color: #F6EFE3;
            background: rgba(255,255,255,0.055); border: 1.5px solid rgba(232,184,75,0.38);
            outline: none; transition: all .18s ease;
        }
        .otp-katoris input:focus {
            border-color: #E8B84B; background: rgba(232,184,75,0.13);
            box-shadow: 0 0 0 5px rgba(232,184,75,0.14);
        }
        .otp-katoris input.filled { border-color: #E8B84B; }

        .btn-bhojan {
            width: 100%; padding: 16px; border: none; border-radius: 14px; cursor: pointer;
            background: linear-gradient(135deg, #F1C065, #D98F32); color: #3B0F1A;
            font-family: 'Manrope', sans-serif; font-weight: 800; font-size: 16px; letter-spacing: 0.2px;
            box-shadow: 0 12px 26px -10px rgba(227,167,60,0.6);
            transition: transform .15s ease, box-shadow .15s ease, opacity .15s ease;
        }
        .btn-bhojan:active { transform: scale(0.98); }
        .btn-bhojan:disabled { opacity: 0.45; box-shadow: none; cursor: default; }

        .link-ghost {
            display: inline-block; margin-top: 18px; background: none; border: none; cursor: pointer;
            font-family: 'Manrope', sans-serif; font-size: 13.5px; font-weight: 600;
            color: rgba(246,239,227,0.65); text-decoration: none; padding: 6px;
        }
        .link-ghost:hover { color: #F1C065; }
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
                    <!-- dummy logo: bowl + rising steam -->
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g class="steam" stroke="#F1C065" stroke-width="2" stroke-linecap="round">
                            <path d="M18 10c-2 3 2 4 0 7" />
                            <path d="M28 10c-2 3 2 4 0 7" />
                        </g>
                        <path d="M8 22h32c0 8.837-7.163 16-16 16S8 30.837 8 22Z" fill="#F1C065" fill-opacity="0.18" stroke="#F1C065" stroke-width="2"/>
                        <path d="M6 22h36" stroke="#F1C065" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h1 class="brand-name">Bhojan</h1>
                <p class="brand-tag">home-style food, on the way</p>

                <div class="divider"><span class="divider-line"></span><span class="divider-dot"></span><span class="divider-line"></span></div>

                <h2 class="auth-heading">Let's get you fed</h2>
                <p class="auth-sub">Enter your phone number to sign in or create an account</p>

                <label class="auth-label">Phone number</label>
                <div class="phone-field">
                    <span class="prefix">+91</span>
                    <input type="tel" inputmode="numeric" placeholder="98765 43210" x-model="phone" maxlength="10" @keyup.enter="sendOtp()">
                </div>

                <p class="auth-error" x-show="error" x-text="error"></p>

                <button class="btn-bhojan" :disabled="loading || phone.length < 10" @click="sendOtp()">
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
                        <g class="steam" stroke="#F1C065" stroke-width="2" stroke-linecap="round">
                            <path d="M18 10c-2 3 2 4 0 7" />
                            <path d="M28 10c-2 3 2 4 0 7" />
                        </g>
                        <path d="M8 22h32c0 8.837-7.163 16-16 16S8 30.837 8 22Z" fill="#F1C065" fill-opacity="0.18" stroke="#F1C065" stroke-width="2"/>
                        <path d="M6 22h36" stroke="#F1C065" stroke-width="2" stroke-linecap="round"/>
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

                <button class="btn-bhojan" :disabled="loading || otpCode.length < otpDigits.length" @click="verifyOtp()">
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
                <h1>Menu</h1>
                <span style="font-size:13px;color:#666;" x-text="'Cart: ' + cartCount"></span>
            </div>
            <div class="screen" style="padding-bottom:0;">
                <template x-for="cat in categories" :key="cat.id">
                    <div>
                        <div class="category-title" x-text="cat.name"></div>
                        <template x-for="item in cat.food_items" :key="item.id">
                            <div class="food-card">
                                <div>
                                    <div class="food-name" x-text="item.name"></div>
                                    <div class="food-price" x-text="'₹' + item.price"></div>
                                </div>
                                <button class="secondary" @click="addToCart(item)">Add</button>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            <div class="cart-fab" x-show="cartCount > 0" @click="goToCart()">
                <span x-text="cartCount + ' item(s) in cart'"></span>
                <span>View Cart →</span>
            </div>

            <div class="bottom-nav">
                <button class="active">Menu</button>
                <button @click="goToOrders()">Orders</button>
                <button @click="goToAccount()">Account</button>
            </div>
        </div>
    </template>

    <!-- CART -->
    <template x-if="screen === 'cart'">
        <div>
            <div class="topbar">
                <button class="secondary" @click="screen='menu'">← Back</button>
                <h1>Your Cart</h1>
                <span></span>
            </div>
            <div class="screen">
                <template x-if="cart.items && cart.items.length === 0">
                    <p style="color:#666;">Your cart is empty.</p>
                </template>
                <template x-for="ci in cart.items" :key="ci.id">
                    <div class="food-card">
                        <div>
                            <div class="food-name" x-text="ci.food_item.name"></div>
                            <div class="food-price" x-text="'₹' + ci.price_snapshot + ' x ' + ci.quantity"></div>
                        </div>
                        <div style="display:flex;gap:8px;align-items:center;">
                            <button class="qty-btn" @click="updateQty(ci, ci.quantity - 1)">-</button>
                            <span x-text="ci.quantity"></span>
                            <button class="qty-btn" @click="updateQty(ci, ci.quantity + 1)">+</button>
                        </div>
                    </div>
                </template>

                <div style="margin-top:16px;">
                    <input type="text" placeholder="Coupon code" x-model="couponCode">
                    <button class="secondary" style="width:100%;" @click="applyCoupon()">Apply Coupon</button>
                    <p class="error" x-show="couponError" x-text="couponError"></p>
                </div>

                <div style="margin-top:16px;border-top:1px solid #eee;padding-top:12px;">
                    <div class="row"><span>Subtotal</span><span x-text="'₹' + cart.subtotal"></span></div>
                    <div class="row" x-show="cart.discount > 0"><span>Discount</span><span x-text="'-₹' + cart.discount"></span></div>
                    <div class="row" style="font-weight:700;"><span>Total</span><span x-text="'₹' + cart.total"></span></div>
                </div>

                <button class="primary" style="margin-top:16px;" @click="goToAddress()" :disabled="!cart.items || cart.items.length === 0">
                    Proceed to Address
                </button>
            </div>
        </div>
    </template>

    <!-- ADDRESS / PLACE ORDER -->
    <template x-if="screen === 'address'">
        <div>
            <div class="topbar">
                <button class="secondary" @click="screen='cart'">← Back</button>
                <h1>Delivery Address</h1>
                <span></span>
            </div>
            <div class="screen">
                <template x-for="addr in addresses" :key="addr.id">
                    <div class="address-card" :class="selectedAddressId === addr.id ? 'selected' : ''" @click="selectedAddressId = addr.id">
                        <div style="font-weight:600;" x-text="addr.label"></div>
                        <div style="font-size:14px;color:#555;" x-text="addr.full_address"></div>
                    </div>
                </template>

                <div style="margin-top:12px;border-top:1px solid #eee;padding-top:12px;">
                    <div style="font-weight:600;margin-bottom:8px;">Add new address</div>
                    <input type="text" placeholder="Label (Home / Work / Other)" x-model="newAddress.label">
                    <input type="text" placeholder="Full address" x-model="newAddress.full_address">
                    <input type="text" placeholder="Landmark (optional)" x-model="newAddress.landmark">
                    <button class="secondary" style="width:100%;" @click="addAddress()">+ Save Address</button>
                </div>

                <p class="error" x-show="error" x-text="error"></p>
                <button class="primary" style="margin-top:16px;" :disabled="!selectedAddressId || loading" @click="placeOrder()">
                    <span x-text="loading ? 'Placing order...' : 'Place Order'"></span>
                </button>
            </div>
        </div>
    </template>

    <!-- ORDER CONFIRMATION -->
    <template x-if="screen === 'confirmation'">
        <div class="screen" style="text-align:center;padding-top:60px;">
            <div style="font-size:48px;">✅</div>
            <h1>Order Placed!</h1>
            <p style="color:#666;" x-text="'Order #' + lastOrder.order_number"></p>
            <button class="primary" style="margin-top:20px;" @click="goToOrders()">View My Orders</button>
        </div>
    </template>

    <!-- ORDER HISTORY -->
    <template x-if="screen === 'orders'">
        <div>
            <div class="topbar"><h1>My Orders</h1><span></span></div>
            <div class="screen">
                <template x-if="orders.length === 0"><p style="color:#666;">No orders yet.</p></template>
                <template x-for="order in orders" :key="order.id">
                    <div class="address-card" style="cursor:default;">
                        <div class="row">
                            <span style="font-weight:600;" x-text="'#' + order.order_number"></span>
                            <span class="status-badge" x-text="order.status.replaceAll('_',' ')"></span>
                        </div>
                        <div style="font-size:14px;color:#555;" x-text="'₹' + order.total + ' · ' + order.created_at.substring(0,10)"></div>
                    </div>
                </template>
            </div>
            <div class="bottom-nav">
                <button @click="goToMenuFromNav()">Menu</button>
                <button class="active">Orders</button>
                <button @click="goToAccount()">Account</button>
            </div>
        </div>
    </template>

    <!-- ACCOUNT -->
    <template x-if="screen === 'account'">
        <div>
            <div class="topbar"><h1>Account</h1><span></span></div>
            <div class="screen">
                <input type="text" placeholder="Name" x-model="profile.name">
                <input type="email" placeholder="Email (optional)" x-model="profile.email">
                <button class="secondary" style="width:100%;margin-bottom:16px;" @click="saveProfile()">Save Profile</button>

                <div style="font-weight:700;margin:16px 0 8px;">Saved Addresses</div>
                <template x-for="addr in addresses" :key="addr.id">
                    <div class="address-card" style="cursor:default;">
                        <div class="row">
                            <span style="font-weight:600;" x-text="addr.label"></span>
                            <button class="secondary" @click="deleteAddress(addr.id)">Delete</button>
                        </div>
                        <div style="font-size:14px;color:#555;" x-text="addr.full_address"></div>
                    </div>
                </template>

                <button class="primary" style="margin-top:20px;background:#dc2626;" @click="logout()">Logout</button>
            </div>
            <div class="bottom-nav">
                <button @click="goToMenuFromNav()">Menu</button>
                <button @click="goToOrders()">Orders</button>
                <button class="active">Account</button>
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

        get cartCount() {
            return (this.cart.items || []).reduce((sum, i) => sum + i.quantity, 0);
        },

        get otpCode() {
            return this.otpDigits.join('');
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
# Food Delivery PWA — Laravel Skeleton

This is a functional skeleton covering every phase from the blueprint:
customer OTP auth → menu → cart → coupons → address → order → order history →
account, plus a role-based admin panel (Super Admin / Menu Manager / Order Manager)
and a basic installable PWA shell.

This was hand-written (not run through `composer create-project`, since this
environment has no internet access) — you'll assemble it into a real Laravel
install in a few minutes using the steps below.

## 1. Create the Laravel project and drop these files in

```bash
composer create-project laravel/laravel food-delivery-app
cd food-delivery-app
composer require laravel/sanctum livewire/livewire spatie/laravel-permission
```

Then copy every file from this skeleton into the matching path in your fresh
Laravel install, **overwriting**:
- `bootstrap/app.php` - done 
- `config/auth.php` - done 
- `config/services.php` - done
- `routes/web.php`, `routes/api.php` -done 
- `database/seeders/DatabaseSeeder.php` done 

And **adding**:
- everything under `app/Models`, `app/Http/Controllers`, `app/Http/Middleware`,
  `app/Livewire`, `app/Services` done
- everything under `database/migrations`, `database/seeders/AdminSeeder.php` -> done
- everything under `resources/views`
- `public/manifest.json`, `public/sw.js`, `public/icons/`
- `config/permission.php`

## 2. Install Tailwind (used by the admin views and PWA shell)

```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```
Configure `tailwind.config.js` content paths to include
`./resources/**/*.blade.php` and `./app/Livewire/**/*.php`, and add the
Tailwind directives to `resources/css/app.css`.

## 3. Environment

Copy `.env.example` → `.env`, set your MySQL credentials, then:

```bash
php artisan key:generate
```

Leave `SMS_PROVIDER=log` for local development — OTPs are written to
`storage/logs/laravel.log` instead of being texted, so you can develop without
an SMS account. Switch to `twilio`/`msg91`/`fast2sms` in `OtpService::send()`
when you're ready to go live with a real provider.

## 4. Database

```bash
php artisan migrate
php artisan db:seed
```

This creates a default Super Admin:
- **email:** admin@example.com
- **password:** password123

**Change this password immediately** — there's no forced-reset flow yet, so do
it manually via the Admins screen or `php artisan tinker`.

## 5. Run it

```bash
npm run build   # or `npm run dev` while developing
php artisan serve
```

- Customer PWA: `http://localhost:8000/`
- Admin panel: `http://localhost:8000/admin/login`

To test the OTP flow: enter any phone number, then check
`storage/logs/laravel.log` for a line like `OTP for 9876543210: 4821` and type
that code in.

## 6. What's already wired up

- **Auth:** phone → OTP → Sanctum token (customer), email/password → session
  (admin, separate `admin` guard so it never collides with customer accounts).
- **Roles:** Super Admin / Menu Manager / Order Manager via
  `spatie/laravel-permission`, enforced both in route middleware
  (`EnsureAdminHasRole`) and hidden/shown in the sidebar.
- **Menu:** categories + food items + optional variants (e.g. Half/Full),
  managed via Livewire CRUD screens, served publicly at `GET /api/menu`.
- **Cart & coupons:** server-persisted cart per user, flat/percent coupons
  with min-order, max-discount, total-usage and per-user-usage limits.
- **Orders:** address selection → order creation → state-machine status
  transitions (`pending → confirmed → preparing → out_for_delivery →
  delivered`, with `cancelled` from early states), full status history log.
- **Order history & account:** customer can view past/current orders,
  edit name/email, and manage (add/edit/delete) saved addresses.
- **PWA:** installable manifest + a minimal service worker (caches the app
  shell, network-first for `/api/*` so data is never stale). Test the
  install prompt via Chrome DevTools → Application → Manifest, or the
  browser's "Install app" icon in the address bar (needs HTTPS in production —
  use `php artisan serve` + `ngrok`, or Laravel Valet, to test installability
  locally).

## 7. Deliberately left for you to decide later

- **Payment integration** — you said not needed yet; orders currently assume
  cash-on-delivery. Slot a payment gateway into `OrderController::store()`
  when ready.
- **Push notifications** for order status changes (Web Push / FCM).
- **Native app wrapping** — once the PWA works well in-browser, wrap it with
  **Capacitor** (recommended, minimal changes) or **PWABuilder** to publish to
  the Play Store / App Store.
- **Delivery fee logic** — currently hardcoded to 0 in `OrderController`.
- **Real SMS provider** — only a `log` driver is implemented; add your
  provider's HTTP call inside `OtpService::send()`.
- **Image storage** — uses local `storage/app/public` disk by default; switch
  to S3 or similar before production (`php artisan storage:link` needed
  either way for local image display).

## 8. Folder map

```
app/
  Http/Controllers/Api/     — customer-facing REST API (auth, menu, cart, orders, addresses, profile)
  Http/Controllers/Admin/   — admin session login/logout
  Http/Middleware/          — EnsureAdminHasRole (role-gated routes)
  Livewire/Admin/           — Dashboard, Categories, FoodItems, Coupons, Orders, Admins
  Models/                   — all Eloquent models
  Services/OtpService.php   — OTP generation + pluggable SMS sending
database/migrations/        — all tables (users, otps, admins, roles/permissions, menu, cart, orders...)
database/seeders/           — AdminSeeder creates the 3 roles + a default Super Admin
resources/views/
  pwa/index.blade.php       — the entire customer app (Alpine.js single-page shell)
  admin/login.blade.php     — admin login screen
  layouts/admin.blade.php   — admin sidebar layout
  livewire/admin/...        — Blade views for each Livewire admin screen
public/manifest.json, sw.js — PWA install + offline shell
routes/api.php, web.php     — all routes
config/auth.php             — adds the 'admin' guard/provider alongside default 'web'
config/services.php         — OTP length/expiry + SMS provider settings
config/permission.php       — spatie/laravel-permission config
```

# P2PTrack360 Service Manager — Architecture Review & Assessment

*Reviewed 16 Oct 2026. Snapshot: `Backend` @ **01d16c0** ("security changes", pushed 16 Oct 2026 11:17 UTC), `Frontend` @ 61f2de7, `service-manager-app` (`master`) @ 4534065 — github.com/ahaq-p2ptrack360.*
*Diagrams (Archify, source-cited, exportable): **P2PTrack360 Service Manager — System Architecture** and **Primary Runtime Flow — Create Ticket (Admin Web UI)**.*
*Supersedes the 12 Oct assessment. Companion docs: architecture.md, prd.md, rules.md, design.md (written against backend 7e0f625; their authentication sections are now out of date — see §1).*

Status labels: **Confirmed** = read in code at the snapshot · **Inferred** = strongly implied, not proven · **Unknown** = no evidence in any repo.

---

## 1. What changed since 12 Oct (backend 7e0f625 → 01d16c0)

| Area | Before | Now | Evidence |
|---|---|---|---|
| API authentication | Only `GET /api/user` guarded | 223 of 227 routes inside `Route::middleware(['auth:sanctum','tenant.context'])` | `backend/routes/api.php:47-360` |
| Login | Returned full `users` row, no token | Returns Sanctum token + 6 profile fields | `AuthController.php:66-101` |
| Tenant isolation | Client-supplied `company_id` / `user_id` | `TenantContext` overwrites actor + company (body, query and company-named path params); `TenantCompanyScope` filters Eloquent models | `Middleware/TenantContext.php:11-49`, `Models/Scopes/TenantCompanyScope.php` |
| Ticket create | Trusted all ids | Derives company/actor from token; checks BU, assignee, customer, vendor, status, type, priority, impact belong to caller (403) | `TicketController.php:47-96` |
| SQL injection (2 sites) | String concatenation | Bound parameters; semgrep rule + `composer security:sql` | `BusinessUnitController.php:116-148`, `DashboardController.php`, `.semgrep/rules/` |
| Backend `cookie.auth` | Logged in from `sso_token` cookie only | Compares `sha256(auth_token)` with `users.sso_token`, redirects on failure | `Middleware/SsoMiddleWare.php` |
| Admin web UI | — | Session login mints a Sanctum token; jQuery/fetch/axios add `Authorization: Bearer` on same-origin calls | `Auth/LoginController.php:97-102`, `partials/script.blade.php:58-91`, `layouts/master.blade.php` |

**Consequence (Confirmed in code, deployment Unknown):** the **web portal** (frontend repo, unchanged since 5 Jun) and the **mobile app** (unchanged) send no `Authorization` header. Against backend 01d16c0 every protected call they make returns **401**. Only the backend's own admin UI works end to end. If 01d16c0 is deployed, portal and mobile data screens are down.

---

## 2. Architecture overview

**Style: modular monolith.** One Laravel 8 API holds all business logic (raw SQL in ~30 controllers, no service layer). Around it: a backend-hosted Blade admin UI, a separate Laravel 11 web portal whose browser JavaScript calls the API directly, a Flutter client, and a separately deployed third-party chat app (InfyChat). Asynchrony is limited to Pusher broadcasts; queues run `sync`.

Primary runtime path (both diagrams): **Staff user → Admin web UI → API (Sanctum + TenantContext) → TicketController → MySQL → Pusher → open portals**, with synchronous SMTP side effects.

---

## 3. Component detail cards

### 3.1 Service Manager API (backend)
- **Responsibility:** system of record and all business rules — tickets, organisation (companies, BUs, groups, designations), master data, vendors/quotations, users/roles, dashboards, billing, notifications, imports.
- **Technology:** PHP `^7.0|^8.2.4`, Laravel `^8.75` (EOL), Sanctum, Passport (installed, unused), Jetstream, Livewire, Spatie Permission/MediaLibrary, maatwebsite/excel, Chatify.
- **Responsibilities:** 227 REST routes under `/api`, `throttle:api` (60/min), CORS `*`.
- **Inputs → outputs:** JSON/multipart over HTTPS (`demo.p2ptrack360.com:8888`) and HTTP (`3.137.76.254`) → JSON; SQL; Pusher events; SMTP mail; files on local disk.
- **Dependencies:** MySQL `ticketapp`, local storage, Pusher, SMTP.
- **Security:** token + tenant checkpoint on 223 routes. **Public:** `login`, `forgot_pass/{email}`, `reset/{email}`, `sendbasicemail/{email}/{username}`. No role/permission checks in controllers.
- **Evidence:** `backend/routes/api.php`, `app/Http/Kernel.php:43-46`, `config/cors.php:18-31`, `app/Http/Controllers/*`.

### 3.2 Auth + tenant checkpoint
- **Responsibility:** authenticate API callers and pin tenant/actor.
- **Technology:** Laravel Sanctum personal access tokens (`personal_access_tokens` migration present); `TenantContext` middleware; `BelongsToTenant` trait + `TenantCompanyScope`.
- **Behaviour:** company 0 = platform admin (unscoped). Tenant users: `user_id`, `created_by`, `generated_by`, `company_id` merged from the token; route params `companyId|company_id|c_id|cid`, `user_id|u_id`, and `{id}` on URIs containing "company" are overwritten.
- **Gaps:** the Eloquent scope does **not** apply to `DB::select/insert/update/delete`; 17 controllers use only raw SQL and have no tenant filter of their own. Tokens never expire (`sanctum.expiration = null`). No logout revocation for mobile/API tokens (only the admin web token is deleted on logout).
- **Evidence:** `TenantContext.php`, `TenantCompanyScope.php`, `Concerns/BelongsToTenant.php`, `config/sanctum.php:36-49`.

### 3.3 Admin web UI (backend Blade)
- **Responsibility:** legacy admin console served by the API host; today the only client that can call the protected API.
- **Technology:** Laravel UI/Jetstream session auth, Blade, jQuery, axios, Echo.
- **Inputs → outputs:** session login → Sanctum token in session → `<meta name="api-bearer-token">` and inline prefilters → same-origin AJAX with Bearer.
- **Security:** token exposed to page JavaScript (any XSS can read it); same-origin only. Pages behind `auth` + `tenant.context`.
- **Evidence:** `Auth/LoginController.php:97-102,129-170`, `resources/views/partials/script.blade.php:58-91`, `resources/views/Tickets/index.blade.php:554,1181-1189`.

### 3.4 Web Portal (frontend repo)
- **Responsibility:** customer/staff portal pages; real-time ticket toasts.
- **Technology:** Laravel 11, PHP 8.2, Blade, Bootstrap 5.3, Vite, jQuery, DataTables, laravel-echo + pusher-js; Vixon template.
- **Inputs → outputs:** local session login (portal DB) → browser AJAX to `{API_URL}` (27 views) → **401 now** (no token). Echo subscribes to public channel `tickets`.
- **Security:** `/api/proxy` open SSRF with TLS verification off; `/debug-session`, `/debug-auth`, `/debug-role` routes; portal `cookie.auth` never rejects (unchanged).
- **Evidence:** `frontend/routes/web.php`, `config/app.php:59`, `resources/js/app.js:1848-1860`, `app/Http/Controllers/ProxyController.php`, `app/Http/Middleware/CookieAuthMiddleware.php`.

### 3.5 Flutter mobile app (service-manager-app, `master`)
- **Responsibility:** login, dashboards, ticket lists, company profile, invoices, notifications, chat WebView.
- **Technology:** Flutter/Dart; http, dio, shared_preferences, webview_flutter, fl_chart, pdf/printing.
- **Inputs → outputs:** login over **plain HTTP** to `3.137.76.254`; REST to `:8888` and the raw IP; no token stored or sent → 401 after login.
- **Security:** plaintext password in SharedPreferences and in the chat URL query string.
- **Evidence:** `lib/main.dart:109-141`, `lib/tickets.dart:138-159`, `lib/chats.dart:31-33`, `lib/constant.dart`.

### 3.6 Business modules (TicketController and peers)
- **Responsibility:** domain logic per resource; raw SQL, little Eloquent.
- **Inputs → outputs:** validated request fields → SQL writes, events, mail.
- **Security:** tenant-aware: Ticket, User, Vendor, BusinessUnit, Dashboard, Invoice, Company (partly). Not tenant-aware: Role, Permission, Status, Priority, Impact, Type, Domain, Designation, BuGroup, GroupMember, BuField, Quote, Notification, UserNotification, SubscriptionPackage, Billing, Mail.
- **Evidence:** per-controller grep of tenant references vs raw DB calls; e.g. `RoleController.php:38-56`, `StatusController.php:28-56`.

### 3.7 Scheduler (privileged zone)
- **Responsibility:** `send:reminder` every minute, `invoices:generate-monthly` monthly, overdue sweep daily.
- **Security:** runs with full DB access outside request auth; cron entry not in any repo (**Unknown** whether active).
- **Evidence:** `app/Console/Kernel.php:16-33`, `Console/Commands/*`.

### 3.8 Data storage
- **MySQL `ticketapp`** (Confirmed): tickets, activity, assignment, replies, quotations, users, companies, BUs, vendors, customers, invoices, payments, notifications, `personal_access_tokens`. Views `vw_tickets`, `vw_quote`. No migrations for core tables; indexes/FKs **Unknown**.
- **Portal MySQL `vixon_laravel`** (Confirmed in config) — shared with `ticketapp` in production is **Unknown**.
- **InfyChat MySQL `chat-app`**; **local disk** `storage/app/public` for uploads (no S3).
- **Sensitive data:** plaintext passwords in `users.two_factor_secret`; `sso_token`; card last-4/holder/expiry in `payments`.

### 3.9 Runtime execution
- Synchronous PHP request per call (`QUEUE_CONNECTION=sync`); mail and broadcasts block the response. No transaction around multi-table ticket writes.

---

## 4. Primary runtime flow — create a ticket (Admin web UI)

| # | Component | Request / event | Data | Sync/async | State change |
|---|---|---|---|---|---|
| 1 | Staff user → Admin UI | Submit form | Title, description, BU, assignee, status, lookups, optional file | Sync | — |
| 2 | Admin UI → API | `POST /api/tickets` + `Authorization: Bearer` | multipart | Sync | — |
| 3 | Sanctum → MySQL | Token lookup | `personal_access_tokens` | Sync | `last_used_at` updated |
| 4 | TenantContext → TicketController | `store()` | actor/company pinned from token | Sync | 401 if no/invalid token |
| 5 | Controller → MySQL | Ownership checks | BU, assignee/group, customer, vendor, status, type, priority, impact | Sync | 403 if foreign |
| 6 | Controller → MySQL | INSERT `tickets`, `user_notifications` | ticket row; notification `is_read=false` | Sync | Ticket created with submitted `status_id` |
| 7 | Controller → Pusher | `ticket.created` | id, title, message, company_id | Async publish | — |
| 8 | Pusher → open portals | WebSocket | same payload, **public channel, all companies** | Async | — |
| 9 | Controller → MySQL | INSERT `ticket_activity`, `ticket_assigned_to` | Individual or Group | Sync | Assignment recorded |
| 10 | Controller → SMTP | Mail assignee, customer, vendors (if quotes allowed) | HTML bodies (title unescaped) | Sync, blocks reply | — |
| 11-12 | API → UI → user | `201 {success, id, assign}` | — | Sync | Table reloads |

Evidence: `TicketController.php:19-276`, `TicketCreatedNotification.php:37-66`, `frontend/resources/js/app.js:1848-1860`.

---

## 5. External dependencies & trust boundaries

### 5.1 External dependencies
| Dependency | Purpose | Protocol (verified) | Auth | Failure handling | Evidence |
|---|---|---|---|---|---|
| Pusher Channels | Ticket events; InfyChat messages | HTTPS server→Pusher, WSS to browsers (`useTLS: true`) | App key/secret (env) | None — sync broadcast | `config/broadcasting.php:33-41` |
| SMTP | Ticket, OTP, invoice, reminder, credential emails | SMTP | Env credentials | Ticket mail: try/catch + log; others unhandled | `.env.example:31-38`, `TicketController.php:176-254` |
| InfyChat (`:8080/chat`) | Chat | HTTPS iframe / WebView | Own login; mobile passes password in URL | — | `frontend/chat/`, `mobile-app/lib/chats.dart:31-33` |
| Public CDNs | jQuery, DataTables, icons, pdfmake | HTTPS | — | Pages break if CDN down | portal views |
| Maps (Mapbox / Google) | Template pages, mobile map widget | HTTPS | Keys not in repo | — | **Unknown** in production |
| Payment gateway | — | **None** — "stripe"/"paypal" stored as labels; card data posted to API | — | — | `PaymentController.php:22-127` |
| Hosting | `demo.p2ptrack360.com` (:8888 API, :8080 chat), AWS-range IP `3.137.76.254` | — | — | — | client code; no IaC/CI/CD |

### 5.2 Trust boundaries
| Boundary | Contains | Crossing | Controls verified |
|---|---|---|---|
| Public internet / client | Browsers (admin UI, portal), mobile app | HTTPS to `:8888`; **HTTP** to `3.137.76.254` | TLS on the hostname only |
| Edge / API boundary | API routes, Sanctum, TenantContext | REST + Bearer | Sanctum token, tenant pinning, 60/min throttle; CORS `*` |
| Application | Business modules | in-process | Ownership checks in 6-7 controllers; no RBAC |
| Privileged | Scheduler, platform admin (company 0) | cron / token | Company 0 bypasses tenant scope entirely |
| Data tier | MySQL, local disk | SQL / FS | Network isolation **Unknown** |
| Portal host | Portal server, portal DB | session cookie | Portal `cookie.auth` ineffective |
| Third parties | Pusher, SMTP, CDNs, InfyChat | TLS | Pusher TLS on; public channel |

**Sensitive cross-boundary flows:** passwords (public `forgot_pass` returns hash + plaintext copy; `sendbasicemail` emails a new password to any address); card numbers (browser → API, no gateway); ticket titles (Pusher public channel → every tenant); mobile credentials (HTTP, SharedPreferences, URL query).

---

## 6. Assessment

### 6.1 Strengths
- Real progress: authentication now gates the API, the actor/tenant comes from the token, the two SQL-injection sites are fixed, and a semgrep guard prevents regressions.
- Ticket creation validates that every referenced record belongs to the caller's company — the right pattern to copy to other writes.
- One backend serves all clients, so fixes land once; real-time notifications already work end to end.
- Automated monthly invoicing with transactions and idempotency.

### 6.2 Bottlenecks and single points of failure
- One API host (two entry points: `:8888` and the raw IP), one MySQL instance, local-disk uploads, an undocumented cron.
- Synchronous email fan-out inside requests (quotation requests to every vendor of a type) and synchronous Pusher calls — SMTP or Pusher latency becomes request latency or failure.
- Dashboard endpoints return unpaginated views (`vw_tickets`).

### 6.3 Scalability and performance
- Stateless token auth now makes horizontal API scaling possible, but sessions (DB), file cache, and local uploads must move to shared stores first.
- `QUEUE_CONNECTION=sync` caps throughput; queueing mail/broadcasts is the cheapest latency win.

### 6.4 Coupling and maintainability
- Raw SQL in controllers, no service layer, duplicated `* copy.php` models, three vendored chat apps, Laravel 8 (EOL) vs 11 on the portal, no tests, no CI, no migrations for core tables.
- Tenant safety now depends on each controller remembering to filter raw SQL — fragile without a shared repository layer or tests.
- Clients hard-code different base URLs; the real mobile code lives on `master`, while `main` is empty.

### 6.5 Findings and recommendations
Severity: Critical / High / Medium / Low. Effort: S = days, M = 1–3 weeks, L = 3+ weeks. Status vs 12 Oct: **New**, **Open**, **Partial**, **Fixed**.

| # | Finding | Evidence | Sev. | Effort | Status | Recommendation |
|---|---|---|---|---|---|---|
| R1 | **Public account takeover:** `GET reset/{email}` sets any user's password from request input; `GET sendbasicemail/{email}/{username}` resets a user's password and mails it to an arbitrary address | `api.php:44-45`, `UserController.php:30-35`, `MailController.php:16-30` | Critical | S | Open (now explicitly public) | Remove both; implement signed, expiring reset tokens (Laravel `Password::broker`) over POST |
| R2 | **Public credential leak:** `GET forgot_pass/{email}` returns `SELECT *` (hash, plaintext `two_factor_secret`, `sso_token`) | `api.php:43`, `UserController.php:25-29` | Critical | S | Open | Delete the route; never return `users.*` |
| R3 | **Clients broken by the auth change:** portal and mobile send no Bearer token → 401 | frontend views (27), `mobile-app/lib/*` | Critical (availability) | M | New | Portal: call `/api/login` at sign-in (or a server-side token exchange), store the token server-side, add the header in a jQuery prefilter. Mobile: store the token in `flutter_secure_storage`, send `Authorization`, HTTPS only. Ship clients before or with the backend |
| R4 | **Cross-tenant by-ID access in 17 raw-SQL controllers** (e.g. `DELETE roles/{id}`, `POST roles/{id}` re-assigns another tenant's role to the caller's company; same for status, priority, types, groups, quotes, notifications) | `RoleController.php:38-56`, `StatusController.php:28-56` | High | M | Partial | Add `company_id = ?` to every by-ID query (or move to Eloquent models with `BelongsToTenant`); add tenant-isolation tests per route |
| R5 | **Plaintext passwords still stored** in `users.two_factor_secret` (user create, profile update, onboarding, vendor create, Excel import); `reset_password` swaps hash/plaintext columns | `UserController.php:64,90,266`, `CompanyController.php:137`, `VendorController.php:167`, `UserImport.php:102` | Critical | S | Open | Stop writing the column, null existing values, send set-password links instead of passwords |
| R6 | No authorization (RBAC): any authenticated user can create/delete companies' master data, users, invoices | Spatie installed; no policy/Gate use in API controllers | High | M | Open | Policies per resource keyed on role permissions; restrict company-0 actions |
| R7 | Public broadcast channel leaks ticket titles to all tenants | `TicketCreatedNotification.php:59-63`, `TicketUpdatedNotification.php:67` | High | S | Open | `PrivateChannel('company.{id}')` + `routes/channels.php` authorization |
| R8 | Vendor quotation emails select vendors by type with no company filter | `TicketController.php:242` | Medium | S | New | Add `company_id` filter |
| R9 | Portal open SSRF proxy and debug routes; portal `cookie.auth` ineffective | `ProxyController.php`, `frontend/routes/web.php:53-93`, `CookieAuthMiddleware.php` | High | S | Open | Remove proxy and debug routes; fix or replace the middleware |
| R10 | Mobile: HTTP to raw IP, plaintext password storage, password in chat URL | `main.dart:109-117`, `chats.dart:31-33` | High | S | Open | HTTPS single base URL, secure storage, token handoff to chat |
| R11 | Card data handled without a gateway | `PaymentController.php:22-127` | High | M | Open | Hosted checkout (Stripe/PayPal) + webhooks |
| R12 | Tokens never expire; API/mobile tokens not revoked on logout; admin token readable by page JS | `config/sanctum.php:49`, `layouts/master.blade.php` | Medium | S | New | Set `expiration`, revoke on logout (`logout/{id}` → current token), consider HttpOnly cookie SPA auth for same-origin admin |
| R13 | CORS `*` on all paths | `config/cors.php:18-31` | Medium | S | Open | Allow-list portal and app origins |
| R14 | Verbose 500s (exception text), unescaped HTML email, `debug.log` committed | `TicketController.php:263-275` | Medium | S | Open | Generic errors; Blade mailables; remove file |
| P1 | Synchronous mail/broadcast; no transactions on ticket writes | `.env.example:21`, `TicketController::store` | Medium | S | Open | Redis/DB queue + worker; `DB::transaction` |
| P2 | Infrastructure SPOFs, no IaC/CI/backups/monitoring | no infra code | Medium | M–L | Open | Managed MySQL + backups, S3, 2+ API nodes behind a load balancer, containerise, CI with tests and semgrep |
| M1 | Maintainability debt (raw SQL, EOL Laravel 8, no tests, dead copies, vendored chat ×3, no core migrations) | repo trees | Medium | L | Open | Service/repository layer, schema migrations from production, Laravel 11 upgrade, PHPUnit tenant tests |
| — | SQL injection (2 sites) | `BusinessUnitController.php`, `DashboardController.php` | — | — | **Fixed** | Keep the semgrep rule in CI |
| — | Unauthenticated API (except 4 routes) | `api.php:47-360` | — | — | **Fixed** | — |
| — | Login returned full user row | `AuthController.php:66-101` | — | — | **Fixed** | — |

### 6.6 Suggested order
1. **Now (days):** R1, R2, R5 (credential exposure), then R3 so portal and mobile work again — or hold the 01d16c0 deploy until R3 ships.
2. **Next 1–2 weeks:** R4 (tenant filters on every raw query, with tests), R7, R8, R9, R10, R12, R13, R14.
3. **Next 2–4 weeks:** R6 (policies), P1.
4. **Quarter:** R11, P2, M1.

---

## 7. Confirmed vs inferred vs unknown
- **Confirmed:** every component, arrow and finding above, cited to files/lines at the snapshot; 227 API routes, 4 public.
- **Inferred:** `:8888` and `3.137.76.254` serve the same backend; portal pages currently fail with 401 *if* 01d16c0 is deployed.
- **Unknown:** whether 01d16c0 is deployed; TLS termination and reverse proxy; DB network isolation; whether portal and API share a database; scheduler cron; backups and monitoring; maps keys in production.

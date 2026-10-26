# P2PTrack360 Service Manager — Architecture Review & Assessment

*Reviewed 21 Oct 2026, 23:00 CDT. Snapshot: `Backend` @ **d34a63a** ("High Risk Issues", 16 Oct 12:35 UTC) · `Frontend` @ e145c21 (unchanged since 16 Oct) · `service-manager-app` (`master`) @ 4534065 (unchanged) — github.com/ahaq-p2ptrack360.*
*Supersedes the 16 Oct review (backend 67d20e7). Archify diagrams ("System Architecture", "Primary Runtime Flow — Create Ticket") still reflect backend 01d16c0 and do not show the portal AI agent, ticket sharing, or the private broadcast channels.*

Status labels: **Confirmed** = read in code at the snapshot · **Inferred** = strongly implied, not proven · **Unknown** = no evidence in any repo.

---

## 1. Executive summary

Backend commit d34a63a closes two High findings in code. Ticket broadcasts now go to a **private per-company channel**, and **seven more controllers** (roles, permissions, status, priority, impact, types, designations) only read their own company's records plus shared system records, and only write their own. The global permission list can now be changed only by platform admins: the first role check in the API.

Three things keep the overall risk high:

1. **The portal was not touched, so its Critical findings remain:** anyone can query any company's tickets through the AI agent (F1), every page writes the user's `two_factor_secret` into JavaScript (F2), share links are unprotected (F3), and the portal's login check never rejects anyone (R9b).
2. **Real-time notifications are now off for everyone.** The private channel's authorization route is never registered (`App\Providers\BroadcastServiceProvider` is commented out), and the portal still listens on the old public `tickets` channel. The cross-tenant leak is closed, but no client receives ticket events (F8).
3. **Eight backend controllers are still exposed across tenants.** Most serious: any tenant user can edit or delete the **platform-wide subscription plans** and **domains**, and delete other companies' BU groups and group members (R4, F9).

---

## 2. What changed since the last review

### 2.1 Backend 67d20e7 → d34a63a ("High Risk Issues")
| Change | Evidence | Effect |
|---|---|---|
| `TicketCreatedNotification` / `TicketUpdatedNotification` broadcast on `PrivateChannel('company.{companyId}')` instead of public `tickets` | `app/Events/TicketCreatedNotification.php`, `TicketUpdatedNotification.php`; callers pass the company at `TicketController.php:144,450` | Closes the cross-tenant leak (R7) |
| Channel authorization: user may join `company.{id}` if it is their company or they are platform admin (company 0) | `routes/channels.php` | Correct rule, but **not loaded** (see F8) |
| New trait `ScopesTenantCompanyData`: `tenantCompanyId()` returns the caller's company (request value only for platform admins); `scopeVisibleCompanyData()` = own company **or** system rows (company 0); `scopeWritableCompanyData()` = own company only | `app/Http/Controllers/Concerns/ScopesTenantCompanyData.php` | Reusable tenant pattern for raw-SQL controllers |
| Applied to Role, Permission, Status, Priority, Impact, Type, Designation: reads scoped visible, updates/deletes scoped writable with 404 when not owned, inserts use the caller's company | `RoleController.php`, `StatusController.php`, `PriorityController.php`, `ImpactController.php`, `TypeController.php`, `DesignationController.php`, `PermissionController.php` | Closes 7 of the 16 remaining R4 controllers |
| Global `permissions` create/update/delete restricted to platform admins (403 otherwise); role-permission assignment requires the role to belong to the caller | `PermissionController.php:20-63,65-80` | First authorization check (R6 partial) |

### 2.2 Frontend and mobile
No new commits since e145c21 (frontend) and 4534065 (mobile). All portal and mobile findings from 16 Oct stand unchanged.

---

## 3. Architecture overview (current)

**Style: modular monolith with a portal that has its own data access.** The Laravel 8 API is the system of record and the main tenant-enforcement point. The Laravel 11 portal serves pages, runs an AI agent that queries the `tickets`, `status`, `priority` and `vendors` tables directly, calls a local LLM (Ollama), and fetches tickets from the API server-side for share pages.

```
Browser ─► Portal (Laravel 11) ─┬─► MySQL (tickets…)            direct reads; company_id from request (F1)
                                ├─► Ollama (LLM)
                                └─► Backend API /tickets/{id}   server-side, no token → 401
Browser ─► Backend API (Sanctum + TenantContext) ─► MySQL, SMTP, disk
                                                 └► Pusher private company.{id}  ✗ no /broadcasting/auth (F8)
Portal Echo ─► Pusher public 'tickets'  ✗ nothing broadcast there any more
Admin UI (backend Blade) ─► Backend API (Bearer, same origin)    ← only fully working client
Mobile ─► Backend API (no token → 401)
```

**Inferred:** the portal and the API share the `users` and `tickets` tables in production (the portal reads `two_factor_secret` and `tickets` directly; the example config names a separate DB, `vixon_laravel`).

---

## 4. Component detail cards

### 4.1 Service Manager API (backend @ d34a63a)
- **Responsibility:** system of record and business rules: tickets, organisation, master data, vendors/quotations, users/roles, dashboards, billing, notifications, imports.
- **Technology:** PHP, Laravel `^8.75` (EOL), Sanctum, Spatie Permission (installed), maatwebsite/excel, Pusher, SMTP.
- **Inputs → outputs:** 224 REST routes; JSON/multipart → JSON, SQL, Pusher events, email, local files.
- **Security in place:** 223 routes inside `['auth:sanctum','tenant.context']` (`routes/api.php:44`); only `POST login` public. Actor/tenant pinned from the token. Ticket create checks ownership of related records. Tenant scoping in Ticket, User, Vendor, BusinessUnit, Dashboard, Invoice, Company (partly) and now Role, Permission, Status, Priority, Impact, Type, Designation. Private per-company broadcast channels. Platform-admin check on global permissions.
- **Still open:** 9 controllers have no tenant checks of their own (§6.2 R4). `UserNotification` is covered because the middleware overwrites `user_id`, which leaves 8 exposed: **BuGroup, GroupMember, BuField, Domain, SubscriptionPackage, Quote, Notification, Billing**. `DashboardController::notifyemail` is also unscoped. No general RBAC; tokens never expire; CORS `*`; broadcasting auth not registered.
- **Evidence:** `backend/routes/api.php`, `app/Http/Middleware/TenantContext.php`, `app/Http/Controllers/Concerns/ScopesTenantCompanyData.php`, `config/sanctum.php:49`, `config/cors.php`, `config/app.php:178`.

### 4.2 Real-time notifications (Pusher)
- **Responsibility:** push `ticket.created` / `ticket.updated` to open browsers.
- **Now:** server publishes to `private-company.{id}`. Clients must call `/broadcasting/auth` to subscribe. That route comes from `Broadcast::routes()` in `App\Providers\BroadcastServiceProvider`, which is **commented out** in `config/app.php:178`, so `routes/channels.php` is never loaded. The only subscriber in code, the portal (`frontend/resources/js/app.js:1854,1862`), still uses `Echo.channel('tickets')`, and the portal has no backend token to authorize a private channel.
- **Result:** no cross-tenant leak, and also no notifications delivered. Note `BROADCAST_DRIVER=log` in `.env.example`; the production driver is **Unknown**.

### 4.3 Web Portal (frontend @ e145c21, unchanged)
- **Responsibility:** portal pages, dashboards/reports, AI agent, ticket sharing, embedded chat.
- **Technology:** Laravel 11, PHP 8.2, Blade, Bootstrap 5.3, Vite, jQuery, Echo.
- **Security:** `cookie.auth` (`CookieAuthMiddleware.php:20-52`) does not verify `auth_token`, passes requests with no cookies, and rotates `sso_token` on every request. Debug routes `/debug-role`, `/debug-auth`, `/debug-session`, `/api/check-session` public (`routes/web.php:64-120`). Catch-all `{any}` renders any existing view by path (`HomeController.php:33-34`).

### 4.4 AI agent (portal)
- **Design:** an LLM-generated JSON plan → `QueryValidator` allow-list → `QueryExecutor` (query builder, bound values, `limit(50)`). The LLM never writes SQL.
- **Gaps:** `company_id`/`user_id` taken from the request before the session user (`AIQueryController.php:44-46`); anonymous access possible through `cookie.auth`; executed SQL returned to the client; `GET /api/ai/conversations` lists every user's conversations when unauthenticated (`AgentChatController.php:96-104`); `verify => false` on outbound provider calls.

### 4.5 Ticket share pages (portal)
`/ticket/{id}?expires=<unix>`: the expiry is computed in the sender's browser (`index.blade.php:2914`) and not signed. `/public/tickets-view?id=` has no check. Both fetch `GET {api}/tickets/{id}` without a token, so they return 401 today.

### 4.6 Flutter mobile app (unchanged)
Login over plain HTTP to `3.137.76.254`; no token stored or sent (401 after login); plaintext password in SharedPreferences and in the chat URL (`mobile-app/lib/main.dart:109-141`, `lib/chats.dart:31-33`).

### 4.7 Admin web UI (backend Blade)
The only client that sends Bearer tokens (same origin); the token is readable by page JavaScript (`backend/resources/views/partials/script.blade.php:58-91`). It does not subscribe to any broadcast channel.

### 4.8 Data storage
- **MySQL `ticketapp`:** system of record; `personal_access_tokens`; `users.two_factor_secret` cleared by migration `2026_10_16_000001` once run.
- **Portal tables:** `ai_conversations`, `ai_messages` (question, answer, plan, result rows, SQL).
- **`password_resets`:** required by the reset-link flow; **no migration in the repo** (Unknown in production).
- **Shared/system rows:** `company_id = 0` rows in status, priority, impacts, types, designations, roles are now visible to every tenant and writable only by platform admins. This is a deliberate model; document it.

### 4.9 External dependencies
| Dependency | Protocol | Notes |
|---|---|---|
| Pusher Channels | HTTPS (server), WSS (clients) | Now private channels; client authorization not available (F8) |
| SMTP | SMTP | Ticket, OTP, invoice, reset-link emails |
| Ollama / optional hosted LLM | HTTP `127.0.0.1:11434` / HTTPS + API key | Portal AI agent; TLS verification off for remote providers |
| InfyChat `:8080/chat` | HTTPS iframe / WebView | Auto-login uses `two_factor_secret` (F2) |
| CDNs | HTTPS | — |
| Payment gateway | — | Still none |

---

## 5. Trust boundaries

| Boundary | Contains | Crossing | Controls verified |
|---|---|---|---|
| Public internet / client | Browsers, mobile | HTTPS (hostname), **HTTP** (raw IP) | — |
| **Portal edge** | Portal pages, AI API, share pages | session/cookie | `cookie.auth` **never rejects**; share pages public; debug routes public |
| Portal → data | Portal → MySQL `tickets`… | SQL | Scoped by a client-controlled `company_id` |
| Portal → LLM | Ollama / hosted provider | HTTP(S) | No TLS verification for remote providers |
| API edge | Backend routes | REST + Bearer | Sanctum + TenantContext on 223/224 routes |
| Application | Business modules | in-process | Tenant scoping in 14 controllers; 8 exposed; platform-admin check on permissions only |
| **Real-time** | Pusher private `company.{id}` | WSS + channel auth | Rule written (`channels.php`), route not registered |
| Privileged | Scheduler; platform admin (company 0) | cron / token | Company 0 bypasses tenant scope; global plans/domains **not** restricted to it (F9) |
| Data tier | MySQL, disk | SQL/FS | Network isolation Unknown |
| Third parties | Pusher, SMTP, InfyChat, CDNs | TLS | — |

---

## 6. Findings and recommendations

Severity: Critical / High / Medium / Low · Effort: S = days, M = 1–3 weeks, L = 3+ weeks · Status vs 16 Oct review: **New / Open / Partial / Fixed**.

### 6.1 New in this review
| # | Finding | Evidence | Sev. | Effort | Recommendation |
|---|---|---|---|---|---|
| **F8** | **Real-time notifications broken for all clients.** Events now go to private `company.{id}` channels, but `BroadcastServiceProvider` (which registers `/broadcasting/auth` and loads `routes/channels.php`) is commented out; the portal still subscribes to the public `tickets` channel and has no token to authorize a private one. | `backend/config/app.php:178`, `app/Providers/BroadcastServiceProvider.php:17-19`, `routes/channels.php`, `frontend/resources/js/app.js:1854,1862` | High (availability) | S–M | Enable `App\Providers\BroadcastServiceProvider` with `Broadcast::routes(['middleware' => ['auth:sanctum']])`; switch clients to `Echo.private('company.' + companyId)` with an `authorizer` that sends the Bearer token (depends on R3 for the portal) |
| **F9** | **Tenant users can change platform-wide data:** any authenticated user can update or delete subscription plans (price, licences, storage) and global domains. | `SubscriptionPackageController.php:32-44`, `DomainController.php:39-50,82-90`; routes `api.php:178-180` | High | S | Apply the same platform-admin check used in `PermissionController` (`company_id === 0`) to all writes on global tables; move it into a reusable gate or middleware |

### 6.2 Carried forward
| # | Finding | Evidence | Sev. | Effort | Status | Recommendation |
|---|---|---|---|---|---|---|
| R7 | Public Pusher channel leaked ticket titles to all tenants | `app/Events/Ticket*Notification.php` | — | — | **Fixed in code** (d34a63a) | Finish with F8 so notifications work again |
| R4 | Cross-tenant by-ID access in raw-SQL controllers | Fixed: Role, Permission, Status, Priority, Impact, Type, Designation. **Remaining (8 exposed):** `BuGroupController.php:50-66` (update/delete any group), `GroupMemberController`, `BuFieldController`, `DomainController`, `SubscriptionPackageController`, `QuoteController`, `NotificationController`, `BillingController`; plus `DashboardController.php:451-460` (`notifyemail` echoes any ticket). `UserNotificationController` is covered by middleware pinning `user_id` | High | S–M | **Partial** (7 of 16) | Apply `ScopesTenantCompanyData` to the remaining controllers; add one tenant-isolation test per by-ID route |
| R6 | No authorization (RBAC) in API controllers | First check: `PermissionController.php:20-63` (platform admin only) | High | M | **Partial** | Policies per resource from role permissions; platform-admin gate for global tables (F9) |
| R1, R2 | Public password reset / `forgot_pass` leak | — | — | — | Fixed (67d20e7) | — |
| R5 | Plaintext passwords stored and emailed | migration `2026_10_16_000001` | — | — | Fixed in code; data cleared when the migration runs | Run the migration everywhere |
| R9a | Portal open SSRF proxy | — | — | — | Fixed (e145c21) | — |
| **F1** | **Unauthenticated cross-tenant data access via the AI agent** (`POST /api/ai/query/plan` with any `company_id`) | `frontend/routes/api.php:25-35`, `AIQueryController.php:44-46`, `QueryExecutor.php:15-60` | **Critical** | S | Open | Require auth; always use `Auth::user()` company; stop returning SQL |
| **F2** | **`two_factor_secret` (legacy plaintext password) written into every portal page** for chat auto-login | `frontend/resources/views/layouts/master.blade.php:214-215,302-310` | **Critical** | S | Open | Remove now; SSO/token handoff to InfyChat |
| **R9b** | Portal `cookie.auth` never rejects; debug routes public; catch-all view route | `CookieAuthMiddleware.php:20-52`, `routes/web.php:64-127` | **Critical** | S | Open | Laravel `auth` middleware or verified token; delete debug routes |
| R3 | Portal and mobile send no API token → 401 on protected calls | `frontend/resources/views/*`, `mobile-app/lib/*` | Critical (availability) | M | Open | Token exchange at portal login; mobile secure storage + header; HTTPS |
| F3 | Ticket share links: unsigned client-side expiry; public by-id view | `routes/web.php:22-28`, `TicketShareController.php:12-104`, `index.blade.php:2914` | High | S | Open | `URL::temporarySignedRoute()` or random share tokens |
| F4 | AI conversations listable/readable when unauthenticated; stored result rows and SQL | `AgentChatController.php:96-147` | High | S | Open | Fixed with F1 + user/company filters |
| R10 | Mobile plaintext HTTP and credential storage | `main.dart`, `chats.dart` | High | S | Open | HTTPS, secure storage, token handoff |
| R11 | Card data without a payment gateway | `PaymentController.php` | High | M | Open | Hosted checkout + webhooks |
| R8 | Vendor quote emails select vendors by type with no company filter | `TicketController.php:242` | Medium | S | Open | Add company filter |
| F5 | TLS verification disabled on AI provider calls | `AgentChatController.php:72,160,186,213,256` | Medium | S | Open | Remove `verify => false` |
| F6 | `password_resets` migration missing for reset-link flow | `backend/database/migrations/` | Medium | S | Open | Add migration; test end to end |
| F7 | Portal queries core tables directly, bypassing API tenant logic | `frontend/app/AI/QueryExecutor.php` | Medium | M | Open | Move AI queries behind API endpoints, or read-only DB user + shared scoping |
| R12 | Sanctum tokens never expire; API logout doesn't revoke | `config/sanctum.php:49` | Medium | S | Open | Set expiration; revoke on logout |
| R13 | CORS `*` | `backend/config/cors.php` | Medium | S | Open | Allow-list origins |
| R14 | Verbose 500s, unescaped HTML email, committed `debug.log` | `TicketController.php:263-275` | Medium | S | Open | Generic errors; Blade mailables |
| P1 | Sync mail/broadcast; no transactions on ticket writes | `.env.example`, `TicketController::store` | Medium | S | Open | Queue + worker; `DB::transaction` |
| P2 | Infra SPOFs; no IaC/CI/backups/monitoring | — | Medium | M–L | Open | Managed DB, S3, LB, CI with tests + semgrep |
| M1 | Maintainability (raw SQL, Laravel 8 EOL, no core migrations, dead copies, vendored chat ×3) | repo trees | Medium | L | Open | Service layer, migrations, upgrade, tests |

### 6.3 Suggested order
1. **Now (hours, portal):** F1 + R9b together (real auth on portal routes; drop client `company_id`/`user_id`); remove F2's line; delete debug routes. Run the backend `two_factor_secret` migration.
2. **This week (backend, small):** F9 (platform-admin gate on global tables), finish R4 with `ScopesTenantCompanyData` on the 8 remaining controllers, R8, R12, R13, F6.
3. **Next 1–2 weeks:** R3 (portal and mobile tokens), then F8 (enable broadcasting auth and private-channel subscriptions, which needs R3), F3, F4, F5.
4. **Following weeks:** R6 policies, F7 decision, P1.
5. **Quarter:** R11, P2, M1.

---

## 7. Strengths
- The backend's tenant model is now consistent and reusable: `TenantContext` pins the actor, `ScopesTenantCompanyData` gives raw-SQL controllers a one-line way to scope reads and writes, and updates/deletes return 404 for records the caller does not own.
- Shared system records (company 0) are an explicit, sensible model: visible to all tenants, writable only by platform admins.
- Broadcast design is now correct (private per-company channels with an authorization rule); only the wiring and clients remain.
- Credential handling is sound: no public password routes, no plaintext storage, reset links instead of emailed passwords.
- The AI agent's plan → allow-list → query builder pattern is safe once authentication is enforced.

## 8. Confirmed vs inferred vs unknown
- **Confirmed:** all findings above, cited to files/lines at backend d34a63a, frontend e145c21, mobile 4534065. Backend has 224 API routes; only `login` is public; 14 controllers apply tenant scoping, 1 is covered by middleware, and 8 remain exposed.
- **Inferred:** portal and API share the `users`/`tickets` tables in production; F1 is exploitable wherever the portal and Ollama are reachable.
- **Unknown:** which commits are deployed; whether the `two_factor_secret` migration has run; whether `password_resets` exists; production broadcast driver; Ollama host and exposure; TLS termination, DB network, backups, monitoring.

# Product Requirements Document — P2PTrack360 Admin Portal

**Status:** Draft for implementation and stakeholder validation  
**Prepared:** 2026-10-23  
**Product being specified:** Admin3 web frontend portal  
**Backend dependency:** Service-Manager-main-Work APIs only  
**Purpose:** Use this document to recreate the Admin3 website and its user-facing features. It is not a PRD for rebuilding the backend API.

> This PRD is grounded in the Admin3 routes, Blade views, JavaScript, controllers, and configuration. Visible UI is evidence of intended portal scope, not proof that every API operation currently works. API contracts, permission rules, and several business behaviors must be validated before implementation.

## 1. Product summary

Admin3 is a browser-based, authenticated service-management portal for company/platform administrators and operations staff. It presents dashboards, ticket management, reporting, organization and user configuration, vendors/quotations, subscriptions/company billing, and a ticket-focused AI assistant.

Admin3 owns the portal experience: navigation, page layouts, forms, tables, client-side interactions, local login/session handling, AI chat screens and conversation persistence. Service-Manager-main-Work is an external business API dependency for the portal's main service-management data and actions. It is not a second frontend to be included in this website scope.

The portal also uses or references third-party/local services for AI, maps, company images, and a separate chat iframe. These should be implemented behind configurable integration boundaries, not hard-coded as assumptions.

## 2. Product goals

1. Recreate the Admin3 portal's authenticated layouts, navigation, pages, forms, tables, modals, filters, exports, and user workflows.
2. Let authorized users monitor and manage service tickets from a dashboard and ticket workspace.
3. Let administrators manage company structure, service configuration, users, vendors, roles, and permissions.
4. Support reports, saved views, quotations, company profile, subscriptions, invoices, and imports where enabled by the API.
5. Provide a focused AI Agent experience for authorized ticket analytics, with conversation history and supported visualizations.
6. Keep API and third-party integrations configurable, testable, and replaceable without redesigning the portal.
7. Preserve role-aware navigation and actions, responsive behavior, and clear loading, empty, success, and failure states.

## 3. Product boundary

### In scope: Admin3 frontend

- Browser UI, authenticated routes, shared shell/sidebar/topbar, page-level navigation, and responsive layouts.
- Portal forms, tables, modals/offcanvas panels, filtering, search, pagination, exports, and client-side visualization behavior evidenced by Admin3.
- Login, registration view, password recovery views, and cookie/session-authenticated page access as applicable to the approved auth design.
- Calls from portal pages to the backend API for business data and mutations.
- Admin3's local AI query/conversation endpoints and their user-facing experience.
- External chat iframe and Maps/image integrations only if approved for the recreation.

### Out of scope: backend rebuild

- Reimplementing Service-Manager-main-Work ticket, company, user, billing, or other domain APIs.
- Replacing its database, business rules, persistence, mail delivery, or payment processing.
- Assuming that UI controls prove backend completion or that a displayed payment action is a live payment gateway.
- Building mobile native applications or requester/vendor portals not evidenced in Admin3.

### Backend/API dependency contract

The portal shall treat the service-management API as an independently deployed dependency. API base URL, authentication, timeouts, upload limits, error format, pagination, filtering, and endpoint schemas must be configurable/documented. API credentials and trusted tenant identity must not be exposed in browser code. If the current design calls the API directly from browser scripts, the rebuild should preserve it only after its authentication/CORS/security model is confirmed; otherwise use a secure server-side adapter/BFF.

## 4. Users and access model

| Portal user | Main portal needs | Evidence/qualification |
|---|---|---|
| Super Admin / platform administrator | Company-wide administration, profile/permission tools, company records, broad visibility | Admin3 shows special Super Admin branches and company ID `0`; exact authority needs confirmation. |
| Company administrator | Manage company profile, users, configuration, teams, tickets, and reports for their company | Inferred from navigation, forms, and tenant-aware fields. |
| Operations/support staff | Review dashboard and tickets, update assigned work, communicate, use reports | Inferred from ticket filters and assignment controls. |
| Billing operator | Manage package, invoice, payment-record and reminder UI | UI exists; role boundary and actual payment behavior need confirmation. |
| Requester/customer or vendor | No confirmed standalone portal in Admin3 | Customer/vendor records appear in management forms; external access is not a confirmed requirement. |

The portal shall use the permission response for role-aware menus and actions, while backend authorization remains authoritative. Admin3 exposes page/action permissions such as Create, Read, Update, and Delete. Exact role names, permission mapping, and company scope are open decisions.

## 5. Information architecture and route inventory

### Main authenticated navigation

The primary sidebar contains the following product areas, with labels and visibility subject to the user's company and permission response:

- Dashboard
- Types, Status, Priority, Impact
- Business Unit
- Groups: Assign Group and Create Group
- Vendors
- Quotations
- Subscription Package
- Tickets
- Reports
- AI Agent
- Domains
- Companies
- User Management: Users, Accounts/Customers, Designations
- Super Admin-only: Profile/Roles and Permissions

The shared shell includes a topbar with global search and layout/navigation controls, a profile area where applicable, and a floating Chat control that opens a separate chat experience. Sidebar filtering must be driven by the authenticated user's permissions; do not rely on hiding controls alone for security.

### Key routes/pages observed

`/` (authenticated index/dashboard), `/dashboard`, `/ticket`, `/status`, `/priority`, `/impact`, `/buisness-unit`, `/assign-group`, `/create-group`, `/vendor`, `/subscription`, `/domain`, `/company`, `/company-profile`, `/user`, `/designation`, `/customer`, `/types`, `/permissions`, `/roles`, `/reports`, `/quotations`, `/agent-chat`, `/ticket/{id}`, and `/public/tickets-view?id=...`.

The current app has route/view naming mismatches (including dashboard and quotation/report links) and a catch-all view route. A recreation should use canonical, consistent route names and avoid exposing arbitrary template views via a catch-all.

## 6. User journeys and detailed portal requirements

### 6.1 Sign-in and account access

- Provide a branded login page with email, password, password visibility, and Remember me option.
- Provide the registration and password reset/recovery screens if approved for the target release.
- Protect portal pages and redirect unauthenticated users to login; preserve/expire sessions according to the approved authentication contract.
- Show clear validation and API/authentication errors without exposing secrets.
- Confirm whether email verification, two-factor/OTP, public registration, and cookie-based API login are required. Existing scaffolding alone does not establish product policy.

### 6.2 Dashboard

**Page content and interactions evidenced:**

- KPI cards for Total, Pending, and Completed tickets, including a percentage comparison with the previous week.
- Date presets: Daily, Weekly, Monthly, Quarterly, Yearly.
- Charts for ticket totals/trends, status, priority, impact, issue type, and completion.
- Ticket table with ID, Company, Title, Description, Status, Priority, Impact, Created At, and actions.
- Tabs/panels for Upcoming Deadlines, Top Creators, and Reported By.
- Profile scope selector: All, Created By Me, Assigned to Me.
- Date field selection (Created At or Completed Date), date inputs, account selection, and date-range filter panel.
- Save, load, apply, and delete dashboard filter/view operations.

**Acceptance:** Changing date/profile/account filters refreshes the relevant KPIs, charts, and ticket rows consistently; saved views can be managed according to permissions; loading, empty, and error states are visible. Calculation definitions and comparison-period semantics must be confirmed with the API/product owner.

### 6.3 Ticket list and create/edit

**List controls:**

- Status quick filters: All, Open, Resolved, Pending, Closed.
- Date-range picker and filter panel for Agent (Created By Me, Assigned To Me, Assigned By Me), Priority, Type, and Impact.
- KPI cards: Total, Closed, Open, Pending, Resolved.
- Ticket table with ticket number, title, issue type, reported/created date, company, completion date, due date, business unit/store, priority, impact, description, status, and row actions.
- Search, pagination, and Copy/Excel/CSV/PDF/Print export controls, subject to approved data-export rules.
- Permission-aware Add and Edit actions.

**Create/edit form fields evidenced in Admin3:**

- Generated/disabled ticket number and creator.
- Individual or group assignment; assignee; reporter.
- Problem/title; complaint mode; issue type and subtype; resolver and resolved date.
- Status, priority, business unit/store, account/customer, vendor, due date, impact.
- Store details/contact, store manager, marketing manager, quotation permission.
- Description, attachments, and domain-configured dynamic fields.
- Conditional store-related fields based on domain eligibility.

**Acceptance:** Required fields, selectors, conditional visibility, field validation, and create/update payloads match the agreed API contract. Multipart uploads show progress or a clear result and enforce server-provided limits. Successful mutations refresh affected data; failures retain user input and explain what needs correction.

### 6.4 Ticket detail, activity, and replies

Provide a ticket detail/share view with tabs for Detail, Quotation, and Activity. Detail content includes ticket identity, creator, assignee, reporter, description, complaint mode, subtype, resolver, status, resolved date, priority, business unit/store, account, due date, impact, store contact, company, vendor/vendor type, and files where authorized.

The activity tab shows a chronological timeline. The conversation/replies area supports composing a reply with rich-text editing and acknowledgment/resolution templates. Attachment behavior must be verified because the current attachment input appears disabled/commented out in the inspected markup. Ticket update and file access must be authorization-checked.

### 6.5 Reports and saved views

Provide a report builder with:

- Available field selection and grouping controls.
- Filter builder and ownership scope (Assigned To Me, Created By Me, All).
- Saved-view create/list/load/apply/delete operations.
- Optional subtotals, exports, and chart setup (chart type, X axis, Y axis).
- Report table fields including ticket/company/business unit/reporter/type/status/priority/impact/description/complaint mode/store contact, relevant contact/address data, and quotation amount/description/approver where supported.

Exact reportable fields, grouping and subtotal semantics, saved-view schema, and exports depend on the API and require a confirmed contract.

### 6.6 Quotations

- Separate Ticket Quotations and Vendor Requests tabs/tables.
- Show ticket context, quotation/status/action fields, vendor, amount, and approval details where returned.
- Add Quote panel with Amount and Remark.
- Allow only authorized actions; show state transitions, validation, and confirmation feedback.

Vendor response, comparison, approval, award, and notification rules are not fully established and must be specified with the API owner.

### 6.7 User management

**Users:** list first/last name, email, business unit, designation, company, creation date, status, and view/edit actions. Create/edit fields include first/last name, email, primary email, password as applicable, business unit, designation, role, and company where authorized. View modal displays identity, email(s), organization, status, and creation date.

**Accounts/customers:** list name, email, phone, address, city/state/country, creation date, edit, and active state. Form fields evidenced include first/middle/last name, email, password where applicable, support email/contact, telephone/mobile, address lines, city/state/country/zipcode, registration number, website, and communication-related fields.

**Designations:** list title and creation date; create/edit title and active state.

The portal must use appropriate masking/validation for credentials and contact details. Customer login capability is not implied by the management screen.

### 6.8 Organization and service configuration

Implement the following management pages as permission-aware tables and create/edit forms:

| Page | UI fields and behavior evidenced |
|---|---|
| Types | Company, title, parent, created date, status; create/edit title and parent; active state on edit. |
| Status | Company, status/title, created date, active state; create/edit title. |
| Priority | Company, title, SLA, created date, active state; create/edit title and SLA. |
| Impact | Company, title, created date, active state; create/edit title and status. |
| Domains | Title, created date, active state; title, “Eligible For Store,” and dynamic additional fields. |
| Business Units | Company, name, email, phone/alternate phone, address, country/state/city, coordinates, marketing manager, responsible user, store manager, vendor/account-required settings, ticket display label, parent business unit, status. |
| Assign Group | Associate business unit, group, and designation; list company/title/business unit/created date. |
| Create Group | Group title, manager, one or more members, active state; list group, members, manager, and edit. |
| Vendors | Company, type/subtype, business unit, name, email/password where applicable, phone/alternate phone, address, coordinates, status. |
| Subscription Packages | Title, price, description, active state; UI contains a licence count defaulting to 1 (confirm intended behavior). |
| Companies | Contact names, company name, email/support email, registration number, telephone/support contact, website, licence count, domain, subscription, address/location, coordinates, map search, profile image, active state. |
| Roles/Profile | Role/profile listing with title create/edit UI. |
| Permissions | Select role; set Create/Read/Update/Delete permissions per page; All control; save changes. |

Forms should support searchable selectors for remote reference data, clear validation, confirmation for destructive changes, and visible active/inactive states. Company/tenant-specific restrictions are API-authoritative.

### 6.9 Company profile and administration

The company profile workspace includes company search/selection and profile editing for image, domain, country/state/city, registration number, website, established date, contact person, description, email, phone/mobile, support contacts, language, address, zipcode, and region.

It also contains invoice listing/creation, subscription/upgrade and payment-related UI, and company data import controls for tickets, business units, users, and group/designation. Invoice fields shown include invoice number, invoice/due dates, status, client, currency, generated by, line items, quantity, unit price, tax, payment status/amount/date/method, and transaction ID. Actions include download/share/print where implemented.

All financial and import operations are API-driven. The portal must label payment records accurately and must not represent a payment as externally verified unless the API contract confirms it. Confirm whether import, payment, cancellation, email, and shipping-address controls are production requirements or prototypes.

### 6.10 AI Agent

**Experience:** responsive conversation sidebar, New Conversation, recent history, assistant header/status, message stream, starter prompts, composer, typing indicator, delete confirmation, optional chart and collapsible query-plan/database-query display. Enter sends; Shift+Enter adds a newline. History currently requests up to eight conversations. The file-attachment button and some header/detail controls are visible but not confirmed functional.

**Supported behavior evidenced:** Admin3's active page calls its local `/api/ai/query/plan` endpoint, persists conversation/message history, displays returned answers/charts, and can display returned SQL/plan data. The query executor is currently ticket-focused, supports count/list/aggregate patterns, caller/company filtering, some status/priority/date and “my” scopes, and caps list results at 50. Unsupported domains or requests should receive a clear limitation response.

Do not equate this UI with a general-purpose chatbot. Confirm whether query plans/SQL should be visible to portal users, what provider is approved, retention rules, and how authenticated tenant/user identity is established. AI must never trust caller-supplied user/company IDs as its sole authorization mechanism.

### 6.11 Shared chat, maps, and media

- Shared shell has a floating Chat button opening a remote chat application in an iframe with auto-login behavior. Recreate only if this integration is approved and securely supported; otherwise provide a configurable/disabled integration state.
- Company/business-unit/customer screens include Maps/location UI. Keep provider/API keys server-side and make provider selection configurable.
- Company logo/profile images load through an external image endpoint. Support a configurable media URL and safe image fallback.

### 6.12 Public ticket-share pages

Admin3 includes `/ticket/{id}` requiring an `expires` parameter and `/public/tickets-view?id=...`, whose inspected controller does not enforce the same expiry. A recreation must not preserve this inconsistency by default. Before enabling public access, define token entropy, expiry, revocation, fields visible, file access, rate limits, and audit behavior. If not specified, require authentication and do not expose public ticket data.

## 7. Core UI/UX requirements

- Recreate the shared Admin3 admin-portal look and responsive page structure rather than generic marketing pages.
- Desktop navigation must support sidebar groups and selected/expanded states; smaller screens must provide usable collapsed navigation and tables/forms.
- Every data page needs loading, empty, error, and success states, plus a clear retry path where safe.
- Tables must support the page's relevant search, sort/pagination, filters, status indicators, row actions, and exports as confirmed.
- Forms must preserve user input after recoverable server errors, display field-level validation, and prevent accidental duplicate submission.
- Modals/offcanvas panels need keyboard-accessible controls and predictable close/submit behavior.
- Charts require labels, legends/tooltips, empty states, and an accessible tabular alternative for key values.
- Do not show inaccessible actions merely because a user can guess a URL; the API remains the authorization source of truth.
- Confirm supported browsers, branding assets, color system, and accessibility target during design sign-off.

## 8. API and integration requirements

Admin3 uses a configurable business API base URL (currently configured as a demo endpoint). Treat endpoint families below as integration contracts to document; do not infer HTTP method, payload shape, error schema, or completion from screen markup alone.

| API family | Portal consumers |
|---|---|
| Tickets and dashboard | Ticket list/detail/create/update, company ticket feeds, activity, replies, attachments/additional fields, vendor requests, share data, dashboard summaries. |
| Reference data | Types, statuses, priorities, impacts, domains, business units, designations, groups/members, roles, permissions. |
| People and organizations | Users, customers/accounts, companies, vendors, subscription packages. |
| Reports and filters | Retrieve/save/list/load/apply/delete reports, dashboard filters, saved views. |
| Billing and company operations | Company profile/images, invoices, invoice send/pay/cancel/shipping address, imports. |
| Portal-local AI | AI plan/query, conversation list/load/delete, messages and chart/query-plan results. |
| External services | Maps, company image/media endpoint, remote chat iframe, configured AI provider/Ollama. |

For each required API operation, implementation must establish: method/path, authentication, tenant scope, request/response schema, validation errors, pagination/sort/filter rules, upload constraints, timeout/retry behavior, idempotency for mutations, and compatibility/versioning policy. Provide an integration adapter so UI components do not scatter endpoint assumptions across pages.

### Known backend authorization findings (release gate)

The following findings were supplied for the current API audit and are recorded here as integration risks; this PRD does not claim to have independently verified fixes. The six controllers `Role`, `Permission`, `Status`, `Priority`, `Impact`, and `Type`, plus `Designation`, were reported fixed for cross-tenant by-ID access. Confirm regression tests remain in place before release.

The following API surfaces were reported as still exposed to cross-tenant by-ID access and must be tenant-scoped and regression-tested by the backend owner before the portal relies on them:

- [BuGroupController.php](app/Http/Controllers/BuGroupController.php): update/delete may target a group outside the caller's tenant.
- [GroupMemberController.php](app/Http/Controllers/GroupMemberController.php)
- [BuFieldController.php](app/Http/Controllers/BuFieldController.php)
- [DomainController.php](app/Http/Controllers/DomainController.php)
- [SubscriptionPackageController.php](app/Http/Controllers/SubscriptionPackageController.php)
- [QuoteController.php](app/Http/Controllers/QuoteController.php)
- [NotificationController.php](app/Http/Controllers/NotificationController.php)
- [BillingController.php](app/Http/Controllers/BillingController.php)
- [DashboardController.php](app/Http/Controllers/DashboardController.php): `notifyemail` was reported to send/echo notification behavior for an arbitrary ticket ID.

`UserNotificationController` was reported as covered by middleware that pins the notification to the authenticated user. Keep that middleware enforcement and test it; do not treat the finding as permission to trust user- or tenant IDs supplied by the browser.

**Portal/release requirement:** The frontend must not expose or rely on cross-tenant record IDs as authorization. The API must authorize the authenticated principal against the tenant and target record on every read, update, delete, notification, and billing operation. Until the backend owner confirms remediation, affected actions must be disabled or blocked from production use; hiding a menu item or routing calls through a portal adapter is not a substitute for API-side authorization. Add negative tests proving tenant A cannot access tenant B records by changing an ID, including the dashboard `notifyemail` path.

## 9. Non-functional requirements

### Security/privacy

- Enforce session and API authorization on every protected page/action; backend checks are mandatory.
- Prevent cross-company data access for screens, exports, downloads, AI conversations, files, and shared links.
- Keep API secrets, provider credentials, and map keys out of browser-delivered assets.
- Protect CSRF/session boundaries and validate uploads and user-provided content.
- Define retention/deletion behavior for AI messages, chat, ticket content, and uploaded files.

### Usability/reliability

- Provide actionable error feedback for API unavailability, expired session, validation failure, and upload errors.
- Avoid losing unsaved form data on recoverable errors and support empty/slow API responses gracefully.
- Define response-time, supported data volume, and browser targets with stakeholders; no numeric service SLA is assumed.

### Maintainability/testability

- Separate presentation, portal server logic, API access, and third-party integrations.
- Test permission-aware navigation/actions, API errors, forms, filters, export scope, and responsive layouts.
- Add integration tests for authentication/tenant context and AI authorization; use mock API fixtures for UI development.

## 10. Acceptance criteria for the website recreation

The portal recreation is acceptable when:

1. The authenticated shell, navigation, and every approved Admin3 business page in Sections 5–6 are implemented and responsive.
2. Each page has working controls for its approved workflows, not just static screenshots; unimplemented integrations are clearly disabled or mocked in a development environment.
3. All displayed data/actions use documented API contracts or explicit local AI endpoints; the frontend does not invent backend behavior.
4. Permission-based navigation and actions match the approved matrix, and direct URL/API access is still protected server-side.
5. Ticket creation, editing, filtering, detail/activity, and replies operate against the agreed API schema with correct loading, validation, and failure states.
6. Dashboard KPIs/charts and report views reconcile with API results and filter selections.
7. Admin CRUD pages for organization/reference data, users, roles/permissions, vendors, and subscriptions use consistent validation and status handling.
8. Quotations, company profile, imports, invoices, and payment UI are included only to the level confirmed by backend contracts and product decisions.
9. AI conversation creation/history/deletion and supported ticket questions work; unsupported requests and provider/API errors are handled safely.
10. No unauthenticated ticket sharing is enabled unless an approved secure share specification is implemented.
11. Automated checks cover route guards, permission states, key form workflows, API failure cases, and tenant-safe data display.

## 11. Excluded template/demo screens

Admin3 contains many generic admin-template demonstration views reachable through a catch-all route but not presented as core business navigation. Unless specifically requested, they are not required for the website recreation: generic calendar/chat/contacts/email/file manager/kanban/to-do demos; sample invoice pages; chart catalogs; form-control catalogs; UI component showcases; icon catalogs; map demos; sample profile/FAQ/pricing/privacy/terms/timeline/maintenance pages; and alternate layout demos. Include only if stakeholders identify a specific one as a real product page.

## 12. Open decisions before implementation

1. Confirm exact routes/pages and which Admin3 features are required in the new website versus legacy/prototype.
2. Obtain API OpenAPI/specification or agree endpoint-by-endpoint schemas and authentication flow.
3. Confirm API calls should be browser-to-API or routed through an Admin3 server-side adapter/BFF.
4. Approve roles, permission matrix, Super Admin semantics, and company/tenant scope.
5. Define required ticket fields, status lifecycle, SLA interpretation, assignment rules, uploads, and reply behavior.
6. Confirm report fields, saved-view semantics, supported exports, chart types, and filter behavior.
7. Confirm quotation lifecycle and which vendor actions are supported.
8. Confirm whether registration, email verification, OTP, password reset, and Remember me are required.
9. Confirm the operational state of subscription/invoice/payment/import controls and whether a real payment provider exists.
10. Decide AI scope/provider, supported query patterns, whether SQL is shown, and data retention rules.
11. Decide whether to retain external chat, Maps, company-media service, and what their replacement/fallback behavior is.
12. Approve public ticket-share policy or keep all ticket details authenticated.
13. Confirm branding, supported browsers, accessibility target, responsive breakpoints, and design assets.

## 13. Evidence in Admin3

Key frontend evidence used to create this PRD:

- Route and view routing: [Admin3/routes/web.php](../Admin3/routes/web.php), [Admin3/routes/api.php](../Admin3/routes/api.php).
- Shared layout and navigation: [Admin3/resources/views/layouts/master.blade.php](../Admin3/resources/views/layouts/master.blade.php), [Admin3/resources/views/layouts/sidebar.blade.php](../Admin3/resources/views/layouts/sidebar.blade.php), [Admin3/resources/views/layouts/topbar.blade.php](../Admin3/resources/views/layouts/topbar.blade.php).
- Dashboard and ticket workspace: [Admin3/resources/views/index.blade.php](../Admin3/resources/views/index.blade.php), [Admin3/resources/views/ticket.blade.php](../Admin3/resources/views/ticket.blade.php), [Admin3/resources/views/tickets-view.blade.php](../Admin3/resources/views/tickets-view.blade.php).
- Reports and quotations: [Admin3/resources/views/report.blade.php](../Admin3/resources/views/report.blade.php), [Admin3/resources/views/quotation.blade.php](../Admin3/resources/views/quotation.blade.php).
- Configuration and organization pages: [Admin3/resources/views/company-profile.blade.php](../Admin3/resources/views/company-profile.blade.php), [Admin3/resources/views/buisness-unit.blade.php](../Admin3/resources/views/buisness-unit.blade.php), [Admin3/resources/views/permission.blade.php](../Admin3/resources/views/permission.blade.php).
- AI experience and supported query executor: [Admin3/resources/views/agent-chat.blade.php](../Admin3/resources/views/agent-chat.blade.php), [Admin3/public/js/agent-chat.js](../Admin3/public/js/agent-chat.js), [Admin3/app/AI/QueryExecutor.php](../Admin3/app/AI/QueryExecutor.php).
- Portal/API configuration and public ticket rendering: [Admin3/config/app.php](../Admin3/config/app.php), [Admin3/app/Http/Controllers/TicketShareController.php](../Admin3/app/Http/Controllers/TicketShareController.php).

**Document owner:** To be assigned  
**Next step:** Validate the open decisions in Section 12, then use this PRD as the website build scope.

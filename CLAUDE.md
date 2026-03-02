# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

**Mea Nubes** is a personal cloud application built on the [`dysback/ogo`](../ogo) micro PHP framework (local path dependency). PHP 8.5+ required.

## Commands

```bash
# Install dependencies
composer install

# Lint / code style check
vendor/bin/phpcs

# Auto-fix code style
vendor/bin/phpcbf
```

No test runner is configured yet.

## Code Style

- All files must use `declare(strict_types=1)`
- Follow **PER-CS** coding standard
- All public methods and classes must have **PHPDoc** comments
- Use **Enums** for fixed lists instead of constants or strings
- Namespace root: `Dysback\NubesMea\` → `src/`

## Architecture

The app has two entry points under `src/public/`, both bootstrapped identically:

- **`api.php`** — REST API using `ApiRouter`, reads `API_NAMESPACE` from config
- **`app.php`** — Web app using `PageRouter`, reads `APP_NAMESPACE` from config

URL routing is handled by Apache via `.htaccess`:
- `/api/*` → `api.php`
- `/app/*` → `app.php`
- Path passed as `?__dy_path=`

### Request Flow

```
HTTP request → .htaccess → api.php / app.php
  → App::initialize() (singleton DI container from ogo)
  → Config → Logger → Router
  → Router::route($path) dispatches dynamically:
      ApiRouter:  /api/{module}/{service}/{method}  → src/Api/{module}/{service}.php
      PageRouter: /app/{module}/{view}/{operation}  → src/App/{module}/{view}.php
```

`ApiRouter` returns `JsonResponse`; `PageRouter` instantiates a view class, calls the operation method, then renders a template from `src/App/Views/{module}/{view}.tmpl.php`.

### Source Layout

```
src/
├── initialize.php        # Defines BASE_PATH, ENVIRONMENT (from MCT_ENVIRONMENT_TYPE env var)
├── public/
│   ├── api.php           # API entry point
│   ├── app.php           # Web app entry point
│   └── .htaccess         # URL rewriting
├── Api/
│   └── {Module}/         # Controllers extending BaseController (return arrays → JSON)
└── App/
    ├── {Module}/          # Views extending HtmlView or GeneralView
    └── Views/
        └── {Module}/     # .tmpl.php templates (required for HtmlView subclasses)
```

### Configuration

Environment selected by the `MCT_ENVIRONMENT_TYPE` env var (`DEV` or `PROD`), defaulting to `PROD`. Config files live at `configs/config.{ENVIRONMENT}.php` and return a PHP array. Accessed via dot-notation: `$app->config->get('LOGGER.LOG_LEVEL')`.

### Ogo Framework

The `dysback/ogo` dependency lives at `../ogo`. Its `CLAUDE.md` documents the full framework architecture including `App`, `Config`, `Logger`, `Router`, `View`, `Response`, `Database`, and `Dao` layers. Refer to it when working with framework internals.

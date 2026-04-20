# CLAUDE.md

## Project

Laravel 12 application with Livewire 4, MoonShine 4 (admin panel), and a Domain-driven structure.

## Key Technologies

- **PHP 8.3**, Laravel 12
- **Livewire 4** — reactive UI components
- **MoonShine 4** — admin panel (`/admin`)
- **Intervention Image 3** — image processing
- **Spatie Honeypot** — spam protection
- **Spatie Sitemap** — sitemap generation

## Directory Structure

- `app/` — standard Laravel (Controllers, Models, Mail, Events, etc.)
- `src/Domain/` — domain layer (autoloaded as `Domain\`)
- `src/Support/` — helpers and support classes (autoloaded as `Support\`)
- `resources/views/` — Blade templates
- `database/migrations/` — migrations

## Common Commands

```bash
# Start dev server (Laravel + Queue + Vite + Pail)
composer dev

# Run tests
composer test

# Code style fix
./vendor/bin/pint

# Run migrations
php artisan migrate

# Clear config cache
php artisan config:clear
```

## Environment

- Local server: OSPanel (Windows)
- Database config in `.env` (not committed)
- `.env.example` contains all required keys

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

## Code Conventions

### PHP imports
Always import classes via `use` statements at the top of the file. Never write fully-qualified class names inline (e.g. `\Illuminate\Database\Eloquent\Collection`).

### Database queries in Controllers
Never write Eloquent queries directly in controllers. Place all queries in the corresponding ViewModel class in `src/Domain/*/ViewModels/`. Controllers only call ViewModel methods.

```php
// src/Domain/User/ViewModels/UserViewModel.php
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

public function UserOrders(): LengthAwarePaginator
{
    return Order::query()
        ->where('user_id', auth()->id())
        ->latest()
        ->paginate(config('site.constants.paginate'));
}

// Controller
$orders = UserViewModel::make()->UserOrders();
```

### Styles
Always make style changes only in `.scss` files. Never edit `.css` files directly — they are compiled output.

Write SCSS with full class names, not BEM ampersand nesting. Each class is a separate top-level rule:

```scss
// Correct
.img-upload { ... }
.img-upload__main { ... }
.img-upload__preview-wrap { ... }

// Wrong
.img-upload {
    &__main { ... }
    &__preview-wrap { ... }
}
```

### Pagination in Blade
Always render pagination with `withQueryString()` and explicit view name:

```blade
{{ $items->withQueryString()->links('pagination::default') }}
```

## Environment

- Local server: OSPanel (Windows)
- Database config in `.env` (not committed)
- `.env.example` contains all required keys

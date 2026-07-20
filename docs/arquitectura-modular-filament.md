# Arquitectura modular (DDD) con Filament

> Guía práctica para estructurar una aplicación Laravel + Filament en módulos autocontenidos, basada en la documentación oficial: https://filamentphp.com/docs/5.x/advanced/modular-architecture

## 1. Concepto

En vez de tener todo el código en `app/` (un monolito), cada dominio de negocio se convierte en su **propio paquete Composer** dentro de `app-modules/`. Cada módulo trae consigo:

- Modelos y lógica de negocio
- Recursos, páginas y widgets de Filament
- Su propio Service Provider
- Rutas, vistas y configuración
- Sus propios tests

**Beneficios:**

- Separación clara de responsabilidades por dominio
- Equipos distintos pueden ser dueños de módulos distintos
- Mejor testabilidad y mantenibilidad
- Los módulos se pueden reutilizar entre proyectos

**Cuándo usarla:** aplicaciones grandes, con varios paneles de Filament (admin, staff, portal de cliente, etc.) o con varios equipos trabajando en paralelo. Para un proyecto pequeño, probablemente es sobre-ingeniería — no lo apliques por defecto.

---

## 2. Instalación

```bash
composer require internachi/modular
```

Crear un módulo nuevo:

```bash
php artisan make:module nombre-del-modulo
```

Esto genera el esqueleto base:

```
app-modules/
└── nombre-del-modulo/
    ├── composer.json
    ├── src/
    │   └── Providers/
    │       └── NombreDelModuloServiceProvider.php
    ├── routes/
    ├── resources/
    ├── database/
    └── tests/
```

---

## 3. Configurar el `composer.json` del módulo

Cada módulo necesita requerir `filament/filament` y declarar su Service Provider para que Laravel lo auto-descubra:

```json
{
    "name": "mi-app/nombre-del-modulo",
    "type": "library",
    "require": {
        "filament/filament": "^5.0"
    },
    "autoload": {
        "psr-4": {
            "Modules\\NombreDelModulo\\": "src/"
        }
    },
    "extra": {
        "laravel": {
            "providers": [
                "Modules\\NombreDelModulo\\Providers\\NombreDelModuloServiceProvider"
            ]
        }
    }
}
```

> Ajusta el namespace `Modules\NombreDelModulo` al nombre real de tu módulo (ej. `Modules\Alerts`, `Modules\Billing`, etc.).

---

## 4. Crear el Plugin de Filament del módulo

Cada módulo define su propia clase que implementa `Filament\Contracts\Plugin`. Este plugin es el que le dice a Filament dónde buscar los Resources, Pages y Widgets del módulo:

```php
<?php

namespace Modules\NombreDelModulo;

use Filament\Contracts\Plugin;
use Filament\Panel;

class NombreDelModuloPlugin implements Plugin
{
    public function getId(): string
    {
        return 'nombre-del-modulo';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function register(Panel $panel): void
    {
        $panel
            ->discoverResources(
                in: __DIR__ . '/Filament/Resources',
                for: 'Modules\\NombreDelModulo\\Filament\\Resources',
            )
            ->discoverPages(
                in: __DIR__ . '/Filament/Pages',
                for: 'Modules\\NombreDelModulo\\Filament\\Pages',
            )
            ->discoverWidgets(
                in: __DIR__ . '/Filament/Widgets',
                for: 'Modules\\NombreDelModulo\\Filament\\Widgets',
            );
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
```

---

## 5. Registrar el plugin en el panel correcto

Con varios paneles (`admin`, `app`, `portal`...) normalmente quieres que un módulo solo se registre en algunos. Esto se hace con `Panel::configureUsing()` dentro del Service Provider del módulo — **sin tocar el `PanelProvider` central**.

### Opción A — registrar en todos los paneles excepto uno

```php
<?php

namespace Modules\NombreDelModulo\Providers;

use Filament\Panel;
use Illuminate\Support\ServiceProvider;
use Modules\NombreDelModulo\NombreDelModuloPlugin;

class NombreDelModuloServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Panel::configureUsing(function (Panel $panel): void {
            if ($panel->getId() !== 'admin') {
                return;
            }

            $panel->plugin(NombreDelModuloPlugin::make());
        });
    }
}
```

### Opción B — registrar de forma distinta según el panel (`match`)

```php
<?php

namespace Modules\NombreDelModulo\Providers;

use Filament\Panel;
use Illuminate\Support\ServiceProvider;
use Modules\NombreDelModulo\NombreDelModuloPlugin;

class NombreDelModuloServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Panel::configureUsing(function (Panel $panel): void {
            match ($panel->getId()) {
                'admin' => $panel->plugin(
                    NombreDelModuloPlugin::make()->enableAdminFeatures(),
                ),
                'staff' => $panel->plugin(
                    NombreDelModuloPlugin::make(),
                ),
                default => null,
            };
        });
    }
}
```

> **Por qué importa:** al añadir o quitar un módulo del proyecto, su integración con Filament se activa o desactiva sola. No hay que editar el `AdminPanelProvider` cada vez que agregas un módulo nuevo.

---

## 6. Estructura de directorio recomendada (completa)

```
app-modules/
└── nombre-del-modulo/
    ├── composer.json
    ├── config/
    │   └── nombre-del-modulo.php
    ├── database/
    │   ├── factories/
    │   ├── migrations/
    │   └── seeders/
    ├── resources/
    │   └── views/
    │       └── filament/
    │           └── pages/
    ├── routes/
    │   └── web.php
    ├── src/
    │   ├── NombreDelModuloPlugin.php
    │   ├── Filament/
    │   │   ├── Pages/
    │   │   ├── Resources/
    │   │   │   └── Entidad/
    │   │   │       ├── EntidadResource.php
    │   │   │       └── Pages/
    │   │   │           ├── CreateEntidad.php
    │   │   │           ├── EditEntidad.php
    │   │   │           └── ListEntidades.php
    │   │   └── Widgets/
    │   ├── Models/
    │   │   └── Entidad.php
    │   └── Providers/
    │       └── NombreDelModuloServiceProvider.php
    └── tests/
```

**Checklist al crear un módulo nuevo:**

- [ ] `php artisan make:module <nombre>`
- [ ] Configurar `composer.json` del módulo (namespace + provider)
- [ ] Crear `<Modulo>Plugin.php` con `discoverResources/Pages/Widgets`
- [ ] Registrar el plugin en el/los panel(es) correctos vía `Panel::configureUsing()`
- [ ] Mover/crear modelos en `src/Models`
- [ ] Mover/crear resources en `src/Filament/Resources`
- [ ] Migraciones propias en `database/migrations`
- [ ] Tests propios en `tests/`

---

## 7. Compartir un recurso entre varios paneles

Si un mismo Resource (ej. `UserResource`) debe aparecer en más de un panel pero con capacidades distintas, expón esas capacidades como métodos fluidos en el plugin:

```php
<?php

namespace Modules\Users;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Modules\Users\Filament\Resources\UserResource;

class UsersPlugin implements Plugin
{
    protected bool $canManageRoles = false;

    public function getId(): string
    {
        return 'users';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function canManageRoles(bool $condition = true): static
    {
        $this->canManageRoles = $condition;

        return $this;
    }

    public function hasRoleManagement(): bool
    {
        return $this->canManageRoles;
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            UserResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
```

Y al registrar, configuras cada panel con las capacidades que le corresponden:

```php
Panel::configureUsing(function (Panel $panel): void {
    match ($panel->getId()) {
        'admin' => $panel->plugin(
            UsersPlugin::make()->canManageRoles(),
        ),
        'staff' => $panel->plugin(
            UsersPlugin::make(),
        ),
        default => null,
    };
});
```

Dentro del `UserResource`, usa `hasRoleManagement()` (accediendo al plugin actual) para mostrar/ocultar columnas, acciones o campos según el panel.

---

## 8. Registrar componentes Livewire del módulo

Si el módulo trae páginas o widgets Livewire personalizados que Filament necesita resolver, regístralos en el `boot()` del plugin:

```php
use Livewire\Livewire;
use Modules\NombreDelModulo\Filament\Pages\AlgunDashboard;

public function boot(Panel $panel): void
{
    Livewire::component('algun-dashboard', AlgunDashboard::class);
}
```

---

## 9. Resumen mental rápido

| Pieza | Responsabilidad |
|---|---|
| `app-modules/<modulo>/` | Un dominio de negocio autocontenido, paquete Composer propio |
| `<Modulo>Plugin.php` | Le dice a Filament dónde están los Resources/Pages/Widgets del módulo |
| `<Modulo>ServiceProvider.php` | Registra el plugin en el panel correcto vía `Panel::configureUsing()` |
| `Panel::configureUsing()` | Permite que el módulo se auto-registre sin tocar el `PanelProvider` central |
| Plugin con métodos fluidos (`->canManageRoles()`) | Permite reusar un mismo Resource con comportamiento distinto por panel |

**Regla de oro:** el `PanelProvider` central (ej. `AdminPanelProvider.php`) no debería necesitar cambios cuando agregas o quitas un módulo — toda la integración vive dentro del módulo mismo.

# `internachi/modular`

Referencia rápida de comandos para el paquete de módulos de Laravel `internachi/modular`.

---

## 📦 Instalación y configuración inicial

```shell
composer require internachi/modular
```

Laravel auto-descubre el paquete, no requiere configuración extra para empezar.

**Publicar el archivo de configuración** (recomendado, sobre todo para personalizar el namespace):

```shell
php artisan vendor:publish --tag=modular-config
```

---

## 🆕 Crear un módulo

```shell
php artisan make:module my-module
```

Esto genera la estructura:

```
app-modules/
  my-module/
    composer.json
    src/
    tests/
    routes/
    resources/
    database/
```

También añade dos entradas al `composer.json` raíz (path repository + require).

Después, hay que actualizar Composer para que registre el módulo:

```shell
composer update modules/my-module
```

---

## 🔄 Sincronizar configuración del proyecto

```shell
php artisan modules:sync
```

- Añade el test suite `Modules` a `phpunit.xml` (si existe).
- Actualiza la config del plugin de PhpStorm para Laravel (si existe), para que detecte las vistas del módulo.
- Es seguro ejecutarlo en cualquier momento (solo añade lo que falte).
- Se puede automatizar en el script `post-autoload-dump` del `composer.json`.

---

## 🛠️ Comandos propios del paquete

| Comando | Descripción |
|---|---|
| `php artisan make:module` | Scaffolding de un módulo nuevo |
| `php artisan modules:cache` | Cachea los módulos cargados (auto-discovery más rápido) |
| `php artisan modules:clear` | Limpia la caché de módulos |
| `php artisan modules:sync` | Sincroniza configuraciones del proyecto (`phpunit.xml`, etc.) |
| `php artisan modules:list` | Lista todos los módulos |

---

## ⚙️ Comandos `make:` de Laravel con opción `--module=`

Se le añade la opción `--module=` a la mayoría de los comandos `make:` de Laravel, para generar el archivo directamente dentro de un módulo en vez de en `app/`.

```shell
php artisan make:controller MyModuleController --module=[nombre-modulo]
```

Comandos soportados:

- `make:cast`
- `make:controller`
- `make:command`
- `make:component`
- `make:channel`
- `make:event`
- `make:exception`
- `make:factory`
- `make:job`
- `make:listener`
- `make:mail`
- `make:middleware`
- `make:model`
- `make:notification`
- `make:observer`
- `make:policy`
- `make:provider`
- `make:request`
- `make:resource`
- `make:rule`
- `make:seeder`
- `make:test`

> 💡 Todos siguen funcionando igual que los comandos nativos de Laravel: soportan stubs personalizados y demás.

---

## 🌱 Seeders por módulo

```shell
# Llama a Modules\MiModulo\Database\Seeders\DatabaseSeeder
php artisan db:seed --module=[nombre-modulo]

# Llama a Modules\MiModulo\Database\Seeders\MiSeeder
php artisan db:seed --class=MiSeeder --module=[nombre-modulo]
```

---

## 🎨 Blade Components (auto-registrados)

| Archivo | Componente |
|---|---|
| `app-modules/demo/src/View/Components/Basic.php` | `<x-demo::basic />` |
| `app-modules/demo/src/View/Components/Nested/One.php` | `<x-demo::nested.one />` |
| `app-modules/demo/resources/components/anonymous.blade.php` | `<x-demo::anonymous />` |
| `app-modules/demo/resources/components/anonymous/nested.blade.php` | `<x-demo::anonymous.nested />` |

---

## 🌍 Traducciones

Archivo: `app-modules/demo/resources/lang/en/messages.php`

Uso:

```php
__('demo::messages.welcome');
```

---

## 🧵 Placeholders para stubs personalizados

Al personalizar los stubs (vía el config `stubs`), tanto rutas como contenido soportan:

- `StubBasePath`
- `StubModuleNamespace`
- `StubComposerNamespace`
- `StubModuleNameSingular`
- `StubModuleNamePlural`
- `StubModuleName`
- `StubClassNamePrefix`
- `StubComposerName`
- `StubMigrationPrefix`
- `StubFullyQualifiedTestCaseBase`
- `StubTestCaseBase`

---

## ✅ Cosas que se auto-descubren en cada módulo

- Commands (Artisan)
- Migrations
- Factories (`factory()`)
- Policies (para tus Models)
- Blade components
- Event listeners

---

## 📁 Config: `config/modular.php`

| Clave | Default | Para qué sirve |
|---|---|---|
| `modules_namespace` | `'Modules'` | Namespace PHP base de los módulos |
| `modules_vendor` | `null` | Prefijo vendor del `composer.json` (auto: kebab-case del namespace) |
| `modules_directory` | `'app-modules'` | Carpeta donde viven los módulos |
| `tests_base` | `'Tests\TestCase'` | Clase base para tests generados |
| `stubs` | `null` | Stubs personalizados por módulo |
| `should_discover_events` | `null` | Activa/desactiva auto-discovery de eventos |

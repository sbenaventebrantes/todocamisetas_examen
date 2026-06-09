# TodoCamisetas API

API backend para el examen de TodoCamisetas.

## Equipo

- Andrea Carre
- Sofia Benavente
- Mixiu Perez

## Tecnologías

- Laravel
- PHP 8.4
- MySQL o SQLite

## Antes de empezar

1. Copia el archivo de entorno.
2. Configura la base de datos.
3. Ejecuta migraciones y seeders.

```bash
composer install
cp .env.example .env
php artisan key:generate
```

## Configuración del `.env`

Revisa al menos estas variables:

```env
APP_NAME="TodoCamisetas API"
DB_CONNECTION=sqlite
DB_DATABASE=/ruta/completa/a/database.sqlite
```

Si prefieres MySQL, ajusta `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD`.

## Base de datos

```bash
php artisan migrate:fresh --seed
```

Ese comando deja la base limpia y carga los datos de demo.

## Levantar el proyecto

```bash
php artisan serve
```

La API queda disponible normalmente en `http://127.0.0.1:8000`.

## Datos de demo

El seeder deja cargados:

- `90minutos` con categoría `preferential`
- `tdeportes` con categoría `regular`
- tallas de ejemplo
- camisetas de ejemplo
- relaciones entre camisetas y tallas

## Endpoints

### Root

- `GET /`

### Customers

- `GET /api/customers`
- `POST /api/customers`
- `GET /api/customers/{customer}`
- `PUT /api/customers/{customer}`
- `DELETE /api/customers/{customer}`
- `GET /api/customers/{customer}/shirts`

### Shirts

- `GET /api/shirts`
- `POST /api/shirts`
- `GET /api/shirts/{shirt}`
- `PUT /api/shirts/{shirt}`
- `DELETE /api/shirts/{shirt}`

### Sizes de una shirt

- `GET /api/shirts/{shirt}/sizes`
- `POST /api/shirts/{shirt}/sizes`
- `PUT /api/shirts/{shirt}/sizes`
- `DELETE /api/shirts/{shirt}/sizes/{size}`

### Sizes

- `GET /api/sizes`
- `POST /api/sizes`
- `GET /api/sizes/{size}`
- `PUT /api/sizes/{size}`
- `DELETE /api/sizes/{size}`

## Casos importantes para probar

1. Listar customers, shirts y sizes.
2. Crear un customer nuevo.
3. Crear una shirt con `productCode` único.
4. Consultar una shirt con `customerId` para ver `finalPrice`.
5. Asociar una talla a una shirt.
6. Intentar asociar la misma talla dos veces.
7. Intentar eliminar un customer con shirts asociadas.

## Respuestas

- Las respuestas de colección usan `data`.
- Las respuestas individuales también usan `data`.
- Las creaciones y actualizaciones devuelven `message` y `data`.
- Los errores devuelven `message` y, cuando aplica, `errors`.

## Estructura

- `app/Http/Controllers/Api`: controladores de la API.
- `app/Http/Requests`: validaciones.
- `app/Http/Resources`: salida JSON en camelCase.
- `app/Models`: modelos y relaciones.
- `database/migrations`: tablas.
- `database/seeders`: datos de demo.
- `docs`: OpenAPI, Postman y apoyo para el informe.

## Documentación útil

- `docs/openapi.yaml`
- `docs/postman_collection.json`
- `docs/exam_support.md`

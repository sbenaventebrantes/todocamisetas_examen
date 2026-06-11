# TodoCamisetas API

API del examen de Desarrollo Backend.

## Equipo

- Andrea Carreño
- Sofia Benavente
- Mixiu Perez

## De que trata

API RESTful para gestionar clientes, camisetas y tallas de un negocio B2B.
Tiene CRUD completo, relacion muchos a muchos entre camisetas y tallas,
y un calculo de precio final segun la categoria del cliente.

## Tecnologias

Laravel 13, PHP 8.3+, MySQL 8, Docker Compose.

## Como levantar el proyecto

```bash
composer install
cp .env.example .env
php artisan key:generate
docker compose up -d --build
docker compose exec app php artisan migrate:fresh --seed --force
```

La API queda en `http://localhost:8000/api`.

## Documentacion (Swagger)

Hay dos formas de ver la documentacion de la API:

1. **Swagger UI** — abrir en el navegador:
   ```
   http://localhost:8000/swagger
   ```
2. **Archivo YAML** — `docs/openapi.yaml`

Si haces cambios y queres regenerar el YAML:

```bash
docker compose exec app php artisan docs:openapi
```

## Endpoints

Todas las rutas van con `/api` adelante.

| Metodo | Ruta | Que hace |
|---|---|---|
| GET | `/health` | Verificar que la API funciona |
| GET | `/customers` | Listar clientes |
| POST | `/customers` | Crear cliente |
| GET | `/customers/{id}` | Ver cliente |
| PUT | `/customers/{id}` | Actualizar cliente |
| DELETE | `/customers/{id}` | Eliminar cliente |
| GET | `/customers/{id}/shirts` | Camisetas de un cliente |
| GET | `/shirts` | Listar camisetas |
| POST | `/shirts` | Crear camiseta |
| GET | `/shirts/{id}?customerId=X` | Ver camiseta con precio final |
| PUT | `/shirts/{id}` | Actualizar camiseta |
| DELETE | `/shirts/{id}` | Eliminar camiseta |
| GET | `/shirts/{id}/sizes` | Tallas de una camiseta |
| POST | `/shirts/{id}/sizes` | Asociar talla |
| PUT | `/shirts/{id}/sizes` | Sincronizar tallas |
| DELETE | `/shirts/{id}/sizes/{sizeId}` | Desasociar talla |
| GET | `/sizes` | Listar tallas |
| POST | `/sizes` | Crear talla |
| GET | `/sizes/{id}` | Ver talla |
| PUT | `/sizes/{id}` | Actualizar talla |
| DELETE | `/sizes/{id}` | Eliminar talla |

## Precio final

Si consultas una camiseta con `?customerId=X`:
- Cliente **Preferencial** + camiseta con `priceOffer` → `finalPrice` = `priceOffer`
- En cualquier otro caso → `finalPrice` = `price`

Ejemplo:

```
GET /api/shirts/{id}?customerId={idPreferencial}
Response: { "finalPrice": 64990, "clientCategory": "preferential" }
```

Abrir el Swagger UI en `http://localhost:8000/swagger` para probar desde el navegador.

# TodoCamisetas API

## Estructura general

- `app/Http/Controllers/Api`: controladores de la API.
- `app/Http/Requests`: validaciones de entrada.
- `app/Http/Resources`: salida JSON en camelCase.
- `app/Models`: modelos y relaciones.
- `database/migrations`: tablas.
- `database/seeders`: datos de demo.
- `docs`: OpenAPI, Postman y apoyo para el informe.

## Modelo de datos

- `customers`: clientes B2B.
- `shirts`: camisetas asociadas a un cliente.
- `sizes`: tallas disponibles.
- `shirt_sizes`: relación muchos a muchos entre camisetas y tallas.

## Relaciones

- Un `customer` tiene muchas `shirts`.
- Una `shirt` pertenece a un `customer`.
- Una `shirt` tiene muchas `sizes`.
- Una `size` pertenece a muchas `shirts`.

## Endpoints principales

- `GET /api/customers`
- `POST /api/customers`
- `GET /api/customers/{id}`
- `PUT /api/customers/{id}`
- `DELETE /api/customers/{id}`
- `GET /api/customers/{id}/shirts`
- `GET /api/shirts`
- `POST /api/shirts`
- `GET /api/shirts/{id}?customerId=1`
- `PUT /api/shirts/{id}`
- `DELETE /api/shirts/{id}`
- `GET /api/shirts/{id}/sizes`
- `POST /api/shirts/{id}/sizes`
- `PUT /api/shirts/{id}/sizes`
- `DELETE /api/shirts/{shirt}/sizes/{size}`
- `GET /api/sizes`
- `POST /api/sizes`

## Reglas de negocio

- No se puede borrar un customer si tiene shirts.
- Si el customer es preferential y la shirt tiene `price_offer`, el `finalPrice` usa ese valor.
- Si el customer es regular o no hay `price_offer`, el `finalPrice` usa `price`.
- No se puede asociar una talla repetida a la misma camiseta.

## Cómo correr el proyecto

1. Instalar dependencias.
2. Configurar `.env`.
3. Ejecutar migraciones.
4. Ejecutar seeders.
5. Levantar el servidor con `php artisan serve`.

## Qué mostrar en el video

- CRUD de customers, shirts y sizes.
- Cálculo de `finalPrice` con `customerId`.
- Asociación de tallas a una camiseta.
- Respuestas en español y JSON en camelCase.

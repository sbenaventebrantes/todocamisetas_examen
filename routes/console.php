<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('docs:openapi', function () {
    File::put(base_path('docs/openapi.yaml'), <<<'YAML'
openapi: 3.0.3
info:
  title: TodoCamisetas API
  version: 1.0.0
  description: API del examen de TodoCamisetas. Los UUID identifican customers, shirts y sizes.
servers:
  - url: http://localhost:8000
tags:
  - name: Health
  - name: Customers
  - name: Shirts
  - name: Shirt sizes
  - name: Sizes
paths:
  /api/health:
    get:
      tags: [Health]
      summary: Check API status
      responses:
        '200':
          description: API active
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/HealthResponse'
              example:
                message: TodoCamisetas API funcionando
                data:
                  status: ok
  /api/customers:
    get:
      tags: [Customers]
      summary: List customers
      responses:
        '200':
          description: Customers list
          content:
            application/json:
              schema:
                type: array
                items:
                  $ref: '#/components/schemas/CustomerResponse'
              example:
                - customerId: 7d7b5cb0-1111-4444-8888-9f5d0f1a0001
                  tradeName: 90minutos
                  taxId: 12345678-9
                  address: Santiago
                  category: preferential
                  contactName: Andrea Carre
                  contactEmail: andrea@correo.com
                  offerPercentage: 10
                  createdAt: '2026-06-09T10:00:00.000000-03:00'
                  updatedAt: '2026-06-09T10:00:00.000000-03:00'
    post:
      tags: [Customers]
      summary: Create customer
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/CustomerInput'
            example:
              tradeName: 90minutos
              taxId: 12345678-9
              address: Santiago
              category: preferential
              contactName: Andrea Carre
              contactEmail: andrea@correo.com
              offerPercentage: 10
      responses:
        '201':
          description: Created
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/CustomerResponse'
              example:
                customerId: 7d7b5cb0-1111-4444-8888-9f5d0f1a0001
                tradeName: 90minutos
                taxId: 12345678-9
                address: Santiago
                category: preferential
                contactName: Andrea Carre
                contactEmail: andrea@correo.com
                offerPercentage: 10
        '409':
          description: Business rule conflict
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/ErrorResponse'
        '422':
          description: Validation error
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/ValidationErrorResponse'
  /api/customers/{customerId}:
    get:
      tags: [Customers]
      summary: Get one customer
      parameters:
        - in: path
          name: customerId
          required: true
          schema:
            type: string
            format: uuid
      responses:
        '200':
          description: Found
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/CustomerResponse'
        '404':
          description: Record not found
    put:
      tags: [Customers]
      summary: Update customer
      parameters:
        - in: path
          name: customerId
          required: true
          schema:
            type: string
            format: uuid
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/CustomerInput'
      responses:
        '200':
          description: Updated
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/CustomerResponse'
        '409':
          description: Business rule conflict
        '422':
          description: Validation error
    delete:
      tags: [Customers]
      summary: Delete customer
      parameters:
        - in: path
          name: customerId
          required: true
          schema:
            type: string
            format: uuid
      responses:
        '204':
          description: Deleted
        '409':
          description: Business rule conflict
  /api/customers/{customerId}/shirts:
    get:
      tags: [Customers, Shirts]
      summary: List shirts by customer
      parameters:
        - in: path
          name: customerId
          required: true
          schema:
            type: string
            format: uuid
      responses:
        '200':
          description: Shirts list
          content:
            application/json:
              schema:
                type: array
                items:
                  $ref: '#/components/schemas/ShirtResponse'
  /api/shirts:
    get:
      tags: [Shirts]
      summary: List shirts
      responses:
        '200':
          description: Shirts list
          content:
            application/json:
              schema:
                type: array
                items:
                  $ref: '#/components/schemas/ShirtResponse'
    post:
      tags: [Shirts]
      summary: Create shirt
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/ShirtInput'
            example:
              customerId: 7d7b5cb0-1111-4444-8888-9f5d0f1a0001
              title: Camiseta titular
              club: Colo Colo
              country: Chile
              type: Home
              color: Blanco
              price: 29990
              priceOffer: 24990
              details: Modelo 2026
              productCode: COL-2026-HOME-01
      responses:
        '201':
          description: Created
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/ShirtResponse'
        '409':
          description: Business rule conflict
        '422':
          description: Validation error
  /api/shirts/{shirtId}:
    get:
      tags: [Shirts]
      summary: Get one shirt
      parameters:
        - in: path
          name: shirtId
          required: true
          schema:
            type: string
            format: uuid
        - in: query
          name: customerId
          required: false
          schema:
            type: string
            format: uuid
      responses:
        '200':
          description: Found
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/ShirtResponse'
        '404':
          description: Record not found
    put:
      tags: [Shirts]
      summary: Update shirt
      parameters:
        - in: path
          name: shirtId
          required: true
          schema:
            type: string
            format: uuid
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/ShirtInput'
      responses:
        '200':
          description: Updated
        '409':
          description: Business rule conflict
        '422':
          description: Validation error
    delete:
      tags: [Shirts]
      summary: Delete shirt
      parameters:
        - in: path
          name: shirtId
          required: true
          schema:
            type: string
            format: uuid
      responses:
        '204':
          description: Deleted
  /api/shirts/{shirtId}/sizes:
    get:
      tags: [Shirt sizes]
      summary: List sizes for a shirt
      parameters:
        - in: path
          name: shirtId
          required: true
          schema:
            type: string
            format: uuid
      responses:
        '200':
          description: Sizes list
          content:
            application/json:
              schema:
                type: array
                items:
                  $ref: '#/components/schemas/SizeResponse'
    post:
      tags: [Shirt sizes]
      summary: Attach a size to a shirt
      parameters:
        - in: path
          name: shirtId
          required: true
          schema:
            type: string
            format: uuid
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/ShirtSizeInput'
      responses:
        '200':
          description: Updated
        '404':
          description: Record not found
        '409':
          description: Business rule conflict
        '422':
          description: Validation error
    put:
      tags: [Shirt sizes]
      summary: Sync sizes for a shirt
      parameters:
        - in: path
          name: shirtId
          required: true
          schema:
            type: string
            format: uuid
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/SyncShirtSizesInput'
      responses:
        '200':
          description: Updated
        '422':
          description: Validation error
  /api/shirts/{shirtId}/sizes/{sizeId}:
    delete:
      tags: [Shirt sizes]
      summary: Detach a size from a shirt
      parameters:
        - in: path
          name: shirtId
          required: true
          schema:
            type: string
            format: uuid
        - in: path
          name: sizeId
          required: true
          schema:
            type: string
            format: uuid
      responses:
        '204':
          description: Deleted
        '404':
          description: Record not found
  /api/sizes:
    get:
      tags: [Sizes]
      summary: List sizes
      responses:
        '200':
          description: Sizes list
          content:
            application/json:
              schema:
                type: array
                items:
                  $ref: '#/components/schemas/SizeResponse'
    post:
      tags: [Sizes]
      summary: Create size
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/SizeInput'
            example:
              name: L
      responses:
        '201':
          description: Created
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/SizeResponse'
        '409':
          description: Business rule conflict
        '422':
          description: Validation error
  /api/sizes/{sizeId}:
    get:
      tags: [Sizes]
      summary: Get one size
      parameters:
        - in: path
          name: sizeId
          required: true
          schema:
            type: string
            format: uuid
      responses:
        '200':
          description: Found
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/SizeResponse'
        '404':
          description: Record not found
    put:
      tags: [Sizes]
      summary: Update size
      parameters:
        - in: path
          name: sizeId
          required: true
          schema:
            type: string
            format: uuid
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/SizeInput'
      responses:
        '200':
          description: Updated
        '409':
          description: Business rule conflict
        '422':
          description: Validation error
    delete:
      tags: [Sizes]
      summary: Delete size
      parameters:
        - in: path
          name: sizeId
          required: true
          schema:
            type: string
            format: uuid
      responses:
        '204':
          description: Deleted
components:
  schemas:
    HealthResponse:
      type: object
      properties:
        message:
          type: string
        data:
          type: object
          properties:
            status:
              type: string
    ErrorResponse:
      type: object
      properties:
        message:
          type: string
        errors:
          type: object
          additionalProperties:
            type: array
            items:
              type: string
    ValidationErrorResponse:
      $ref: '#/components/schemas/ErrorResponse'
    CustomerInput:
      type: object
      required: [tradeName, taxId, category, contactName, contactEmail]
      properties:
        tradeName:
          type: string
        taxId:
          type: string
        address:
          type: string
        category:
          type: string
          enum: [preferential, regular]
        contactName:
          type: string
        contactEmail:
          type: string
          format: email
        offerPercentage:
          type: number
          minimum: 0
          maximum: 100
    CustomerResponse:
      allOf:
        - $ref: '#/components/schemas/CustomerInput'
        - type: object
          properties:
            customerId:
              type: string
              format: uuid
            createdAt:
              type: string
            updatedAt:
              type: string
    ShirtInput:
      type: object
      required: [customerId, title, club, country, type, color, price, productCode]
      properties:
        customerId:
          type: string
          format: uuid
        title:
          type: string
        club:
          type: string
        country:
          type: string
        type:
          type: string
        color:
          type: string
        price:
          type: number
        priceOffer:
          type: number
        details:
          type: string
        productCode:
          type: string
    ShirtResponse:
      allOf:
        - $ref: '#/components/schemas/ShirtInput'
        - type: object
          properties:
            productId:
              type: string
              format: uuid
            finalPrice:
              type: number
            clientCategory:
              type: string
              nullable: true
            sizes:
              type: array
              items:
                $ref: '#/components/schemas/SizeResponse'
            createdAt:
              type: string
            updatedAt:
              type: string
    SizeInput:
      type: object
      required: [name]
      properties:
        name:
          type: string
    SizeResponse:
      allOf:
        - $ref: '#/components/schemas/SizeInput'
        - type: object
          properties:
            sizeId:
              type: string
              format: uuid
            createdAt:
              type: string
            updatedAt:
              type: string
    ShirtSizeInput:
      type: object
      required: [sizeId]
      properties:
        sizeId:
          type: string
          format: uuid
    SyncShirtSizesInput:
      type: object
      required: [sizeIds]
      properties:
        sizeIds:
          type: array
          items:
            type: string
            format: uuid
YAML
    );

    $this->info('OpenAPI generado en docs/openapi.yaml');
})->purpose('Generate the OpenAPI specification for the API');

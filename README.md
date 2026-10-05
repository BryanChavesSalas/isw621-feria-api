# Feria del Agricultor · API

Proyecto compartido de la **Prueba corta práctica 1** de ISW-621 Programación en Ambiente Web II (UTN, sede San Carlos).

Es la API REST de la Feria del Agricultor de Ciudad Quesada, en Laravel 13 con PostgreSQL. La base ya trae los **puestos** y un recurso resuelto de ejemplo, las **degustaciones**. Cada estudiante construye un recurso más en su propio milestone, siguiendo la guía paso a paso del enunciado. Al final, con los once pull requests fusionados, la feria tiene su API completa.

## Lo que ya trae la base

- Errores en formato RFC 9457 (`application/problem+json`) con `instance` igual al encabezado `X-Request-Id`.
- `Puesto`, con un lugar reservado para la relación de cada milestone en `app/Models/Puesto.php`.
- El ejemplo resuelto de degustaciones: enum, migración, modelo, factory, Form Requests, Resource, controlador, rutas, pruebas y requisitos.
- Rutas por archivo: cada recurso registra las suyas en `routes/api/v1/<recurso>.php`.
- Calidad automática: Pint, Larastan en nivel 6 y PHPUnit. La CI corre las tres en cada pull request contra PostgreSQL.

## Preparar el entorno

```bash
git clone https://github.com/BryanChavesSalas/isw621-feria-api.git
cd isw621-feria-api
composer install
cp .env.example .env
php artisan key:generate
# Cree las bases feria y feria_test en PostgreSQL y ponga su contraseña en DB_PASSWORD de .env
php artisan migrate --seed
php artisan test
```

La documentación de la API (Scramble) queda en http://localhost:8000/docs/api con `php artisan serve`.

## Los once milestones

| Milestone | Recurso | Ruta |
| --- | --- | --- |
| M01 | Productos del puesto | `/api/v1/puestos/{puesto}/productos` |
| M02 | Ofertas de la semana | `/api/v1/puestos/{puesto}/ofertas` |
| M03 | Reseñas de los puestos | `/api/v1/puestos/{puesto}/resenas` |
| M04 | Apartados de producto | `/api/v1/puestos/{puesto}/apartados` |
| M05 | Inspecciones sanitarias | `/api/v1/puestos/{puesto}/inspecciones` |
| M06 | Certificaciones de las fincas | `/api/v1/puestos/{puesto}/certificaciones` |
| M07 | Cosechas anunciadas | `/api/v1/puestos/{puesto}/cosechas` |
| M08 | Recetas con productos de la feria | `/api/v1/puestos/{puesto}/recetas` |
| M09 | Avisos de los puestos | `/api/v1/puestos/{puesto}/avisos` |
| M10 | Colaboradores del puesto | `/api/v1/puestos/{puesto}/colaboradores` |
| M11 | Canastas armadas | `/api/v1/puestos/{puesto}/canastas` |

## Cómo se trabaja (GitHub Flow)

1. Asígnese el issue padre de su milestone y sus cinco sub-issues.
2. Cree la rama desde `main`: `feature/<número del issue padre>-<recurso>`.
3. Haga un commit por sub-issue, con Conventional Commits y el número del sub-issue: `feat(resenas): esquema, modelo y factory (#15)`.
4. Abra el pull request en borrador desde el primer commit, con la plantilla y un `Closes #` por cada issue.
5. Antes de marcarlo como listo para revisión, corra `composer check` y deje la CI en verde.
6. `main` está protegida: nada entra sin pull request, sin la CI en verde y sin la aprobación del docente (CODEOWNERS). La fusión es con squash.

Toque solo sus archivos y su línea de `Puesto.php`. Así los once pull requests se fusionan sin conflictos.

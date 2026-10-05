# Requisitos · <Título del milestone> (M00)

Fuente: entrevista con Doña Ana Lucía Vargas, administradora de la feria (sub-issue de requisitos de su milestone).

## 1. Historia de usuario

Como cliente de la feria quiero ver las degustaciones activas de un puesto para saber qué puedo probar y en qué jornada.

## 2. Criterios de aceptación (reverso de la tarjeta)

-Solo se muestran las degustaciones activas del puesto consultado, ordenadas alfabeticamente por nombre de la A a la Z las degustaciones de otros puestos no deben aparecer.

-Al registrar una degustación indicando el nombre, la cantidad de porciones que se reparten y la jornada en que se realizará, la degustación queda guardada correctamente en el puesto correspondiente.

-Si la cantidad de porciones ingresada está fuera del rango de 10 a 300, el sistema debe rechazar el registro e indicar el motivo del rechazo.

## 3. Clasificación de los enunciados de la entrevista

| Enunciado | Tipo | Por qué |
| --- | --- | ---  |
| E1 | Funcional   | Indica una función o comportamiento que debe realizar el sistema|
| E2 |Restricción  |Define un límite impuesto que el equipo debe respetar y no puede modificar libremente|
| E3 |Supuesto     |Es una condición que se considera verdadera, pero que no ha sido confirmada y representa un posible riesgo|
| E4 |No funcional |Describe una característica de calidad sobre cómo debe funcionar el sistema y no una función específica|

## 4. El enunciado ambiguo, reescrito para que sea verificable

- Antes (E?): «Y el sistema tiene que ser seguro, para que nadie toque las reseñas de otros.»
- Después: <El sistema debe impedir que un usuario modifique o elimine una reseña creada por otro usuario únicamente el autor de la reseña o un usuario administrador autorizado podrá modificarla o eliminarla>

## 5. Prioridad MoSCoW de este milestone

| Elemento | Prioridad |
| --- | --- |
| Dejar una reseña con calificación y canal | <Must> |
| <Ver las reseñas visibles de un puesto> |Must |
| <Que el puesto responda a una reseña> | Could|
| <Subir fotos con la reseña> |Won't |

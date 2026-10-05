# Requisitos · Degustaciones del puesto (M00)

Fuente: entrevista con Doña Ana Lucía Vargas, administradora de la feria (sub-issue de requisitos del milestone).

## 1. Historia de usuario

Como cliente de la feria quiero ver las degustaciones activas de un puesto para saber qué puedo probar y en qué jornada.

## 2. Criterios de aceptación (reverso de la tarjeta)

- Solo veo las degustaciones activas, ordenadas por nombre (A a Z); las de otros puestos no aparecen.
- Al registrar una degustación con nombre de la degustación, porciones que se reparten y jornada en que se reparte, queda guardada en el puesto.
- Si porciones que se reparten queda fuera de 10 a 300, el sistema lo rechaza y dice por qué.

## 3. Clasificación de los enunciados de la entrevista

| Enunciado | Tipo | Por qué |
| --- | --- | --- |
| E1 | Funcional | Dice qué hace el sistema. |
| E2 | Restricción | Es un límite impuesto desde afuera que el equipo no puede cambiar. |
| E3 | Supuesto | Se cree cierto pero no está confirmado: es un riesgo y se documenta. |
| E4 | No funcional | Dice cómo debe hacerlo (calidad), no qué hace. |

## 4. El enunciado ambiguo, reescrito para que sea verificable

- Antes (E4): «Y que las degustaciones se encuentren fácil en el celular.»
- Después: Desde la pantalla de un puesto, el cliente llega a sus degustaciones activas con un toque, y el listado responde en menos de 1 segundo.

## 5. Prioridad MoSCoW de este milestone

| Elemento | Prioridad |
| --- | --- |
| Anunciar una degustación con porciones y jornada | Must |
| Ver las degustaciones activas de un puesto | Must |
| Avisar a los clientes cuando empieza una degustación | Could |
| Reservar una porción por adelantado | Won't |

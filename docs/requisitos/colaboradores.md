# Requisitos · Colaboradores del puesto (M10)

Fuente: entrevista con Don Rafael Solís, productor de quesos (sub-issue de requisitos del milestone, #56).

## 1. Historia de usuario

Como productor de quesos quiero llevar la lista de las personas que me ayudan en el puesto, con su rol y las horas que trabajan a la semana, para organizar los turnos de la feria y cumplir con el límite de horas de la ley.

## 2. Criterios de aceptación (reverso de la tarjeta)

- Solo veo los colaboradores activos de mi puesto, ordenados por nombre (A a Z); los de otros puestos no aparecen.
- Al registrar un colaborador con su nombre, su rol (vendedor, cajero o cargador) y sus horas semanales, queda guardado en el puesto.
- Si las horas semanales quedan fuera de 4 a 48, el sistema rechaza el registro y dice por qué.

## 3. Clasificación de los enunciados de la entrevista

| Enunciado | Tipo | Por qué |
| --- | --- | --- |
| E1 | Restricción | El límite de 48 horas lo impone el Código de Trabajo desde afuera; el equipo no lo puede cambiar. |
| E2 | Supuesto | Se cree que cada colaborador trabaja siempre en el mismo puesto, pero no está confirmado: es un riesgo y se documenta. |
| E3 | Funcional | Dice qué hace el sistema: llevar la lista de colaboradores con su rol y sus horas. |
| E4 | No funcional | Dice cómo debe hacerlo (seguridad de los datos), no qué hace. |

## 4. El enunciado ambiguo, reescrito para que sea verificable

- Antes (E4): «Y que los datos de mi gente estén bien protegidos.»
- Después: Solo el productor dueño del puesto, autenticado, puede consultar o modificar sus colaboradores; cualquier otra solicitud responde 401 o 403 y no muestra ningún dato.

## 5. Prioridad MoSCoW de este milestone

| Elemento | Prioridad |
| --- | --- |
| Registrar un colaborador con rol y horas | Must |
| Ver los colaboradores activos del puesto | Must |
| Calcular el pago semanal de cada colaborador | Could |
| Conectarse con la planilla de la CCSS | Won't |

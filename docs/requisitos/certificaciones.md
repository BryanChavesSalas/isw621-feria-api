# Requisitos · <Título del milestone> (M00)

Fuente: entrevista con  Don Óscar Rodríguez, productor orgánico(sub-issue de requisitos de su milestone).

## 1. Historia de usuario

Como productor de la feria quiero mostrar las certificaciones de mi finca y su vigencia para que los clientes confíen más en mi puesto.

## 2. Criterios de aceptación (reverso de la tarjeta)

- El listado de un puesto muestra solo las certificaciones verificadas, ordenadas por nombre de la A a la Z.
- Al registrar una certificación se guarda su nombre, tipo (orgánico, buenas prácticas o comercio justo) y vigencia en meses.
- Una certificación con vigencia fuera de 1 a 36 meses o con un tipo no permitido es rechazada con un error 422.

## 3. Clasificación de los enunciados de la entrevista

| Enunciado | Tipo | Por qué |
| --- | --- | --- |
| E1 | Supuesto | El "supongo" indica que el productor tiene una creencia, esp no es un hecho confirmado ni un requisito del sistema. |
| E2 | Funcional | Describe lo qué debe hacer el sistema: mostrar certificaciones, tipo y vigencia. |
| E3 | Restricción | El límite de 36 meses lo impone la certificadora, no el equipo de desarrollo. |
| E4 | No funcional |  El pide una cualidad del sistema, que es confiabilidad de los datos mostrados, eso no una acción concreta. |


## 4. El enunciado ambiguo, reescrito para que sea verificable

- Antes (E4): «Que sea confiable y que no muestre datos viejos.»
- Después: El listado de certificaciones debe mostrar únicamente las certificaciones con "verificada = true", ordenadas por nombre (A a Z), sin incluir certificaciones no verificadas.

## 5. Prioridad MoSCoW de este milestone

| Elemento | Prioridad |
| --- | --- |
| Registrar una certificación con tipo y vigencia | Must |
| Ver las certificaciones verificadas de un puesto | Must |
| Recordar al productor un mes antes del vencimiento | Won't |
| Validar el certificado en el sistema de la certificadora | Won't |

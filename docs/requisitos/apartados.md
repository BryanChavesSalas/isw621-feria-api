# Requisitos · Historia de Usuario de Apartados (M20)

Fuente: entrevista con <Don Rafael Solís>, productor de quesos que vende en la feria(sub-issue de requisitos del milestone).

## 1. Historia de usuario

Como <productor de quesos> quiero <mejorar el sistema para apartar queso en mi negocio> para <facilitar la administración tanto pra el cliente como para yo como productor>.

## 2. Criterios de aceptación (reverso de la tarjeta)

- <El cliente al acceder al sistema y seleccionar cantidad y el día de entrega, hay tanto disponibilidad de producto como espacio en la cámara el sistema deberá guardar en el registro, de manera exitosa, el apartado de ese cliente>
- <Si en la camara de frío hay un total de 48 unidades, y un cliente aparta 3, el sistema debe de prohibir realizar este apartado e informar la condición de por qué se niega su apartado>
- <El sistema debe de permitir al administrador observar la condición de estado de entrega de cada apartado, para observar cuales ya han salido y cuales no se vendieron después de su fecha de entrega>

## 3. Clasificación de los enunciados de la entrevista

| Enunciado | Tipo | Por qué |
| --- | --- | --- |
| E1 | <Funcional> | <Es la razón de la existencia del sistema> |
| E2 | <Funcional> | <Es un requisito para el flujo de apartados> |
| E3 | <Restricción> | <El sistema de apartados puede tener un maximo de 50 activos, debido a restricción en almacenamiento fisico> |
| E4 | <Supuesto> | <Se supone que al menos un 90% de los apartados si llegan a tener entrega> | 

## 4. El enunciado ambiguo, reescrito para que sea verificable

- Antes (E1): «<Que apartar sea facilito, que cualquiera lo entienda>»
- Después: <Qué el cliente con sólo digitar su numero de cedula en una tableta encontrada en el cada puesto, este pueda verificar el historial/estado de sus apartados, además de tener una sección muy atractiva para el ojo y super intuitiva en la que la unica dirección que se pueda pensar es en apartar una orden, con los campos minimos necesarios para concretar el apartado.>

## 5. Prioridad MoSCoW de este milestone

| Elemento | Prioridad |
| <Apartar una cantidad para una franja de entrega> | <Must> |
| <Ver los apartados confirmados de un puesto> | <Should> |
| <Avisar por mensaje cuando el apartado está listo> |<Won't> |
| <Cobrar el apartado por adelantado con tarjeta> | <Could> |

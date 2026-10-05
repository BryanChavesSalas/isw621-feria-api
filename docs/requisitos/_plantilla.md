# Requisitos · Colaboradores de puesto (M00)

Fuente: entrevista con Don Rafael Solis (sub-issue de requisitos de su milestone).

## 1. Historia de usuario

Como Productor de quesos quiero llevar la lista de las personas que me ayudan, con su rol y las horas que trabajan a la semana para que los datos de mi gente estén bien protegidos

## 2. Criterios de aceptación (reverso de la tarjeta)

Condición: No permitir registrar más de 48 horas de trabajo semanales por trabajador.
Verificable: Si se intenta registrar a un trabajador con más de 48 horas semanales, el sistema debe rechazar el registro o mostrar un mensaje indicando que se supera el límite permitido.

Condición: Permitir registrar a cada trabajador junto con su rol y las horas semanales trabajadas.
Verificable: Al guardar un trabajador con su nombre, rol y horas semanales, el sistema debe mostrar correctamente esos datos en la lista de trabajadores.

Condición: Proteger la información de los trabajadores.
Verificable: Un usuario sin autorización no debe poder consultar ni modificar los datos de los trabajadores.

## 3. Clasificación de los enunciados de la entrevista

E1: Restriccion, Porque no se pueden sobrepasar las horas que el codigo de trabajo establece.
E2: Supuesto, Poque se asume que todos trabajan en el mismo puesto siempre.
E3: Funcional, Porque es la funcion que el cliente solicita que cumpla el sistema.
E4: No funcional, Porque son las implementaciones de seguridad que el sistema debe de llevar.

## 4. El enunciado ambiguo, reescrito para que sea verificable

- Antes[E4]: "Y que los datos de mi gente estén bien protegidos."
- Después: El sistema deberá permitir acceso a los datos personales de los empleados únicamente a usuarios administradores con autorizacion.

## 5. Prioridad MoSCoW de este milestone
 Registrar un colaborador con rol y horas | Must 
 Ver los colaboradores activos del puesto | Must 
 Calcular el pago semanal de cada colaborador | Should 
 Conectarse con la planilla de la CCSS | Won't 
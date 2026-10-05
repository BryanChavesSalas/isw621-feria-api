# Requisitos · Reseñas de los puestos (M03)

Fuente: entrevista con Doña Ana Lucía Vargas, administradora de la feria (#14).

## 1. Historia de usuario

Como cliente de la feria quiero dejar una reseña con una calificación de una a cinco estrellas y especificar el canal por el que la realizo para compartir mi experiencia sobre un puesto.

## 2. Criterios de aceptación (reverso de la tarjeta)

-El cliente puede seleccionar un puesto, asignarle una calificación de 1 a 5 estrellas e indicar si la reseña fue realizada en persona, por WhatsApp o en la web.
-Al registrar una reseña válida, esta queda asociada únicamente al puesto seleccionado y puede mostrarse junto con su alias.
-El sistema no muestra públicamente el nombre completo ni el número de teléfono de la persona que escribe la reseña.

## 3. Clasificación de los enunciados de la entrevista

Enunciado: [E1] Quiero que los clientes califiquen cada puesto de una a cinco estrellas y digan si lo hicieron en persona, por WhatsApp o en la web.
Tipo: Funcional.
Por qué: El sistema debe permitirle al usuario calificar cada puesto de una a cinco estrella y decir de que manera lo hicieron (en persona, por whatsapp o la web).

Enunciado: [E2] Creo que la gente va a ser honesta con las calificaciones.
Tipo: Supuesto.
Por qué: La honestidad por parte del cliente es es un límite impuesto desde afuera que el equipo no puede cambiar.

Enunciado: [E3] Por la Ley 8968 no podemos publicar el nombre completo ni el teléfono de quien escribe: solo un alias.
Tipo: Restricción.
Por qué: La Ley 8968 impone límites sobre los datos personales que pueden publicarse.

Enunciado: [E4] Y el sistema tiene que ser seguro, para que nadie toque las reseñas de otros.
Tipo: No funcional.
Por qué: Define una caracteristica de como el sistema debe comportarse ante la privacidad de cada usuario, no dice qué hacer para cumplor con eso.

## 4. El enunciado ambiguo, reescrito para que sea verificable

-Antes (E4): «Y el sistema tiene que ser seguro, para que nadie toque las reseñas de otros.»

-Después: El sistema deberá permitir modificar o eliminar una reseña únicamente al usuario que la creó o a un usuario autorizado con permisos de administración.

## 5. Prioridad MoSCoW de este milestone

Elemento: Dejar una reseña con calificación y canal
Prioridad: Must 

Elemento: Ver las reseñas visibles de un puesto
Prioridad: Must

Elemento: Que el puesto responda a una reseña
Prioridad: Could

Elemento: Subir fotos con la reseña
Prioridad: Won´t
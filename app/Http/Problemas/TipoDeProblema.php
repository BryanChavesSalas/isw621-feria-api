<?php

namespace App\Http\Problemas;

enum TipoDeProblema: string
{
    case SolicitudInvalida = 'solicitud-invalida';
    case NoAutenticado = 'no-autenticado';
    case Prohibido = 'prohibido';
    case NoEncontrado = 'no-encontrado';
    case MetodoNoPermitido = 'metodo-no-permitido';
    case Conflicto = 'conflicto';
    case DatosInvalidos = 'datos-invalidos';
    case DemasiadasSolicitudes = 'demasiadas-solicitudes';
    case ErrorInterno = 'error-interno';
    case ServicioNoDisponible = 'servicio-no-disponible';

    /** Código HTTP con que responde este tipo de problema. */
    public function estado(): int
    {
        return match ($this) {
            self::SolicitudInvalida => 400,
            self::NoAutenticado => 401,
            self::Prohibido => 403,
            self::NoEncontrado => 404,
            self::MetodoNoPermitido => 405,
            self::Conflicto => 409,
            self::DatosInvalidos => 422,
            self::DemasiadasSolicitudes => 429,
            self::ErrorInterno => 500,
            self::ServicioNoDisponible => 503,
        };
    }

    /** Resumen legible que no cambia entre ocurrencias. */
    public function titulo(): string
    {
        return match ($this) {
            self::SolicitudInvalida => 'Solicitud inválida',
            self::NoAutenticado => 'No autenticado',
            self::Prohibido => 'Acceso prohibido',
            self::NoEncontrado => 'Recurso no encontrado',
            self::MetodoNoPermitido => 'Método no permitido',
            self::Conflicto => 'Conflicto',
            self::DatosInvalidos => 'Datos inválidos',
            self::DemasiadasSolicitudes => 'Demasiadas solicitudes',
            self::ErrorInterno => 'Error interno',
            self::ServicioNoDisponible => 'Servicio no disponible',
        };
    }

    /** Explicación fija, escrita para el cliente. */
    public function detalle(): string
    {
        return match ($this) {
            self::SolicitudInvalida => 'La solicitud no se puede procesar tal como viene.',
            self::NoAutenticado => 'Envíe un token válido en el encabezado Authorization.',
            self::Prohibido => 'No tiene permiso para realizar esta acción.',
            self::NoEncontrado => 'El recurso solicitado no existe.',
            self::MetodoNoPermitido => 'Esta ruta no acepta el método HTTP utilizado.',
            self::Conflicto => 'La solicitud choca con el estado actual del recurso.',
            self::DatosInvalidos => 'Uno o más campos no cumplen las reglas.',
            self::DemasiadasSolicitudes => 'Superó el límite de solicitudes. Espere antes de intentar de nuevo.',
            self::ErrorInterno => 'Ocurrió un error inesperado. Si se repite, reporte el valor de "instance".',
            self::ServicioNoDisponible => 'Un servicio externo no respondió. Intente de nuevo en unos minutos.',
        };
    }

    /** URI estable del tipo, igual en todos los ambientes. */
    public function uri(): string
    {
        return rtrim((string) config('feria.problemas_uri'), '/').'/'.$this->value;
    }

    /** Tipo genérico de un código HTTP, o null si el código no tiene semántica propia. */
    public static function paraEstado(int $estado): ?self
    {
        foreach (self::cases() as $tipo) {
            if ($tipo->estado() === $estado) {
                return $tipo;
            }
        }

        return null;
    }
}

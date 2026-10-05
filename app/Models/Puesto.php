<?php

namespace App\Models;

use Database\Factories\PuestoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable(['nombre', 'telefono'])]
class Puesto extends Model
{
    /** @use HasFactory<PuestoFactory> */
    use HasFactory;

    /**
     * Las rutas anidadas (puestos/{puesto}/resenas/{resena}) buscan el hijo con la
     * relación en plural. Laravel pluraliza en inglés; el puesto usa el plural
     * en español: resena → resenas, inspeccion → inspecciones.
     *
     * @param  string  $childType
     */
    protected function childRouteBindingRelationshipName($childType): string
    {
        $nombre = Str::camel($childType);

        return preg_match('/[aeiou]$/', $nombre) === 1 ? $nombre.'s' : $nombre.'es';
    }

    /**
     * Degustaciones del puesto: el ejemplo resuelto.
     *
     * @return HasMany<Degustacion, $this>
     */
    public function degustaciones(): HasMany
    {
        return $this->hasMany(Degustacion::class);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Un lugar por milestone. Escriba su relación SOLO debajo de su línea,
    // sin tocar las demás: así los 11 pull requests se fusionan sin conflictos.
    // ─────────────────────────────────────────────────────────────────────

    // M01 · productos(): escriba su relación debajo de esta línea.

    // M02 · ofertas(): escriba su relación debajo de esta línea.

    // M03 · resenas(): escriba su relación debajo de esta línea.

    // M04 · apartados(): escriba su relación debajo de esta línea.

    // M05 · inspecciones(): escriba su relación debajo de esta línea.

    // M06 · certificaciones(): escriba su relación debajo de esta línea.

    // M07 · cosechas(): escriba su relación debajo de esta línea.
    /**
     * Cosechas del puesto.
     *
     * @return HasMany<Cosecha, $this>
     */
    public function cosechas(): HasMany
    {
        return $this->hasMany(Cosecha::class);
    }

    // M08 · recetas(): escriba su relación debajo de esta línea.

    // M09 · avisos(): escriba su relación debajo de esta línea.

    // M10 · colaboradores(): escriba su relación debajo de esta línea.

    // M11 · canastas(): escriba su relación debajo de esta línea.
}

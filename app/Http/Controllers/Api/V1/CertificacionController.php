<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\ActualizarCertificacionRequest;
use App\Http\Requests\V1\GuardarCertificacionRequest;
use App\Http\Resources\V1\CertificacionResource;
use App\Models\Certificacion;
use App\Models\Puesto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class CertificacionController
{
    /** Lista las certificaciones verificadas, ordenadas por nombre (A a Z), de 15 en 15. */
    public function index(Puesto $puesto): AnonymousResourceCollection
    {
        return CertificacionResource::collection(
            $puesto->certificaciones()->where('verificada', true)->orderBy('nombre')->paginate(15),
        );
    }

    /** Registra una certificación en el puesto y responde 201 con su dirección en Location. */
    public function store(GuardarCertificacionRequest $request, Puesto $puesto): JsonResponse
    {
        $certificacion = $puesto->certificaciones()->create($request->validated());

        return (new CertificacionResource($certificacion->refresh()))
            ->response()
            ->setStatusCode(201)
            ->header('Location', route('v1.puestos.certificaciones.show', [$puesto, $certificacion]));
    }

    /** Detalle de una certificación del puesto. */
    public function show(Puesto $puesto, Certificacion $certificacion): CertificacionResource
    {
        return new CertificacionResource($certificacion);
    }

    /** Cambia solo los campos que llegan en la solicitud. */
    public function update(ActualizarCertificacionRequest $request, Puesto $puesto, Certificacion $certificacion): CertificacionResource
    {
        $certificacion->update($request->validated());

        return new CertificacionResource($certificacion);
    }

    /** Elimina la certificación y responde 204 sin cuerpo. */
    public function destroy(Puesto $puesto, Certificacion $certificacion): Response
    {
        $certificacion->delete();

        return response()->noContent();
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class BaseDeDatosTest extends TestCase
{
    /** Las pruebas corren en PostgreSQL, sobre la base de pruebas y no sobre la de trabajo. */
    #[Test]
    public function las_pruebas_corren_en_la_base_de_pruebas_de_postgresql(): void
    {
        $this->assertSame('pgsql', DB::connection()->getDriverName());
        $this->assertSame('feria_test', DB::connection()->getDatabaseName());
    }
}

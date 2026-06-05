<?php

namespace Tests\Feature;

use App\Models\Cif;
use Tests\TestCase;

class CifRouteKeyTest extends TestCase
{
    public function test_cif_route_key_is_encoded_and_decodable(): void
    {
        $encoded = Cif::encodeRouteKey('CIF000001');

        $this->assertNotSame('CIF000001', $encoded);
        $this->assertSame('CIF000001', Cif::decodeRouteKey($encoded));
    }

    public function test_plain_cif_id_is_not_a_valid_route_key(): void
    {
        $this->assertNull(Cif::decodeRouteKey('CIF000001'));
    }
}

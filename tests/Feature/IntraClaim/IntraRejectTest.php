<?php

namespace Tests\Feature\IntraClaim;

use Tests\TestCase;

class IntraRejectTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature\IntraClaim;

use Tests\TestCase;

class IntraClaimindexTest extends TestCase
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

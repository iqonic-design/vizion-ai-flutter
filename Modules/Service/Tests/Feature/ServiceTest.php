<?php

namespace Modules\Service\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test Service.
     *
     * @return void
     */
    public function test_backend_services_list_page()
    {
        $this->signInAsAdmin();

        $response = $this->get('app/services');

        $response->assertStatus(200);
    }
}

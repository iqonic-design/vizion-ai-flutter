<?php

namespace Modules\CustomTemplate\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomTemplateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test CustomTemplate.
     *
     * @return void
     */
    public function test_backend_customtemplates_list_page()
    {
        $this->signInAsAdmin();

        $response = $this->get('app/customtemplates');

        $response->assertStatus(200);
    }
}

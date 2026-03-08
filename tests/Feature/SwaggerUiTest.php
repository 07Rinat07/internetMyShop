<?php

namespace Tests\Feature;

use Tests\TestCase;

class SwaggerUiTest extends TestCase
{
    public function test_swagger_ui_page_is_available()
    {
        $response = $this->get('/swagger');

        $response->assertOk();
        $response->assertSee('internetMyShop API');
        $response->assertSee('SwaggerUIBundle');
    }

    public function test_openapi_spec_is_served_from_web_route()
    {
        $response = $this->get('/swagger/openapi.yaml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/yaml; charset=UTF-8');
        $response->assertSee('openapi: 3.1.1');
        $response->assertSee('url: /api/v1');
    }
}

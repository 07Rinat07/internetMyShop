<?php

namespace App\Http\Controllers;

class SwaggerController extends Controller
{
    public function index()
    {
        return view('swagger.index', [
            'specUrl' => route('swagger.spec'),
        ]);
    }

    public function spec()
    {
        $path = base_path('docs/openapi.yaml');

        abort_unless(is_file($path), 404);

        return response(file_get_contents($path), 200, [
            'Content-Type' => 'application/yaml; charset=UTF-8',
        ]);
    }
}

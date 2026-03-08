<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Symfony\Component\Yaml\Yaml;
use Tests\TestCase;

class OpenApiContractTest extends TestCase
{
    public function test_openapi_paths_match_api_routes(): void
    {
        $spec = Yaml::parseFile(base_path('docs/openapi.yaml'));
        $documentedPaths = array_keys($spec['paths'] ?? []);
        sort($documentedPaths);

        $routePaths = collect(Route::getRoutes()->getRoutes())
            ->filter(fn ($route) => str_starts_with($route->uri(), 'api/v1/'))
            ->map(fn ($route) => '/'.$this->normalizeRoutePath($route->uri()))
            ->unique()
            ->sort()
            ->values()
            ->all();

        $this->assertSame($documentedPaths, $routePaths);
    }

    private function normalizeRoutePath(string $uri): string
    {
        $uri = preg_replace('#^api/v1/#', '', $uri) ?? $uri;

        return preg_replace('#\{([^}:]+):[^}]+\}#', '{$1}', $uri) ?? $uri;
    }
}

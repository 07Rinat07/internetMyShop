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

    public function test_openapi_methods_match_api_routes(): void
    {
        $spec = Yaml::parseFile(base_path('docs/openapi.yaml'));
        // Keep docs honest when a route reuses the same URI but gains or loses HTTP verbs.
        $documentedMethods = collect($spec['paths'] ?? [])
            ->mapWithKeys(function (array $operations, string $path): array {
                $methods = collect(array_keys($operations))
                    ->map(static fn (string $method): string => strtolower($method))
                    ->filter(fn (string $method): bool => in_array($method, ['get', 'post', 'put', 'patch', 'delete'], true))
                    ->sort()
                    ->values()
                    ->all();

                return [$path => $methods];
            })
            ->sortKeys()
            ->all();

        $routeMethods = collect(Route::getRoutes()->getRoutes())
            ->filter(fn ($route) => str_starts_with($route->uri(), 'api/v1/'))
            ->reduce(function (array $carry, $route): array {
                $path = '/'.$this->normalizeRoutePath($route->uri());
                $methods = collect($route->methods())
                    ->map(static fn (string $method): string => strtolower($method))
                    ->reject(fn (string $method): bool => in_array($method, ['head', 'options'], true))
                    ->sort()
                    ->values()
                    ->all();

                $carry[$path] = array_values(array_unique(array_merge($carry[$path] ?? [], $methods)));
                sort($carry[$path]);

                return $carry;
            }, []);

        ksort($routeMethods);

        $this->assertSame($documentedMethods, $routeMethods);
    }

    private function normalizeRoutePath(string $uri): string
    {
        $uri = preg_replace('#^api/v1/#', '', $uri) ?? $uri;

        // Strip Laravel parameter binding hints so `{product:slug}` matches OpenAPI `{product}`.
        return preg_replace('#\{([^}:]+):[^}]+\}#', '{$1}', $uri) ?? $uri;
    }
}

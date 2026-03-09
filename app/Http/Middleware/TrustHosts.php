<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array
     */
    public function hosts()
    {
        $patterns = [];

        foreach ($this->configuredHosts() as $host) {
            $patterns[] = $this->hostPattern($host);
        }

        return array_values(array_filter(array_unique($patterns)));
    }

    /**
     * @return array<int, string>
     */
    private function configuredHosts(): array
    {
        $hosts = [
            $this->extractHost((string) config('app.url')),
            $this->extractHost((string) env('FRONTEND_URL', '')),
            $this->extractHost((string) config('payments.status_page_base_url', '')),
        ];

        foreach (explode(',', (string) env('TRUSTED_HOSTS', '')) as $host) {
            $hosts[] = $this->extractHost($host);
        }

        if (app()->environment(['local', 'testing', 'docker'])) {
            $hosts = array_merge($hosts, ['localhost', '127.0.0.1', '::1', 'app']);
        }

        return array_values(array_unique(array_filter($hosts)));
    }

    private function extractHost(string $value): ?string
    {
        $value = trim($value);

        if ($value === '') {
            return null;
        }

        $host = parse_url(str_contains($value, '://') ? $value : "http://{$value}", PHP_URL_HOST);

        if (! is_string($host) || $host === '') {
            return null;
        }

        return trim($host, '[]');
    }

    private function hostPattern(string $host): string
    {
        if (filter_var($host, FILTER_VALIDATE_IP) || ! str_contains($host, '.')) {
            return '^'.preg_quote($host).'$';
        }

        return '^(.+\\.)?'.preg_quote($host).'$';
    }
}

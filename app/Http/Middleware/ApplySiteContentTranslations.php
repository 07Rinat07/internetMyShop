<?php

namespace App\Http\Middleware;

use App\Services\SiteContent\SiteContentService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplySiteContentTranslations
{
    public function __construct(
        private readonly SiteContentService $siteContentService,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $this->siteContentService->applyTranslations(app()->getLocale());

        return $next($request);
    }
}

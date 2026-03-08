<?php

namespace Database\Seeders;

use App\Models\SiteContent;
use App\Services\SiteContent\SiteContentService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class StorefrontSiteContentSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('site_contents')) {
            return;
        }

        if (SiteContent::query()->exists()) {
            return;
        }

        app(SiteContentService::class)->syncDefaults();
    }
}

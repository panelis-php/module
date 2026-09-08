<?php

namespace Panelis\Module\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    private const string NAMESPACE = 'module';

    public function boot(): void
    {
        $this->syncActivityLoggingSetting();

        $this->loadTranslationsFrom(__DIR__.'/../../lang', self::NAMESPACE);

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->loadViewsFrom(__DIR__.'/../../resources/views', self::NAMESPACE);
    }

    public function register(): void {}

    private function syncActivityLoggingSetting(): void
    {
        $settingClass = 'Panelis\\Setting\\Models\\Setting';

        if (class_exists($settingClass) && config()->has('activitylog.enabled')) {
            config()->set('activitylog.enabled', $settingClass::get('activity.enabled', config('activitylog.enabled')));
        }
    }
}

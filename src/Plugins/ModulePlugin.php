<?php

declare(strict_types=1);

namespace Panelis\Module\Plugins;

use Filament\Contracts\Plugin;
use Filament\Panel;

class ModulePlugin implements Plugin
{
    public function getId(): string
    {
        return 'module';
    }

    public function register(Panel $panel): void
    {
        $panel->discoverPages(__DIR__.'/../Panel/Pages', 'Panelis\\Module\\Panel\\Pages');
    }

    public function boot(Panel $panel): void {}
}

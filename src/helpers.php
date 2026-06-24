<?php

if (! function_exists('get_packages')) {
    function get_packages(): array
    {
        $installed = json_decode(
            file_get_contents(base_path('vendor/composer/installed.json')),
            true,
        );

        return $installed['packages'];
    }
}

if (! function_exists('get_plugins')) {
    function get_plugins(): array
    {
        return collect(get_packages())
            ->pluck('extra.panelis.plugins')
            ->flatten()
            ->filter()
            ->map(fn (string $plugin): object => app($plugin))
            ->values()
            ->all();
    }
}

if (! function_exists('get_modules')) {
    function get_modules(): array
    {
        return collect(get_packages())
            ->filter(fn (array $package) => isset($package['extra']['panelis']))
            ->values()
            ->all();
    }
}

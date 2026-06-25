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
            ->filter(function (array $package): bool {
                return data_get($package, 'extra.panelis') || collect(data_get($package, 'keywords', []))
                    ->contains(fn (string $keyword) => str($keyword)->lower()->contains('panelis'));
            })
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

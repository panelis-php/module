<?php

namespace Panelis\Module\Panel\Pages;

use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Panelis\Module\Panel\Resources\ModuleResource\Enums\ModulePermission;

class ViewModule extends Page
{
    use InteractsWithInfolists;

    protected static ?string $slug = 'modules/view';

    protected string $view = 'module::filament.pages.view-module';

    public array $moduleData = [];

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function canAccess(): bool
    {
        return user_can(ModulePermission::Read);
    }

    public function mount(): void
    {
        $module = request()->query('module');
        abort_if(empty($module), 404);

        $this->moduleData = collect(get_modules())
            ->first(fn (array $package): bool => $package['name'] === $module) ?? [];

        abort_if(empty($this->moduleData), 404);
    }

    public function getTitle(): string
    {
        return $this->moduleData['name'];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('module::module.details'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('module::module.name'))
                            ->state($this->moduleData['name']),

                        TextEntry::make('description')
                            ->label(__('module::module.description'))
                            ->state($this->moduleData['description'] ?? '-'),

                        TextEntry::make('license')
                            ->label(__('module::module.license'))
                            ->state(is_array($this->moduleData['license'] ?? null) ? implode(', ', $this->moduleData['license']) : ($this->moduleData['license'] ?? '-')),

                        TextEntry::make('time')
                            ->label(__('module::module.updated_at'))
                            ->state($this->moduleData['time'] ?? '-'),

                        TextEntry::make('keywords')
                            ->label(__('module::module.keywords'))
                            ->state(implode(', ', $this->moduleData['keywords'] ?? []) ?: '-'),

                        KeyValueEntry::make('authors')
                            ->label(__('module::module.author'))
                            ->keyLabel(__('module::module.name'))
                            ->valueLabel(__('module::module.email'))
                            ->state(collect($this->moduleData['authors'] ?? [])->mapWithKeys(fn (array $author): array => [
                                $author['name'] => $author['email'] ?? '-',
                            ])->all()),

                        KeyValueEntry::make('require')
                            ->label(__('module::module.dependency'))
                            ->keyLabel(__('module::module.package'))
                            ->valueLabel(__('module::module.version'))
                            ->state($this->moduleData['require'] ?? []),
                    ]),
            ]);
    }
}

<?php

namespace Panelis\Module\Panel\Pages;

use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Panelis\Module\Panel\Resources\Resources\ModuleResource\Enums\ModulePermission;
use Panelis\Package;

class Module extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $slug = 'modules';

    protected string $view = 'module::filament.pages.module';

    public static function canAccess(): bool
    {
        return user_can(ModulePermission::Browse);
    }

    public static function getLabel(): ?string
    {
        return __('module::module.label');
    }

    public static function getNavigationLabel(): string
    {
        return __('module::module.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('ui.system');
    }

    public function table(Table $table): Table
    {
        return $table
            ->records(fn (): array => Package::getPanelisModules())
            ->columns([
                TextColumn::make('name')
                    ->label(__('module::module.name')),

                TextColumn::make('description')
                    ->label(__('module::module.description')),

                TextColumn::make('version')
                    ->label(__('module::module.version')),
            ]);
    }
}

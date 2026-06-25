<?php

namespace Panelis\Module\Panel\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Panelis\Module\Panel\Resources\ModuleResource\Enums\ModulePermission;

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
            ->records(fn (): array => get_modules())
            ->stackedOnMobile()
            ->columns([
                TextColumn::makeSinceDate('time', __('module::module.updated_at')),

                TextColumn::make('name')
                    ->label(__('module::module.name')),

                TextColumn::make('description')
                    ->label(__('module::module.description'))
                    ->wrap(),

                TextColumn::make('version')
                    ->label(__('module::module.version')),
            ])
            ->recordActions([
                Action::make('support')
                    ->label(__('module::module.btn.support'))
                    ->icon(Heroicon::BugAnt)
                    ->hidden(fn (array $record): bool => empty($record['support']))
                    ->url(fn (array $record): ?string => data_get($record, 'support.issues'))
                    ->openUrlInNewTab(),
            ]);
    }
}

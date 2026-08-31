<?php

namespace Panelis\Module\Panel\Resources\ModuleResource\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum ModulePermission: string implements HasLabel
{
    case Browse = 'BrowseModule';

    case Read = 'ReadModule';

    case Edit = 'EditModule';

    case Add = 'AddModule';

    case Delete = 'DeleteModule';

    public function getLabel(): string
    {
        return __(sprintf('module::permission.name_%s', Str::snake($this->value)));
    }
}

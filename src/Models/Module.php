<?php

namespace Panelis\Module\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panelis\Module\Database\Factories\ModuleFactory;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

/**
 * @property string $name
 * @property bool $is_enabled
 */
#[UseFactory(ModuleFactory::class)]
class Module extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
        'description',
        'is_enabled',
        'is_builtin',
    ];

    protected $casts = [
        'is_enabled' => 'bool',
        'is_builtin' => 'bool',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('module')
            ->logOnly(['name', 'description', 'is_enabled', 'is_builtin'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return 'module::activity.'.$eventName;
    }
}

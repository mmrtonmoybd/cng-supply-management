<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AssetDocument extends Model
{
    use LogsActivity;

    protected $fillable = [
        'asset_id',
        'name',
        'path',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function getDocumentUrlAttribute()
    {
        return asset('storage/'.$this->path);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Asset document')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
}

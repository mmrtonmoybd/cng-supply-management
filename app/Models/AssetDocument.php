<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetDocument extends Model
{
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
}

<?php

namespace App\Modules\Specialization\Models;

use App\Modules\Master\Models\Master;
use App\Modules\Service\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specialization extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function masters(): BelongsToMany
    {
        return $this->belongsToMany(Master::class, 'master_specialization');
    }
}

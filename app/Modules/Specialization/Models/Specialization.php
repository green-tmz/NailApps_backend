<?php

namespace App\Modules\Specialization\Models;

use App\Modules\Master\Models\Master;
use App\Modules\Service\Models\Service;
use App\Modules\Specialization\Database\Factories\SpecializationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specialization extends Model
{
    /** @use HasFactory<SpecializationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * @return SpecializationFactory
     */
    protected static function newFactory(): SpecializationFactory
    {
        return SpecializationFactory::new();
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function masters(): BelongsToMany
    {
        return $this->belongsToMany(Master::class, 'master_specialization');
    }
}

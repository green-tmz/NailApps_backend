<?php

namespace App\Modules\Service\Models;

use App\Modules\Appointment\Models\Appointment;
use App\Modules\Master\Models\Master;
use App\Modules\Service\Database\Factories\ServiceFactory;
use App\Modules\Specialization\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $id
 * @property mixed $user_id
 */
class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;

    protected $fillable = [
        'specialization_id',
        'name',
        'description',
        'duration',
        'price',
    ];

    protected static function newFactory(): ServiceFactory
    {
        return ServiceFactory::new();
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }

    public function master(): BelongsToMany
    {
        return $this->belongsToMany(Master::class, 'master_service');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}

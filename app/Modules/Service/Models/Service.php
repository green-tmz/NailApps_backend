<?php

namespace App\Modules\Service\Models;

use App\Modules\Appointment\Models\Appointment;
use App\Modules\Master\Models\Master;
use App\Modules\Specialization\Models\Specialization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'specialization_id',
        'name',
        'description',
        'duration',
        'price',
    ];

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }

    public function masters(): BelongsToMany
    {
        return $this->belongsToMany(Master::class, 'master_service');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}

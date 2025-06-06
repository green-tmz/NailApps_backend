<?php

namespace App\Modules\Master\Models;

use App\Models\User;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Schedule\Models\Schedule;
use App\Modules\Service\Models\Service;
use App\Modules\Specialization\Models\Specialization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed $user
 */
class Master extends Model
{
    protected $fillable = [
        'user_id',
        'experience',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany(Specialization::class, 'master_specialization');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'master_service');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function schedule(): HasOne
    {
        return $this->hasOne(Schedule::class);
    }
}

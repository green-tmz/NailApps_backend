<?php

namespace App\Modules\Client\Models;

use App\Modules\Auth\Models\User;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Client\Database\Factories\ClientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $user_id
 * @property mixed $id
 * @property mixed $master_id
 * @property mixed $user
 */
class Client extends Model
{
    /** @use HasFactory<ClientFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'email',
        'first_name',
        'last_name',
        'second_name',
        'birth_date',
        'notes',
        'preferences',
    ];

    protected $casts = [
        'preferences' => 'array',
        'birth_date' => 'date',
    ];


    protected static function newFactory(): ClientFactory
    {
        return ClientFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}

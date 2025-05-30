<?php

namespace App\Modules\Schedule\Models;

use App\Modules\Master\Models\Master;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $fillable = [
        'master_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_working',
    ];

    public function master(): BelongsTo
    {
        return $this->belongsTo(Master::class);
    }
}

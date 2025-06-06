<?php

namespace App\Modules\Master\Models;

use Illuminate\Database\Eloquent\Model;

class MasterSpecialization extends Model
{
    protected $fillable = [
        'master_id', 'specialization_id',
    ];
}

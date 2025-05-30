<?php

namespace App\Modules\Notification\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function getNotificationTypeAttribute()
    {
        return str_replace('App\\Notifications\\', '', $this->type);
    }
}

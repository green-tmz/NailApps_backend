<?php

namespace App\Modules\Material\Models;

use App\HasFinancials;
use App\Modules\Service\Models\Service;
use Database\Factories\Modules\Material\Database\Factories\MaterialFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property mixed $user_id
 */
class Material extends Model
{
    /** @use HasFactory<MaterialFactory> */
    use HasFactory;
    use HasFinancials;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'unit',
        'price',
        'min_threshold',
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'material_service')
            ->withPivot('quantity_used');
    }
}

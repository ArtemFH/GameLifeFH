<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $validate)
 * @method static find($id)
 * @method static where(string $string, $Type)
 */
class Field extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'size_x',
        'size_y',
        'steps'
    ];

    /**
     * @return HasMany
     */
    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class);
    }
}

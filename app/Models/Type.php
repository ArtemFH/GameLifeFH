<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $validate)
 * @method static find($id)
 * @method static where(string $string, $Type)
 * @method static whereName(string $string)
 */
class Type extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name'
    ];
}

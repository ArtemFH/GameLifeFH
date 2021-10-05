<?php

namespace App\Models;

use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $validate)
 * @method static find($id)
 * @method static where(string $string, $Type)
 * @method static whereFieldId($id)
 */
class Animal extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'steps',
        'current_x',
        'current_y',
        'type_id',
        'field_id'
    ];

    protected $hidden = [
        'id',
        'steps',
        'current_x',
        'current_y',
        'type_id',
        'field_id'
    ];

    protected $appends = [
        'X',
        'Y',
        'N',
        'type',
        'field'
    ];

    /**
     * @return HigherOrderBuilderProxy|mixed|null
     */
    public function getXAttribute()
    {
        return $this->attributes['current_x'];
    }

    /**
     * @return HigherOrderBuilderProxy|mixed|null
     */
    public function getYAttribute()
    {
        return $this->attributes['current_y'];
    }

    /**
     * @return HigherOrderBuilderProxy|mixed|null
     */
    public function getNAttribute()
    {
        return $this->attributes['steps'];
    }

    /**
     * @return HigherOrderBuilderProxy|mixed|null
     */
    public function getTypeAttribute()
    {
        return $this->type()->first()->name;
    }

    /**
     * @return HigherOrderBuilderProxy|mixed|null
     */
    public function getFieldAttribute()
    {
        return $this->attributes['field_id'];
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * @return BelongsTo
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }
}

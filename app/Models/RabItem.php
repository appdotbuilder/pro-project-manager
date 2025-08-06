<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\RabItem
 *
 * @property int $id
 * @property int $rab_id
 * @property string $item_code
 * @property string $description
 * @property string $unit
 * @property string $quantity
 * @property string $unit_price
 * @property string $total_price
 * @property string|null $notes
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Rab $rab
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|RabItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RabItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RabItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|RabItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RabItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RabItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RabItem whereItemCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RabItem whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RabItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RabItem whereRabId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RabItem whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RabItem whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RabItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RabItem whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RabItem whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class RabItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'rab_id',
        'item_code',
        'description',
        'unit',
        'quantity',
        'unit_price',
        'total_price',
        'notes',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'decimal:3',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the RAB that owns the item.
     */
    public function rab(): BelongsTo
    {
        return $this->belongsTo(Rab::class);
    }
}
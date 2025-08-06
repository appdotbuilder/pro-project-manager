<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ActivityPhoto
 *
 * @property int $id
 * @property int $daily_activity_id
 * @property string $file_path
 * @property string $file_name
 * @property string $file_type
 * @property int $file_size
 * @property string|null $caption
 * @property array|null $metadata
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DailyActivity $dailyActivity
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityPhoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityPhoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityPhoto query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityPhoto whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityPhoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityPhoto whereDailyActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityPhoto whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityPhoto whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityPhoto whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityPhoto whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityPhoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityPhoto whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityPhoto whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityPhoto whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class ActivityPhoto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'daily_activity_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'caption',
        'metadata',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the daily activity that owns the photo.
     */
    public function dailyActivity(): BelongsTo
    {
        return $this->belongsTo(DailyActivity::class);
    }
}
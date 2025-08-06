<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Rab
 *
 * @property int $id
 * @property int $project_id
 * @property int $scope_id
 * @property int $uploaded_by
 * @property string $title
 * @property string|null $description
 * @property string $file_path
 * @property string $file_name
 * @property string $file_type
 * @property int $file_size
 * @property string|null $total_amount
 * @property string $version
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\Scope $scope
 * @property-read \App\Models\User $uploadedBy
 * @property-read \App\Models\User|null $approvedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RabItem> $items
 * @property-read int|null $items_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Rab newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rab newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rab query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereScopeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereUploadedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rab whereVersion($value)

 * 
 * @mixin \Eloquent
 */
class Rab extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'project_id',
        'scope_id',
        'uploaded_by',
        'title',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'total_amount',
        'version',
        'status',
        'notes',
        'approved_at',
        'approved_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the project that owns the RAB.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the scope that owns the RAB.
     */
    public function scope(): BelongsTo
    {
        return $this->belongsTo(Scope::class);
    }

    /**
     * Get the user who uploaded the RAB.
     */
    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the user who approved the RAB.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the items for the RAB.
     */
    public function items(): HasMany
    {
        return $this->hasMany(RabItem::class);
    }
}
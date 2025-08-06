<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\DailyActivity
 *
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 * @property int|null $scope_id
 * @property \Illuminate\Support\Carbon $activity_date
 * @property string $activity_type
 * @property string $description
 * @property array|null $manpower
 * @property array|null $materials
 * @property string|null $work_progress_weight
 * @property string|null $notes
 * @property string|null $weather
 * @property string|null $safety_notes
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $submitted_at
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Scope|null $scope
 * @property-read \App\Models\User|null $approvedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ActivityPhoto> $photos
 * @property-read int|null $photos_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity query()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereActivityDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereActivityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereManpower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereMaterials($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereSafetyNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereScopeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereWeather($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyActivity whereWorkProgressWeight($value)

 * 
 * @mixin \Eloquent
 */
class DailyActivity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'scope_id',
        'activity_date',
        'activity_type',
        'description',
        'manpower',
        'materials',
        'work_progress_weight',
        'notes',
        'weather',
        'safety_notes',
        'status',
        'submitted_at',
        'approved_at',
        'approved_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activity_date' => 'date',
        'manpower' => 'array',
        'materials' => 'array',
        'work_progress_weight' => 'decimal:2',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the project that owns the daily activity.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user that owns the daily activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the scope that owns the daily activity.
     */
    public function scope(): BelongsTo
    {
        return $this->belongsTo(Scope::class);
    }

    /**
     * Get the user who approved the daily activity.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the photos for the daily activity.
     */
    public function photos(): HasMany
    {
        return $this->hasMany(ActivityPhoto::class);
    }
}
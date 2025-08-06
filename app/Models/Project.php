<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Project
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property string|null $budget
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectUser> $projectUsers
 * @property-read int|null $project_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rab> $rabs
 * @property-read int|null $rabs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DailyActivity> $dailyActivities
 * @property-read int|null $daily_activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DailyReport> $dailyReports
 * @property-read int|null $daily_reports_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project active()
 * @method static \Database\Factories\ProjectFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company_id',
        'name',
        'code',
        'description',
        'location',
        'start_date',
        'end_date',
        'budget',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the company that owns the project.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the project users for the project.
     */
    public function projectUsers(): HasMany
    {
        return $this->hasMany(ProjectUser::class);
    }

    /**
     * Get the RABs for the project.
     */
    public function rabs(): HasMany
    {
        return $this->hasMany(Rab::class);
    }

    /**
     * Get the daily activities for the project.
     */
    public function dailyActivities(): HasMany
    {
        return $this->hasMany(DailyActivity::class);
    }

    /**
     * Get the daily reports for the project.
     */
    public function dailyReports(): HasMany
    {
        return $this->hasMany(DailyReport::class);
    }

    /**
     * Scope a query to only include active projects.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
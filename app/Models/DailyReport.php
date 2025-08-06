<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\DailyReport
 *
 * @property int $id
 * @property int $project_id
 * @property int $generated_by
 * @property \Illuminate\Support\Carbon $report_date
 * @property string $report_number
 * @property array|null $personnel_presence
 * @property string|null $weather
 * @property string|null $safety_notes
 * @property string|null $general_notes
 * @property array|null $activities_summary
 * @property array|null $materials_summary
 * @property array|null $manpower_summary
 * @property string|null $overall_progress
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $finalized_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\User $generatedBy
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereActivitiesSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereFinalizedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereGeneralNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereGeneratedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereManpowerSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereMaterialsSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereOverallProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport wherePersonnelPresence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereReportDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereReportNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereSafetyNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereWeather($value)

 * 
 * @mixin \Eloquent
 */
class DailyReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'project_id',
        'generated_by',
        'report_date',
        'report_number',
        'personnel_presence',
        'weather',
        'safety_notes',
        'general_notes',
        'activities_summary',
        'materials_summary',
        'manpower_summary',
        'overall_progress',
        'status',
        'finalized_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'report_date' => 'date',
        'personnel_presence' => 'array',
        'activities_summary' => 'array',
        'materials_summary' => 'array',
        'manpower_summary' => 'array',
        'overall_progress' => 'decimal:2',
        'finalized_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the project that owns the daily report.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who generated the daily report.
     */
    public function generatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Scope
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectUser> $projectUsers
 * @property-read int|null $project_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rab> $rabs
 * @property-read int|null $rabs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DailyActivity> $dailyActivities
 * @property-read int|null $daily_activities_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Scope newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Scope newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Scope query()
 * @method static \Illuminate\Database\Eloquent\Builder|Scope whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scope whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scope whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scope whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scope whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scope whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scope whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class Scope extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'color',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the project users for the scope.
     */
    public function projectUsers(): HasMany
    {
        return $this->hasMany(ProjectUser::class);
    }

    /**
     * Get the RABs for the scope.
     */
    public function rabs(): HasMany
    {
        return $this->hasMany(Rab::class);
    }

    /**
     * Get the daily activities for the scope.
     */
    public function dailyActivities(): HasMany
    {
        return $this->hasMany(DailyActivity::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ProjectUser
 *
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 * @property int $role_id
 * @property int|null $scope_id
 * @property string $status
 * @property \Illuminate\Support\Carbon $assigned_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Role $role
 * @property-read \App\Models\Scope|null $scope
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectUser whereAssignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectUser whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectUser whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectUser whereScopeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectUser active()

 * 
 * @mixin \Eloquent
 */
class ProjectUser extends Model
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
        'role_id',
        'scope_id',
        'status',
        'assigned_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'assigned_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the project that owns the project user.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user that owns the project user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the role that owns the project user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the scope that owns the project user.
     */
    public function scope(): BelongsTo
    {
        return $this->belongsTo(Scope::class);
    }

    /**
     * Scope a query to only include active project users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
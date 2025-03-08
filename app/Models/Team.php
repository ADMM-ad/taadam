<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $table = 'team';
    protected $fillable = [
        'nama_team'
    ];
    public function detailTeams()
    {
        return $this->hasMany(DetailTeam::class, 'team_id');
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'detail_team', 'team_id', 'user_id');
    }
}

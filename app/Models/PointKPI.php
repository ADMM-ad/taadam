<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointKPI extends Model
{
    use HasFactory;

    protected $table = 'point_kpi';
    protected $fillable = [
        'user_id',
        'bulan',
        'point_absensi',
        'point_jobdesk',
        'point_hasil',
        'point_attitude',
        'point_rata_rata'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailTeam()
    {
        return $this->belongsTo(DetailTeam::class);
    }

    public function absensi()
    {
        return $this->belongsTo(Absensi::class);
    }

    public function jobdesk()
    {
        return $this->belongsTo(DetailJobdesk::class);
    }

    public function jobdeskHasil()
    {
        return $this->belongsTo(JobdeskHasil::class);
    }
}

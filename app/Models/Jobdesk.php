<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobdesk extends Model
{
    use HasFactory;

    protected $table = 'jobdesk';
    protected $fillable = [
        'team_id',
        'nama_pekerjaan',
        'deskripsi',
        'tenggat_waktu',
        'waktu_selesai',
        'status',
        'hasil'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function detailJobdesk()
    {
        return $this->hasMany(DetailJobdesk::class, 'jobdesk_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'detail_jobdesk', 'jobdesk_id', 'user_id');
    }
}

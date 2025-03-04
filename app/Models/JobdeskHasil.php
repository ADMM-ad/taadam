<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobdeskHasil extends Model
{
    use HasFactory;

    protected $table = 'jobdesk_hasil';
    protected $fillable = [
        'team_id',
        'bulan',
        'views'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJobdesk extends Model
{
    use HasFactory;

    protected $table = 'detail_jobdesk';
    protected $fillable = [
        'user_id',
        'jobdesk_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobdesk()
    {
        return $this->belongsTo(Jobdesk::class);
    }
}

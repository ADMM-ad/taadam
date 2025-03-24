<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'absensi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'tanggal',
        'waktu_datang',
        'waktu_terlambat',
        'waktu_pulang',
        'kehadiran',
        'pesan',
        'bukti',
        'status'
    ];

    /**
     * Get the user associated with the absensi record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

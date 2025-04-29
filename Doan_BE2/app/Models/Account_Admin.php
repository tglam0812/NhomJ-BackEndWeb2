<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account_Admin extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $fillable = [
        'full_name',
        'email',
        'password',
        'phone',
        'gender',
        'date',
        'address',
        'avatar',
        'level_id',
        'status',
        'about',
        'remember_token',
    ];

    /**
     * Quan hệ: Mỗi user thuộc về một cấp bậc (level)
     */
    public function level()
    {
        return $this->belongsTo(LevelUser::class, 'level_id');
    }
}

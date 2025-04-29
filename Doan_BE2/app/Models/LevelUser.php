<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelUser extends Model
{
    use HasFactory;

    protected $table = 'level_user';
    protected $primaryKey = 'level_id';
    public $timestamps = true;

    protected $fillable = [
        'level_name',
    ];

    /**
     * Quan hệ: Một cấp bậc có nhiều user
     */
    public function users()
    {
        return $this->hasMany(Account_Admin::class);
    }
}

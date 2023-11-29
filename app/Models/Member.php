<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    public $timestamps = false; // 禁用自動時間戳
    protected $table = 'USERS_TEST'; 
    protected $primaryKey = 'USER_ID'; 
    protected $fillable = ['USER_ID', 'USER_PASSWORD']; 
}

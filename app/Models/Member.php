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
    // 使用非遞增或者非數字的primaryKey，則需要多加這行
    public $incrementing = false; 
    // protected $fillable = ['USER_ID', 'USER_PASSWORD']; 
}

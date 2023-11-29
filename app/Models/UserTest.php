<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTest extends Model
{
    use HasFactory;
    protected $table = 'USER_TEST';
    protected $primaryKey = 'USER_ID';
    
    protected $fillable = [
        'USER_ID', 
        'USER_PASSWORD'
    ];
}

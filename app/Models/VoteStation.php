<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteStation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'A_VOTE_H_TEST'; 
    protected $primaryKey = 'VOTE_ID';
}

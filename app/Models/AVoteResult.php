<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AVoteL;
use App\Models\DeptBase;
use App\Models\EmpBase;
use App\Models\Vote;

class AVoteResult extends Model
{
    use HasFactory;

    protected $table = 'A_VOTE_RESULT_TEST';

    // public function dept()
    // {
    //     return $this->belongsTo(DeptBase::class, 'VOTE_DEPT_CODE', 'DEPT_CODE')
    //         ->where('STATUS_FLAG', '!=', 'D');
    // }

    // public function emp()
    // {
    //     return $this->belongsTo(EmpBase::class, 'VOTE_USER', 'EMP_CODE');
    // }

    // public function voteTitle()
    // {
    //     return $this->hasOne(Vote::class, 'VOTE_ID', 'VOTE_ID');
    // }

    // public function voteLTest()
    // {
    //     return $this->hasOne(AVoteL::class, 'VOTE_ID', 'VOTE_ID')->whereColumn('A_VOTE_RESULT_TEST.VOTE_LINE_NO', 'A_VOTE_H_TEST.LINE_NO');
    // }   

}

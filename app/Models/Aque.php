<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aque extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'questions';

    public function answers()
    {
        return $this->hasMany(\App\Models\Answer::class,'question_id','id');
    }
}

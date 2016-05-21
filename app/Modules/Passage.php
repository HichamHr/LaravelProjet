<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Passage
 *
 * @property string $exam_ID
 * @property string $Question
 * @property string $Rep
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Passage whereExam_ID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Passage whereQuestion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Passage whereRep($value)
 * @mixin \Eloquent
 */
class Passage extends Model
{
    
    public $timestamps = false;
    
    protected $table = 'passage';
    protected $fillable = ['exam_ID','Question','Rep'];
    //protected $hidden = ['deleted_at','created_at','updated_at'];
    
    protected  $primaryKey = 'exam_ID';

    public function Quest(){
        return $this->hasOne('App\Modules\Questions','question_ID','Question');
    }

    public function Reponses(){
        return $this->hasOne('App\Modules\Reponses','id','Rep');
    }
    public function Exam(){
        return $this->hasOne('App\Modules\Exams','id','exam_ID');
    }

}

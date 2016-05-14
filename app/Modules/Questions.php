<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\Questions
 *
 * @property string $question_ID
 * @property string $Question
 * @property string $Type
 * @property string $Score
 * @property string $Pile_ID
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Questions whereQuestion_ID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Questions whereQuestion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Questions whereScore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Questions wherePile_ID($value)
 * @mixin \Eloquent
 */
class Questions extends Model
{
    public $timestamps = false;

    use SoftDeletes;

    protected $table = 'questions';
    protected $fillable = ['question_ID','Question','Type','Score','Pile_ID'];
    //protected $hidden = ['deleted_at','created_at','updated_at'];

    protected $primaryKey = 'question_ID';
    protected $dates = ['deleted_at'];

    public function Pile(){
        return $this->hasOne('App\Modules\Piles','id','Pile_ID');
    }

    public function Passage(){
        return $this->hasMany('App\Modules\Passage','Question_id','question_ID');
    }

    public function Reponses(){
        return $this->hasMany('App\Modules\Reponses','Question_id','question_ID');
    }
}

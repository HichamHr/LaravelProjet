<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\Reponses
 *
 * @property string $id
 * @property string $reponse
 * @property string $is_true
 * @property string $Question_id
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Reponses whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Reponses whereReponse($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Reponses whereIs_true($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Reponses whereQuestion_id($value)
 * @mixin \Eloquent
 */
class Reponses extends Model
{
    
    use SoftDeletes;

    protected $table = 'reponses';
    protected $fillable = ['id','reponse','is_true','Question_id'];
    protected $hidden = ['is_true'/*,'deleted_at','created_at','updated_at'*/];

    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    public function Question(){
        return $this->hasOne('App\Modules\Questions','question_ID','Question_id');
    }
}

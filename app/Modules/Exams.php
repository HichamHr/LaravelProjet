<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\Exams
 *
 * @property string $id
 * @property string $date
 * @property string $description
 * @property string $type
 * @property string $Pile
 * @property integer $etudiant
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Exams whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Exams whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Exams whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Exams wherePile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Exams whereEtudiant($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Exams whereDate($value)
 * @mixin \Eloquent
 */
class Exams extends Model
{
    
    use SoftDeletes;

    protected $table = 'exams';
    protected $fillable = ['id','date','description','list_questions','type','Pile','etudiant'];
    //protected $hidden = ['deleted_at','created_at','updated_at'];

    protected $primaryKey = 'id';
    protected $dates = ['deleted_at','created_at','updated_at'];


    public function Etudiant_(){
        return $this->hasOne('App\Modules\Etuduant','CIN','etudiant');
    }

    public function Pile_(){
        return $this->hasOne('App\Modules\Piles','id','Pile');
    }

    public function PileDuration(){
        return $this->Pile_()->select(array('duree','id'));
    }

    public function Passages(){
        return $this->hasMany('App\Modules\Passage','exam_ID','id');
    }



}

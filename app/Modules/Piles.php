<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Modules\Piles
 *
 * @property string $id
 * @property string $Description
 * @property string $duree
 * @property string $Max_Score
 * @property string $valide_Score
 * @property integer $module_ID
 * @property integer $prof
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Piles whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Piles whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Piles whereDuree($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Piles whereMax_Score($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Piles whereValide_Score($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Piles whereModule_ID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Piles whereProf($value)
 * @mixin \Eloquent
 */

class Piles extends Model
{
    use SoftDeletes;

    protected $table = 'piles';
    protected $fillable = ['id','Description','duree','nbr-question','Max_Score','valide_Score','module_ID','prof'];
    //protected $hidden = ['deleted_at','created_at','updated_at'];

    protected $primaryKey = 'id';
    protected $dates = ['deleted_at','created_at','updated_at'];

    public function Module(){
        return $this->hasOne('App\Modules\Modules','numero','module_ID');
    }
    public function Prof_(){
        return $this->hasOne('App\Modules\Prof','CIN','prof');
    }

    public function Exams(){
        return $this->hasMany('App\Modules\Exams','Pile','id');
    }
    public function Questions(){
        return $this->hasMany('App\Modules\Questions','Pile_ID','id');
    }


}

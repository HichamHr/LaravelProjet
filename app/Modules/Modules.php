<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\Modules
 *
 * @property string $numero
 * @property string $nom
 * @property string $MH
 * @property string $specialite
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Modules whereNumero($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Modules whereNom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Modules whereMH($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Modules whereSpecialite($value)
 * @mixin \Eloquent
 */
class Modules extends Model
{
    
    use SoftDeletes;

    protected $table = 'modules';
    protected $fillable = ['numero','nom','MH','specialite'];
    //protected $hidden = ['deleted_at','created_at','updated_at'];
    protected $dates = ['deleted_at'];

    public $timestamps = false;

    protected $primaryKey = 'numero';

    public function Specialite(){
        return $this->hasOne('App\Modules\Specialite','id','specialite');
    }

    public function Piles(){
        return $this->hasMany('App\Modules\Piles','module_ID','numero');
    }
}

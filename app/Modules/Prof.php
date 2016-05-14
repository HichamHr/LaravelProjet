<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Prof
 *
 * @property string $CIN
 * @property string $Nom
 * @property string $Prenom
 * @property string $Adresse
 * @property string $avatar
 * @property integer $compte
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Prof whereCIN($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Prof whereNom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Prof wherePrenom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Prof whereAdresse($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Prof whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Prof whereCompte($value)
 * @mixin \Eloquent
 */
class Prof extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'CIN';

    protected $table = 'prof';
    protected $fillable = ['CIN','Nom','Prenom','Adresse','avatar','compte','active'];
    //protected $hidden = ['deleted_at','created_at','updated_at'];

    public function compte(){
        return $this->hasOne('App\Modules\User',"id","compte");
    }

    public function Prof_Specialite(){
        return $this->hasMany('App\Modules\Prof_Specialite',"id_prof","CIN");
    }

    public function Piles(){
        return $this->hasMany('App\Modules\Piles','prof','CIN');
    }
}

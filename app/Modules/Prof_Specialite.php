<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Prof_Specialite
 *
 * @property string $id_prof
 * @property string $id_specialite
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Prof_Specialite whereId_prof($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Prof_Specialite whereId_specialite($value)
 * @mixin \Eloquent
 */
class Prof_Specialite extends Model
{
    
    protected $table = 'prof_specialite';
    protected $fillable = ['id_prof','id_specialite'];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function Prof(){
        return $this->hasOne('App\Modules\Prof',"CIN","id_prof")
            ->selectRaw('CIN,Nom,Prenom,avatar');
    }

    public function Specialite(){
        return $this->hasOne('App\Modules\Specialite',"id","id_specialite");
    }
}

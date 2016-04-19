<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\Piles
 *
 * @property string $id
 * @property string $abbreviation
 * @property string $intitule
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Specialite whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Specialite whereAbbreviation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Specialite whereIntitule($value)
 * @mixin \Eloquent
 */
class Specialite extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    protected $table = 'specialite';
    protected $fillable = ['id','abbreviation','intitule'];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    public function Etudiant(){
        return $this->hasMany('App\Modules\Etuduant','id_specialite','id')
            ->selectRaw('CIN,Nom,Prenom,avatar');
    }
    public function ProfSpecialite(){
        return $this->hasMany('App\Modules\Prof_Specialite','id_specialite','id');
    }

    public function Modules(){
        return $this->hasMany('App\Modules\Modules','specialite','id');
    }
}

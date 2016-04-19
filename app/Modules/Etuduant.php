<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Etuduant
 *
 * @property string $CIN
 * @property string $Nom
 * @property string $Prenom
 * @property string $Adresse
 * @property string $avatar
 * @property integer $compte_id
 * @property integer $id_specialite
 * @property-read \App\Modules\User $compte
 * @property-read \App\Modules\Specialite $Specialite
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Exams[] $Exams
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Etuduant whereCIN($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Etuduant whereNom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Etuduant wherePrenom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Etuduant whereAdresse($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Etuduant whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Etuduant whereCompteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Etuduant whereIdSpecialite($value)
 * @mixin \Eloquent
 */
class Etuduant extends Model
{
    public $timestamps = false;

    protected $table = 'etudiant';
    protected $fillable = ['CIN','Nom','Prenom','Adresse','avatar','compte_id','id_specialite','active','blocked'];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    protected $primaryKey = 'CIN';

    public function compte(){
        return $this->hasOne('App\Modules\User',"id","compte_id");
    }

    public function Specialite(){
        return $this->hasOne('App\Modules\Specialite','id','id_specialite');
    }

    public function Exams(){
        return $this->hasMany('App\Modules\Exams','etudiant','CIN');
    }
}

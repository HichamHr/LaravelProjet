<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Modules\Admin
 *
 * @property string $CIN
 * @property string $Nom
 * @property string $Prenom
 * @property string $Adresse
 * @property string $avatar
 * @property integer $compte
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin whereCIN($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin whereNom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin wherePrenom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin whereAdresse($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin whereCompte($value)
 * @mixin \Eloquent
 */
class Admin extends Model
{
    
    public $timestamps = false;
    
    protected $table = 'admin';
    protected $fillable = ['CIN','Nom','Prenom','Adresse','avatar','compte_id'];
    //protected $hidden = ['deleted_at','created_at','updated_at'];

    protected $primaryKey = 'CIN';


}

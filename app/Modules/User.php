<?php

namespace App\Modules;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\Etuduant
 *
 * @property string $id
 * @property string $email
 * @property string $user
 * @property string $phone
 * @property string $role
 * @property string $password
 * @property-read \App\Modules\User $compte
 * @property-read \App\Modules\Etuduant $etudiant
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Exams[] $Exams
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Etuduant whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Etuduant whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Etuduant whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Etuduant wherePhone$value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Etuduant whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Etuduant wherePassword($value)
 * @mixin \Eloquent
 */

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, SoftDeletes;

    protected $table = 'comptes';
    protected $fillable = ['email', 'user', 'phone', 'role'];
    protected $hidden = ['password', 'remember_token', /*'deleted_at', 'created_at', 'updated_at'*/];

    protected $primaryKey = 'id';
    protected $dates = ['deleted_at','created_at','updated_at'];

    public function Etudiant(){
        return $this->hasOne('App\Modules\Etuduant',"compte_id","id");
    }

    public function Prof(){
        return $this->hasOne('App\Modules\Prof',"compte","id");
    }

    public function Admin(){
        return $this->hasOne('App\Modules\Admin',"compte","id");
    }

    public function hasRole($roles)
    {
        if(is_array($roles)){
            foreach($roles as $need_role){
                if($this->checkIfUserHasRole($need_role)) {
                    return true;
                }
            }
        } else{
            return $this->checkIfUserHasRole($roles);
        }
        return false;
    }
    private function checkIfUserHasRole($need_role)
    {
        return (strtolower($need_role)==strtolower($this->role)) ? true : false;
    }
}

<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class Examsofficiel extends Model
{
    
    //
    protected $table = 'examsofficiel';
    protected $fillable = ['id_exam','id_pile','date_exam'];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function Etudiants(){
        return $this->hasOne('App\Modules\Etuduant',"CIN","id_etudiant")
            ->selectRaw('CIN,Nom,Prenom,avatar');
    }

    public function Pile(){
        return $this->hasOne('App\Modules\Piles',"id","id_pile");
    }
}

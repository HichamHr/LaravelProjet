<?php

namespace App\Http\Controllers\API\UsersControle;

use App\Modules\Prof;
use app\OpenTest\Validation;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;

class Professeur extends Controller
{
    public function __construct()
    {
        $this->middleware('cors');
        $this->middleware('jwt.auth');
        $this->middleware('tokenRefresh');
        $this->middleware('roles:etudiant,prof,admin');
    }

    public function Profile($user){
        $prof = Prof::where('compte', $user)->first();
        echo json_encode($prof);
    }

    public function Update($user, Request $request){
        $validation = Validation::ProfileUpdate($request);
        if($request->input('id_specialite') != "0"){
            if($validation === "done"){
                DB::table('prof')
                    ->where('compte', $user)
                    ->update([
                        'CIN' => $request->input('CIN'),
                        'Nom' => $request->input('Nom'),
                        'Prenom'=> $request->input('Prenom'),
                        'Adresse'=> $request->input('Adresse'),
                        'avatar'=> $request->input('avatar'),
                    ]);
                return response()->json(['error' => false ], 200);
            }
            else{
                return response()->json(['error' => true,'message'=>$validation ], 401);
            }
        }
        else{
            return response()->json(['error' => true,'message'=>'specialite_default'], 401);
        }
    }

}

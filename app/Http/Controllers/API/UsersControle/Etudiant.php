<?php

namespace App\Http\Controllers\API\UsersControle;



use App\Http\Controllers\Controller;
use App\Modules\Etuduant;
use app\OpenTest\Validation;
use DB;
use Illuminate\Http\Request;
use JWTAuth;

class Etudiant extends Controller
{
    public function __construct()
    {
        $this->middleware('cors');
        $this->middleware('jwt.auth');
        $this->middleware('tokenRefresh');
        $this->middleware('roles:etudiant,prof,admin');

    }

    public function getProfile(){
        $user = JWTAuth::parseToken()->authenticate();
        $prof = Etuduant::where('compte_id', $user->id)->first();
        echo json_encode($prof);
    }

    public function postUpdate(Request $request)
    {
        $validation = Validation::ProfileUpdate($request);
        $user = JWTAuth::parseToken()->authenticate();
        if ($request->input('id_specialite') != "0") {
            if ($validation === "done") {
                DB::table('etudiant')
                    ->where('compte_id', $user->id)
                    ->update([
                        'CIN' => $request->input('CIN'),
                        'Nom' => $request->input('Nom'),
                        'Prenom' => $request->input('Prenom'),
                        'Adresse' => $request->input('Adresse'),
                        'avatar' => $request->input('avatar'),
                        'id_specialite' => $request->input('id_specialite'),
                    ]);
                return response()->json(['error' => false], 401);
            } else {
                return response()->json(['error' => true, 'message' => $validation], 401);
            }
        } else {
            return response()->json(['error' => true, 'message' => 'specialite_default'], 401);
        }
    }
}

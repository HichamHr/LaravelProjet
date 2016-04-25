<?php

namespace App\Http\Controllers\API;


use App\Modules\Admin;
use App\Modules\Etuduant;
use App\Modules\Prof;
use App\Modules\User;
use app\OpenTest\Functions;
use app\OpenTest\Validation;
use DB;
use Hash;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class Auth extends Controller
{

    public function __construct()
    {
        $this->middleware('cors');
        $this->middleware('tokenRefresh', ['only' => ['ProfileAccount']]);
        $this->middleware('jwt.auth', ['except' => ['Login', 'Register']]);
    }


    public function Login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));

    }
    public function Register(Request $request)
    {
        $validation = Validation::register($request);
        if ($validation === "done") {
            DB::transaction(
                function () use ($request) {

                    $role = $request->input('role');
                    $user = new User();
                    $user->email = $request->input('email');
                    $user->user = $request->input('user');
                    $user->role = $role;
                    $user->phone = $request->input('phone');
                    $user->password = Hash::make($request->input('password'));
                    $saveU = $user->save();
                    $saveData = false;
                    if ($role === "prof") {
                        echo $user->id;
                        $prof = new  Prof();
                        $prof->CIN = $request->input('CIN');
                        $prof->compte = $user->id;
                        $saveData = $prof->save();
                    } else if ($role === "etudiant") {
                        echo $user->id;
                        $etudiant = new Etuduant();
                        $etudiant->CIN = $request->input('CIN');
                        $etudiant->compte_id = $user->id;
                        $etudiant->id_specialite = 0;
                        $saveData = $etudiant->save();
                    } else {
                        $user->delete();
                    }
                    return response()->json(array('success' => true, 'SaveCompt' => $saveU, 'SaveData' => $saveData), 200);
                });
        } else {
            return response()->json(array('success' => false, 'Message' => $validation), 400);
        }
        return null;
    }
    public function ProfileAccount()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->hasRole(env('ETUDIANT_PERMISSION_NAME', "Etudiant"))) {
            $user->Etudiant;
            return response()->json(array('compt' => $user), 200);
        } else if ($user->hasRole(env('PROF_PERMISSION_NAME', "Prof"))) {
            $user->Prof;
            return response()->json(array('compt' => $user), 200);
        } else if ($user->hasRole(env('ADMIN_PERMISSION_NAME', "Admin"))) {
            $user->Admin;
            return response()->json(array('compt' => $user), 200);
        }
        return response()->json(array('success' => false, 'Message' => 'invalide_Profile'), 404);
    }
}

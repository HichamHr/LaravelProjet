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
        $this->middleware('jwt.auth', ['except' => ['Login', 'Register']]);
    }

    public function Login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['flash' => 'invalid_credentials'], 404);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['flash' => 'could_not_create_token'], 500);
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
                    $user->save();
                    if ($role === "prof") {
                        echo $user->id;
                        $prof = new  Prof();
                        $prof->CIN = $request->input('CIN');
                        $prof->compte = $user->id;
                        $prof->save();
                    } else if ($role === "etudiant") {
                        echo $user->id;
                        $etudiant = new Etuduant();
                        $etudiant->CIN = $request->input('CIN');
                        $etudiant->compte_id = $user->id;
                        $etudiant->id_specialite = 0;
                        $etudiant->save();
                    } else {
                        $user->delete();
                    }
                    return response()->json(array('flash' => "registration_done"), 200);
                });
        } else {
            return response()->json(array("flash" => $validation), 400);
        }
        return null;
    }
}

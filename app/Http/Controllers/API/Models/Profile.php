<?php

namespace App\Http\Controllers\API\Models;

use app\OpenTest\Validation;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;

class Profile extends Controller
{
    public function __construct()
    {
        $this->middleware('cors');
        $this->middleware('jwt.auth');
        $this->middleware('tokenRefresh');
        $this->middleware('roles:prof,admin',['except'=>['getIndex','getAll','getUser','postAvatar']]);
    }

    public function getIndex(){
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
    public function getAll()
    {
        $COMPTS = \App\Modules\User::all();
        if ($COMPTS != null) {
            foreach ($COMPTS as $cm) {
                if ($cm->hasRole(env('ETUDIANT_PERMISSION_NAME', 'Etudiant'))) {
                    $cm->Etudiant;
                } else if ($cm->hasRole(env('PROF_PERMISSION_NAME', 'Prof'))) {
                    $cm->Prof;
                } else if ($cm->hasRole(env('ADMIN_PERMISSION_NAME', 'Admin'))) {
                    $cm->Admin;
                }
            }
        }
        return response()->json(compact('COMPTS'), 200);
    }
    public function getUser($id)
    {
        $COMPT = \App\Modules\User::find($id);
        if ($COMPT != null) {
            if ($COMPT->hasRole(env('ETUDIANT_PERMISSION_NAME', 'Etudiant'))) {
                $COMPT->Etudiant;
            } else if ($COMPT->hasRole(env('PROF_PERMISSION_NAME', 'Prof'))) {
                $COMPT->Prof;
            } else if ($COMPT->hasRole(env('ADMIN_PERMISSION_NAME', 'Admin'))) {
                $COMPT->Admin;
            }
        }
        return response()->json(compact('COMPT'), 200);
    }

    public function postBlock($id)
    {
        $COMPT = \App\Modules\User::find($id);
        if ($COMPT != null) {
            if ($COMPT->hasRole(env('ETUDIANT_PERMISSION_NAME', 'Etudiant'))) {
                $Etudiant = $COMPT->Etudiant;
                $Etudiant->blocked = "y";
                $Etudiant->save();
            }
        }
        return response()->json(compact('COMPT'), 200);
    }
    public function postUnblock($id)
    {
        $COMPT = \App\Modules\User::find($id);
        if ($COMPT != null) {
            if ($COMPT->hasRole(env('ETUDIANT_PERMISSION_NAME', 'Etudiant'))) {
                $Etudiant = $COMPT->Etudiant;
                $Etudiant->blocked = "n";
                $Etudiant->save();
            }
        }
        return response()->json(compact('COMPT'), 200);
    }
    public function postActivate($id)
    {
        $COMPT = \App\Modules\User::find($id);
        if ($COMPT != null) {
            if ($COMPT->hasRole(env('ETUDIANT_PERMISSION_NAME', 'Etudiant'))) {
                $Etudiant = $COMPT->Etudiant;
                $Etudiant->active = "y";
                $Etudiant->save();
            }
        }
        if ($COMPT != null) {
            if ($COMPT->hasRole(env('PROF_PERMISSION_NAME', 'Prof'))) {
                $Prof = $COMPT->Prof;
                $Prof->active = "y";
                $Prof->save();
            }
        }
        return response()->json(compact('COMPT'), 200);
    }
    public function postAvatar(Request $request)
    {
        $validation = Validation::Avatar($request);
        if ($validation === "done") {
            $user = JWTAuth::parseToken()->authenticate();
            $tblName = ""; $champId = "";
            if ($user->hasRole(env('ETUDIANT_PERMISSION_NAME', "Etudiant"))) {
                $champId = "compte_id";
                $tblName = "etudiant";
            } else if ($user->hasRole(env('PROF_PERMISSION_NAME', "Prof"))) {
                $champId = "compte";
                $tblName = "prof";
            } else if ($user->hasRole(env('ADMIN_PERMISSION_NAME', "Admin"))) {
                $champId = "compte";
                $tblName = "admin";
            }

            $imageName = $user->id . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(base_path() . '/public/images/avatars/', $imageName);

            DB::table($tblName)->where($champId, $user->id)
                ->update(
                    [
                        'avatar' => asset("images/avatars/$imageName")
                    ]
                );
            return response()->json(['error' => false, 'image' => asset("images/avatars/$imageName")], 200);
        } else {
            return response()->json(['error' => true, 'message' => $validation], 401);
        }
    }
}

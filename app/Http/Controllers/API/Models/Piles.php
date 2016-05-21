<?php

namespace App\Http\Controllers\API\Models;

use App\Modules\Questions;
use app\OpenTest\Validation;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;

class Piles extends Controller
{
    public function __construct()
    {
        
        $this->middleware('cors');
        $this->middleware('jwt.auth');
        $this->middleware('tokenRefresh');
        $this->middleware('roles:etudiant,prof,admin');
    }

    public function getIndex($trashed = null){
        if($trashed == null)
            $Piles = \App\Modules\Piles::all();
        else if($trashed === "trashed")
            $Piles = \App\modules\Piles::onlyTrashed()->get();
        else if($trashed === "all")
            $Piles = \App\modules\Piles::withTrashed()->get();
        else
            $Piles = null;

        return response()->json(compact('Piles'), 200);
    }

    public function getProfPiles($trashed = null){
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->hasRole(env('PROF_PERMISSION_NAME', "Prof"))){
            $prof = $user->Prof;
            if($trashed == null)
                $Piles = \App\Modules\Piles::where("Prof",$prof->CIN)->get();
            else if($trashed === "trashed")
                $Piles = \App\modules\Piles::onlyTrashed()->where("Prof",$prof->CIN)->get();
            else if($trashed === "all")
                $Piles = \App\modules\Piles::withTrashed()->where("Prof",$prof->CIN)->get();
            else
                $Piles = null;

            return response()->json(compact('Piles'), 200);
        }
    }

    public function getShow($id){
        $Pile= \App\Modules\Piles::find($id);
        return response()->json(compact('Pile'), 200);
    }
    public function getProf($id){
        $Pile = \App\Modules\Piles::find($id);
        if($Pile != null)
            $Prof = $Pile->Prof_;
        return response()->json(compact('Prof'), 200);
    }
    public function getQuestion($id){
        $Pile = \App\Modules\Piles::find($id);
        if($Pile != null)
            $Questions = $Pile->Questions;
        return response()->json(compact('Questions'), 200);
    }
    public function getQuestionrand($id){
        $Pile = \App\Modules\Piles::find($id);
        if($Pile != null){
            $Questions = $Pile->QuestionsRand;
            if($Questions != null){
                foreach ($Questions as $qs)
                    $qs->ReponseRand;
            }
        }
        return response()->json(compact('Questions'), 200);
    }
    public function getModule($id){
        $Pile = \App\Modules\Piles::find($id);
        if($Pile != null)
            $Module = $Pile->Module;
        return response()->json(compact('Module'), 200);
    }
    public function getFull($id){
        $Pile = \App\Modules\Piles::find($id);
        if($Pile != null){
            $Pile->Prof_;
            $quest = $Pile->Questions;
            if($quest != null){
                foreach ($quest as $qs)
                    $qs->Reponses;
            }
            $Pile->Module;
        }
        return response()->json(compact('Pile'), 200);
    }

    public function postNew(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $profID = $user->Prof->CIN;
        $request->request->add(['prof'=>$profID]);
        $validation = Validation::Piles($request);
        
        if($user->hasRole(env('PROF_PERMISSION_NAME', "Prof"))){

            if ($validation === "done") {
                $pile = new \App\Modules\Piles();
                $pile->titre = $request->input('titre');
                $pile->Description = $request->input('Description');
                $pile->duree = $request->input('duree');
                $pile->nbr_question = $request->input('nbr_question');
                $pile->Max_Score = $request->input('Max_Score');
                $pile->valide_Score = $request->input('valide_Score');
                $pile->module_ID = $request->input('module_ID');
                $pile->prof = $profID;
                if ($pile->saveOrFail()) {
                    return response()->json($pile, 200);
                } else {
                    return response()->json(array('flash' => "Error_Add"), 500);
                }
            }
            return response()->json(array('flash' => $validation), 406);
        }
        return response()->json(array('flash' => "Just_Prof_can_add_piles"), 401);
    }
    public function postEdite(Request $request,$id){
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->hasRole(env('PROF_PERMISSION_NAME', "Prof"))){
            $prof = $user->Prof;
            $pile = \App\Modules\Piles::find($id);
            if($prof->CIN === $pile->prof){
                $validation = Validation::Piles($request);
                if ($validation === "done") {
                    DB::table('piles')
                        ->where('id', $id)
                        ->update([
                            'titre' => $request->input('titre'),
                            'Description' => $request->input('Description'),
                            'duree' => $request->input('duree'),
                            'Max_Score' => $request->input('Max_Score'),
                            'nbr_question' => $request->input('nbr_question'),
                            'valide_Score' => $request->input('valide_Score'),
                            'module_ID' => $request->input('module_ID'),
                        ]);
                    return response()->json(['flash' => "Pile_Updated"], 200);
                } else {
                    return response()->json(['flash' => $validation], 406);
                }
            }
            return response()->json(['flash' => "Pile_Error_Permission"], 404);
        }
        return response()->json(['flash' => "Must_Have_Prof_Compt"], 404);
    }
    public function postRestore($id){
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->hasRole(env('PROF_PERMISSION_NAME', "Prof"))) {
            $prof = $user->Prof;
            $pile = \App\Modules\Piles::withTrashed()->find($id);
            if ($prof->CIN === $pile->prof) {
                if ($pile->trashed()) {
                    $pile->restore();
                    return response()->json(['flash' => "Pile_Restored"], 200);
                }
                else{
                    return response()->json(['flash' => 'Pile_Not_Fond'], 404);
                }
            }
            return response()->json(['flash' => "Pile_Error_Permission"], 404);
        }
        return response()->json(['flash' => "Must_Have_Prof_Compt"], 404);
    }
    public function postDelete($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->hasRole(env('PROF_PERMISSION_NAME', "Prof"))) {
            $prof = $user->Prof;
            $pile = \App\Modules\Piles::withTrashed()->find($id);
            if ($prof->CIN === $pile->prof) {
                if ($pile->trashed()) {
                    //$specialite->forceDelete();
                    return response()->json(['flash' => 'Pile_Deleted_for_ever'], 200);
                }
                else {
                    $pile->delete();
                    return response()->json(['flash' => 'Pile_Deleted'], 200);
                }
            }
            return response()->json(['flash' => "Pile_Error_Permission"], 404);
        }
        return response()->json(['flash' => "Must_Have_Prof_Compt"], 404);
    }
}

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

    public function getIndex(){
        $Piles = \App\Modules\Piles::all();
        return response()->json(compact('Piles'), 200);
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
    public function getQuestionrand($id,$count){
        $Pile = \App\Modules\Piles::find($id);
        if($Pile != null)
            $Question = Questions::where('Pile_ID',$Pile->id)->orderByRaw("RAND()")->limit($count)->get();
        return response()->json(compact('Question'), 200);
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
                $pile->Description = $request->input('Description');
                $pile->duree = $request->input('duree');
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
        $validation = Validation::Piles($request);
        if ($validation === "done") {
            DB::table('piles')
                ->where('id', $id)
                ->update([
                    'Description' => $request->input('Description'),
                    'duree' => $request->input('duree'),
                    'Max_Score' => $request->input('Max_Score'),
                    'valide_Score' => $request->input('valide_Score'),
                    'module_ID' => $request->input('module_ID'),
                ]);
            return response()->json(['flash' => "Pile_Updated"], 200);
        } else {
            return response()->json(['flash' => $validation], 406);
        }
    }
    public function postRestore($id){
        $pile = \App\Modules\Piles::withTrashed()->find($id);
        if ($pile->trashed()) {
            $pile->restore();
            return response()->json(['flash' => "Pile_Restored"], 200);
        }
        else{
            return response()->json(['flash' => 'Pile_Not_Fond'], 404);
        }
    }
    public function postDelete($id)
    {
        $pile = \App\Modules\Piles::withTrashed()->find($id);
        if ($pile->trashed()) {
            //$specialite->forceDelete();
            return response()->json(['flash' => 'Pile_Deleted_for_ever'], 200);
        }
        else{
            $pile->delete();
            return response()->json(['flash' => 'Pile_Deleted'], 200);
        }
    }
}

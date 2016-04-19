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
        $piles = \App\Modules\Piles::all();
        return response()->json($piles, 200);
    }
    public function getShow($id){
        $piles = \App\Modules\Piles::find($id);
        return response()->json(compact('piles'), 200);
    }
    public function getProf($id){
        $piles = \App\Modules\Piles::find($id);
        $Prof = $piles->Prof_;
        return response()->json(compact('Prof'), 200);
    }
    public function getQuestion($id){
        $piles = \App\Modules\Piles::find($id);
        $Questions = $piles->Questions;
        return response()->json(compact('Questions'), 200);
    }
    public function getQuestionrand($id,$count){
        $piles = \App\Modules\Piles::find($id);
        $Question = Questions::where('Pile_ID',$piles->id)->orderByRaw("RAND()")->limit($count)->get();
        return response()->json(compact('Question'), 200);
    }
    public function getModule($id){
        $piles = \App\Modules\Piles::find($id);
        $Module = $piles->Module;
        return response()->json(compact('Module'), 200);
    }
    public function getFull($id){
        $piles = \App\Modules\Piles::find($id);
        $piles->setRelation('Prof_',$piles->Prof_);
        $piles->setRelation('Questions',$piles->Questions);
        $piles->setRelation('Module',$piles->Module);
        return response()->json(compact('piles'), 200);
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
                    return response()->json(array('error' => false, 'Message' => "Error_Add"), 401);
                }
            }
            return response()->json(array('error' => false, 'Message' => $validation), 401);
        }
        return response()->json(array('error' => false, 'Message' => "Just_Prof_can_add_piles"), 401);
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
            return response()->json(['error' => false], 200);
        } else {
            return response()->json(['error' => true, 'message' => $validation], 401);
        }
    }
    public function postRestore($id){
        $pile = \App\Modules\Piles::withTrashed()->find($id);
        if ($pile->trashed()) {
            $pile->restore();
            return response()->json(['error' => false], 200);
        }
        else{
            return response()->json(['error' => true, 'message' => 'Not_Fond'], 401);
        }
    }
    public function postDelete($id)
    {
        $pile = \App\Modules\Piles::withTrashed()->find($id);
        if ($pile->trashed()) {
            //$specialite->forceDelete();
            return response()->json(['error' => true, 'message' => 'Deleted_for_ever'], 401);
        }
        else{
            $pile->delete();
            return response()->json(['error' => true, 'message' => 'Deleted'], 401);
        }
    }
}

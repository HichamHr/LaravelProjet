<?php

namespace App\Http\Controllers\API\Models;

use app\OpenTest\Validation;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class Reponses extends Controller
{

    public function __construct()
    {
        
        $this->middleware('cors');
        $this->middleware('jwt.auth');
        $this->middleware('tokenRefresh');
        $this->middleware('roles:etudiant,prof,admin');
    }
    
    public function getIndex(){
        $reponses = \App\Modules\Reponses::all();
        return response()->json(compact('reponses'), 200);
    }
    public function getShow($id){
        $reponses = \App\Modules\Reponses::find($id);
        return response()->json(compact('reponses'), 200);
    }
    public function getQuestion($id){
        $reponse = \App\Modules\Reponses::find($id);
        if($reponse != null)
            $Question = $reponse->Question;
        return response()->json(compact('Question'), 200);
    }
    public function getFull($id){
        $reponses = \App\Modules\Reponses::find($id);
        if($reponses != null)
            $reponses->Question;
        return response()->json(compact('reponses'), 200);
    }

    public function postNew(Request $request){
        $validation = Validation::Reponses($request);
        if ($validation === "done") {
            $reponse = new \App\Modules\Reponses();
            $reponse->reponse = $request->input('reponse');
            $reponse->is_true = $request->input('is_true');
            $reponse->Question_id = $request->input('Question_id');

            if ($reponse->saveOrFail()) {
                return response()->json(array('flash'=>$reponse), 200);
            } else {
                return response()->json(array('flash' => "Error_Add_Reponse"), 500);
            }
        }
        else{
            return response()->json(['error' => true, 'message' => $validation], 406);
        }
    }

    public function postEdite(Request $request,$id){
        $validation = Validation::Questions($request);
        if ($validation === "done") {
            \App\Modules\Reponses::where('id',$id)->update([
                'reponse' => $request->input('reponse'),
                'is_true' => $request->input('reponse'),
                'Question_id' => $request->input('reponse'),
            ]);
            
            return response()->json(['flash' => "Reponse_Updated"], 200);
        } else {
            return response()->json(['flash' => $validation], 406);
        }
    }

    public function postRestore($id){
        $reponse = \App\Modules\Reponses::withTrashed()->find($id);
        if ($reponse->trashed()) {
            $reponse->restore();
            return response()->json(['flash' => "Reponse_Restored"], 200);
        }
        else{
            return response()->json(['error' => 'Reponse_Not_Fond'], 404);
        }
    }

    public function postDelete($id)
    {
        $reponse = \App\Modules\Reponses::withTrashed()->find($id);
        if ($reponse->trashed()) {
            //$specialite->forceDelete();
            return response()->json(['flash' => 'Reponse_Deleted_for_ever'], 200);
        }
        else{
            $reponse->delete();
            return response()->json(['flash' => 'Reponse_Deleted'], 200);
        }
    }
}

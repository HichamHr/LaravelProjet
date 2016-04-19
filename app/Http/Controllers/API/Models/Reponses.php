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
        $reponses = \App\Modules\Reponses::find($id);
        $Question = $reponses->Question;
        return response()->json(compact('Question'), 200);
    }
    public function getFull($id){
        $reponses = \App\Modules\Reponses::find($id);
        $reponses->setRelation('Question',$reponses->Question);
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
                return response()->json($reponse, 200);
            } else {
                return response()->json(array('error' => false, 'Message' => "Error_Add"), 401);
            }
        }
        else{
            return response()->json(['error' => true, 'message' => $validation], 401);
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
            
            return response()->json(['error' => false], 200);
        } else {
            return response()->json(['error' => true, 'message' => $validation], 401);
        }
    }

    public function postRestore($id){
        $reponse = \App\Modules\Reponses::withTrashed()->find($id);
        if ($reponse->trashed()) {
            $reponse->restore();
            return response()->json(['error' => false], 200);
        }
        else{
            return response()->json(['error' => true, 'message' => 'Not_Fond'], 401);
        }
    }

    public function postDelete($id)
    {
        $reponse = \App\Modules\Reponses::withTrashed()->find($id);
        if ($reponse->trashed()) {
            //$specialite->forceDelete();
            return response()->json(['error' => true, 'message' => 'Deleted_for_ever'], 401);
        }
        else{
            $reponse->delete();
            return response()->json(['error' => true, 'message' => 'Deleted'], 401);
        }
    }
}

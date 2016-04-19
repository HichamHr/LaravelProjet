<?php

namespace App\Http\Controllers\API\Models;

use App\Modules\Reponses;
use app\OpenTest\Validation;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class Questions extends Controller
{
    public function __construct()
    {
        $this->middleware('cors');
        $this->middleware('jwt.auth');
        $this->middleware('tokenRefresh');
        $this->middleware('roles:etudiant,prof,admin');
    }
    
    public function getIndex(){
        $question = \App\Modules\Questions::all();
        return response()->json(compact('question'), 200);
    }
    public function getShow($id){
        $question = \App\Modules\Questions::find($id);
        return response()->json(compact('question'), 200);
    }
    public function getPile($id){
        $question = \App\Modules\Questions::find($id);
        $Pile = $question->Pile;
        return response()->json(compact('Pile'), 200);
    }
    public function getReponses($id){
        $question = \App\Modules\Questions::find($id);
        $Reponses = $question->Reponses;
        return response()->json(compact('Reponses'), 200);
    }
    public function getReponsesrand($id,$count){
        $question = \App\Modules\Questions::find($id);
        $Question = Reponses::where('Question_id',$question->question_ID)->orderByRaw("RAND()")->limit($count)->get();
        return response()->json(compact('Question'), 200);
    }
    public function getFull($id){
        $question = \App\Modules\Questions::find($id);
        $question->setRelation('Pile',$question->Pile);
        $question->setRelation('Reponses',$question->Reponses);
        return response()->json(compact('question'), 200);
    }

    public function postNew(Request $request){
        $validation = Validation::Questions($request);
        if ($validation === "done") {
            $question = new \App\Modules\Questions();
            $question->Question = $request->input('Question');
            $question->Type = $request->input('Type');
            $question->Score = $request->input('Score');
            $question->Pile_ID = $request->input('Pile_ID');
            if ($question->saveOrFail()) {
                return response()->json($question, 200);
            } else {
                return response()->json(array('error' => false, 'Message' => "Error_Add"), 401);
            }
        }
        return response()->json(array('error' => false, 'Message' => $validation), 401);
    }
    public function postEdite(Request $request,$id){
        $validation = Validation::Questions($request);
        if ($validation === "done") {
            DB::table('questions')
                ->where('question_ID', $id)
                ->update([
                    'Question' => $request->input('Question'),
                    'Type' => $request->input('Type'),
                    'Score' => $request->input('Score'),
                    'Pile_ID' => $request->input('Pile_ID'),
                ]);
            return response()->json(['error' => false], 200);
        } else {
            return response()->json(['error' => true, 'message' => $validation], 401);
        }
    }
    public function postRestore($id){
        $question = \App\Modules\Questions::withTrashed()->find($id);
        if ($question->trashed()) {
            $question->restore();
            return response()->json(['error' => false], 200);
        }
        else{
            return response()->json(['error' => true, 'message' => 'Not_Fond'], 401);
        }
    }
    public function postDelete($id)
    {
        $question = \App\Modules\Questions::withTrashed()->find($id);
        if ($question->trashed()) {
            //$specialite->forceDelete();
            return response()->json(['error' => true, 'message' => 'Deleted_for_ever'], 401);
        }
        else{
            $question->delete();
            return response()->json(['error' => true, 'message' => 'Deleted'], 401);
        }
    }
}

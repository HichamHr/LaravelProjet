<?php

namespace App\Http\Controllers\API\Models;

use app\OpenTest\Validation;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class Passage extends Controller
{

    public function __construct()
    {
        $this->middleware('cors');
        $this->middleware('jwt.auth');
        $this->middleware('tokenRefresh');
        $this->middleware('roles:etudiant,prof,admin');
    }
    
    public function getIndex(){
        $Passages = \App\Modules\Passage::all();
        return response()->json($Passages, 200);
    }
    public function getExame($id){
        $Passages = \App\Modules\Passage::find($id);
        return response()->json($Passages->Exam, 200);
    }
    public function getQuestion($id){
        $Passages = \App\Modules\Passage::find($id);
        return response()->json($Passages->Quest, 200);
    }
    public function getReponse($id){
        $Passages = \App\Modules\Passage::find($id);
        return response()->json($Passages->Reponses, 200);
    }
    public function getFull($id){
        $Passages = \App\Modules\Passage::find($id);
        $Passages->Exam;
        $Passages->Quest;
        $Passages->Reponses;
        return response()->json($Passages, 200);
    }

    public function postNew(Request $request){
        $validation = Validation::Passage($request);
        if ($validation === "done") {

            $passageExist = DB::table('passage')->where(array(
                'exam_ID'=>$request->input('exam_ID'),
                'Question'=>$request->input('Question')
            ))->exists();

            if($passageExist){
                DB::table('passage')->where(array(
                    'exam_ID'=>$request->input('exam_ID'),
                    'Question'=>$request->input('Question')
                ))->update(array(
                    'Rep' => $request->input('Rep')
                ));
                return response()->json('Updated', 200);
            }
            else{
                $passage = new \App\Modules\Passage();
                $passage->exam_ID = $request->input('exam_ID');
                $passage->Question = $request->input('Question');
                $passage->Rep = $request->input('Rep');

                if ($passage->save()) {
                    return response()->json($passage, 200);
                } else {
                    return response()->json(array('error' => true, 'Message' => "Error_Add"), 401);
                }
            }

        }
        return response()->json(['error' => true, 'message' => $validation], 401);
        
    }

}

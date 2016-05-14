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
        $this->middleware('roles:prof,admin',
            ['except'=>[
                'getIndex',
                'getExame',
                'getQuestion',
                'getReponse',
                'getFull',
                'postNew',
                'postNewarr'
            ]]);
    }
    
    public function getIndex(){
        $Passages = \App\Modules\Passage::all();
        return response()->json(compact("Passages"), 200);
    }
    public function getExame($id){
        $Passage = \App\Modules\Passage::find($id);
        $Exame = null;
        if ($Passage != null)
            $Exame = $Passage->Exam;
        return response()->json(compact("Exame"), 200);
    }
    public function getQuestion($id){
        $Passage = \App\Modules\Passage::find($id);
        $Quest = null;
        if ($Passage != null)
            $Quest = $Passage->Quest;
        return response()->json(compact("Quest"), 200);
    }
    public function getReponse($id){
        $Passage = \App\Modules\Passage::find($id);
        $Reponses = null;
        if ($Passage != null)
            $Reponses = $Passage->Reponses;
        return response()->json(compact("Reponses"), 200);
    }
    public function getFull($id){
        $Passage = \App\Modules\Passage::find($id);
        if($Passage != null){
            $Passage->Exam;
            $question = $Passage->Quest;
            $Reponses = null;
            if($question != null){
                $Reponses = $question->Reponses;
                if($Reponses != null){
                    foreach ($Reponses as $Rep){
                        if($Rep->is_true != "f"){
                            $Rep->istrue = true;
                        }
                    }
                }

            }
            $Passage->Reponses;
        }
        return response()->json(compact('Passage'), 200);
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
                return response()->json(array('flash' => 'Passage_Updated'), 200);
            }
            else{
                $passage = new \App\Modules\Passage();
                $passage->exam_ID = $request->input('exam_ID');
                $passage->Question = $request->input('Question');
                $passage->Rep = $request->input('Rep');

                if ($passage->save()) {
                    return response()->json($passage, 200);
                } else {
                    return response()->json(array('flash' => "Error_Add_Passage"), 500);
                }
            }

        }
        return response()->json(['flash' => $validation], 406);
        
    }
    public function postNewarr($examId,Request $request){
        $Reponses = $request->input("json");
        $Passages =  (array) json_decode(base64_decode($Reponses));
        echo $Reponses;

        foreach ($Passages as $_Passage){
            if($_Passage->isSelected) {
                $_Passage->Question = $_Passage->Question_id;

                $passageExist = DB::table('passage')->where(array(
                    'exam_ID'=>$examId,
                    'Question'=>$_Passage->Question,
                    'Rep' => $_Passage->id
                ))->exists();

                if($passageExist){
                    DB::table('passage')->where(array(
                        'exam_ID'=>$examId,
                        'Question'=>$_Passage->Question,
                        'Rep' => $_Passage->id
                    ))->update(array(
                        'Rep' => $_Passage->id
                    ));
                    echo response()->json(array('flash' => 'Passage_Updated'), 200);
                }
                else{
                    $passage = new \App\Modules\Passage();
                    $passage->exam_ID = $examId;
                    $passage->Question = $_Passage->Question;
                    $passage->Rep = $_Passage->id;

                    if ($passage->save()) {
                        echo response()->json($passage, 200);
                    } else {
                        echo response()->json(array('flash' => "Error_Add_Passage"), 500);
                    }
                }
                dump($_Passage);

            }
        }

    }

}

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
            $Passage->Quest;
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

}

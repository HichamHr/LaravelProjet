<?php

namespace App\Http\Controllers\API\Models;

use app\OpenTest\Validation;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;

class Exams extends Controller
{
    public function __construct()
    {
        $this->middleware('cors');
        $this->middleware('jwt.auth');
        $this->middleware('tokenRefresh');
        $this->middleware('roles:prof,admin',
            ['except'=>[
                'getIndex',
                'getShow',
                'getEtudiant',
                'getPile',
                'getPassages',
                'getFull',
                'postNew',
                'postEditeListQuestions',
                'getExamQuestions'
            ]]);
    }
    
    public function getIndex(){
        $Exames = \App\Modules\Exams::all();
        return response()->json(compact('Exames'), 200);
    }
    public function getShow($id){
        $Exame = \App\Modules\Exams::find($id);
        return response()->json(compact('Exame'), 200);
    }
    public function getEtudiant($id){
        $Exame = \App\Modules\Exams::find($id);
        if($Exame != null)
            $Etudiant = $Exame->Etudiant_;
        return response()->json(compact('Etudiant'), 200);
    }
    public function getPile($id){
        $Exame = \App\Modules\Exams::find($id);
        if($Exame != null)
            $Pile = $Exame->Pile_;
        return response()->json(compact('Pile'), 200);
    }
    public function getPassages($id){
        $Exame = \App\Modules\Exams::find($id);
        if($Exame != null)
            $Passages = $Exame->Passages;
        return response()->json(compact('Passages'), 200);
    }
    public function getFull($id){
        $Exame = \App\Modules\Exams::find($id);
        if($Exame != null){
            $Exame->Etudiant_;
            $Exame->Pile_;
            $Exame->Passages;
        }

        return response()->json(compact('Exame'), 200);
    }

    public function getExamQuestions($id){
        $Exame = \App\Modules\Exams::find($id);
        if($Exame != null){
            $list_questions = json_decode($Exame->list_questions, true);
            $Questions = \App\Modules\Questions::whereIn('question_ID',$list_questions)->get();
            $passage = $Exame->Passages;
            if($Questions != null){
                foreach ($Questions as $qu){
                    $questionReponses = $qu->ReponseRand;
                    foreach ($questionReponses as $rep){
                        $rep->isSelected = false;
                        foreach ($passage as $pa){
                            if($pa->Question === $qu->question_ID && $pa->Rep === $rep->id){
                                $rep->isSelected = true;
                                $qu->havRepo = true;
                            }
                        }
                    }
                }
            }
            return response()->json(compact('Questions'), 200);
        }
        return response()->json(array('flash' => "Exame_Not_Found"), 404);
    }

    public function postNew(Request $request){
        $validation = Validation::Exame($request);
        if ($validation === "done") {
            $user = JWTAuth::parseToken()->authenticate();
            $exame = new \App\Modules\Exams();
            $exame->date = Carbon::now();
            //$exame->description = $request->input('description');
            $exame->Pile = $request->input('pile');
            $exame->type = $request->input('type');
            $exame->etudiant = $user->Etudiant->CIN;
            $pile = \App\Modules\Piles::find($request->input('pile'));
            if ($exame->saveOrFail()) {
                $exame->duration = $pile->duree * 60 * 1000;
                return response()->json($exame, 200);
            } else {
                return response()->json(array('flash' => "Error_Add_New_Exam"), 500);
            }
        }
        else{
            return response()->json(['flash' => $validation], 406);
        }
    }
    public function postEdite(Request $request, $id){
        \App\Modules\Exams::where('id',$id)->update([
            'description' => $request->input('description'),
        ]);
        return response()->json(['flash' => 'Exame_Updated'], 200);
    }
    public function postEditeListQuestions(Request $request, $id){
        $update = \App\Modules\Exams::where('id',$id)->whereNull('list_questions')->update([
            'list_questions' => $request->input('list_questions'),
        ]);
        if($update == 0)
            return response()->json(['flash' => 'Exame_Have_Question_Prev'], 200);
        else
            return response()->json(['flash' => 'Exame_Update_list_questions'], 200);
    }
}

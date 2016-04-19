<?php

namespace App\Http\Controllers\API\Models;

use app\OpenTest\Validation;
use Carbon\Carbon;
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
        $this->middleware('roles:etudiant,prof,admin');
    }
    
    public function getIndex(){
        $Exames = \App\Modules\Exams::all();
        return response()->json(compact('Exames'), 200);
    }
    public function getShow($id){
        $Exames = \App\Modules\Exams::find($id);
        return response()->json(compact('Exames'), 200);
    }
    public function getEtudiant($id){
        $Exames = \App\Modules\Exams::find($id);
        $Etudiant = $Exames->Etudiant_;
        return response()->json(compact('Etudiant'), 200);
    }
    public function getPile($id){
        $Exames = \App\Modules\Exams::find($id);
        $Pile = $Exames->Pile_;
        return response()->json(compact('Pile'), 200);
    }
    public function getPassages($id){
        $Exames = \App\Modules\Exams::find($id);
        $Passages = $Exames->Passages;
        return response()->json(compact('Passages'), 200);
    }
    public function getFull($id){
        $Exames = \App\Modules\Exams::find($id);
        $Exames->setRelation('Etudiant_',$Exames->Etudiant_);
        $Exames->setRelation('Pile_',$Exames->Pile_);
        $Exames->setRelation('Passages',$Exames->Passages);
        return response()->json(compact('Exames'), 200);
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

            if ($exame->saveOrFail()) {
                return response()->json($exame, 200);
            } else {
                return response()->json(array('error' => false, 'Message' => "Error_Add"), 401);
            }
        }
        else{
            return response()->json(['error' => true, 'message' => $validation], 401);
        }
    }

    public function postEdite(Request $request, $id){
        \App\Modules\Exams::where('id',$id)->update([
            'description' => $request->input('description'),
        ]);
    }
    
}

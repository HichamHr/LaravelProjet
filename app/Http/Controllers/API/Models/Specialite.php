<?php

namespace App\Http\Controllers\API\Models;

use App\Modules\Modules;
use app\OpenTest\Validation;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * @property  request
 */
class Specialite extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('cors');
        $this->middleware('jwt.auth');
        $this->middleware('tokenRefresh');
        $this->middleware('roles:etudiant,prof,admin');
    }
    
    public function getIndex()
    {
        $Specialites = \App\Modules\Specialite::all();
        return response()->json(compact('Specialites'), 200);
    }
    public function getShow($id)
    {
        $Specialite = \App\Modules\Specialite::find($id);
        return response()->json(compact('Specialite'), 200);
    }
    public function getModules($id){
        $specialite = \App\Modules\Specialite::find($id);
        if($specialite != null){
            $Modules = $specialite->Modules;
            if($Modules != null){
                foreach ($Modules as $module)
                    $module->Piles;
            }
        }
        return response()->json(compact('specialite'), 200);
    }
    public function getProfs($id){
        $specialite = \App\Modules\Specialite::find($id);
        if($specialite != null){
            $Profs = $specialite->ProfSpecialite;
            if($Profs != null){
                foreach ($Profs as $Pr)
                    $Pr->Prof;
            }
        }
        return response()->json(compact('Profs'), 200);
    }
    public function getEtudiants($id){
        $specialite = \App\Modules\Specialite::find($id);
        if($specialite != null)
            $Etudiants = $specialite->Etudiant;
        return response()->json(compact('Etudiants'), 200);
    }
    public function getFull($id){
        $specialite = \App\Modules\Specialite::find($id);
        if($specialite != null){
            $Modules = $specialite->Modules;
            if($Modules != null){
                foreach ($Modules as $module){
                    $piles = $module->Piles;
                    if($piles != null){
                        foreach ($piles as $pile)
                            $pile->Prof_;
                    }
                }
            }
            $Profs = $specialite->ProfSpecialite;
            if($Profs != null){
                foreach ($Profs as $Pr)
                    $Pr->Prof;
            }
            $specialite->Etudiant;
        }
        return response()->json(compact('specialite'), 200);
    }



    public function postNew(Request $request)
    {
        $validation = Validation::Specialite($request);
        if ($validation === "done") {
            $specialite = new \App\Modules\Specialite();
            $specialite->abbreviation = $request->input('abbreviation');
            $specialite->intitule = $request->input('intitule');
            if ($specialite->saveOrFail()) {
                return response()->json(compact('specialite'), 200);
            } else {
                return response()->json(array('error' => false, 'Message' => "Error_Add"), 500);
            }
        } else {
            return response()->json(array('error' => false, 'Message' => $validation), 406);
        }
    }
    public function postEdite(Request $request, $id)
    {
        $validation = Validation::SpecialiteUpdate($request);
        if ($validation === "done") {
            \App\Modules\Specialite::where('id',$id)->update([
                'abbreviation' => $request->input('abbreviation'),
                'intitule' => $request->input('intitule'),
            ]);
            return response()->json(['error' => false], 200);
        } else {
            return response()->json(['error' => true, 'message' => $validation], 406);
        }
    }
    public function postRestore($id){
        $specialite = \App\Modules\Specialite::withTrashed()->find($id);
        if ($specialite->trashed()) {
            $specialite->restore();
            return response()->json(['error' => false], 200);
        }
        else{
            return response()->json(['error' => true, 'message' => 'Not_Fond'], 404);
        }
    }
    public function postDelete($id)
    {
        $specialite = \App\Modules\Specialite::withTrashed()->find($id);
        if ($specialite->trashed()) {
            //$specialite->forceDelete();
            return response()->json(['error' => false, 'message' => 'Deleted_for_ever'], 200);
        }
        else{
            $specialite->delete();
            return response()->json(['error' => false, 'message' => 'Deleted'], 200);
        }
    }

}

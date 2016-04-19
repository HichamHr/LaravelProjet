<?php

namespace App\Http\Controllers\API\Models;

use app\OpenTest\Validation;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class Modules extends Controller
{

    public function __construct()
    {
        $this->middleware('cors');
        $this->middleware('jwt.auth');
        $this->middleware('tokenRefresh');
        $this->middleware('roles:etudiant,prof,admin');
    }
    
    public function getIndex(){
        $Modules = \App\Modules\Modules::all();
        return response()->json(compact('Modules'), 200);
    }
    public function getShow($id){
        $Modules = \App\Modules\Modules::find($id);
        return response()->json(compact('Modules'), 200);
    }
    public function getPiles($id){
        $Modules = \App\Modules\Modules::find($id);
        $Prof = $Modules->Piles;
        foreach ($Prof as $Pr)
            $Pr->Prof;
        return response()->json(compact('Modules'), 200);
    }

    public function postNew(Request $request){
        $validation = Validation::Modules($request);
        if ($validation === "done") {
            $module = new \App\Modules\Modules();
            $module->nom = $request->input('nom');
            $module->MH = $request->input('MH');
            $module->specialite = $request->input('specialite');

            if ($module->saveOrFail()) {
                return response()->json($module, 200);
            } else {
                return response()->json(array('error' => false, 'Message' => "Error_Add"), 401);
            }
        }
        else{
            return response()->json(['error' => true, 'message' => $validation], 401);
        }
    }
    public function postEdite(Request $request, $id){
        $validation = Validation::Modules($request);
        if ($validation === "done") {
            \App\Modules\Modules::where('numero',$id)->update([
                'nom' => $request->input('nom'),
                'MH' => $request->input('MH'),
                'specialite' => $request->input('specialite'),
            ]);

            return response()->json(['error' => false], 200);
        } else {
            return response()->json(['error' => true, 'message' => $validation], 401);
        }
    }
    public function postRestore($id){
        $module = \App\Modules\Modules::withTrashed()->find($id);
        if ($module->trashed()) {
            $module->restore();
            return response()->json(['error' => false], 200);
        }
        else{
            return response()->json(['error' => true, 'message' => 'Not_Fond'], 401);
        }
    }
    public function postDelete($id)
    {
        $module = \App\Modules\Modules::withTrashed()->find($id);
        if ($module->trashed()) {
            //$specialite->forceDelete();
            return response()->json(['error' => true, 'message' => 'Deleted_for_ever'], 401);
        }
        else{
            $module->delete();
            return response()->json(['error' => true, 'message' => 'Deleted'], 401);
        }
    }
}

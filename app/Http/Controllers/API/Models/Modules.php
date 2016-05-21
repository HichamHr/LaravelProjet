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
        $this->middleware('roles:prof,admin',
            ['except'=>[
                'getIndex',
                'getShow',
                'getPiles'
            ]]);
    }
    
    public function getIndex($trashed = null){
        if($trashed == null)
            $Modules = \App\Modules\Modules::all();
        else if($trashed === "trashed")
            $Modules = \App\modules\Modules::onlyTrashed()->get();
        else if($trashed === "all")
            $Modules = \App\modules\Modules::withTrashed()->get();
        else
            $Modules = null;

        return response()->json(compact('Modules'), 200);
    }

    public function getShow($id){
        $Module = \App\Modules\Modules::find($id);
        return response()->json(compact('Module'), 200);
    }
    public function getPiles($id){
        $Module = \App\Modules\Modules::find($id);
        if($Module != null){
            $Prof = $Module->Piles;
            if($Prof != null){
                foreach ($Prof as $Pr)
                    $Pr->Prof_;
            }
        }
        return response()->json(compact('Module'), 200);
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
                return response()->json(array('flash' => "Error_Add_Module"), 500);
            }
        }
        else{
            return response()->json(['flash' => $validation], 406);
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

            return response()->json(['flash' => "Module_Updated"], 200);
        } else {
            return response()->json(['flash' => $validation], 406);
        }
    }
    public function postRestore($id){
        $module = \App\Modules\Modules::withTrashed()->find($id);
        if ($module->trashed()) {
            $module->restore();
            return response()->json(['flash' => "Module_Restored"], 200);
        }
        else{
            return response()->json(['flash' => 'Not_Fond_Module'], 404);
        }
    }
    public function postDelete($id)
    {
        $module = \App\Modules\Modules::withTrashed()->find($id);
        if ($module->trashed()) {
            //$specialite->forceDelete();
            return response()->json(['flash' => 'Deleted_for_ever_Module'], 200);
        }
        else{
            $module->delete();
            return response()->json(['flash' => 'Module_Deleted'], 200);
        }
    }
}

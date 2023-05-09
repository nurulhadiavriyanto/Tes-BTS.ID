<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChecklistController extends Controller
{
    public function getChecklist() {
        $data = Checklist::all();
        return response()->json($data, 200);
    }

    public function createChecklist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $checklist = Checklist::create([
            'name' => $request->get('name'),
        ]);

        return response()->json($checklist, 200);
    }
    
    public function deleteChecklist($id)
    {
        $checklist = Checklist::find($id);
        if(!isset($checklist)){
            return response()->json("Data not found.", 400);
        }
        $checklist->delete();
     
        return response()->json("Data ".$checklist->name." has been deleted.", 200);
    }
}

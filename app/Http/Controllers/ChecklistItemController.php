<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\ChecklistItem;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChecklistItemController extends Controller
{
    public function getChecklistItem($id) {
        $checklist = Checklist::find($id);
        if(!isset($checklist)){
            return response()->json("Checklist not found.", 400);
        }

        $data = ChecklistItem::select('checklist_item.id','checklist.name as checklist_name','checklist_item.name as item_name')
            ->join('checklist', 'checklist_item.id_checklist', '=', 'checklist.id')
            ->where('checklist.id','=',$id)
            ->get();

        return response()->json($data, 200);
    }

    public function createChecklistItem(Request $request, $id)
    {
        $checklist = Checklist::find($id);
        if(!isset($checklist)){
            return response()->json("Checklist not found.", 400);
        }

        $validator = Validator::make($request->all(), [
            'itemName' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $checklist_item = ChecklistItem::create([
            'id_checklist' => $id,
            'name' => $request->get('itemName'),
        ]);

        return response()->json($checklist_item, 200);
    }

    public function getChecklistItemByChecklist($checklist_id, $item_id) {
        $checklist = Checklist::find($checklist_id);
        if(!isset($checklist)){
            return response()->json("Checklist not found.", 400);
        }

        $checklist_item = ChecklistItem::find($item_id);
        if(!isset($checklist_item)){
            return response()->json("Checklist Item not found.", 400);
        }

        $data = ChecklistItem::select('checklist_item.id','checklist.name as checklist_name','checklist_item.name as item_name')
            ->join('checklist', 'checklist_item.id_checklist', '=', 'checklist.id')
            ->where('checklist.id', '=', $checklist_id)
            ->where('checklist_item.id', '=', $item_id)
            ->get();

        return response()->json($data, 200);
    }

    public function deleteChecklistItem($checklist_id, $item_id)
    {
        $checklist = Checklist::find($checklist_id);
        if(!isset($checklist)){
            return response()->json("Checklist not found.", 400);
        }

        $checklist_item = ChecklistItem::find($item_id);
        if(!isset($checklist_item)){
            return response()->json("Checklist Item not found.", 400);
        }

        $checklist_item->delete();
     
        return response()->json("Data ".$checklist_item->name." has been deleted.", 200);
    }

    public function updateChecklistItem(Request $request, $checklist_id, $item_id)
    {
        $checklist = Checklist::find($checklist_id);
        if(!isset($checklist)){
            return response()->json("Checklist not found.", 400);
        }

        $checklist_item = ChecklistItem::find($item_id);
        if(!isset($checklist_item)){
            return response()->json("Checklist Item not found.", 400);
        }

        $validator = Validator::make($request->all(), [
            'itemName' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $checklist_item->name = $request->itemName;
        $checklist_item->save();

        return response()->json($checklist_item, 200);
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Record;
use App\Models\Combiner;
use Illuminate\Http\Request;


class RecordController extends Controller
{
    public function createrecord($id, Request $request)
    {
        $newRecord = Record::create([
            'table_id' => $id,
        ]);
        // Retrieve the field structure from existing combiners
        $firstRecord = Record::where('table_id', $id)->first();
        $combiners = Combiner::where('table_id', $id)->where('record_id', $firstRecord->id)->get();

        // Duplicate combiners for the new record
        foreach ($combiners as $combiner) {
            Combiner::create([
                'table_id'   => $id,
                'record_id'  => $newRecord->id, // Link to the new record
                'field_id'   => $combiner->field_id,
                'field_name' => $combiner->field_name,
                'order'      => $combiner->order,
                'content'    => null, // Set content to null or default if needed
            ]);
        }
    }
}

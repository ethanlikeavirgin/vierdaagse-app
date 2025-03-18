<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Table;
use App\Models\Field;
use App\Models\Combiner;
use App\Models\Record;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        return Inertia::render('Tables/Index', ['tables' => $tables]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
        ]);

        $baseSlug = strtolower(str_replace(' ', '_', $request->name));
        $slug = $baseSlug;
        // Check for uniqueness
        $counter = 1;
        while (Table::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '_' . $counter;
            $counter++;
        }

        Table::create([
            'name' => $request->name,
            'slug' => $slug,
            'category' => $request->category,
        ]);

        return redirect()->to('/builder')->with('message', 'Created');
    }

    public function update(Request $request, Table $builder)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
        ]);

        $baseSlug = strtolower(str_replace(' ', '_', $request->name));
        $slug = $baseSlug;
        // Check for uniqueness
        $counter = 1;
        while (Table::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '_' . $counter;
            $counter++;
        }

        $builder->update([
            'name' => $request->name,
            'slug' => $slug,
            'category' => $request->category,
        ]);

        return redirect()->to('/builder')->with('message', 'Updated');
    }

    public function destroy(Table $builder)
    {
        $builder->delete();
        return redirect()->route('builder.index')->with('message', 'Deleted');
    }
    public function show($id) 
    {
        $table = Table::where('id', $id)->get();
        $fields = Field::all();
        $records = Record::where('table_id', $id)->get();
        $combiner = Combiner::with('field')->get();
        return Inertia::render('Tables/Detail', ['table' => $table, 'fields' => $fields, 'combiner' => $combiner, 'records' => $records]);
    }
    /*public function duplicate($id, Request $request)
    {
        $c_field = Field::where('slug', $request->category)->first();
        Combiner::create([
            'table_id' => $id,
            'field_id' => $c_field->id,
            'content' => $request->name,
        ]);
    }*/
    public function duplicate($id, Request $request)
    {
        $c_field = Field::where('slug', $request->category)->first();
        $records = Record::where('table_id', $id)->get();

        $baseSlug = strtolower(str_replace(' ', '_', $request->name));
        $slug = $baseSlug;
        // Check for uniqueness
        $counter = 1;
        while (Combiner::where('field_name', $slug)->exists()) {
            $slug = $baseSlug . '_' . $counter;
            $counter++;
        }
        foreach ($records as $record) {
            Combiner::create([
                'table_id' => $id,
                'field_id' => $c_field->id,
                'field_name' => $slug,
                'content' => $request->name,
                'record_id' => $record->id,
            ]);
        }
    }

    public function savecontent($recordId, Request $request)
    {
        dd($request);
    }
}
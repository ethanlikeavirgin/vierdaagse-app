<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Table;
use App\Models\Field;
use App\Models\Combiner;

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

        $baseSlug = strtolower(str_replace(' ', '-', $request->name));
        $slug = $baseSlug;
        // Check for uniqueness
        $counter = 1;
        while (Table::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
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

        $baseSlug = strtolower(str_replace(' ', '-', $request->name));
        $slug = $baseSlug;
        // Check for uniqueness
        $counter = 1;
        while (Table::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
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
        $combiner = Combiner::with('field')->get();
        return Inertia::render('Tables/Detail', ['table' => $table, 'fields' => $fields, 'combiner' => $combiner]);
    }
    public function duplicate($id, Request $request)
    {
        $c_field = Field::where('slug', $request->category)->first();
        Combiner::create([
            'table_id' => $id,
            'field_id' => $c_field->id,
            'content' => $request->name,
        ]);
    }
    public function savecontent($id, Request $request)
    {
        $filePath = $request->file('file') ? $request->file('file')->store('files', 'public') : null;

        if($request->file != "") {
            Combiner::where('id', $id)->update([
                'content' => $filePath,
            ]);
        }else {
            Combiner::where('id', $id)->update([
                'content' => $request->content,
            ]);
        }
    }
}
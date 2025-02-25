<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Field;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::all();
        return Inertia::render('Tables/Field', ['fields' => $fields]);
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
        while (Field::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        Field::create([
            'name' => $request->name,
            'slug' => $slug,
            'category' => $request->category
        ]);
    }
}

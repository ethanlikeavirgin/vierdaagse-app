<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Record;
use App\Models\Combiner;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TestController extends Controller
{
    public function home()
    {
        $table_home = table('home')->first(); // Fetch all fields for the 'contact' table
        return Inertia::render('Welcome', ['table_home' => $table_home]);
    }
}

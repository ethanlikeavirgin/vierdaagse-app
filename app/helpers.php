<?php

use App\Models\Table;
use App\Models\Record;
use App\Models\Combiner;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

if (!function_exists('table')) {
    function table($slug)
    {
        $table = Table::where('slug', $slug)->first();
        if (!$table) return null;

        $records = Record::where('table_id', $table->id)->get();
        if ($records->isEmpty()) return null;

        $data = [];
        foreach ($records as $record) {
            $combiners = Combiner::where('record_id', $record->id)->get();
            foreach ($combiners as $combiner) {
                $data[$combiner->field_name] = $combiner->content; // Store as key-value pair
            }
        }

        return new class($data) {
            private $data;
            public function __construct($data) { $this->data = $data; }
            
            // Return a single object (first item) when calling ->first()
            public function first() {
                return (object) $this->data;
            }
            
            // Return an array (all items) when calling ->get()
            public function get() {
                return $this->data;
            }
        };
    }
}

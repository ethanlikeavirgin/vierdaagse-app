<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Combiner extends Model
{
    protected $table = 'combiner'; // Explicitly define the table name

    protected $fillable = ['table_id', 'field_id', 'order', 'content'];

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id', 'id');
    }

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id', 'id');
    }
}
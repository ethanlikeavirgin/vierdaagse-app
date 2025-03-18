<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table = 'records'; // Explicitly define the table name

    protected $fillable = ['table_id'];

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id', 'id');
    }
}

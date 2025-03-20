<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Record;

class Combiner extends Model
{
    use HasTranslations;
    protected $table = 'combiner'; // Explicitly define the table name
    public $translatable = ['content'];

    protected $fillable = ['table_id', 'field_id', 'field_name', 'record_id', 'order', 'content'];
    // ✅ Force JSON cast to ensure it's handled correctly
    protected $casts = [
        'content' => 'array',  // ✅ Ensures Laravel treats it as JSON
    ];

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id', 'id');
    }

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id', 'id');
    }

    public function records()
    {
        return $this->belongsTo(Record::class, 'record_id', 'id');
    }
}
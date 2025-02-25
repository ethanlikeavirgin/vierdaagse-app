<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Combiner; // ✅ ADD THIS LINE

class Table extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
    ];

    public function fields()
    {
        return $this->belongsToMany(Field::class, 'combiner')
            ->withPivot(['order', 'content', 'created_at', 'updated_at']);
    }

    // One-to-Many relationship with Combiner
    public function combiners()
    {
        return $this->hasMany(Combiner::class, 'table_id', 'id');
    }
}

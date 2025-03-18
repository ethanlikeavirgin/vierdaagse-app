<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Combiner;

class Field extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
    ];
    public function tables(): BelongsToMany
    {
        return $this->belongsToMany(Table::class, 'combiner')->withPivot(['order', 'content', 'created_at', 'updated_at']);
    }

    public function combiners()
    {
        return $this->hasMany(Combiner::class, 'field_id', 'id');
    }
}

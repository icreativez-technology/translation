<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslationTag extends Model
{
    protected $fillable = ['tag'];
    
    public function translation()
    {
        return $this->belongsTo(Translation::class);
    }
}
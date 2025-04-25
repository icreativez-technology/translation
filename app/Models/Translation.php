<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = ['group', 'key', 'value', 'locale'];
    
    public function tags()
    {
        return $this->hasMany(TranslationTag::class);
    }
    
    public function scopeForLocale($query, $locale)
    {
        return $query->where('locale', $locale);
    }
    
    public function scopeForGroup($query, $group)
    {
        return $query->where('group', $group);
    }
    
    public function scopeWithTag($query, $tag)
    {
        return $query->whereHas('tags', fn($q) => $q->where('tag', $tag));
    }
}

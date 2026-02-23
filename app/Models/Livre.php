<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    
    public $timestamps = false;
    protected $fillable = ['titre', 'description', 'photo', 'audio', 'age_min', 'age_max'];
    public function pages()
    {
        return $this->hasMany(Page::class);
    }
    public function progressions() {
        return $this->hasMany(Progression::class);
    }
    

}

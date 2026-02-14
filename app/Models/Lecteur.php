<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecteur extends Model
{  
    protected $fillable = ['nom', 'age'];
    
    public function progressions() {
        return $this->hasMany(Progression::class);
    }
}


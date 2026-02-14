<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progression extends Model
{
    protected $fillable = ['lecteur_id', 'livre_id', 'derniere_page'];

    public function lecteur() {
        return $this->belongsTo(Lecteur::class);
    }

    public function livre() {
        return $this->belongsTo(Livre::class);
    }

    public function page() {
        return $this->belongsTo(Page::class, 'derniere_page');
    }
}


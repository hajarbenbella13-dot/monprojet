<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'livre_id',     
        'num_page', 
        'image', 
        'audio', 
        'contenu'
    ];

public function livre()
{
    return $this->belongsTo(Livre::class);
}
}

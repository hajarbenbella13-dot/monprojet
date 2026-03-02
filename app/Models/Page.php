<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $timestamps = false;
   protected $fillable = ['livre_id', 'num_page', 'contenu', 'image', 'audio'];

public function livre()
{
    return $this->belongsTo(Livre::class);
}

}

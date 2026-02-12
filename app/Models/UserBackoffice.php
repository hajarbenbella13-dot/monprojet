<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserBackoffice extends Authenticatable
{
    use Notifiable;

    protected $table = 'userbackoffice'; // <-- important
    public $timestamps = false; // ou true si tu ajoutes updated_at
    protected $fillable = ['login', 'password'];
    protected $hidden = ['password'];

    

    public function username()
{
    return 'login'; 
}

public function getEmailAttribute()
{
    return $this->login;
}
}

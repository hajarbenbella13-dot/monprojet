<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <--- 1. Darouri t-zidi had l-ligne

class UserBackoffice extends Authenticatable
{
    use HasApiTokens, Notifiable; // <--- 2. Zidi HasApiTokens hna

    protected $table = 'userbackoffice'; 
    public $timestamps = false; 
    protected $fillable = ['login', 'password'];
    protected $hidden = ['password'];

    /**
     * Bach Laravel i-qelleb b 'login' blast 'email' f l-authentification
     */
    public function username()
    {
        return 'login'; 
    }

    /**
     * Accessor: ila chi blassa f Laravel bghat 'email', t-akhod 'login'
     */
    public function getEmailAttribute()
    {
        return $this->login;
    }
}
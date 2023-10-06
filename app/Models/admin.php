<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    protected $fillable = [
        'name', 'email', 'password',
    ];
    public function authenticate($password)
    {
        return $this->password === $password;
    }
}

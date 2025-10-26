<?php

namespace App\Models;
use App\Models\Account;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const STATUS_ACTIVE = 'active';
    const STATUS_SUSPENDED = 'suspended';

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'status',
        'admin_id',
        'employee_id',
    ];


    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
// As Admin: get all employees
    public function employees()
    {
        return $this->hasMany(User::class, 'admin_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'employee_id');
    }
    public function isEmployee()
{
    return $this->role === 'employee';
}

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

}

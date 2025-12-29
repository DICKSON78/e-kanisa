<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'department_id',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function member()
    {
        return $this->hasOne(Member::class);
    }

    public function createdIncomes()
    {
        return $this->hasMany(Income::class, 'created_by');
    }

    public function createdExpenses()
    {
        return $this->hasMany(Expense::class, 'created_by');
    }

    public function createdEvents()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'requested_by');
    }

    public function approvedRequests()
    {
        return $this->hasMany(Request::class, 'approved_by');
    }

    // Helper methods
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    public function hasPermission($permission)
    {
        return $this->role && $this->role->hasPermission($permission);
    }

    public function isMchungaji()
    {
        return $this->hasRole('Mchungaji');
    }

    public function isMhasibu()
    {
        return $this->hasRole('Mhasibu');
    }

    public function isMwanachama()
    {
        return $this->hasRole('Mwanachama');
    }
}

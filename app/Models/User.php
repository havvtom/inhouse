<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Message;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);

    }

    public function sentMessages(){
        return $this->hasMany(Message::class, 'created_by_id');
    }

    public function getSentCountAttribute(){
        return $this->sentMessages()->count();
    }

    public function receivedMessages(){
        return $this->hasMany(Message::class, 'sending_to_id');
    }

    //Inbox count only shows messages received by the authenticated user that have not been seen
    public function getInboxCountAttribute(){
        return $this->receivedMessages()->where('seen', null)->count();
    }

   
    public function hasRole($role){

        if($this->roles->contains('name', $role)){
            return true;
        }

        return false;
    }

    public function hasPermissionTo($permission){
        //permission through role
        foreach($this->roles as $role){
            if($role->permissions->contains('name', $permission)){
                return true;
            }
        }

        if($this->permissions->contains('name', $permission)){
            return true;
        }

        return false;
    }
}

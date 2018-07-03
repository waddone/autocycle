<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Anunturi;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin() {
        if($this->type == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    public function hasActiveAds() {
        return Anunturi::where('status','=','activ')->count();
        //return $this->hasMany('App\Anunturi', 'user_id')->where('status','=','activ')->count();
    }

    public function hasSterseAds() {
        return Anunturi::where('status','=','sters')->count();
        //return $this->hasMany('App\Anunturi', 'user_id')->where('status','=','sters')->count();
    }

    public function hasSeturiAds() {
        return Anunturi_sparte::where('status','=','activ')->count();
        //return $this->hasMany('App\Anunturi_sparte', 'user_id')->where('status','=','activ')->count();
    }

    public function hasCereri() {
        return $this->hasMany('App\Cereri')->where('status','=','activ')->count();
    }
    
}

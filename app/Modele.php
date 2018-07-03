<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Modele extends Model{
    protected $table = 'modele';

    protected $fillable = [
        'marca' , 'modele'
    ];


}


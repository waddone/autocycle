<?php

namespace App;
use Illuminate\Database\Eloquent\Model;



class Piese extends Model{
    protected $table = 'piese';

    protected $fillable = [
        'categorie' , 'piesa'
    ];


}

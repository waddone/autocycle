<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Categorii extends Model{
    protected $table = 'categoriipiese';

    protected $fillable = [
        'categorie'
    ];


}

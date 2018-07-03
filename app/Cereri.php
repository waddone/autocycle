<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Cereri extends Model {
    protected $table = 'cereri';

    protected $fillable = [
        'marca', 'marca', 'an', 'descriere', 'carburant', 'nume', 'telefon'
    ];

 
    //protected $hidden = ['latime'];
    
    //const CREATED_AT = 'added_on';
    //const UPDATED_AT = 'modified_on';

  

}

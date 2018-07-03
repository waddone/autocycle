<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Newsletter extends Model {
    protected $table = 'newsletter';

    protected $fillable = [
        'name', 'email', 'active'
    ];

 
    //protected $hidden = ['latime'];
    
    //const CREATED_AT = 'added_on';
    //const UPDATED_AT = 'modified_on';

  

}

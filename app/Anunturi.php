<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\User;


//class Anunturi extends Authenticatable
class Anunturi extends Model {
    protected $table = 'anunturi';

    //protected $fillable = [
    //    'user_id', 'titlu', 'categorie', 'categoriepiesa', 'piesa', 'marca', 'model', 'an', 'descriere', 'pret', 'moneda'
    //];

    //protected $hidden = ['latime'];
    
    //const CREATED_AT = 'added_on';
    //const UPDATED_AT = 'modified_on';

    public function AnuntUrl() {
    	return $url = url('/').'/dezmembrari-auto/'.str_replace(' ', '-', strtolower($this->titlu)).'-id-'.$this->id; 
    }


    public function User() {
        return $this->belongsTo('App\User');
    }


    public function NrOfAvailablePics() {
        $x = array();

        if($this->image1 != '') {$x[] = 1;}
        if($this->image2 != '') {$x[] = 2;}
        if($this->image3 != '') {$x[] = 3;}
        if($this->image4 != '') {$x[] = 4;}
        if($this->image5 != '') {$x[] = 5;}
        if($this->image6 != '') {$x[] = 6;}
        if($this->image7 != '') {$x[] = 7;}
        if($this->image8 != '') {$x[] = 8;}
        if($this->image9 != '') {$x[] = 9;}

        return $x;

    }

}

<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modele;
use App\Piese;

class AjaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        //$this->middleware('auth')->except(['contulMeu','underConstruction','afisareAnunt']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function getModel($marca) {
        $marca = strtolower($marca);
        $marca = trim(strip_tags($marca));
        $model_c = Modele::where('marca','=',$marca)->get();
        return json_encode($model_c);
    }

    public function getPiesa($categorie) {
        $categ   = strtolower($categorie);
        $categ   = trim(strip_tags($categ));
        $categ_c = Piese::where('categorie','=',$categ)->get();
        return json_encode($categ_c);
    }    

}

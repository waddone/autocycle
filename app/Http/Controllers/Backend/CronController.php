<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Anunturi;
use App\Marci;
use App\Modele;
use App\Categorii;
use App\Piese;

class CronController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth')->except(['getAvailablesMarci']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

   

    public function getAvailablesMarci(){

        $available_obj_marci_c        = Anunturi::where('user_id','=', '78')->groupBy('marca')->get();

        $available_marci_c = array();

        foreach ($available_obj_marci_c as $available_obj_marci_r) {
            $available_marci_c[] = $available_obj_marci_r->marca;
        }

        $marci_c    = Marci::whereIn('marca', $available_marci_c)->get();

        foreach ($marci_c as $marci_r) {
            $marci_r->available = 'yes';
            $marci_r->save();
            
        }
        
    }



}

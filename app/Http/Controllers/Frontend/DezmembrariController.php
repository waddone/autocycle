<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Anunturi;
use App\Marci;
use App\Modele;
use App\Categorii;
use App\Piese;

class DezmembrariController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth')->except(['listareAnunturi','underConstruction','afisareAnunt','filtrareAnunturi']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function listareAnunturi(){
        //$limit      = 20;
        //if(!isset($paginatie)) {
        //    $start      = 0;
        //} else {
        //    $start      = str_replace('pagina=', '', $paginatie);
        //}
        $marci_c        = Marci::where('available','=','yes')->get();
        $piese_c        = Piese::all();
        $count_anunturi = Anunturi::where('user_id','=', '78')->where('status','=','activ')->count();
        $pret_min       = Anunturi::min('pret');
        $pret_max       = Anunturi::max('pret');
        /*
        $anunturi_c     = Anunturi::where('user_id','=', '78')
                            ->orderBy('id', 'asc')
                            ->skip($start)
                            ->take($limit)
                            ->get();
        */
        $anunturi_c     = Anunturi::where('user_id','=','78')->where('status','=','activ')->orderBy('id', 'desc')->paginate(20);
       
        return view('frontend.dezmembrari-auto', compact('anunturi_c', 'count_anunturi','pret_min','pret_max', 'marci_c', 'piese_c'));
    }


    public function afisareAnunt($anunt){

        $ids                 = explode('-id-', $anunt);
        $id                  = $ids['1'];
        $anunt_r             = Anunturi::where('id','=',$id)->first();
        $anunturi_similare   = Anunturi::where('marca','=',$anunt_r->marca)->where('model','=',$anunt_r->model)->take(12)->get();

        return view('frontend.dezmembrari-auto-anunt', compact('anunt_r','anunturi_similare'));
    }


    public function filtrareAnunturi(Request $request) {
        
        $marci_c        = Marci::where('available','=','yes')->get();
        $piese_c        = Piese::all();
        $marca_aleasa   = '';
        $model_aleasa   = '';
        $piesa_aleasa   = '';

        if($request->marca && $request->model && $request->piesa) {

            $anunturi_c     = Anunturi::where('marca','=',$request->marca)->where('model','=',$request->model)->where('piesa','=',$request->piesa)->orderBy('id', 'desc')->paginate(20);
            $count_anunturi = Anunturi::where('marca','=',$request->marca)->where('model','=',$request->model)->where('piesa','=',$request->piesa)->count();
            $pret_min       = Anunturi::where('marca','=',$request->marca)->where('model','=',$request->model)->where('piesa','=',$request->piesa)->min('pret');
            $pret_max       = Anunturi::where('marca','=',$request->marca)->where('model','=',$request->model)->where('piesa','=',$request->piesa)->max('pret');
            $h1             = $request->marca.' '.$request->model.' '.$request->piesa;
            $marca_aleasa   = $request->marca;
            $model_aleasa   = $request->model;
            $piesa_aleasa   = $request->piesa;
        } 

        if($request->marca && $request->model && !$request->piesa) {
            $anunturi_c     = Anunturi::where('marca','=',$request->marca)->where('model','=',$request->model)->orderBy('id', 'desc')->paginate(20);
            $count_anunturi = Anunturi::where('marca','=',$request->marca)->where('model','=',$request->model)->count();
            $pret_min       = Anunturi::where('marca','=',$request->marca)->where('model','=',$request->model)->min('pret');
            $pret_max       = Anunturi::where('marca','=',$request->marca)->where('model','=',$request->model)->max('pret');
            $h1             = $request->marca.' '.$request->model;
            $marca_aleasa   = $request->marca;
            $model_aleasa   = $request->model;
            $piesa_aleasa   = '';
        } 

        if($request->marca && !$request->model && !$request->piesa) {
            $anunturi_c     = Anunturi::where('marca','=',$request->marca)->orderBy('id', 'desc')->paginate(20);
            $count_anunturi = Anunturi::where('marca','=',$request->marca)->count();
            $pret_min       = Anunturi::where('marca','=',$request->marca)->min('pret');
            $pret_max       = Anunturi::where('marca','=',$request->marca)->max('pret');
            $h1             = $request->marca;
            $marca_aleasa   = $request->marca;
            $model_aleasa   = '';
            $piesa_aleasa   = '';
        } 

        return view('frontend.dezmembrari-auto-filtru', compact('anunturi_c', 'count_anunturi','pret_min','pret_max', 'marci_c', 'piese_c', 'h1', 'marca_aleasa', 'model_aleasa','piesa_aleasa'));

    }



}

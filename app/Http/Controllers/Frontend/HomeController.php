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
use Illuminate\Http\UploadedFile;
use Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Cereri;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth')->except(['index','underConstruction', 'despreNoi', 'contact', 'termeniSiConditii','cererePiesa']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function underConstruction() {
        return view('frontend.underConstruction');
    }

    public function index(){

        $marci_c        = Marci::where('available','=','yes')->get();
        $piese_c        = Piese::all();
        $anunturi_c     = Anunturi::where('user_id','=', '78')
                            ->where('status','=', 'activ')
                            ->inRandomOrder()
                            ->skip(0)
                            ->take(12)
                            ->get();

        return view('frontend.home', compact('anunturi_c', 'marci_c', 'piese_c'));
    }

    public function despreNoi(){
        return view('frontend.despre-noi');
    }

    public function contact(){
        return view('frontend.contact');
    }

    public function termeniSiConditii(){
        return view('frontend.termeni-si-conditii');
    }

    public function cererePiesa($a1 = null,$a2 = null,$a3 = null){

        $marci_c         = Marci::where('available','=','yes')->get();
        $categ_c         = Categorii::all();
        return view('frontend.cerere-piesa' ,compact('marci_c','categ_c','a1','a2','a3'));
    }

    public function trimiteCererePost(Request $request) {

        $this->validate($request, [
            'marca'             => 'required',
            'model'             => 'required',
            'an'                => 'required',
            'descriere'         => 'required',
            'carburant'         => 'required',
            'nume'              => 'required',
            'telefon'           => 'required'
        ]);

        $cerere_r              = new Cereri;
        $cerere_r->nume        = $request->nume; 
        $cerere_r->telefon     = $request->telefon; 
        $cerere_r->marca       = $request->marca; 
        $cerere_r->model       = $request->model; 
        $cerere_r->descriere   = $request->descriere; 
        $cerere_r->an          = $request->an; 
        $cerere_r->carburant   = $request->carburant; 
        $cerere_r->status      = 'activ';


        $poza_name       = strtolower(str_replace(' ', '-', $request->nume));
        if($request->file('image1')) {
            $file             = $request->image1->getClientOriginalExtension();
            $extension        = $request->image1->extension();
            $path_350         = public_path('../resources/assets/cereri/'.$poza_name.'_350.'.$extension);
            $img = Image::make($request->file('image1')->getRealPath())
                ->resize(null, 350, function ($constraint) {
                        $constraint->aspectRatio();
                    }
                )
                ->insert(public_path('watermark.png'), 'bottom-right', 10, 10)
                ->save($path_350);

            $request->file('image1')->move('resources/assets/cereri/', $poza_name.'.'.$extension);
            $image1           = 'resources/assets/cereri/'.$poza_name.'.'.$extension;
            $image_thumb_350  = str_replace(public_path(), '', $path_350);
            $image_thumb_350  = str_replace('\../', '', $image_thumb_350);
            $cerere_r->image1           = $image1;
            $cerere_r->image_thumb_350  = $image_thumb_350;
        } 
        // create image for cerere


        $cerere_r->save();
       
        Session::flash('message', 'Cerere trimisa cu succes!'); 

        return redirect()->route('cerere-piesa');
    }


}

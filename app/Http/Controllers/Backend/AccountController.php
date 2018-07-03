<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Anunturi;
use App\Anunturi_sparte;
use App\Marci;
use App\Modele;
use App\Categorii;
use App\Piese;
use App\Cereri;
use App\User;
use App\Newsletter;
use Illuminate\Http\UploadedFile;
use Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
// toate facades se pot scrie si asa 
// use Input;
// for email
use App\Mail\SendingNewsletters;
use Illuminate\Support\Facades\Mail;


// use response for csv
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;


class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth')->except(['newsletterPost','newsletterTest']);

        // ar trebuii sa creezi un middleware pentru admin si except pentru client la functia cererepiesa
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function showResetForm(Request $request, $token = null) {
        $user_logat_r   = Auth::user();
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email, 'user_logat_r' => $user_logat_r]
        );
    }

    public function showResetFormAccount(Request $request, $token = null) {
        $user_logat_r   = Auth::user();
        return view('auth.passwords.reset2')->with(
            ['token' => $token, 'email' => $request->email, 'user_logat_r' => $user_logat_r]
        );
    }

    public function contulMeu() {
        $user_logat_r    = Auth::user();
        return view('backend.contul-meu', compact('user_logat_r'));
    }

    public function newsletter() {
        $user_logat_r    = Auth::user();
        $user_c          = Newsletter::all();
        return view('backend.newsletter', compact('user_logat_r','user_c'));
    }

    public function adaugaAnunt() {
        $marci_c         = Marci::all();
        $categ_c         = Categorii::all();
        $user_logat_r    = Auth::user();
        return view('backend.adauga-anunt', compact('marci_c','categ_c','user_logat_r'));
    }

    public function adaugaAnuntPost(Request $request) {

        $this->validate($request, [
            'anunt_id'          => 'required',
            'titlu'             => 'required|max:255',
            'categoriepiesa'    => 'required|max:255',
            'piesa'             => 'required|max:255',
            'marca'             => 'required|max:100',
            'model'             => 'required|max:20',
            'an'                => 'required',
            'descriere'         => 'required',
            'pret'              => 'required',
            'moneda'            => 'required'
        ]);

        $poza_name       = strtolower(str_replace(' ', '-', $request->titlu));
        $cai_putere  = '';
        if($request->kilowati != '') {
            $cai_putere      = round($request->kilowati * 1.341);
        }
        
        if($request->anunt_id == 'new') {
            $anunt_r = new Anunturi;
            $message_alert  = 'Anunt adaugat cu succes!';
        } else {
            $anunt_r = Anunturi::where('id','=',$request->anunt_id)->first();
            $message_alert  = 'Anunt modificat cu succes!';
        }
    
        $anunt_r->categorie             = 'dezmembrari auto';
        $anunt_r->titlu                 = $request->titlu;
        $anunt_r->categoriepiesa        = $request->categoriepiesa;
        $anunt_r->piesa                 = $request->piesa; 
        $anunt_r->marca                 = $request->marca;
        $anunt_r->model                 = $request->model;
        $anunt_r->an                    = $request->an;
        $anunt_r->descriere             = $request->descriere;
        $anunt_r->pret                  = $request->pret;
        $anunt_r->moneda                = $request->moneda;
        $anunt_r->capacitate_cilindrica = $request->capacitate_cilindrica;
        $anunt_r->carburant             = $request->carburant;
        $anunt_r->kilowati              = $request->kilowati;
        $anunt_r->cai_putere            = $cai_putere;
        $anunt_r->cutie_viteze          = $request->cutie_viteze;
        $anunt_r->serie_sasiu           = $request->serie_sasiu;
        $anunt_r->cod_piesa             = $request->cod_piesa;
        if($request->file('image1')) {
            $file             = $request->image1->getClientOriginalExtension();
            $extension        = $request->image1->extension();
            $path_350         = public_path('../resources/assets/uploads/thumb_350/'.$poza_name.'_350.'.$extension);
            $path_normal      = public_path('../resources/assets/uploads/'.$poza_name.'.'.$extension);
            $img = Image::make($request->file('image1')->getRealPath())
                ->resize(null, 350, function ($constraint) {
                        $constraint->aspectRatio();
                    }
                )
                ->insert(public_path('watermark.png'), 'bottom-right', 10, 10)
                ->save($path_350);
            $image_thumb_350  = str_replace(public_path(), '', $path_350);
            $image_thumb_350  = str_replace('\../', '', $image_thumb_350);

            $img_n = Image::make($request->file('image1')->getRealPath())
                ->resize(null, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    }
                )
                ->insert(public_path('watermark.png'), 'bottom-right', 10, 10)
                ->save($path_normal);
            $image_normal  = str_replace(public_path(), '', $path_normal);
            $image_normal  = str_replace('\../', '', $image_normal);
            $anunt_r->image1                = $image_normal;
            $anunt_r->image_thumb_350       = $image_thumb_350;
        } 
        if($request->file('image2')) {
            $file             = $request->image2->getClientOriginalExtension();
            $extension        = $request->image2->extension();
            $request->file('image2')->move('resources/assets/uploads', $poza_name.'_2.'.$extension);
            $image2  = 'resources/assets/uploads/'.$poza_name.'_2.'.$extension;  
            $anunt_r->image2  = $image2;
        } 
        if($request->file('image3')) {
            $file             = $request->image3->getClientOriginalExtension();
            $extension        = $request->image3->extension();
            $request->file('image3')->move('resources/assets/uploads', $poza_name.'_3.'.$extension);
            $image3           = 'resources/assets/uploads/'.$poza_name.'_3.'.$extension;  
            $anunt_r->image3  = $image3;
        } 
        if($request->file('image4')) {
            $file             = $request->image4->getClientOriginalExtension();
            $extension        = $request->image4->extension();
            $request->file('image4')->move('resources/assets/uploads', $poza_name.'_4.'.$extension);
            $image4           = 'resources/assets/uploads/'.$poza_name.'_4.'.$extension;  
            $anunt_r->image4  = $image4;
        }
        if($request->file('image5')) {
            $file             = $request->image5->getClientOriginalExtension();
            $extension        = $request->image5->extension();
            $request->file('image5')->move('resources/assets/uploads', $poza_name.'_5.'.$extension);
            $image5           = 'resources/assets/uploads/'.$poza_name.'_5.'.$extension;  
            $anunt_r->image5  = $image5;
        } 
        if($request->file('image6')) {
            $file             = $request->image6->getClientOriginalExtension();
            $extension        = $request->image6->extension();
            $request->file('image6')->move('resources/assets/uploads', $poza_name.'_6.'.$extension);
            $image6           = 'resources/assets/uploads/'.$poza_name.'_6.'.$extension;  
            $anunt_r->image6  = $image6;
        }
        if($request->file('image7')) {
            $file             = $request->image7->getClientOriginalExtension();
            $extension        = $request->image7->extension();
            $request->file('image7')->move('resources/assets/uploads', $poza_name.'_7.'.$extension);
            $image7           = 'resources/assets/uploads/'.$poza_name.'_7.'.$extension;
            $anunt_r->image7  = $image7;  
        } 
        if($request->file('image8')) {
            $file             = $request->image8->getClientOriginalExtension();
            $extension        = $request->image8->extension();
            $request->file('image8')->move('resources/assets/uploads', $poza_name.'_8.'.$extension);
            $image8           = 'resources/assets/uploads/'.$poza_name.'_8.'.$extension;  
            $anunt_r->image8  = $image8;
        } 
        if($request->file('image9')) {
            $file             = $request->image9->getClientOriginalExtension();
            $extension        = $request->image9->extension();
            $request->file('image9')->move('resources/assets/uploads', $poza_name.'_9.'.$extension);
            $image9           = 'resources/assets/uploads/'.$poza_name.'_9.'.$extension;  
            $anunt_r->image9  = $image9;
        } 
        if($request->file('video')) {
            $file             = $request->video->getClientOriginalExtension();
            $extension        = $request->video->extension();
            $request->file('video')->move('resources/assets/uploads/video/', $poza_name.'.'.$extension);
            $video            = 'resources/assets/uploads/video/'.$poza_name.'.'.$extension;  
            $anunt_r->video   = $video;
        } 
        $anunt_r->user_id               = '78';
        $anunt_r->judet                 = 'Dambovita';
        $anunt_r->localitate            = 'Pucioasa';
        $anunt_r->dataanunt             = date('Y-m-d H:i:s');
        $anunt_r->dataexpirare          = date('Y-m-d H:i:s', strtotime(' +1 month'));
        $anunt_r->save(); 
        
        Session::flash('message', $message_alert); 

        if(!$request->anunt_id) {
            return redirect()->route('adauga-anunt');
        } else {
            return redirect()->route('anunturi');
        }
    }

    public function stergeAnunt(Request $request) {
        $this->validate($request, [
            'anunt_id'             => 'required|max:255'
        ]); 

        $anunt_r = Anunturi::where('id','=',$request->anunt_id)->first();
        $anunt_r->status = 'sters';
        $anunt_r->save();

        Session::flash('message', 'Anuntul a fost sters cu succes!'); 
        return redirect()->route('anunturi');

    }

    public function stergeSetAnunt(Request $request) {
        $this->validate($request, [
            'anunt_spart_id'     => 'required|max:255'
        ]); 

        $anunt_set_r = Anunturi_sparte::where('id','=',$request->anunt_spart_id)->first();
        $anunt_set_r->status = 'inactiv';
        $anunt_set_r->save();

        $anunturi_c  = Anunturi::where('spart_id','=',$request->anunt_spart_id)->get();
        foreach ($anunturi_c as $anunturi_r) {
            $anunturi_r->status = 'sters';
            $anunturi_r->save();
        }

        Session::flash('message', 'Setul de Anunturi a fost sters cu succes!'); 
        return redirect()->route('seturi-anunturi');

    }
    
    public function reactiveazaAnunt(Request $request) {
        $this->validate($request, [
            'anunt_id'             => 'required|max:255'
        ]); 

        $anunt_r = Anunturi::where('id','=',$request->anunt_id)->first();
        $anunt_r->status = 'activ';
        $anunt_r->save();

        Session::flash('message', 'Anuntul a fost reactivat cu succes!'); 
        return redirect()->route('anunturi-sterse');

    }

    public function Anunturi() {
        $model_c        = Modele::all();
        $piesa_c        = Piese::all(); 
        $user_logat_r   = Auth::user();
        return view('backend.anunturi', compact('model_c', 'piesa_c','user_logat_r'));
    }

    public function AnunturiSterse() {
        $model_c        = Modele::all();
        $piesa_c        = Piese::all(); 
        $user_logat_r   = Auth::user();
        return view('backend.anunturi-sterse', compact('model_c', 'piesa_c','user_logat_r'));
    }

    public function generatorAnunturi() {
        $marci_c        = Marci::all();
        $user_logat_r   = Auth::user();
        return view('backend.generator-anunturi', compact('marci_c','user_logat_r'));
    }

    public function adaugaAllAnunturiPost(Request $request) {
        $this->validate($request, [
            'marca'             => 'required|max:100',
            'model'             => 'required',
            'an'                => 'required',
            'descriere'         => 'required'
        ]);

        $piesa_c = Piese::where('spart','=','da')->get();

        $cai_putere  = '';
        if($request->kilowati != '') {
            $cai_putere      = round($request->kilowati * 1.341);
        }
        $image1 = '';
        $image2 = '';
        $image3 = '';
        $image4 = '';
        $image5 = '';
        $video  = '';
        $image_thumb_350 = '';
        $poza_name                              = strtolower(str_replace(' ', '-', $request->marca)).'-'.strtolower(str_replace(' ', '-', $request->model)).'-din-dezmembrari';

        if($request->anunt_existent_id == 'new') {
            $anunt_spart_r  = new Anunturi_sparte;
            $message_alert  = 'Seturi de anunturi adaugate cu succes!';
        } else {
            $anunt_spart_r  = Anunturi_sparte::where('id','=',$request->anunt_existent_id)->first();
            $message_alert  = 'Seturi de anunturi modificate cu succes!';
        }

        $anunt_spart_r->user_id                 = '78';
        $anunt_spart_r->marca                   = $request->marca;
        $anunt_spart_r->model                   = $request->model;
        $anunt_spart_r->an                      = $request->an;
        $anunt_spart_r->descriere               = $request->descriere;
        $anunt_spart_r->serie_sasiu             = $request->serie_sasiu;
        $anunt_spart_r->capacitate_cilindrica   = $request->capacitate_cilindrica;
        $anunt_spart_r->carburant               = $request->carburant;
        $anunt_spart_r->kilowati                = $request->kilowati;
        $anunt_spart_r->cai_putere              = $cai_putere;
        $anunt_spart_r->cutie_viteze            = $request->cutie_viteze;
        if($request->file('image1')) {
            $file             = $request->image1->getClientOriginalExtension();
            $extension        = $request->image1->extension();
            $path_350         = public_path('../resources/assets/uploads/thumb_350/'.$poza_name.'_350.'.$extension);
            $path_normal      = public_path('../resources/assets/uploads/'.$poza_name.'.'.$extension);
            $img = Image::make($request->file('image1')->getRealPath())
                ->resize(null, 350, function ($constraint) {
                        $constraint->aspectRatio();
                    }
                )
                ->insert(public_path('watermark.png'), 'bottom-right', 10, 10)
                ->save($path_350);
            $image_thumb_350  = str_replace(public_path(), '', $path_350);
            $image_thumb_350  = str_replace('\../', '', $image_thumb_350);

            $img_n = Image::make($request->file('image1')->getRealPath())
                ->resize(null, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    }
                )
                ->insert(public_path('watermark.png'), 'bottom-right', 10, 10)
                ->save($path_normal);
            $image_normal  = str_replace(public_path(), '', $path_normal);
            $image_normal  = str_replace('\../', '', $image_normal);
            $anunt_spart_r->image1                = $image_normal;
            $anunt_spart_r->image_thumb_350       = $image_thumb_350;
            $image1                               = $image_normal;
            $image_thumb_350                      = $image_thumb_350;
        } 
        if($request->file('image2')) {
            $file             = $request->image2->getClientOriginalExtension();
            $extension        = $request->image2->extension();
            $request->file('image2')->move('resources/assets/uploads', $poza_name.'_2.'.$extension);
            $image2  = 'resources/assets/uploads/'.$poza_name.'_2.'.$extension;        
        } 
        if($request->file('image3')) {
            $file             = $request->image3->getClientOriginalExtension();
            $extension        = $request->image3->extension();
            $request->file('image3')->move('resources/assets/uploads', $poza_name.'_3.'.$extension);
            $image3           = 'resources/assets/uploads/'.$poza_name.'_3.'.$extension;  
        } 
        if($request->file('image4')) {
            $file             = $request->image4->getClientOriginalExtension();
            $extension        = $request->image4->extension();
            $request->file('image4')->move('resources/assets/uploads', $poza_name.'_4.'.$extension);
            $image4           = 'resources/assets/uploads/'.$poza_name.'_4.'.$extension; 
        }
        if($request->file('image5')) {
            $file             = $request->image5->getClientOriginalExtension();
            $extension        = $request->image5->extension();
            $request->file('image5')->move('resources/assets/uploads', $poza_name.'_5.'.$extension);
            $image5           = 'resources/assets/uploads/'.$poza_name.'_5.'.$extension;  
        } 
        if($request->file('video')) {
            $file             = $request->video->getClientOriginalExtension();
            $extension        = $request->video->extension();
            $request->file('video')->move('resources/assets/uploads/video/', $poza_name.'.'.$extension);
            $video            = 'resources/assets/uploads/video/'.$poza_name.'.'.$extension;  
            $anunt_spart_r->video   = $video;
        } 
    
        $anunt_spart_r->save();

        foreach ($piesa_c as $piesa_r) {
            if($request->anunt_existent_id == 'new') {
                $anunt_r  = new Anunturi;
            } else {
                $anunt_r         = Anunturi::where('spart_id','=',$request->anunt_existent_id)->where('piesa','=',$piesa_r->piesa)->first();
                $image1          = $anunt_spart_r->image1;
                $image_thumb_350 = $anunt_spart_r->image_thumb_350;
                if(!$request->file('image2')) { $image2 = $anunt_r->image2; }
                if(!$request->file('image3')) { $image3 = $anunt_r->image3; }
                if(!$request->file('image4')) { $image4 = $anunt_r->image4; }
                if(!$request->file('image5')) { $image5 = $anunt_r->image5; } 
                if(!$request->file('video')) { $video = $anunt_r->video; } 

            }
            
            $anunt_r->categorie             = 'dezmembrari auto';
            $anunt_r->titlu                 = 'dezmembrez '.$piesa_r->piesa.' pentru '.$request->marca.' '.$request->model;
            $anunt_r->categoriepiesa        = $piesa_r->categorie;
            $anunt_r->piesa                 = $piesa_r->piesa; 
            $anunt_r->marca                 = $request->marca;
            $anunt_r->model                 = $request->model;
            $anunt_r->an                    = $request->an;
            $anunt_r->descriere             = $request->descriere.', dezmembram '. $piesa_r->piesa;
            $anunt_r->pret                  = '1';
            $anunt_r->moneda                = 'ron';
            $anunt_r->capacitate_cilindrica = $request->capacitate_cilindrica;
            $anunt_r->carburant             = $request->carburant;
            $anunt_r->kilowati              = $request->kilowati;
            $anunt_r->cai_putere            = $cai_putere;
            $anunt_r->cutie_viteze          = $request->cutie_viteze;
            $anunt_r->serie_sasiu           = $request->serie_sasiu;
            $anunt_r->image1                = $image1;
            $anunt_r->image2                = $image2;
            $anunt_r->image3                = $image3;
            $anunt_r->image4                = $image4;
            $anunt_r->image5                = $image5;
            $anunt_r->image_thumb_350       = $image_thumb_350;
            $anunt_r->video                 = $video;
            $anunt_r->judet                 = 'Dambovita';
            $anunt_r->localitate            = 'Pucioasa';
            $anunt_r->spart                 = 'da';
            $anunt_r->user_id               = '78';
            $anunt_r->spart_id              = $anunt_spart_r->id;
            $anunt_r->provenienta           = 'autocycle';
            $anunt_r->dataanunt             = date('Y-m-d H:i:s');
            $anunt_r->dataexpirare          = date('Y-m-d H:i:s', strtotime(' +1 month'));
            $anunt_r->save(); 
        }

        Session::flash('message', $message_alert); 

        return redirect()->route('generator-anunturi');
        
    }

    public function generatorAnunturiNou() {
        $marci_c        = Marci::all();
        $user_logat_r   = Auth::user();
        $piese_gen      = Piese::where('spart','=','da')->get();
        return view('backend.generator-anunturi-nou', compact('marci_c','user_logat_r','piese_gen'));
    }

    public function adaugaAllAnunturiPostNou(Request $request) {
        $this->validate($request, [
            'marca'             => 'required|max:100',
            'model'             => 'required',
            'an'                => 'required',
            'descriere'         => 'required'
        ]);

        $piesa_c = Piese::where('spart','=','da')->get();

        $cai_putere  = '';
        if($request->kilowati != '') {
            $cai_putere      = round($request->kilowati * 1.341);
        }
        $image1 = '';
        $image2 = '';
        $image3 = '';
        $image4 = '';
        $image5 = '';
        $video  = '';
        $image_thumb_350 = '';
        $poza_name                              = 'dezmembrez-'.strtolower(str_replace(' ', '-', $request->marca)).'-'.strtolower(str_replace(' ', '-', $request->model));

        $anunt_spart_r  = new Anunturi_sparte;

        $anunt_spart_r->user_id                 = '78';
        $anunt_spart_r->marca                   = $request->marca;
        $anunt_spart_r->model                   = $request->model;
        $anunt_spart_r->an                      = $request->an;
        $anunt_spart_r->descriere               = $request->descriere;
        $anunt_spart_r->serie_sasiu             = $request->serie_sasiu;
        $anunt_spart_r->capacitate_cilindrica   = $request->capacitate_cilindrica;
        $anunt_spart_r->carburant               = $request->carburant;
        $anunt_spart_r->kilowati                = $request->kilowati;
        $anunt_spart_r->cai_putere              = $cai_putere;
        $anunt_spart_r->cutie_viteze            = $request->cutie_viteze;
        if($request->file('image1')) {
            $file             = $request->image1->getClientOriginalExtension();
            $extension        = $request->image1->extension();
            $path_350         = public_path('../resources/assets/uploads/thumb_350/'.$poza_name.'_350.'.$extension);
            $img = Image::make($request->file('image1')->getRealPath())
                ->resize(null, 350, function ($constraint) {
                        $constraint->aspectRatio();
                    }
                )
                ->save($path_350);
            $request->file('image1')->move('resources/assets/uploads', $poza_name.'.'.$extension);
            $image1           = 'resources/assets/uploads/'.$poza_name.'.'.$extension;
            $image_thumb_350  = str_replace(public_path(), '', $path_350);
            $image_thumb_350  = str_replace('\../', '', $image_thumb_350);
            $anunt_spart_r->image1                = $image1;
            $anunt_spart_r->image_thumb_350       = $image_thumb_350;
        } 
        if($request->file('image2')) {
            $file             = $request->image2->getClientOriginalExtension();
            $extension        = $request->image2->extension();
            $request->file('image2')->move('resources/assets/uploads', $poza_name.'_2.'.$extension);
            $image2  = 'resources/assets/uploads/'.$poza_name.'_2.'.$extension;        
        } 
        if($request->file('image3')) {
            $file             = $request->image3->getClientOriginalExtension();
            $extension        = $request->image3->extension();
            $request->file('image3')->move('resources/assets/uploads', $poza_name.'_3.'.$extension);
            $image3           = 'resources/assets/uploads/'.$poza_name.'_3.'.$extension;  
        } 
        if($request->file('image4')) {
            $file             = $request->image4->getClientOriginalExtension();
            $extension        = $request->image4->extension();
            $request->file('image4')->move('resources/assets/uploads', $poza_name.'_4.'.$extension);
            $image4           = 'resources/assets/uploads/'.$poza_name.'_4.'.$extension; 
        }
        if($request->file('image5')) {
            $file             = $request->image5->getClientOriginalExtension();
            $extension        = $request->image5->extension();
            $request->file('image5')->move('resources/assets/uploads', $poza_name.'_5.'.$extension);
            $image5           = 'resources/assets/uploads/'.$poza_name.'_5.'.$extension;  
        } 
        if($request->file('video')) {
            $file             = $request->video->getClientOriginalExtension();
            $extension        = $request->video->extension();
            $request->file('video')->move('resources/assets/uploads/video/', $poza_name.'.'.$extension);
            $video            = 'resources/assets/uploads/video/'.$poza_name.'.'.$extension;  
            $anunt_spart_r->video   = $video;
        } 
    
        $anunt_spart_r->save();

        foreach ($piesa_c as $piesa_r) {
        
            if($request->input('piesaId_'.$piesa_r->id)) {
                $titlu     = $request->input('titlu_'.$piesa_r->id);
                $desc      = $request->input('desc_'.$piesa_r->id);
                $pret      = $request->input('pret_'.$piesa_r->id);
                $moneda    = $request->input('moneda_'.$piesa_r->id);
                $anunt_r   = new Anunturi;
                $anunt_r->categorie             = 'dezmembrari auto';
                $anunt_r->titlu                 = $titlu;
                $anunt_r->categoriepiesa        = $piesa_r->categorie;
                $anunt_r->piesa                 = $piesa_r->piesa; 
                $anunt_r->marca                 = $request->marca;
                $anunt_r->model                 = $request->model;
                $anunt_r->an                    = $request->an;
                $anunt_r->descriere             = $desc;
                $anunt_r->pret                  = $pret;
                $anunt_r->moneda                = $moneda;
                $anunt_r->capacitate_cilindrica = $request->capacitate_cilindrica;
                $anunt_r->carburant             = $request->carburant;
                $anunt_r->kilowati              = $request->kilowati;
                $anunt_r->cai_putere            = $cai_putere;
                $anunt_r->cutie_viteze          = $request->cutie_viteze;
                $anunt_r->serie_sasiu           = $request->serie_sasiu;
                $anunt_r->image1                = $image1;
                $anunt_r->image2                = $image2;
                $anunt_r->image3                = $image3;
                $anunt_r->image4                = $image4;
                $anunt_r->image5                = $image5;
                $anunt_r->image_thumb_350       = $image_thumb_350;
                $anunt_r->video                 = $video;
                $anunt_r->judet                 = 'Dambovita';
                $anunt_r->localitate            = 'Pucioasa';
                $anunt_r->spart                 = 'da';
                $anunt_r->user_id               = '78';
                $anunt_r->spart_id              = $anunt_spart_r->id;
                $anunt_r->provenienta           = 'autocycle';
                $anunt_r->dataanunt             = date('Y-m-d H:i:s');
                $anunt_r->dataexpirare          = date('Y-m-d H:i:s', strtotime(' +1 month'));
                $anunt_r->save(); 
                
            } 
            
        }

        Session::flash('message', 'Set de anunturi adaugat cu succes!'); 
        return redirect()->route('generator-anunturi-nou');
        
    }


    public function modificaGeneratorPost(Request $request) {
        $this->validate($request, [
            'anunt_existent_id'     => 'required'
        ]);

        $anunturi_sparte_c = Anunturi::where('spart_id','=',$request->anunt_existent_id)->get();

        /*
        $idulos       = $anuntur_individuale_din_spart_r->id;
        $image_idulos = 'image_'.$idulos;
        
        if(isset($_POST['id_'.$idulos]) and strlen($_POST['id_'.$idulos]) >= 1) {
            $titlu     = $_POST['titlu_'.$idulos];
            $descriere = $_POST['descriere_'.$idulos];
            $pret      = $_POST['pret_'.$idulos];
            $moneda    = $_POST['moneda_'.$idulos];
            $anuntur_individuale_din_spart_r->titlu     = $titlu;
            $anuntur_individuale_din_spart_r->descriere = $descriere;
            $anuntur_individuale_din_spart_r->pret      = $pret;
            $anuntur_individuale_din_spart_r->moneda    = $moneda;
        } 
        */
        //$idulos       = $anuntur_individuale_din_spart_r->id;        

        foreach ($anunturi_sparte_c as $anunt_r) {   
            $titlu_id  = 'titlu_'.$anunt_r->id;
            $pret_id   = 'pret_'.$anunt_r->id;
            $moneda_id = 'moneda_'.$anunt_r->id;
            $desc_id   = 'desc_'.$anunt_r->id;
            $anunt_r->titlu             = $request->$titlu_id;
            $anunt_r->pret              = $request->$pret_id;
            $anunt_r->moneda            = $request->$moneda_id;
            $anunt_r->descriere         = $request->$desc_id;
            $anunt_r->save(); 
        }

        Session::flash('message', 'Seturi de anunturi adaugate cu succes!'); 

        return redirect()->route('set-anunturi', ['id' => $request->anunt_existent_id]);
        
    }

    public function SeturiAnunturi() {
        $model_c        = Modele::all();
        $piesa_c        = Piese::all(); 
        $user_logat_r   = Auth::user();
        return view('backend.seturi-anunturi', compact('model_c', 'piesa_c','user_logat_r'));
    }

    public function SetAnunturi($id) {
        $marci_c        = Marci::all();
        $piesa_c        = Piese::all(); 
        $set_anunturi_r = Anunturi_sparte::where('id','=',$id)->first();
        $anunturi_sp_p  = Anunturi::where('spart_id','=',$id)->first();
        $anunturi_sp_c  = Anunturi::where('spart_id','=',$id)->get();
        $user_logat_r   = Auth::user();
        return view('backend.set-anunturi', compact('set_anunturi_r','anunturi_sp_c','anunturi_sp_p','marci_c', 'piesa_c','user_logat_r'));
    }

    public function exportaSetAnunturi($id) {
       
        $headers = array(
            "Content-type"          => "text/csv",
            "Content-Disposition"   => "attachment; filename=file.csv",
            "Pragma"                => "no-cache",
            "Cache-Control"         => "must-revalidate, post-check=0, pre-check=0",
            "Expires"               => "0"
        );
        $anunturi = Anunturi::where('spart_id','=',$id)->get();

        $columns  = array(
                        'id',
                        'titlu', 
                        'marca', 
                        'model', 
                        'piesa',
                        'an',
                        'cod_piesa',
                        'serie_sasiu',
                        'carburant',
                        'capacitate_cilindrica',
                        'pret',
                        'moneda'
                    );
        $callback = function() use ($anunturi, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($anunturi as $anunt) {
                fputcsv($file, array($anunt->titlu, $anunt->marca, $anunt->model, $anunt->piesa, $anunt->an, $anunt->cod_piesa, $anunt->serie_sasiu, $anunt->carburant, $anunt->capacitate_cilindrica, $anunt->pret, $anunt->moneda));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }
    // export piese-auto.ro
    public function exportaSetAnunturiPieseAuto($id) {
        $anunt_spart_r = Anunturi_sparte::where('id','=',$id)->first();
        $titlu_file    = strtolower(str_replace(' ', '-', $anunt_spart_r->marca)).'-'.strtolower(str_replace(' ', '-', $anunt_spart_r->model)).'-piese-auto-ro';
        $headers = array(
            "Content-type"          => "text/csv",
            "Content-Disposition"   => "attachment; filename=".$titlu_file.".csv",
            "Pragma"                => "no-cache",
            "Cache-Control"         => "must-revalidate, post-check=0, pre-check=0",
            "Expires"               => "0"
        );
        $anunturi = Anunturi::where('spart_id','=',$id)->get();

        $columns  = array(
                        'id',
                        'titlu', 
                        'categoria',
                        'descriere',
                        'moneda',
                        'pret',
                        'cantitate',
                        'poze'
                    );
        $callback = function() use ($anunturi, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($anunturi as $anunt) {
                $imagine = 'https://autodezmembrat.ro/'.$anunt->image1;
                $moneda  = strtoupper($anunt->moneda);
                fputcsv($file,  array(
                                    $anunt->id, 
                                    $anunt->titlu, 
                                    $anunt->piesa, 
                                    $anunt->descriere, 
                                    $moneda, 
                                    $anunt->pret,
                                     '1', 
                                    $imagine
                                )
                );
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }
    // export dez.ro
    public function exportaSetAnunturiDez($id) {
       
        $anunt_spart_r = Anunturi_sparte::where('id','=',$id)->first();
        $titlu_file    = strtolower(str_replace(' ', '-', $anunt_spart_r->marca)).'-'.strtolower(str_replace(' ', '-', $anunt_spart_r->model)).'-dez';

        $headers = array(
            "Content-type"          => "text/csv",
            "Content-Disposition"   => "attachment; filename=".$titlu_file.".csv",
            "Pragma"                => "no-cache",
            "Cache-Control"         => "must-revalidate, post-check=0, pre-check=0",
            "Expires"               => "0"
        );

        $anunturi = Anunturi::where('spart_id','=',$id)->get();

        $columns  = array(
                        'piesa', 
                        'marca',
                        'model',
                        'an',
                        'titlu',
                        'descriere',
                        'poze',
                        'pret',
                        'bucati'
                    );
        $callback = function() use ($anunturi, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($anunturi as $anunt) {
                $imagine = 'https://autodezmembrat.ro/'.$anunt->image1;
                $moneda  = strtoupper($anunt->moneda);
                fputcsv($file,  array(
                                    $anunt->piesa, 
                                    $anunt->marca, 
                                    $anunt->model, 
                                    $anunt->an, 
                                    $anunt->titlu, 
                                    $anunt->descriere, 
                                    $imagine,
                                    $anunt->pret,
                                    '1'
                                )
                );
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }

    public function cereriActive() { 
        $model_c        = Modele::all(); 
        $user_logat_r   = Auth::user();
        return view('backend.cereri-active', compact('model_c', 'user_logat_r'));
    }

    public function cereriRezolvate() {
        $model_c        = Modele::all(); 
        $user_logat_r   = Auth::user();
        return view('backend.cereri-rezolvate', compact('model_c', 'user_logat_r'));
    }

    public function newsletterAdd() {
        $user_logat_r   = Auth::user();
        return view('backend.newsletter-add', compact('user_logat_r'));
    }

    public function newsletterPost(Request $request) {
        $this->validate($request, [
            'name'             => 'required|max:100',
            'email'            => 'required|string|email|max:255'
        ]);

        $email = $request->email;

        $user_r = Newsletter::where('email','=',$email)->first();

        if(!is_object($user_r)) {
            $user_r         = new Newsletter;
            $user_r->name   = $request->name;
            $user_r->email  = $request->email;
            $user_r->active = 'yes';
            $user_r->save();
            Session::flash('message', 'User salvat cu succes!'); 
        } else {
            Session::flash('message', 'Acest email este deja in baza noastra de date!'); 
        }

        return back();
    }

    public function newsletterPost2(Request $request) {
        $this->validate($request, [
            'id'             => 'required|max:100',
            'active'         => 'required'
        ]);

        $user_r = Newsletter::where('id','=',$request->id)->first();
        $user_r->active = $request->active;
        $user_r->save();
        Session::flash('message', 'Salvat cu succes!'); 
        return back();
    }


    public function newsletterView() {
        return view('backend.newsletter-view');
    }

    public function newsletterSend(Request $request) {

        $this->validate($request, [
            'text'             => 'required',
            'titlu'            => 'required'
        ]);
        
        $availableUsersForNewsletter_c      = Newsletter::where('active','=','yes')->get();
        $availableUsersForNewsletter_count  = Newsletter::where('active','=','yes')->count();

        foreach ($availableUsersForNewsletter_c as $thatUser_r) {
            Mail::to($thatUser_r->email)->send(new SendingNewsletters($request->text, $thatUser_r->name, $request->titlu));
        }
        
        Session::flash('message', 'Newsletter trimis cu succes la '.$availableUsersForNewsletter_count.' useri !'); 
        return redirect()->route('newsletter-view');
    
    }

    public function newsletterTest() {
        return view('emails.newsletter-template');
    }

    public function testing() {
        
        $anunturi_c = Anunturi::where('spart_id','=','1027')->get();
        foreach ($anunturi_c as $anunturi_r) {
            $anunturi_r->titlu = $anunturi_r->marca.' '.$anunturi_r->model.' din anul '.$anunturi_r->an.' din dezmembrari';
            $anunturi_r->descriere = 'Dezmembram '.$anunturi_r->marca.' '.$anunturi_r->model.' din anul '.$anunturi_r->an;
            $anunturi_r->save();  
        }
    }

    public function activeazaRezolvata(Request $request) {
        $this->validate($request, [
            'id'             => 'required'
        ]);

        $cerere_r = Cereri::where('id','=',$request->id)->first();
        $cerere_r->status = 'inactiv';
        $cerere_r->save();

        return redirect()->route('cereri-active');
    }

    public function clientCererePiesa() {
        $marci_c         = Marci::all();
        $categ_c         = Categorii::all();
        $user_logat_r    = Auth::user();
        return view('backend.client-cerere-piesa', compact('marci_c','categ_c','user_logat_r'));
    }
    

}

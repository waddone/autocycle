<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modele;
use App\Piese;
use App\Anunturi;
use App\Anunturi_sparte;
use App\Cereri;
use App\Newsletter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DatatableController extends Controller
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

    public function datatableAnunturi() {

        //$countulos          = Anunturi::where('status','=','activ')->count();
        
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $model_search       = $_GET['columns']['1']['search']['value'];
        $piesa_search       = $_GET['columns']['2']['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (titlu LIKE '%{$exploded_data[$i]}%')";
            }
        }

        if($model_search != null) {
            $exploded_data = explode(' ', $model_search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (model LIKE '%{$exploded_data[$i]}%')";
            }
        }

        if($piesa_search != null) {
            $exploded_data = explode(' ', $piesa_search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (piesa LIKE '%{$exploded_data[$i]}%')";
            }
        }
         
        $anunturi_c = DB::select( DB::raw("SELECT * FROM anunturi WHERE status = 'activ' $sql_search ORDER BY id DESC LIMIT $start,$limit") );
        
        /*
        $anunturi_c    = DB::table('anunturi')
                            ->where('status','=','activ')
                            ->orWhere('titlu', 'like','%'.$search.'%')
                            ->orWhere('model', 'like','%'.$model_search.'%')
                            ->orWhere('piesa', 'like','%'.$piesa_search.'%')
                            ->orderBy('id', 'desc')
                            ->skip($start)
                            ->take($limit)
                            ->get();
        */
        $countulos = DB::table('anunturi')
                            ->where('status','=','activ')
                            ->orderBy('id', 'desc')
                            ->count();

        //
        if($countulos != 0) {
            foreach ($anunturi_c as $anunturi_r) {
                if(strpos($anunturi_r->image1, 'resources/assets/uploads/') !== false) {
                    $image_url = url('/').'/'.$anunturi_r->image1;
                } else {
                    $image_url = 'https://dezmembrarisipieseauto.ro/'.$anunturi_r->image1;

                }
                $image     = '<a class="openSaysMe" data-modal="Anunturi" data-dowhat="img" data-id="'.$anunturi_r->id.'"><img src='.$image_url.' style=height:30px;></a>';
                if($anunturi_r->titlu != '') {
                    $titlu = $anunturi_r->titlu;
                } else {
                    $titlu = '<span style="color:red">Nu are titlu</span>';
                }

                $data[] = array(
                    'image'          => $image,
                    'marca'          => $titlu.'<div class="DTrow"><span class="DTmodel">'.$anunturi_r->marca.'</span> <span class="DTmodel">'.$anunturi_r->model.'</span></div>',
                    'piesa'          => $anunturi_r->piesa,
                    'actiuni'        => '<button class="btn btn-primaryDt openSaysMe" data-modal="Anunturi" data-dowhat="edit" data-id="'.$anunturi_r->id.'">Modifica</button><button class="btn btn-primaryDt openSaysMe" data-modal="Anunturi" data-dowhat="delete" data-id="'.$anunturi_r->id.'">Sterge</button>'
                );
            }
        } else {
            $data = '';
        }
       
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 
    }

    public function datatableAnunturiSterse() {

        //$countulos          = Anunturi::where('status','=','sters')->count();
        
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $model_search       = $_GET['columns']['1']['search']['value'];
        $piesa_search       = $_GET['columns']['2']['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (titlu LIKE '%{$exploded_data[$i]}%')";
            }
        }

        if($model_search != null) {
            $exploded_data = explode(' ', $model_search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (model LIKE '%{$exploded_data[$i]}%')";
            }
        }

        if($piesa_search != null) {
            $exploded_data = explode(' ', $piesa_search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (piesa LIKE '%{$exploded_data[$i]}%')";
            }
        }
        
        // 
        $anunturi_c = DB::select( DB::raw("SELECT * FROM anunturi WHERE status = 'sters' $sql_search ORDER BY id DESC LIMIT $start,$limit") );
        $countulos  = sizeof($anunturi_c);
        // varianta simplificata
        //
        //$anunturi_c    = DB::table('anunturi')
        //                    ->where('status','=','activ')
        //                    ->orderBy('id', 'desc')
        //                    ->skip($start)
        //                    ->take($limit)
        //                    ->get();
        if($countulos != 0) {
            foreach ($anunturi_c as $anunturi_r) {
                if(strpos($anunturi_r->image1, 'resources/assets/uploads/') !== false) {
                    $image_url = url('/').'/'.$anunturi_r->image1;
                } else {
                    $image_url = 'https://dezmembrarisipieseauto.ro/'.$anunturi_r->image1;

                }
                $image     = '<a class="openSaysMe" data-modal="Anunturi" data-dowhat="img" data-id="'.$anunturi_r->id.'"><img src='.$image_url.' style=height:30px;></a>';

                $data[] = array(
                    'image'          => $image,
                    'marca'          => '<div class="DTrow"><span class="DTmodel">'.$anunturi_r->marca.'</span> <span class="DTmodel">'.$anunturi_r->model.'</span></div>',
                    'piesa'          => $anunturi_r->piesa,
                    'actiuni'        => '<button class="btn btn-primaryDt openSaysMe" data-modal="Anunturi" data-dowhat="edit" data-id="'.$anunturi_r->id.'">Modifica</button><button class="btn btn-primaryDt openSaysMe" data-modal="Anunturi" data-dowhat="reactiveaza" data-id="'.$anunturi_r->id.'">Reactiveaza</button>'
                );

            }
        } else {
            $data = '';
        }
       
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;


        return $detalii; 

    }

    public function datatableSeturiAnunturi() {

        //$countulos          = Anunturi_sparte::count();
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $model_search       = $_GET['columns']['1']['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (titlu LIKE '%{$exploded_data[$i]}%')";
            }
        }

        if($model_search != null) {
            $exploded_data = explode(' ', $model_search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (model LIKE '%{$exploded_data[$i]}%')";
            }
        }

        $anunturi_sparte_c = DB::select( DB::raw("SELECT * FROM anunturi_sparte WHERE status = 'activ' $sql_search ORDER BY id DESC LIMIT $start,$limit") );
        $countulos  = sizeof($anunturi_sparte_c);
        // varianta simplificata
        //
        //$anunturi_c    = DB::table('anunturi')
        //                    ->where('status','=','activ')
        //                    ->where('name', 'like', $search.'%')
        //                    ->orderBy('id', 'desc')
        //                    ->skip($start)
        //                    ->take($limit)
        //                    ->get();
        if($countulos != 0) {
            foreach ($anunturi_sparte_c as $anunturi_r) {
                if(strpos($anunturi_r->image1, 'resources/assets/uploads/') !== false) {
                    $image_url = url('/').'/'.$anunturi_r->image1;
                } else {
                    $image_url = 'https://dezmembrarisipieseauto.ro/'.$anunturi_r->image1;

                }
                $image     = '<a class="openSaysMe" data-modal="Anunturi_sparte" data-dowhat="img" data-id="'.$anunturi_r->id.'"><img src='.$image_url.' style=height:30px;></a>';

                $data[] = array(
                    'image'          => $image,
                    'marca'          => '<div class="DTrow"><span class="DTmodel">'.$anunturi_r->marca.'</span> <span class="DTmodel">'.$anunturi_r->model.'</span></div>',
                    'actiuni'        => '<a href="'.route('set-anunturi', ['id' => $anunturi_r->id ]).'" class="btn btn-primaryDt">Vezi lista piese</a><button class="btn btn-primaryDt openSaysMe" data-modal="Anunturi_sparte" data-dowhat="delete" data-id="'.$anunturi_r->id.'">Sterge</button><a href="'.route('exporta-set-anunturi-piese-auto', ['id' => $anunturi_r->id ]).'" class="btn btn-primaryDt">Exporta piese auto</a><a href="'.route('exporta-set-anunturi-dez', ['id' => $anunturi_r->id ]).'" class="btn btn-primaryDt">Exporta dez</a>'
                );
            }
        } else {
            $data = '';
        }
       
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;


        return $detalii; 

    }

    public function datatableSetAnunturi($id) {

        //$countulos          = Anunturi::where('status','=','activ')->where('spart_id','=',$id)->count();
        
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (titlu LIKE '%{$exploded_data[$i]}%')";
            }
        }        
         
        $anunturi_c = DB::select( DB::raw("SELECT * FROM anunturi WHERE status = 'activ' AND spart_id = '{$id}' $sql_search ORDER BY id DESC LIMIT $start,$limit") );
        $countulos  = sizeof($anunturi_c);

        if($countulos != 0) {
            foreach ($anunturi_c as $anunturi_r) {
                if(strpos($anunturi_r->image1, 'resources/assets/uploads/') !== false) {
                    $image_url = url('/').'/'.$anunturi_r->image1;
                } else {
                    $image_url = 'https://dezmembrarisipieseauto.ro/'.$anunturi_r->image1;

                }
                $image     = '<a class="openSaysMe" data-modal="Anunturi" data-dowhat="img" data-id="'.$anunturi_r->id.'"><img src='.$image_url.' style=height:30px;></a>';
                $selected_ron   = '';
                $selected_euro  = '';
                if($anunturi_r->moneda == 'ron') {
                    $selected_ron   = 'selected';
                    $selected_euro  = '';
                } else {
                    $selected_ron   = '';
                    $selected_euro  = 'selected';
                }

                $data[] = array(
                    'image'          => $image,
                    'titlu'          => '<div class="DTrow"><input class="form-control" type="text" name="titlu_'.$anunturi_r->id.'" value="'.$anunturi_r->titlu.'"></div><div class="DTrow"><textarea class="form-control" name="desc_'.$anunturi_r->id.'">'.$anunturi_r->descriere.'</textarea></div>',
                    'pret'           => '<div class="DTrow"><input class="form-control" type="text" name="pret_'.$anunturi_r->id.'" value="'.$anunturi_r->pret.'"></div>',
                    'moneda'         => '<div class="DTrow"><select name="moneda_'.$anunturi_r->id.'" class="form-control"><option value="ron" '.$selected_ron.'>ron</option><option value="euro" '.$selected_euro.'>euro</option></div>',
                );
            }
        } else {
            $data = '';
        }
       
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 
    }


    public function datatableCereriActive() {

        //$countulos          = Cereri::where('status','=','activ')->count();    
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $model_search       = $_GET['columns']['1']['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (titlu LIKE '%{$exploded_data[$i]}%')";
            }
        }

        if($model_search != null) {
            $exploded_data = explode(' ', $model_search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (model LIKE '%{$exploded_data[$i]}%')";
            }
        }
        
        $cereri_c = DB::select( DB::raw("SELECT * FROM cereri WHERE status = 'activ' $sql_search ORDER BY id DESC LIMIT $start,$limit") );
        $countulos  = sizeof($cereri_c);
        if($countulos != 0) {
            foreach ($cereri_c as $cereri_r) {
                if($cereri_r->image1 != '') {
                    $image     = '<a class="openSaysMe" data-modal="Cereri" data-dowhat="img" data-id="'.$cereri_r->id.'"><img src='.url('/').'/'.$cereri_r->image1.' style=height:30px;></a>';
                } else {
                    $image     = '<img src="'.url('/').'/resources/assets/cereri/noimage.jpg" style=height:30px;>';
                }
               
                $data[] = array(
                    'image'          => $image,
                    'marca'          => '<div class="DTrow"><span class="DTmodel">'.$cereri_r->marca.'</span> <span class="DTmodel">'.$cereri_r->model.'</span></div>',
                    'piesa'          => $cereri_r->descriere,
                    'actiuni'        => '<button class="btn btn-primaryDt openSaysMe" data-modal="Cereri" data-dowhat="detalii" data-id="'.$cereri_r->id.'">Detalii cerere</button><button class="btn btn-primaryDt openSaysMe" data-modal="Cereri" data-dowhat="rezolvata" data-id="'.$cereri_r->id.'">Rezolvata ?</button>'
                );
            }
        } else {
            $data = '';
        }
       
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 
    }

    public function datatableCereriRezolvate() {

        //$countulos          = Cereri::where('status','=','inactiv')->count();
        
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $model_search       = $_GET['columns']['1']['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (titlu LIKE '%{$exploded_data[$i]}%')";
            }
        }

        if($model_search != null) {
            $exploded_data = explode(' ', $model_search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (model LIKE '%{$exploded_data[$i]}%')";
            }
        }
        
        $cereri_c = DB::select( DB::raw("SELECT * FROM cereri WHERE status = 'inactiv' $sql_search ORDER BY id DESC LIMIT $start,$limit") );
        $countulos  = sizeof($cereri_c);

        if($countulos != 0) {
            foreach ($cereri_c as $cereri_r) {
                if($cereri_r->image1 != '') {
                    $image     = '<a class="openSaysMe" data-modal="Anunturi" data-dowhat="img" data-id="'.$cereri_r->id.'"><img src='.$cereri_r->image1.' style=height:30px;></a>';
                } else {
                    $image     = '';
                }
               
                $data[] = array(
                    'image'          => $image,
                    'marca'          => '<div class="DTrow"><span class="DTmodel">'.$cereri_r->marca.'</span> <span class="DTmodel">'.$cereri_r->model.'</span></div>',
                    'piesa'          => $cereri_r->descriere,
                    'actiuni'        => '<button class="btn btn-primaryDt openSaysMe" data-modal="Cereri" data-dowhat="rezolvata" data-id="'.$cereri_r->id.'">Rezolvata ?</button>'
                );
            }
        } else {
            $data = '';
        }
       
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 
    }

    public function datatableNewsletter() {

        //$countulos          = Newsletter::all()->count();
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (titlu LIKE '%{$exploded_data[$i]}%')";
            }
        }
        
         
        $user_c = DB::select( DB::raw("SELECT * FROM newsletter WHERE active != 'mata' $sql_search ORDER BY id DESC LIMIT $start,$limit") );
        $countulos  = sizeof($user_c);
        // varianta simplificata
        //
        //$anunturi_c    = DB::table('anunturi')
        //                    ->where('status','=','activ')
        //                    ->orderBy('id', 'desc')
        //                    ->skip($start)
        //                    ->take($limit)
        //                    ->get();
        if($countulos != 0) {
            foreach ($user_c as $user_r) {

                if($user_r->active == 'yes') {
                    $button = '<button class="btn btn-primaryDt openSaysMe" data-modal="Newsletter" data-dowhat="deactivate" data-id="'.$user_r->id.'">Dezactiveaza</button>';
                } else {
                    $button = '<button class="btn btn-primaryDt openSaysMe" data-modal="Newsletter" data-dowhat="activate" data-id="'.$user_r->id.'">Activeaza</button>';
                }
               
                $data[] = array(
                    'nume'           => $user_r->name,
                    'email'          => $user_r->email,
                    'actiuni'        => $button
                );
            }
        } else {
            $data = '';
        }
       
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 
    }


}

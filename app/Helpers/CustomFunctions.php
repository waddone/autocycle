<?php 

//namespace App\Helpers;

//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

	
    function breadcrumbs() {

        $breadcrubs_link                    = "$_SERVER[REQUEST_URI]";
        $breadcrubs_link                    = str_replace('https://', '' , $breadcrubs_link);
        $breadcrubs_link                    = str_replace('http://', '' , $breadcrubs_link);
        $breadcrubs_link                    = rtrim($breadcrubs_link, '/');
        $breadcrubs_link                    = str_replace('www.', '' , $breadcrubs_link);
        $breadcrubs_bucati                  = explode('/', $breadcrubs_link);
        $nr_bucati                          = count($breadcrubs_bucati);
        //$nr_bucati                          = $nr_bucati - 1;
        $bread_ul_li                        = '<ol itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb"><a itemprop="item" href="'.url('/').'" title="dezmembrari si piese auto"><i class="fa fa-home"></i></a>';
        $href                               = '';
        $class_activ            = ' class="active"';
        for ($i=0;$i<=$nr_bucati;$i++) {
            $i;
            $y = $i + 1;
            $breadcrubs_title               = '';

            if(isset($breadcrubs_bucati[$i])) {            
                if($i == $nr_bucati) {
                    $href   .= $breadcrubs_bucati[$i];
                    $href    = rtrim($href, '/');
                    $breadcrubs_title       .= str_replace('-', ' ', $breadcrubs_bucati[$i]);
                } else {
                    $href                   .= $breadcrubs_bucati[$i].'/';
                    $breadcrubs_title       .= str_replace('-', ' ', $breadcrubs_bucati[$i]);
                }
                $bread_ul_li                .= '<li'.$class_activ.' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"> <a itemprop="item" href="'.$href.'" title="'.$breadcrubs_title.'"><span itemprop="name">'.$breadcrubs_bucati[$i].'</a></span><meta itemprop="position" content="'.$y.'" /> </li>';
            }
        }
        $bread_ul_li                        .= '</ol>';
        return $bread_ul_li;
        
    }

    /**
     * trims text to a space then adds ellipses if desired
     * @param string $input text to trim
     * @param int $length in characters to trim to
     * @param bool $ellipses if ellipses (...) are to be added
     * @param bool $strip_html if html tags are to be stripped
     * @return string
     */
    function trim_text($input, $length, $ellipses = true, $strip_html = true) {
        //strip tags, if desired
        if ($strip_html) {
            $input = strip_tags($input);
        }
      
        //no need to trim, already shorter than trim length
        if (strlen($input) <= $length) {
            return $input;
        }
      
        //find last space within length
        $last_space = strrpos(substr($input, 0, $length), ' ');
        $trimmed_text = substr($input, 0, $last_space);
      
        //add ellipses (...)
        if ($ellipses) {
            $trimmed_text .= '...';
        }
      
        return $trimmed_text;
    }


    function getSchoolIdFromCurrentLogedUser() {

        $user_logat_r       = Auth::user();
        if($user_logat_r->hasSchool() == true) {
            return $school_id  = $user_logat_r->returnSchoolId();
        } else {
            return false;
        }
        
    }

?>
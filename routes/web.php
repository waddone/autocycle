<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// PROBABLY WE WILL USE THIS ALSO
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use \App\Http\Controllers\Frontend\HomeController;

Route::get ('/under-construction', 				HomeController::class.'@underConstruction')->name('under-construction');
Route::get ('/', 								'Frontend\HomeController@index')->name('home');
Route::get ('/despre-noi', 						'Frontend\HomeController@despreNoi')->name('despre-noi');
Route::get ('/contact', 						'Frontend\HomeController@contact')->name('contact');
Route::get ('/termeni-si-conditii', 			'Frontend\HomeController@termeniSiConditii')->name('termeni-si-conditii');
Route::get ('/cerere-piesa/{a1?}/{a2?}/{a3?}', 	'Frontend\HomeController@cererePiesa')->name('cerere-piesa');
Route::post('/trimite-cerere-post', 			'Frontend\HomeController@trimiteCererePost')->name('trimite-cerere-post');


//Route::get('/dezmembrari-auto/{paginatie}', 	'Frontend\DezmembrariController@index')->name('dezmembrari-auto');
Route::get('/dezmembrari-auto', 				'Frontend\DezmembrariController@listareAnunturi')->name('listare-anunturi');
Route::get('/dezmembrari-auto/{anunt}', 		'Frontend\DezmembrariController@afisareAnunt')->name('afisare-anunt');
Route::get('/filtru/{cautare?}', 				'Frontend\DezmembrariController@filtrareAnunturi')->name('filtrare-anunturi');


///////////// routes for account

Route::get ('/contul-meu', 							'Backend\AccountController@contulMeu')->name('contul-meu')->middleware('auth');
Route::get ('/contul-meu/adauga-anunt', 			'Backend\AccountController@adaugaAnunt')->name('adauga-anunt')->middleware('auth');
Route::post('/contul-meu/adauga-anunt-post', 		'Backend\AccountController@adaugaAnuntPost')->name('adauga-anunt-post')->middleware('auth');
Route::post('/contul-meu/sterge-anunt', 			'Backend\AccountController@stergeAnunt')->name('sterge-anunt')->middleware('auth');
Route::post('/contul-meu/reactiveaza-anunt', 		'Backend\AccountController@reactiveazaAnunt')->name('reactiveaza-anunt')->middleware('auth');
Route::get ('/contul-meu/generator-anunturi', 		'Backend\AccountController@generatorAnunturi')->name('generator-anunturi')->middleware('auth');
Route::post('/contul-meu/adauga-generator-post',	'Backend\AccountController@adaugaAllAnunturiPost')->name('adauga-generator')->middleware('auth');
Route::get ('/contul-meu/generator-anunturi-nou', 	'Backend\AccountController@generatorAnunturiNou')->name('generator-anunturi-nou')->middleware('auth');
Route::post('/contul-meu/sterge-set-anunt', 		'Backend\AccountController@stergeSetAnunt')->name('sterge-set-anunt')->middleware('auth');
Route::post('/contul-meu/adauga-generator-post-nou','Backend\AccountController@adaugaAllAnunturiPostNou')->name('adauga-generator-nou')->middleware('auth');
Route::post('/contul-meu/modifica-generator',  		'Backend\AccountController@modificaGeneratorPost')->name('modifica-generator')->middleware('auth');
Route::get ('/contul-meu/anunturi', 				'Backend\AccountController@Anunturi')->name('anunturi')->middleware('auth');
Route::get ('/contul-meu/anunturi-sterse', 			'Backend\AccountController@AnunturiSterse')->name('anunturi-sterse')->middleware('auth');
Route::get ('/contul-meu/seturi-anunturi', 			'Backend\AccountController@SeturiAnunturi')->name('seturi-anunturi')->middleware('auth');
Route::get ('/contul-meu/set/{id}', 				'Backend\AccountController@SetAnunturi')->name('set-anunturi')->middleware('auth');
Route::get ('/contul-meu/exporta-dez/{id}', 		'Backend\AccountController@exportaSetAnunturiDez')->name('exporta-set-anunturi-dez')->middleware('auth');
Route::get ('/contul-meu/exporta-piese-auto/{id}', 	'Backend\AccountController@exportaSetAnunturiPieseAuto')->name('exporta-set-anunturi-piese-auto')->middleware('auth');
Route::get ('/contul-meu/newsletter', 				'Backend\AccountController@newsletter')->name('newsletter')->middleware('auth');
Route::get ('/contul-meu/cereri-active', 			'Backend\AccountController@cereriActive')->name('cereri-active')->middleware('auth');
Route::get ('/contul-meu/cereri-rezolvate', 		'Backend\AccountController@cereriRezolvate')->name('cereri-rezolvate')->middleware('auth');
Route::post('/contul-meu/activeaza-rezolvata',		'Backend\AccountController@activeazaRezolvata')->name('activeaza-rezolvata')->middleware('auth');



Route::get ('/contul-meu/newsletter-add', 			'Backend\AccountController@newsletterAdd')->name('newsletter-add')->middleware('auth');;
Route::post('/contul-meu/newsletter-post', 			'Backend\AccountController@newsletterPost')->name('newsletter-post');
Route::post('/contul-meu/newsletter-post-2', 		'Backend\AccountController@newsletterPost2')->name('newsletter-post-2');
Route::get ('/contul-meu/newsletter-view', 			'Backend\AccountController@newsletterView')->name('newsletter-view');
Route::post('/contul-meu/newsletter-send', 			'Backend\AccountController@newsletterSend')->name('newsletter-send');
Route::get ('/contul-meu/newsletter-test', 			'Backend\AccountController@newsletterTest')->name('newsletter-test');
Route::get ('/contul-meu/testing', 					'Backend\AccountController@testing')->name('testing');



Route::get ('/contul-meu/reset-password', 				'Backend\AccountController@showResetForm')->name('reset-password');
Route::get ('/contul-meu/reset-password-2',  			'Backend\AccountController@showResetFormAccount')->name('reset-password-account');

Route::get ('/contul-meu/client-cerere-piesa', 		'Backend\AccountController@clientCererePiesa')->name('client-cerere-piesa');




// pagini vizibile daca esti logat
Auth::routes();


// ajaxuri 
Route::get('/ajax/get-model/{marca}', 			'Backend\AjaxController@getModel')->name('get-model');
Route::get('/ajax/get-piesa/{categorie}', 		'Backend\AjaxController@getPiesa')->name('get-piesa');


///////////// datatables /////////////////////////////////
Route::get('/datatables/anunturi',				'Backend\DatatableController@datatableAnunturi')->name('datatable-anunturi');
Route::get('/datatables/anunturi-sterse',		'Backend\DatatableController@datatableAnunturiSterse')->name('datatable-anunturi-sterse');
Route::get('/datatables/seturi-anunturi',	 	'Backend\DatatableController@datatableSeturiAnunturi')->name('datatable-seturi-anunturi');
Route::get('/datatables/set-anunturi/{id}',	 	'Backend\DatatableController@datatableSetAnunturi')->name('datatable-set-anunturi');
Route::get('/datatables/cereri-active',	 		'Backend\DatatableController@datatableCereriActive')->name('datatable-cereri-active');
Route::get('/datatables/cereri-rezolvate',	 	'Backend\DatatableController@datatableCereriRezolvate')->name('datatable-cereri-rezolvate');
Route::get('/datatables/newsletter',	 		'Backend\DatatableController@datatableNewsletter')->name('datatable-newsletter');
//////////// end datatables //////////////////////////////


///////////// modale /////////////////////////////////
Route::get('/modale/{modal}/{dowhat}/{id}',		'Backend\ModaleController@generalModale')->name('general-modale');
//////////// end modale //////////////////////////////



///////////// modale /////////////////////////////////
Route::get('/cronuri/get-availables-marci',		'Backend\CronController@getAvailablesMarci')->name('get-availables-marci');
//////////// end modale //////////////////////////////
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\DenemeController;
use App\Http\Controllers\OptikFormController;
use App\Http\Controllers\SonucController;
use App\Http\Controllers\KurumController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/login', [UserAuthController::class, 'login']);


/* ####### USER AUTH ####### */
Route::group(['middleware' => ['auth:sanctum']], function() {
  Route::post('/logout', [UserAuthController::class, 'logout']);
  Route::get('/periods', [PeriodController::class, 'all']);
  Route::get('/getActivePeriod', [PeriodController::class, 'getActivePeriod']);
  Route::get('/denemeler', [DenemeController::class, 'denemeler']);
  Route::get('/denemeler/{period}', [DenemeController::class, 'getActivePeriodDenemeler']);
  Route::get('/denemelerim/{id}', [DenemeController::class, 'myOwnDenemeler']);
  Route::get('/deneme/{id}', [DenemeController::class, 'show']);
  Route::post('/create/deneme', [DenemeController::class, 'store']);
  Route::post('/dublicate/deneme', [DenemeController::class, 'duplicateDeneme']);
  Route::post('/update/deneme', [DenemeController::class, 'update']);
  Route::post('/delete/deneme', [DenemeController::class, 'delete']);
  Route::get('/optik-forms/{id}', [OptikFormController::class, 'myOwnOptikForms']);
  Route::get('/optik-form/{id}', [OptikFormController::class, 'show']);
  Route::post('/create/optik-form', [OptikFormController::class, 'store']);
  Route::post('/update/optik-form', [OptikFormController::class, 'update']);
  Route::post('/delete/optik-form', [OptikFormController::class, 'delete']);
  Route::post('/create/answer-key', [DenemeController::class, 'storeAnswerKey']);
  Route::get('/answer-key/{deneme_id}', [DenemeController::class, 'getAnswerKey']);
  Route::post('/save/deneme-result', [SonucController::class, 'store']);
  Route::get('/download/sonuc/{deneme_id}/{user_id}', [SonucController::class, 'generatePDF']);
  Route::get('/download/answerkey/{deneme_id}/{user_id}', [SonucController::class, 'answerkey']);
  Route::get('/download/answer_key_layout', [OptikFormController::class, 'downloadAnswerKeyLayout']);
});

/* ####### ADMIN ####### */
/* no login no middleware */
Route::prefix('admin')->group(function () {
  Route::post('/login', [AdminController::class, 'login']);
});
/* AUTH and Admin middleware - login sanctum ile yap??yor ayr??ca admin middlewar'inden kontrol ediyor */
Route::prefix('admin')->as('admin.')->middleware(['auth:sanctum','admin'])->group(function() {
  Route::post('/logout', [AdminController::class, 'logout']);
  Route::post('/create/period', [PeriodController::class, 'store']);
  Route::post('/update/period', [PeriodController::class, 'update']);
  Route::post('/delete/period', [PeriodController::class, 'delete']);
  Route::get('/kurumlar', [KurumController::class, 'kurumlar']);
  Route::post('/delete/kurum', [KurumController::class, 'delete']);
  Route::post('/change-kurum-status', [KurumController::class, 'change_status']);
  Route::get('/denemeler', [AdminController::class, 'denemeler']);
  Route::get('/denemeler/{period}', [AdminController::class, 'getActivePeriodDenemeler']);
});

/*

1- logout i??lemi revize edilmeli - bir ki??i login olup ??erezleri temizlerse db de token kal??yor? daha sonra tekrar giri?? yapsa s??k??nt?? oluyor mu?
2- iki farkl?? yerden ayn?? hesap girildi??inde ve biri ????kt??????nda s??k??nt?? var m??? token username ??zerinden olu??uyor.

* ??nemli Olan -> OptikormLayout olu??turukenki dinamik alanlardaki field ad??yla cevap anahtar??ndanki ders k??sm??n??n ismi e??le??meli!!!
* verileri buna g??re al??yor

D??ZELT??LECEK
 - SELECTLER??N ARROWU Z-??NDEX FAZLA OLUP HEADER'IN ??ST??NE ??IKIYOR
 - Analiz sayfas??nda fmt se??ilince table'da listelenirken iki tane bo?? olan karakteri html yanyana g??stermiyor (ayr??l??p her biri bir spanda g??sterilecek)
 - sonu?? y??kleme sayfas??nda sonu?? y??kleme file '?? temizlenecek - data ??st??ne push ediliyor'
 - fmt dosyas??nda en son ders'in son sorular?? bo?? b??rak??lm????sa bo??luk karakteri atm??yor san??r??m - bunun i??in soru say??s?? kadar karakter yoksa sona bo??luklar?? otomatik at arraya
 - cevap anahtar?? olmayan denemelerin analiz sayfas??na gitmemeli uyar?? vermeli
*/

/*

  Dashboard B??t??n Denemeler List - Ba??ka birinin olu??turdu??u denemeye Uygula denirse Analiz sayfas??na gider
  Burada uygun optik ile FMT okumas?? yap??l??p De??erlendir t??klan??rsa yeni deneme dublicate edilir ve sonuc o deneme i??in kaydedilir
  Art??k o deneme kullan??c??n??n instance etti??i denemedir

*/

/*
  template/js/custom.min.js line 90 d??zenlendi - handleCustomFileInput()
  input file se??im yap??ld??ktan sonra istenilen dosyan??n ismini yazma-silme a??amas??nda p??r??z olu??turdu??u i??in gerekli i??lem DenemeAnaliz.vue line 312 de yap??ld??
*/

/*

denemeler tablosunda kimden instance edildi??i bilgisi tutuluyor dublicate edilmi??se is_primary = 0
is_primary = 1 demek yeni olu??turulmu?? deneme
is_primary = 0 demek external_deneme yani olu??turulan bir deneme uygula butonuyla girilip sonu?? dosyas?? y??klenip okunmu?? ve dublicate edilmi??

*/

/*
  ** Dashboard'da peroid select-option sayfa y??klenirken selected olamayabiliyor...

  ** Dashboard.vue - period select-option de??i??tirildi??inde changePeriod() metodu ??al????arak this.period_manuel_selection = true yap??yor ve getDenemeler() 'i bu ??ekilde ??a??r??yor
  ** DenemeController 'a period payloadl?? bir request gidiyor DenemeController buna g??re getActivePeriodDenemeler() metodunu d??n??yor
  ** paginationda buna g??re ??ekilleniyor

  DenemeController 'da Sayfa y??klenince ??al????an denemeler() ile ??zel period se??iminde ??al????an getActivePeriodDenemeler() metodlar??nda Dashboard sayfas??na pagionation'lu sonu??lar d??n??yor
*/

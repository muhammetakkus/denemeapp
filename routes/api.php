<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\DenemeController;
use App\Http\Controllers\OptikFormController;
use App\Http\Controllers\SonucController;

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
/* AUTH and Admin middleware - login sanctum ile yapıyor ayrıca admin middlewar'inden kontrol ediyor */
Route::prefix('admin')->as('admin.')->middleware(['auth:sanctum','admin'])->group(function() {
  Route::post('/logout', [AdminController::class, 'logout']);
  Route::post('/create/period', [PeriodController::class, 'store']);
  Route::post('/update/period', [PeriodController::class, 'update']);
  Route::post('/delete/period', [PeriodController::class, 'delete']);
});

/*

1- logout işlemi revize edilmeli - bir kişi login olup çerezleri temizlerse db de token kalıyor? daha sonra tekrar giriş yapsa sıkıntı oluyor mu?
2- iki farklı yerden aynı hesap girildiğinde ve biri çıktığında sıkıntı var mı? token username üzerinden oluşuyor.

* Önemli Olan -> OptikormLayout oluşturukenki dinamik alanlardaki field adıyla cevap anahtarındanki ders kısmının ismi eşleşmeli!!!
* verileri buna göre alıyor

DÜZELTİLECEK
 - SELECTLERİN ARROWU Z-İNDEX FAZLA OLUP HEADER'IN ÜSTÜNE ÇIKIYOR
 - Analiz sayfasında fmt seçilince table'da listelenirken iki tane boş olan karakteri html yanyana göstermiyor (ayrılıp her biri bir spanda gösterilecek)
 - sonuç yükleme sayfasında sonuç yükleme file 'ı temizlenecek - data üstüne push ediliyor'
 - fmt dosyasında en son ders'in son soruları boş bırakılmışsa boşluk karakteri atmıyor sanırım - bunun için soru sayısı kadar karakter yoksa sona boşlukları otomatik at arraya
 - cevap anahtarı olmayan denemelerin analiz sayfasına gitmemeli uyarı vermeli
*/

/*

  Dashboard Bütün Denemeler List - Başka birinin oluşturduğu denemeye Uygula denirse Analiz sayfasına gider
  Burada uygun optik ile FMT okuması yapılıp Değerlendir tıklanırsa yeni deneme dublicate edilir ve sonuc o deneme için kaydedilir
  Artık o deneme kullanıcının instance ettiği denemedir

*/

/*
  template/js/custom.min.js line 90 düzenlendi - handleCustomFileInput()
  input file seçim yapıldıktan sonra istenilen dosyanın ismini yazma-silme aşamasında pürüz oluşturduğu için gerekli işlem DenemeAnaliz.vue line 312 de yapıldı
*/

/*

denemeler tablosunda kimden instance edildiği bilgisi tutuluyor dublicate edilmişse is_primary = 0
is_primary = 1 demek yeni oluşturulmuş deneme
is_primary = 0 demek external_deneme yani oluşturulan bir deneme uygula butonuyla girilip sonuç dosyası yüklenip okunmuş ve dublicate edilmiş

*/

/*
  ** Dashboard'da peroid select-option sayfa yüklenirken selected olamayabiliyor...

  ** Dashboard.vue - period select-option değiştirildiğinde changePeriod() metodu çalışarak this.period_manuel_selection = true yapıyor ve getDenemeler() 'i bu şekilde çağrıyor
  ** DenemeController 'a period payloadlı bir request gidiyor DenemeController buna göre getActivePeriodDenemeler() metodunu dönüyor
  ** paginationda buna göre şekilleniyor

  DenemeController 'da Sayfa yüklenince çalışan denemeler() ile özel period seçiminde çalışan getActivePeriodDenemeler() metodlarında Dashboard sayfasına pagionation'lu sonuçlar dönüyor
*/

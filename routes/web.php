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

Route::get('/', 'HomeController@index');

Route::get('/share', 'HomeController@indexFromShare');

Route::get('/brigadeiros-gourmet', function () {
    return redirect('https://go.hotmart.com/L13756980J');
});

Route::group(['prefix' => 'carsystem'], function () {
    
    Route::get('/', function () {
        return redirect('/carsystem/research');
    });

    Route::get('research', 'Carsystem\ResearchesController@index');
    Route::post('research', 'Carsystem\ResearchesController@store');
    Route::get('final', 'Carsystem\ResearchesController@final');
    Route::get('nao-gostaria1', 'Carsystem\ResearchesController@iDowntWant1');
    Route::get('nao-gostaria2', 'Carsystem\ResearchesController@iDowntWant2');

});

Route::get('/obrigado', function () {
    return view('thanks');
});

Route::middleware(['isAdministrator'])->group(function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

Route::group(['prefix' => 'quiz'], function () {
    
    Route::get('/', function () {
        return redirect('/quiz/research');
    });

    Route::get('research', 'Quiz\ResearchesController@index');
    Route::post('research', 'Quiz\ResearchesController@store');
    Route::get('final', 'Quiz\ResearchesController@final');
});

Route::group(['prefix' => 'carsystem'], function () {
    
    Route::get('/', function () {
        return redirect('/carsystem/research');
    });

    Route::get('research', 'Carsystem\ResearchesController@index');
    Route::post('research', 'Carsystem\ResearchesController@store');
    Route::get('final', 'Carsystem\ResearchesController@final');
    Route::get('nao-gostaria1', 'Carsystem\ResearchesController@iDowntWant1');
    Route::get('nao-gostaria2', 'Carsystem\ResearchesController@iDowntWant2');

});

Route::group(['prefix' => 'ead'], function () {
    
    Route::get('/', function () {
        return redirect('/ead/research');
    });

    Route::get('research', 'Ead\ResearchesController@index');
    Route::post('research', 'Ead\ResearchesController@store');
    Route::get('final', 'Ead\ResearchesController@final');

});

Route::group(['prefix' => 'pesquisa-oceanos'], function () {
    
    Route::get('/', function () {
        return redirect('/pesquisa-oceanos/research');
    });

    Route::get('research', 'GreenpeaceOceanos\ResearchesController@index');
    Route::post('research', 'GreenpeaceOceanos\ResearchesController@store');
    Route::get('final', 'GreenpeaceOceanos\ResearchesController@final');
});

Route::group(['prefix' => 'alfacon'], function () {
    
    Route::get('/', function () {
        return redirect('/alfacon/research');
    });

    Route::get('info', 'Alfacon\ResearchInfoController@index');
    Route::post('info', 'Alfacon\ResearchInfoController@fromForm');
    
    Route::get('research', 'Alfacon\ResearchesController@index');
    Route::post('research', 'Alfacon\ResearchesController@store');
    Route::get('final', 'Alfacon\ResearchesController@final');
    Route::get('results', 'Alfacon\ResultsController@show');
    Route::get('results/search', 'Alfacon\ResultsController@search');
    Route::get('results/search-research/{email}', 'Alfacon\ResultsController@searchEmail');
});

Route::group(['prefix' => 'xmove-car'], function () {   
    Route::get('/', 'XMoveCarController@index');
    Route::get('/final', 'XMoveCarController@final');
    Route::post('/create', 'XMoveCarController@create');
    Route::get('/search','XMoveCarController@search');
    Route::get('/show', 'XMoveCarController@show');
});

Route::group(['prefix' => 'research'], function () {   
    Route::get('/{url}/{customersId}', 'ResearchSponsored\ResearchesController@index');

    Route::post('/{url}/research', 'ResearchSponsored\ResearchesController@store');
    Route::post('/get-data-research', 'ResearchSponsored\ResearchesController@getData');
    Route::post('/save-research-answer', 'ResearchSponsored\ResearchesController@saveResearchAnswer');
    Route::get('/final/research/{middlePageId}', 'ResearchSponsored\ResearchesController@final');
    Route::post('/verify-research', 'ResearchSponsored\ResearchesController@verifyResearch');
});

Route::group(['prefix' => 'opinion-research'], function () {
    Route::get('/pesquisa', 'RaptorSurvey\RaptorSurveyController@showForm');
    Route::post('/pesquisa', 'RaptorSurvey\RaptorSurveyController@store');
    Route::get('/no-profile', 'RaptorSurvey\RaptorSurveyController@showNoProfile');
});

Route::group(['prefix' => 'profile-research'], function () {
    Route::get('/research', 'Infoproduto\InfoprodutoController@showResearch');
    Route::post('/research', 'Infoproduto\InfoprodutoController@saveResearch');

    Route::get('/postback/{customerId}', 'Infoproduto\InfoprodutoController@postback');
});

Route::get('login', 'Auth\LoginController@index');

Route::post('login', 'Auth\LoginController@login');

Route::get('termos-e-condicoes', 'TermsOfUseController@conditions');

Route::get('termos-e-condicoes-sweet', 'TermsOfUseController@conditionsSweet');

Route::get('politica-de-privacidade', 'TermsOfUseController@privacy');

Route::get('politica-de-privacidade-sweet', 'TermsOfUseController@privacySweet');

Route::get('produtos', 'ProdutosController@index');

Route::get('perfumes', 'PerfumesController@index');

Route::get('musculacao', 'MusculacaoController@index');

Route::get('bebes', 'BebesController@index');

Route::get('maquiagem', 'MaquiagemController@index');

Route::get('emagrecimento', 'EmagrecimentoController@index');

Route::get('dinheiro-na-internet', 'DinheiroInternetController@index');

Route::get('revenda', 'RevendaController@index');

//Route::get('clairvoyant', 'ClairvoyantController@index');
Route::get('/clairvoyant', function () {
    return redirect('/');
});

//Route::get('/clairvoyant/cadastros','ClairvoyantController@cadastros');
Route::get('/clairvoyant/cadastros', function () {
    return redirect('/');
});

//Route::get('clairvoyant/getTrackingId', 'ClairvoyantController@getTrackingId');
Route::get('clairvoyant/getTrackingId', function () {
    return redirect('/');
});

Route::group(['prefix' => 'amostras'], function () {
    Route::get('/', ['as' => 'amostras.index', 'uses' => 'AmostrasController@index']);
});

Route::group(['prefix' => 'compartilhar'], function () {
    Route::get('/', 'MemberGetMember\MemberGetMemberController@index');
    Route::get('/postback', 'MemberGetMember\PostbackController@postback');
    Route::get('/postbackActions', 'MemberGetMember\PostbackController@postbackActions');
});

Route::group(['prefix' => 'coming-from-blog'], function() {
    Route::get('/', 'BlogRegister\BlogRegisterController@index');
    Route::get('/postback', 'BlogRegister\BlogRegisterController@postback');
});

Route::group(['prefix' => 'create'], function () {
    Route::post('/', 'SweetApiController@create')->name('sweet.api.create');
    Route::post('/validate-email', ['as' => 'sweet.api.validate.email', 'uses' => 'SweetApiController@hasEmail']);
});

Route::group(['prefix' => 'saveclairvoyant'], function () {
    Route::post('/', 'ClairvoyantController@create')->name('clairvoyant.api.create');
});

Route::get('/campaigns/from-store/{id}', 'CampaignsController@comingFromStore');
Route::get('/new-campaigns', 'CampaignsController@indexNewCampaigns');

Route::get('/campaigns/from-dashboard/{campaign_id}', 'CampaignsController@comingFromDashboard');

Route::group(['prefix' => 'share-action'], function () {
    Route::get('/', 'ShareAction\ShareActionController@index');
    
});

Route::group(['prefix' => 'app-mobile'], function () {
    Route::get('/verify-app-invite/{customerId}', 'MobileApp\InviteAppController@verfiyInviteApp');   
    Route::get('/create-waiting-list/{customerId}', 'MobileApp\InviteAppController@createWaitingList');   
});  

Route::group(['middleware' => 'access'], function() {
    Route::group(['prefix' => 'campaigns'], function() {
        Route::get('/', ['as' => 'sweet.api.campaigns', 'uses' => 'CampaignsController@index']);
        Route::get('/search', ['as' => 'sweet.api.search.campaigns', 'uses' => 'CampaignsController@search']);
        Route::post('/save', ['as' => 'sweet.api.save.campaigns', 'uses' => 'CampaignsController@save']);
        Route::group(['prefix' => 'answers'], function() {
            Route::post('/save', ['as' => 'sweet.api.save.answers', 'uses' => 'CampaignAnswersController@save']);
        });
    });

    Route::group(['prefix' => 'final-campaign'], function() {
        Route::get('/', ['as' => 'sweet.redirect', 'uses' => 'RedirectController@index']);
        //Route::get('/donwload-ebook', ['as' => 'sweet.ebook.download', 'uses' => 'DownloadController@ebook']);
    });
});


<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
 
Route::get('/stickyPostList', 'HomeController@stickyPostList')->name('sticky.post.list');
Route::get('/noneStickyPostList', 'HomeController@noneStickyPostList')->name('none.sticky.post.list');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{id}/section', 'HomeController@section')->name('section');

Route::get('/', 'HomeController@index')->name('home');

Route::get('/show/{id}/{slug}', 'HomeController@show')->name('show.post');

Route::get('/allblog', 'ThreadController@allBlog')->name('allBlog');
Route::get('/live_search/site', 'CreateSiteController@action')->name('live_search.site');


Route::middleware(['auth'])->group(function(){
    
    Route::get('/cr8175876192emmanueladeyemo05', 'DepartmentController@index');
    Route::post('/cstore', 'DepartmentController@store')->name('cstore');

    Route::get('/set_admin', 'BlogAdminController@index')->name('create.admin');

    Route::get('/{id}/profile', 'UserUpdateController@index')->name('profile');
    Route::post('/update_user', 'UserUpdateController@update')->name('update.user');



    Route::post('/commentstore', 'CommentController@store')->name('store.comment'); 
    Route::post('commentupdate/{comment}', 'CommentController@update')->name('update.comment'); 
    Route::get('commentdelete/{destroy}', 'CommentController@destroy')->name('comment.destroy'); 

    Route::post('/commentreply', 'ReplyController@store')->name('reply.comment'); 
    Route::post('commentreply/{reply}', 'ReplyController@update')->name('reply.update'); 
    Route::get('commentreply/{reply}/delete', 'ReplyController@destroy')->name('reply.destroy'); 



    Route::get('/create_site', 'CreateSiteController@index')->name('create.site');
    Route::post('/store_site', 'CreateSiteController@store')->name('store.site');
    Route::get('/edit_site/{id}', 'CreateSiteController@edit')->name('edit.site');
    Route::post('/update_site/{id}', 'CreateSiteController@update')->name('update.site');

    Route::middleware(['checkaccess'])->group(function(){ 
        
        Route::get('/dashboard', 'BlogAdminController@index')->name('dashboard');
        
        Route::get('/admin', 'BlogAdminController@admin')->name('admin');
        Route::post('/search_admin', 'BlogAdminController@search')->name('search.admin');
        Route::get('/make_admin/{id}', 'BlogAdminController@store')->name('make.admin');
        Route::get('/remove_admin/{id}', 'BlogAdminController@destroy')->name('remove.admin');
        Route::get('/live_search/action', 'BlogAdminController@action')->name('live_search.action');

        Route::get('/create_post', 'ThreadController@create')->name('create.post');
        Route::post('/store_post', 'ThreadController@store')->name('store.post');
        Route::get('/edit_post/{id}', 'ThreadController@edit')->name('edit.post');
        Route::post('/update/{id}', 'ThreadController@update')->name('update.post');
        Route::get('/delete/{id}', 'ThreadController@destroy')->name('delete.post');
        
    });

});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
<?php

use App\Http\Controllers\PostController;
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

// ++++++++++++++++++++++++++++ Show "All Articles" ++++++++++++++++++++++++++++
Route::get('/',[PostController::class,'index']);
// ++++++++++++++++++++++++++++ Create "New Article" ++++++++++++++++++++++++++++
Route::get('/create',function(){
    return view('create');
});
// ++++++++++++++++++++++++++++ Store "New Article" Form Data ++++++++++++++++++++++++++++
Route::post('/post',[PostController::class,'store']);
// ++++++++++++++++++++++++++++ Delete "Article" with specific "id" ++++++++++++++++++++++++++++
Route::delete('/delete/{id}',[PostController::class,'destroy']);
// ++++++++++++++++++++++++++++ Edit "Article" with specific "id" ++++++++++++++++++++++++++++
Route::get('/edit/{id}',[PostController::class,'edit']);
// ++++++++++++++++++++++++++++ Update "Article" with specific "id" ++++++++++++++++++++++++++++
Route::put('/update/{id}',[PostController::class,'update']);
// ++++++++++++++++++++++++++++ Delete "Article Image" with specific "id" ++++++++++++++++++++++++++++
Route::delete('/deleteimage/{id}',[PostController::class,'deleteimage']);
// ++++++++++++++++++++++++++++ Delete "Article Cover Image" with specific "id" ++++++++++++++++++++++++++++
Route::delete('/deletecover/{id}',[PostController::class,'deletecover']);
// ++++++++++++++++++++++++++++ Delete "All Selected Article" ++++++++++++++++++++++++++++
Route::delete('/selected-posts',[PostController::class,'deleteAll'])->name('post.delete');



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
// php artisan route:listで確認できる
Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::resource("goals","GoalController")->middleware('auth');
//            GET|HEAD  | goals                          | goals.index         | App\Http\Controllers\GoalController@index                              | web          |
// |        | POST      | goals                          | goals.store         | App\Http\Controllers\GoalController@store                              | web          |
// |        | GET|HEAD  | goals/create                   | goals.create        | App\Http\Controllers\GoalController@create                             | web          |
// |        | GET|HEAD  | goals/{goal}                   | goals.show          | App\Http\Controllers\GoalController@show                               | web          |
// |        | PUT|PATCH | goals/{goal}                   | goals.update        | App\Http\Controllers\GoalController@update                             | web          |
// |        | DELETE    | goals/{goal}                   | goals.destroy       | App\Http\Controllers\GoalController@destroy                            | web          |
// |        | GET|HEAD  | goals/{goal}/edit              | goals.edit          | App\Http\Controllers\GoalController@edit        

Route::resource("goals.todos","TodoController")->middleware('auth');
//            GET|HEAD  | goals/{goal}/todos             | goals.todos.index   | App\Http\Controllers\TodoController@index                              | web          |
// |        | POST      | goals/{goal}/todos             | goals.todos.store   | App\Http\Controllers\TodoController@store                              | web          |
// |        | GET|HEAD  | goals/{goal}/todos/create      | goals.todos.create  | App\Http\Controllers\TodoController@create                             | web          |
// |        | PUT|PATCH | goals/{goal}/todos/{todo}      | goals.todos.update  | App\Http\Controllers\TodoController@update                             | web          |
// |        | DELETE    | goals/{goal}/todos/{todo}      | goals.todos.destroy | App\Http\Controllers\TodoController@destroy                            | web          |
// |        | GET|HEAD  | goals/{goal}/todos/{todo}      | goals.todos.show    | App\Http\Controllers\TodoController@show                               | web          |
// |        | GET|HEAD  | goals/{goal}/todos/{todo}/edit | goals.todos.edit    | App\Http\Controllers\TodoController@edit          


Route::post('/goals/{goal}/todos/{todo}/sort',"TodoController@sort")->middleware('auth');
            // | POST      | goals/{goal}/todos/{todo}/sort |                     | App\Http\Controllers\TodoController@sort                               | web          |

Route::resource("tags", "TagController")->middleware('auth');
// |        | POST      | tags                           | tags.store          | App\Http\Controllers\TagController@store                               | web,auth     |
// |        | GET|HEAD  | tags                           | tags.index          | App\Http\Controllers\TagController@index                               | web,auth     |
// |        | GET|HEAD  | tags/create                    | tags.create         | App\Http\Controllers\TagController@create                              | web,auth     |
// |        | GET|HEAD  | tags/{tag}                     | tags.show           | App\Http\Controllers\TagController@show                                | web,auth     |
// |        | PUT|PATCH | tags/{tag}                     | tags.update         | App\Http\Controllers\TagController@update                              | web,auth     |
// |        | DELETE    | tags/{tag}                     | tags.destroy        | App\Http\Controllers\TagController@destroy                             | web,auth     |
// |        | GET|HEAD  | tags/{tag}/edit                | tags.edit           | App\Http\Controllers\TagController@edit                                | web,auth     |

Route::post('/goals/{goal}/todos/{todo}/tags/{tag}', 'TodoController@addTag')->middleware('auth');

Route::delete('/goals/{goal}/todos/{todo}/tags/{tag}', 'TodoController@removeTag')->middleware('auth');


Auth::routes();
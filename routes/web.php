<?php

use App\Models\Post;
use Illuminate\Support\Facades\File;
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

    //$documents = YamlFrontMatter::parseFile(resource_path('posts/fourth.html'));


    // $posts = array_map(function($file){
    //     $documents = YamlFrontMatter::parseFile($file);

    //     return new Post(

    //         $documents->title,
    //         $documents->date,
    //         $documents->excerpt,
    //         $documents->body(),
    //         $documents->slug,
    //     );
    // },$files);


    // $posts =[];

    // foreach ($files as $file){
    //     $documents = YamlFrontMatter::parseFile($file);

    //     $posts[] = new Post(

    //         $documents->title,
    //         $documents->date,
    //         $documents->excerpt,
    //         $documents->body(),
    //         $documents->slug,
    //     );

    // }

    // $posts = Post::all();
      return view('welcome', [
        'posts' => Post::all()
      ]);
});

Route::get('posts/{post}', function($slug) {
    return view('post',[
        'post' => Post::findOrFail($slug)
    ]); 
});

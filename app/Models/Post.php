<?php

namespace App\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Illuminate\Support\Facades\File;

class Post{

    public $title;

    public $date;

    public $excerpt;

    public $body;

    public $slug;

    public function __construct($title, $date, $excerpt, $body, $slug)
    {
        $this->title = $title;
        $this->date = $date;
        $this->excerpt = $excerpt;
        $this->body = $body;
        $this->slug = $slug;
    }

    public static function all(){

        return cache()->rememberForever('post.all',function(){
            $files = File::files(resource_path("posts"));

            $posts = collect($files)
            ->map(function($file){
                return YamlFrontMatter::parseFile($file);
            })
            ->map(function($documents){
                return new Post(
    
                    $documents->title,
                    $documents->date,
                    $documents->excerpt,
                    $documents->body(),
                    $documents->slug,
                );
            })
            ->sortByDesc('date');
            
            return $posts;
        });
        
        // $files = File::files(resource_path("posts/"));
        // // ddd(File::files(resource_path("posts/")));
        // return array_map(function($file){
        //     return $file->getContents();
        // }, $files);
    }

    public static function find($slug){
        
        return static::all()->firstWhere('slug', $slug);

        // if(!file_exists( $path = resource_path("posts/{$slug}.html"))){
        //     throw new ModelNotFoundException();
        // }

        // return cache()->remember("posts.{$slug}", 5, fn() => file_get_contents($path));
    }

    public static function findOrFail($slug){
        
        $posts = static::find($slug);

        if(! $posts){
            throw new ModelNotFoundException();
        }

        return $posts;
    }

}
?>
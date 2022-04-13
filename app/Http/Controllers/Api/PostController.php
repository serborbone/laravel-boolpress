<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        //ottengo i post con i dati relativi alle categorie
        $posts = Post::with(['category'])->get();

        $posts = Post::paginate(2);

        return response()->json(
        
          [
            'results' => $posts,
          ]
        
        );
    }

}

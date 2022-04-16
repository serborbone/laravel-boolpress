<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.post.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
          [
            'title'=>'required|min:5',
            'content' => 'required|min:10',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id',
            'image' => 'nullable|max:2048',
          ]
        );

        $data = $request->all();

        if (isset($data['image'])) {

            $cover_path = Storage::put('post_covers', $data['image']); 
            $data['cover'] = $cover_path;
            
        }

        $slug = Str::slug($data['title']);

        //indice che definisco per gli slug già esistenti
        $counter = 1;

        //controllo se c'è un post con lo stesso slug
        while(Post::where('slug', $slug)->first() ) {

          //se esiste un post con lo stesso slug appendo un indice dopo il titolo
          $slug = Str::slug($data['title']) . '-' . $counter;
          $counter++;
        
        };

        //il valore slug è uguale allo slug definito sopra
        $data['slug'] = $slug;

        $post = new Post();

        $post->fill($data);

        $post->save();

        $post->tags()->sync($data['tags']);

        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //ottengo data e ora attuale
        $now = Carbon::now();
        
        //ottengo la data di creazione del post
        $dateTimePost = Carbon::create($post->created_at);

        //ritorna la differenza tra la data attuale e la data di creazione del post in giorni
        $diffInDays = $now->diffInDays($dateTimePost);
        

        return view('admin.post.show', compact('post', 'diffInDays'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {

      $categories = Category::all();  
      $tags = Tag::all();

      return view('admin.post.edit', compact('post', 'categories', 'tags'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

        $request->validate(
          [
            'title'=>'required|min:5',
            'content' => 'required|min:10',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id',
            'image' => 'nullable|max:2048',
          ]
        );

        $data = $request->all();

        if (isset($data['image'])) {

            if($post->cover) {
              Storage::delete($post->cover);
            }

            $cover_path = Storage::put('post_covers', $data['image']); 
            $data['cover'] = $cover_path;
            
        }

        //ottengo lo slug del titolo
        $slug = Str::slug($data['title']);

        //se lo slug è modificato
        if ($post->slug != $slug) {
        
            $counter = 1;

            while(Post::where('slug', $slug)->first() ) {

            //se esiste un post con lo stesso slug appendo un indice dopo il titolo
            $slug = Str::slug($data['title']) . '-' . $counter;
            $counter++;
        
            };

            //il valore slug è uguale allo slug definito sopra
            $data['slug'] = $slug;


        }

        $post->update($data);
        $post->save();

        if (isset($data['tags'])) {

          $post->tags()->sync($data['tags']);
          
        }

        return redirect()->route('admin.posts.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        if ($post->cover) {

          Storage::delete($post->cover);

        }

        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}

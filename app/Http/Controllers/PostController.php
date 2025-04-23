<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();
        // kalo pake with disini
        // $posts = Post::with('author:id,username')->get();
        // kalo pake loadMissing disini
        // sama aja hasilnya
        return PostDetailResource::collection($posts->loadMissing(['author:id,username', 'comments:id,post_id,user_id,comments_content']));
    }

    public function show($id) {
        $post = Post::with('author:id,username')->findOrFail($id); // untuk memfilter kolom apa aja yg mau dipanggil (gk boleh spasi dan pk dalam hal ini id harus di ikut sertakan)
        return new PostDetailResource($post->loadMissing(['author:id,username', 'comments:id,post_id,user_id,comments_content']));
    }

    // eager loading pada api resource
    // public function show2($id) {
    //     $post = Post::findOrFail($id); // maka akan di panggil author dan data" nya, padahal kita gk manggil with author tapi tetep kepanggil, karena di PostDetailResource langsung nulis $this->author
    //     return new PostDetailResource($post);
    // }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required'
        ]);

        $request['author_id'] = Auth::user()->id;
        $post = Post::create($request->all());
        return new PostDetailResource($post->loadMissing('author:id,username')); // panggil juga author nya, karena udah bikin relationship whenLoaded di PostDetailResource hanya tinggal panggil
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required'
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());
        return new PostDetailResource($post->loadMissing('author:id,username'));
    }

    public function destroy($id) {
        $post = Post::findOrFail($id);
        $post->delete();
        return new PostDetailResource($post->loadMissing('author:id,username'));
    }
}

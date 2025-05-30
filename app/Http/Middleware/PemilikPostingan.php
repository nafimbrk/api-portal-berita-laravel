<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PemilikPostingan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd('ini middleware yg baru dibuat');
        $currentUser = Auth::user();
        $post = Post::findOrFail($request->id);

        if ($post->author_id != $currentUser->id) {
            return response()->json([
                'message' => 'data not found'
            ], 404);
        }

        return $next($request); // lanjut ke controller
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PemilikKomentar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $comment = Comment::findOrFail($request->id);

        if ($comment->user_id != $user->id) {
            return response()->json([
                'message' => 'data not found'
            ], 404);
        }

        return $next($request);
    }
}

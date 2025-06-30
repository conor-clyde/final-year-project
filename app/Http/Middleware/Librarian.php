<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class Librarian {
    public function handle(Request $request, Closure $next): Response {
        $user = auth()->user();
        if ($user && $user->role === User::ROLE_LIBRARIAN) {
            return $next($request);
        }
        abort(403);
    }
}

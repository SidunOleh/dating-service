<?php

namespace App\Http\Middleware;

use App\Models\ProfileVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackProfileVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    { 
        if ($request->creator) {
            ProfileVisit::create(['creator_id' => $request->creator->id,]);
        }

        return $next($request);
    }
}

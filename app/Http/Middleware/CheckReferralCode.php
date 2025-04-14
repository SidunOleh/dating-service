<?php

namespace App\Http\Middleware;

use App\Services\ReferralSystem\ReferralSystem;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckReferralCode
{
    public function __construct(
        public ReferralSystem $referralSystem
    )
    {
        
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($code = $request->query('ref')) {
            $this->referralSystem->memoryReferralCode($code);

            return redirect($request->url());
        }

        return $next($request);
    }
}

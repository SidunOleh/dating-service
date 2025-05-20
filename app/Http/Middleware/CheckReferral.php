<?php

namespace App\Http\Middleware;

use App\Services\ReferralSystem\ReferralSystem;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckReferral
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
        $creator = $request->creator;

        $referer = parse_url($request->headers->get('referer'));
        if (($referer['host'] ?? '') != $request->getHost()) {
            $this->referralSystem->memoryReferralCode($creator->referral_code);
        }

        if (! $creator->is_approved) {
            return redirect()->route('home.index');
        }

        return $next($request);
    }
}

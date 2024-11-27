<?php

namespace App\Http\Controllers\Web\Filters;

use App\Http\Controllers\Controller;
use App\Models\ZipCode;
use Illuminate\Http\Request;

class ApplyController extends Controller
{
    public function __invoke(Request $request)
    {
        $filters = [];
        $filters['gender'] = $request->query('gender');
        $filters['zip'] = $request->query('zip');
        $filters['miles'] = $request->query('miles');

        if ( 
            $filters['zip'] and 
            $filters['miles'] and 
            $zipCode = ZipCode::where('zip', $filters['zip'])->first() 
        ) {
            $filters['center']['lat'] = $zipCode->latitude;
            $filters['center']['lng'] = $zipCode->longitude;
            $filters['radius'] = $filters['miles'] * 1609;
        }

        session(['filters' => $filters,]);

        return redirect()->route('home.index');
    }
}

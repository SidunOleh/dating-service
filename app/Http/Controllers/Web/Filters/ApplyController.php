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
        $filters['s'] = $request->query('s');
        $filters['gender'] = $request->query('gender');

        if (
            $zip = $request->query('zip') and
            $zipCode = ZipCode::where('zip', $zip)->first() and
            $miles = $request->query('miles')
        ) {
            $filters['zip'] = $zip;
            $filters['miles'] = $miles;
            $filters['center']['lat'] = $zipCode->latitude;
            $filters['center']['lng'] = $zipCode->longitude;
            $filters['radius'] = $miles * 1609;
        }

        session(['filters' => $filters,]);

        return redirect()->route('home.index');
    }
}

<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\ZipCode;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request, int $page = 1)
    {
        $filters = [];
        $filters['s'] = $request->query('s');
        $filters['gender'] = $request->query('gender');

        if (
            $zip = $request->query('zip') and
            $zipCode = ZipCode::where('zip', $zip)->first() and
            $miles = $request->query('miles')
        ) {
            $filters['center']['lat'] = $zipCode->latitude;
            $filters['center']['lng'] = $zipCode->longitude;
            $filters['radius'] = $miles * 1609;
        }

        $template = Template::inRandomOrder()->firstOrFail();
        $template->setPage($page)
            ->setFilters($filters)
            ->fillData();

        return view('pages.home', ['template' => $template,]);
    }
}

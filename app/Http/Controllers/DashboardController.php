<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
   

    /**
     * Display the view.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if (!Gate::allows('access-dashboards')) {
            abort(403);
        }

        return view('dashboard');
    }
}

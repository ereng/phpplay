<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmrController extends Controller
{
    public function medbookresult(Request $request)
    {
        \Log::info('medbook');
        \Log::info($request->all());
    }

    public function ml4afrikaresult(Request $request)
    {
        \Log::info('ml4afrika');
        \Log::info($request->all());
    }

    public function sanitasresult(Request $request)
    {
        \Log::info('sanitas');
        \Log::info($request->all());
    }

}


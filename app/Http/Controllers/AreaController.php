<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function show($slug)
    {
        $area = Area::where('slug', $slug)->firstOrFail();

        return view('areas.show', compact('area'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\MixInfo;
use Illuminate\Http\Request;

class ImportExportController extends Controller
{
    public function form()
    {
        $mix_infos = MixInfo::all();
        return view('imports_exports.form')->with(compact('mix_infos'));
    }
}

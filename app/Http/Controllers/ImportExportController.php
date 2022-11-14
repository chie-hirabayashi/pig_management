<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportExportController extends Controller
{
    public function form()
    {
        return view('imports_exports.form');
    }
}

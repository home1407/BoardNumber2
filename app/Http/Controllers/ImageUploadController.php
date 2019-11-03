<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function fileCreate()
    {
        return view('imageupload');
    }
}

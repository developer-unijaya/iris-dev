<?php

namespace App\Http\Controllers\Documentation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserInterfaceController extends Controller
{
    // Content Typography
    public function typography()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "UI"], ['name' => "Typography"]
        ];
        return view('/content/ui-pages/ui-typography', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    // Icons Feather
    public function icons_feather()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "UI"], ['name' => "Feather Icons"]
        ];
        return view('/content/ui-pages/icons-feather', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}

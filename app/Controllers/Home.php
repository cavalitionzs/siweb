<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard'
        ];
        return view('admin/overview', $data);
    }

    // public function index()
    // {
    //     return view('admin/overview');
    // }
}

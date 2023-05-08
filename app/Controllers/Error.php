<?php

namespace App\Controllers;

class Error extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard'
        ];
        return view('Error/index', $data);
    }
    public function Karyawan()
    {
        $data = [
            'title' => 'Dashboard'
        ];
        return view('Error/Karyawan', $data);
    }

    public function Admin()
    {
        $data = [
            'title' => 'Dashboard'
        ];
        return view('Error/Admin', $data);
    }

    public function Manajer()
    {
        $data = [
            'title' => 'Dashboard'
        ];
        return view('Error/Manajer', $data);
    }
}

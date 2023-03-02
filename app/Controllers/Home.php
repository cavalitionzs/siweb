<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('admin/overview');
    }

    public function about()
    {
        return view('about.php');
    }

    // public function about($nama = 'Anom')
    // {
    //     echo "Hi, nama saya adalah $nama";
    // }

    // public function about($nama = 'Anom', $umur = 25)
    // {
    //     echo "Hi, nama saya adalah $nama. Usia saya $umur tahun.";
    // }

    public function contact()
    {
        return view('contact.php');
    }
    public function DD()
    {
        return view('DD.php');
    }

    public function PO()
    {
        return view('PO.php');
    }
}

<?php

namespace App\Controllers;

use \App\Models\BerandaModel;

class Home extends BaseController
{
    // public function index()
    // {
    //     $data = [
    //         'title' => 'Dashboard'
    //     ];
    //     return view('admin/overview', $data);
    // }
    private $beranda;
    public function __construct()
    {
        $this->beranda       = new BerandaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Beranda'
        ];
        return view('beranda', $data);
        // dd($data);
    }

    public function showChartTransaksi()
    {
        $tahun = $this->request->getVar('tahun');
        $reportTrans = $this->beranda->reportTransaksi($tahun);
        $response = [
            'status' => false,
            'data'   => $reportTrans
        ];
        echo json_encode($response);
    }

    public function showChartCustomer()
    {
        $tahun = $this->request->getVar('tahun');
        $reportCust = $this->beranda->reportCustomer($tahun);
        $response = [
            'status' => false,
            'data'   => $reportCust
        ];
        echo json_encode($response);
    }

    public function showChartBeli()
    {
        $tahun = $this->request->getVar('tahun');
        $reportBeli = $this->beranda->reportBeli($tahun);
        $response = [
            'status' => false,
            'data'   => $reportBeli
        ];
        echo json_encode($response);
    }

    public function showChartSupplier()
    {
        $tahun = $this->request->getVar('tahun');
        $reportSupp = $this->beranda->reportSupplier($tahun);
        $response = [
            'status' => false,
            'data'   => $reportSupp
        ];
        echo json_encode($response);
    }
}

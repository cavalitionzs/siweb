<?php

namespace App\Controllers;

use App\Models\CategoryKomik;
use \App\Models\KomikModel;

define('_TITLE', 'Data Komik');

class Komik extends BaseController
{
    private $komikModel, $catModel;
    public function __construct()
    {
        $this->komikModel = new komikModel();
        $this->catModel = new CategoryKomik();
    }

    public function index()
    {
        $datakomik   = $this->komikModel->getBook();
        $data = [
            'title' => _TITLE,
            'data_komik' => $datakomik
        ];
        // dd($data_komik);
        return view('komik/index', $data);
    }

    public function detail($slug)
    {
        $data_komik = $this->komikModel->getBook($slug);
        $data = [
            'title' => _TITLE,
            'data_komik' => $data_komik
        ];
        // dd($data_komik);
        return view('komik/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Komik',
            'category' => $this->catModel->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        // dd($data_komik);
        return view('komik/create', $data);
    }

    public function save()
    {
        // VALIDASI INPUT
        if (!$this->validate([
            'title' => [
                'rules' => 'required|is_unique[komik.title]',
                'label' => 'Judul',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],
            'author' => 'required',
            'release_year' => 'required|integer',
            'price' => 'required|numeric',
            'discount' => 'permit_empty|decimal',
            'stock' =>  'required|integer',
        ])) {
            return redirect()->to('/komik/create')->withInput();
        }

        $slug = url_title($this->request->getVar('title'), '-', true);
        $this->komikModel->save([
            'title' => $this->request->getVar('title'),
            'author' => $this->request->getVar('author'),
            'release_year' => $this->request->getVar('release_year'),
            'price' => $this->request->getVar('price'),
            'discount' => $this->request->getVar('discount'),
            'stock' => $this->request->getVar('stock'),
            'komik_category_id' => $this->request->getVar('komik_category_id'),
            'slug' => $slug,
        ]);
        session()->setFlashdata("msg", "Data Berhasil Ditambahkan!");
        return redirect()->to('/komik');
    }
}

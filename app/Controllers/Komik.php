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

    public function edit($slug)
    {
        $datakomik = $this->komikModel->getBook($slug);
        if (empty($datakomik)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Judul buku $slug tidak ditemukan!");
        }

        $data = [
            'title' => 'Ubah Buku',
            'category' => $this->catModel->findAll(),
            'validation' => \Config\Services::validation(),
            'result' => $datakomik
        ];
        // dd($data);
        return view('komik/edit', $data);
    }

    public function delete($id)
    {
        $datakomik = $this->komikModel->find($id);
        $this->komikModel->delete($id);
        if ($datakomik['cover'] != $this->defaultImage) {
            unlink('img/' . $datakomik['cover']);
        }
        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/komik');
    }

    public function update($id)
    {
        // CEK JUDUL
        $dataOld = $this->komikModel->getBook($this->request->getVar('slug'));
        if ($dataOld['title'] == $this->request->getVar('title')) {
            $rule_title = 'required';
        } else {
            $rule_title = 'required';
        }
        // VALIDASI INPUT
        if (!$this->validate([
            'title' => [
                'rules' => 'required',
                'label' => 'Judul',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'author' => [
                'rules' => 'required',
                'label' => 'Penulis',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'release_year' => [
                'rules' => 'required|integer',
                'label' => 'Tahun Rilis',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'integer' => '{field} hanya boleh Angka!'
                ]
            ],
            'price' => [
                'rules' => 'required|numeric',
                'label' => 'Harga',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'numeric' => '{field} hanya boleh Angka!'
                ]
            ],
            'discount' => [
                'rules' => 'permit_empty|decimal',
                'label' => 'Diskon',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'decimal' => '{field} hanya boleh angka atau decimal!'
                ]
            ],
            'stock' =>  [
                'rules' => 'required|integer',
                'label' => 'Stok',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'integer' => '{field} hanya boleh Angka!'
                ]
            ],
            'cover' => [
                'rules' => 'max_size[cover,10240]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar tidak boleh lebih dari 10MB',
                    'is_image' => 'Yang ada pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!',
                ]
            ],
        ])) {
            return redirect()->to('komik/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $OldFileName = $this->request->getVar('OldCover');
        $fileCover = $this->request->getFile('cover');
        if ($fileCover->getError() == 4) {
            $fileName = $this->$OldFileName;
        } else {
            $fileName = $fileCover->getRandomName();
            $fileCover->move('img', $fileName);

            if ($OldFileName != $this->defaultImage && $OldFileName != "") {
                unlink('img/' . $OldFileName);
            }
        }

        $slug = url_title($this->request->getVar('title'), '-', true);
        $this->komikModel->save([
            'komik_id' => $id,
            'title' => $this->request->getVar('title'),
            'author' => $this->request->getVar('author'),
            'release_year' => $this->request->getVar('release_year'),
            'price' => $this->request->getVar('price'),
            'discount' => $this->request->getVar('discount'),
            'stock' => $this->request->getVar('stock'),
            'komik_category_id' => $this->request->getVar('komik_category_id'),
            'slug' => $slug,
            'cover' => $fileName,
        ]);
        session()->setFlashdata("msg", "Data Berhasil Diubah!");
        return redirect()->to('/komik');
    }

    public function save()
    {
        // VALIDASI INPUT
        if (!$this->validate([
            'title' => [
                'rules' => 'required|is_unique[book.title]',
                'label' => 'Judul',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],
            'author' => [
                'rules' => 'required',
                'label' => 'Penulis',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'release_year' => [
                'rules' => 'required|integer',
                'label' => 'Tahun Rilis',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'integer' => '{field} hanya boleh Angka!'
                ]
            ],
            'price' => [
                'rules' => 'required|numeric',
                'label' => 'Harga',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'numeric' => '{field} hanya boleh Angka!'
                ]
            ],
            'discount' => [
                'rules' => 'permit_empty|decimal',
                'label' => 'Diskon',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'decimal' => '{field} hanya boleh angka atau decimal!'
                ]
            ],
            'stock' =>  [
                'rules' => 'required|integer',
                'label' => 'Stok',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'integer' => '{field} hanya boleh Angka!'
                ]
            ],
            'cover' => [
                'rules' => 'max_size[cover,10240]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar tidak boleh lebih dari 10MB',
                    'is_image' => 'Yang ada pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!',
                ]
            ],
        ])) {
            return redirect()->to('/komik/create')->withInput();
        }

        $fileCover = $this->request->getFile('cover');
        if ($fileCover->getError() == 4) {
            $fileName = $this->defaultImage;
        } else {
            $fileName = $fileCover->getRandomName();
            $fileCover->move('img', $fileName);
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
            'cover' => $fileName,
        ]);
        session()->setFlashdata("msg", "Data Berhasil Ditambahkan!");
        return redirect()->to('/komik');
    }
}

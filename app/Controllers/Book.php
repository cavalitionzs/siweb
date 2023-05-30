<?php

namespace App\Controllers;

use \App\Models\BookModel;
use \App\Models\CategoryModel;
use \App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

define('_TITLE', 'Data Buku');

class Book extends BaseController
{
    // public function index()
    // {
    //     $bookModel = new BookModel();
    //     $dataBook = $bookModel->findAll();
    //     // dd($dataBook);
    // }

    private $bookModel, $catModel;
    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->catModel = new CategoryModel();
    }

    public function index()
    {
        $data_book   = $this->bookModel->getBook();
        $data = [
            'title' => _TITLE,
            'data_book' => $data_book
        ];
        // dd($dataBook);
        return view('book/index', $data);
    }

    public function detail($slug)
    {
        $data_book = $this->bookModel->getBook($slug);
        $data = [
            'title' => _TITLE,
            'data_book' => $data_book
        ];
        // dd($data_book);
        return view('book/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Buku',
            'category' => $this->catModel->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        // dd($data);
        return view('book/create', $data);
    }

    public function edit($slug)
    {
        $data_book = $this->bookModel->getBook($slug);
        if (empty($data_book)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Judul buku $slug tidak ditemukan!");
        }

        $data = [
            'title' => 'Ubah Buku',
            'category' => $this->catModel->findAll(),
            'validation' => \Config\Services::validation(),
            'result' => $data_book
        ];
        // dd($data);
        return view('book/edit', $data);
    }

    public function delete($id)
    {
        $data_book = $this->bookModel->find($id);
        $this->bookModel->delete($id);
        if ($data_book['cover'] != $this->defaultImage) {
            unlink('img/' . $data_book['cover']);
        }
        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/book');
    }

    public function update($id)
    {
        // CEK JUDUL
        $dataOld = $this->bookModel->getBook($this->request->getVar('slug'));
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
            return redirect()->to('book/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $OldFileName = $this->request->getVar('OldCover');
        $fileCover = $this->request->getFile('cover');
        if ($fileCover->getError() == 4) {
            $fileName = $this->$OldFileName;
            if ($fileCover == "") {
                $fileName = $OldFileName;
            }
        } else {
            $fileName = $fileCover->getRandomName();
            $fileCover->move('img', $fileName);

            if ($OldFileName != $this->defaultImage && $OldFileName != "") {
                unlink('img/' . $OldFileName);
            }
        }

        $slug = url_title($this->request->getVar('title'), '-', true);
        $this->bookModel->save([
            'book_id' => $id,
            'title' => $this->request->getVar('title'),
            'author' => $this->request->getVar('author'),
            'release_year' => $this->request->getVar('release_year'),
            'price' => $this->request->getVar('price'),
            'discount' => $this->request->getVar('discount'),
            'stock' => $this->request->getVar('stock'),
            'book_category_id' => $this->request->getVar('book_category_id'),
            'slug' => $slug,
            'cover' => $fileName,
        ]);
        session()->setFlashdata("msg", "Data Berhasil Diubah!");
        return redirect()->to('book/');
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
            return redirect()->to('/book/create')->withInput();
        }

        $fileCover = $this->request->getFile('cover');
        if ($fileCover->getError() == 4) {
            $fileName = $this->defaultImage;
        } else {
            $fileName = $fileCover->getRandomName();
            $fileCover->move('img', $fileName);
        }

        $slug = url_title($this->request->getVar('title'), '-', true);
        $this->bookModel->save([
            'title' => $this->request->getVar('title'),
            'author' => $this->request->getVar('author'),
            'release_year' => $this->request->getVar('release_year'),
            'price' => $this->request->getVar('price'),
            'discount' => $this->request->getVar('discount'),
            'stock' => $this->request->getVar('stock'),
            'book_category_id' => $this->request->getVar('book_category_id'),
            'slug' => $slug,
            'cover' => $fileName,
        ]);
        session()->setFlashdata("msg", "Data Berhasil Ditambahkan!");
        return redirect()->to('/book');
    }

    public function importData()
    {
        $file = $this->request->getFile("file");
        $ext  = $file->getExtension();
        if ($ext == "xls")
            $reader = new Xls();
        else
            $reader = new Xlsx();
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        foreach ($sheet as $key => $value) {
            if ($key == 0) continue;

            $namaFile = $this->defaultImage;
            // dd($value[1]);
            $slug     = url_title($value[1], '-', true);

            // Cek Judul //
            $dataOld = $this->bookModel->getBook($slug);
            if (!$dataOld) {
                $this->bookModel->save([
                    'title' => $value[1],
                    'author' => $value[2],
                    'release_year' => $value[3],
                    'price' => $value[4],
                    'discount' => $value[5] ?? 0,
                    'stock' => $value[6],
                    'book_category_id' => $value[7],
                    'slug' => $slug,
                    'cover' => $namaFile,
                ]);
                session()->setFlashdata("msg", "Data Behasil Diimport!");
            } else if ($dataOld) {
                session()->setFlashdata("msg", "Data sudah ada!");
            }
        }
        return redirect()->to('/book');
    }
}

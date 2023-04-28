<?php

namespace App\Controllers;

use App\Models\UsersModel;

define('_TITLE', 'Data User');

class Users extends BaseController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new UsersModel();
    }

    public function index()
    {
        $dataUser = $this->userModel->getUsers();
        $data = [
            'tittle'  => _TITLE,
            'result'  => $dataUser
        ];
        return view('user/index', $data);
    }

    public function create()
    {
        $data = [
            'tittle' => 'Tambah User'
        ];
        return view('user/create', $data);
    }

    public function edit($id)
    {
        $dataUser = $this->userModel->getUsers($id);
        $data = [
            'tittle'  => _TITLE,
            'result'  => $dataUser
        ];
        return view('user/edit', $data);
    }

    public function update($id)
    {
        $user_myth = new UsersModel();
        // dd($this->reques->getVar('username'));
        $this->userModel->save([
            'id'            => $id,
            'firstname'     => $this->request->getVar('firstname'),
            'lastname'      => $this->request->getVar('lastname'),
            'user_name'     => $this->request->getVar('username'),
            'user_email'    => $this->request->getVar('email'),
            'role'          => $this->request->getVar('role'),
        ]);

        session()->setFlashdata('msg', 'Berhasil memperbarui user');
        return redirect()->to('/users');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/users');
    }

    public function save()
    {
        $user_myth = new UsersModel();
        $user_myth->save([
            'firstname'     => $this->request->getVar('firstname'),
            'lastname'      => $this->request->getVar('lastname'),
            'user_name'     => $this->request->getVar('username'),
            'user_email'    => $this->request->getVar('email'),
            'role'          => $this->request->getVar('role'),
            'user_password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ]);
    }
}

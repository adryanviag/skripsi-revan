<?php

namespace App\Controllers;

use App\Models\DataBibitModel;

class DataBibitAyam extends BaseController
{
    public function index()
    {
        $bibit = new DataBibitModel();
        $data['databibit'] = $bibit->findAll();
        $data['title'] = 'Data Bibit Ayam';
        return view('pages/data_ayam/index', $data);
    }

    public function tambah()
    {
        $data['title'] = 'Data Bibit Ayam';
        return view('pages/data_ayam/tambah', $data);
    }

    public function store()
    {
        $bibit = new DataBibitModel();

        if (!$this->validate([
            'jenis'  => 'required',
            'tanggal' => 'required',
            'jml_stok' => 'required'
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $stok = (int) $this->request->getVar('jml_stok');

        $data = [
            'jenis' => $this->request->getVar('jenis'),
            'jml_stok' => $stok,
            'tanggal' => $this->request->getVar('tanggal')
        ];

        $bibit->save($data);

        $session = session();
        $session->setFlashdata("success", "Data berhasil ditambahkan");
        return redirect()->to(base_url('data-ayam'));
    }

    public function edit($id)
    {
        $data['title'] = 'Data Bibit Ayam';

        $bibit = new DataBibitModel();
        $data['bibit'] = $bibit->find($id);

        return view('pages/data_ayam/edit', $data);
    }

    public function update($id)
    {
        $bibit = new DataBibitModel();

        if (!$this->validate([
            'jenis'  => 'required',
            'tanggal' => 'required',
            'jml_stok' => 'required'
        ])) {
            session()->setFlashdata('error', 'Form tidak lengkap!');
            return redirect()->back()->withInput();
        }

        $stok = (int) $this->request->getVar('jml_stok');

        $data = [
            'jenis' => $this->request->getVar('jenis'),
            'jml_stok' => $stok,
            'tanggal' => $this->request->getVar('tanggal')
        ];

        $bibit->update($id, $data);

        $session = session();
        $session->setFlashdata("success", "Data berhasil diubah");
        return redirect()->to(base_url('data-ayam'));
    }

    public function delete($id)
    {
        $bibit = new DataBibitModel();

        $session = session();
        $session->setFlashdata("success", "Data berhasil dihapus");
        $bibit->delete($id);
        return redirect()->back();
    }
}

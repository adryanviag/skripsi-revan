<?php

namespace App\Controllers;

use App\Models\PenjualanModel;

class Penjualan extends BaseController
{
    public function index()
    {
        $penjualan = new PenjualanModel();
        $data['penjualan'] = $penjualan->findAll();
        $data['title'] = 'Data Penjualan Ayam';

        return view('pages/penjualan/index', $data);
    }

    public function tambah()
    {
        $data['title'] = 'Data Penjualan Ayam';
        return view('pages/penjualan/tambah', $data);
    }

    public function store()
    {
        $penjualan = new PenjualanModel();
        
        if (!$this->validate([
            'jenis'  => 'required',
            'tanggal' => 'required',
            'bibit_terjual' => 'required',
            'harga_jual' => 'required'
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $stok = (int) $this->request->getVar('bibit_terjual');
        $harga_jual = (int) $this->request->getVar('harga_jual');

        $data = [
            'jenis' => $this->request->getVar('jenis'),
            'harga_jual' => $harga_jual,
            'bibit_terjual' => $stok,
            'tanggal' => $this->request->getVar('tanggal')
        ];

        $penjualan->save($data);

        $session = session();
        $session->setFlashdata("success", "Data berhasil ditambahkan");
        return redirect()->to(base_url('penjualan'));
    }

    public function edit($id)
    {
        $data['title'] = 'Data Penjualan Ayam';

        $penjualan = new PenjualanModel();
        $data['penjualan'] = $penjualan->find($id);

        return view('pages/penjualan/edit', $data);
    }

    public function update($id)
    {
        $penjualan = new PenjualanModel();

        if (!$this->validate([
            'jenis'  => 'required',
            'tanggal' => 'required',
            'bibit_terjual' => 'required',
            'harga_jual' => 'required'
        ])) {
            session()->setFlashdata('error', 'Form tidak lengkap!');
            return redirect()->back()->withInput();
        }

        $stok = (int) $this->request->getVar('bibit_terjual');
        $harga_jual = (int) $this->request->getVar('harga_jual');

        $data = [
            'jenis' => $this->request->getVar('jenis'),
            'bibit_terjual' => $stok,
            'harga_jual' => $harga_jual,
            'tanggal' => $this->request->getVar('tanggal')
        ];

        $penjualan->update($id, $data);

        $session = session();
        $session->setFlashdata("success", "Data berhasil diubah");
        return redirect()->to(base_url('penjualan'));
    }

    public function delete($id)
    {
        $penjualan = new PenjualanModel();

        $session = session();
        $session->setFlashdata("success", "Data berhasil dihapus");
        $penjualan->delete($id);
        return redirect()->back();
    }
}

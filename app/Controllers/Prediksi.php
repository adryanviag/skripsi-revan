<?php

namespace App\Controllers;

use App\Models\PenjualanModel;
use App\Models\PrediksiModel;

class Prediksi extends BaseController
{
    public function index()
    {
        $data['title'] = 'Peramalan';

        return view('pages/prediksi/index', $data);
    }

    public function hitung()
    {
        $query = new PenjualanModel();

        // Alpha
        $alpha = (float) $this->request->getVar('alpha');

        if ($alpha == 0) {
            $session = session();
            $session->setFlashData('error_simpan', 'Pilih Alpha!');
            return redirect()->to(base_url('prediksi'));
        }

        // Get the dates
        $tahun = '2021';
        $bulan = 12;
        
        // Query
        $fetchData = $query
            ->select('*')
            ->findAll();
        
        $data = [
            ['st1' => $fetchData[0]['harga_jual'],
            'st2' => $fetchData[0]['harga_jual'],
            'st3' => $fetchData[0]['harga_jual'],
            'at_ft' => 0]
        ];


        // calculate st1, st2, st3, at, bt, ct for each months.
        for ($i=1; $i <= count($fetchData); $i++) { 
            $data[$i]['st1'] = $alpha * $fetchData[$i - 1]['harga_jual'] + (1 - $alpha) * $data[$i - 1]['st1'];
            $data[$i]['st2'] = $alpha * $data[$i]['st1'] + (1 - $alpha) * $data[$i - 1]['st2'];
            $data[$i]['st3'] = $alpha * $data[$i]['st2'] + (1 - $alpha) * $data[$i - 1]['st3'];
            $data[$i]['at'] = 3 * $data[$i]['st1'] - 3 * $data[$i]['st2'] + $data[$i]['st3'];
            $data[$i]['bt'] = ($alpha / (2 * (1 - $alpha) ** 2)) * (6 - 5 * $alpha) * $data[$i]['st1'] - (10 - 8 * $alpha) * $data[$i]['st2'] + (4 - 3 * $alpha) * $data[$i]['st3'];
            $data[$i]['ct'] = ($alpha ** 2 / (1 - $alpha) ** 2) * ($data[$i]['st1'] - 2 * $data[$i]['st2'] + $data[$i]['st3']);
            $data[$i+1]['forecast'] = ($data[$i]['at']) + ($data[$i]['bt'] * 1) + (0.5 * $data[$i]['ct'] * 1);
            $data[$i+1]['st1'] = 0;
            $data[$i+1]['st2'] = 0;
            $data[$i+1]['st3'] = 0;
            $data[$i+1]['at'] = 0;
            $data[$i+1]['bt'] = 0;
            $data[$i+1]['ct'] = 0;
        }

        // calculate forecast
        $data[1]['forecast'] = $fetchData[0]['harga_jual'];

        // price for at-ft
        $new_harga = [];
        for ($i=0; $i < count($fetchData); $i++) { 
            array_push($new_harga, $fetchData[$i]['harga_jual']);
        }

        
        // calculate at-ft, absolute at-ft
        for ($i=0; $i < count($new_harga); $i++) { 
            $data[$i + 1]['at_ft'] = round($new_harga[$i] - $data[$i + 1]['forecast']);
            $data[$i + 1]['abs_at_ft'] = abs($data[$i + 1]['at_ft']);
            $data[$i + 1]['mse_at_ft'] = abs($data[$i + 1]['at_ft'] * $data[$i + 1]['abs_at_ft']);
            $data[$i + 1]['mape_at_ft'] = abs(($new_harga[$i] - $data[$i + 1]['forecast'])/$new_harga[$i]);
        }

        $new_total = [];
        for ($i=1; $i < count($data); $i++) {
            array_push($new_total, $data[$i]);
        }
        $new_total = array_combine(range(1, count($new_total)), array_values($new_total));
        $new_harga = array_combine(range(1, count($new_harga)), array_values($new_harga));

        $total = [];

        array_walk_recursive($new_total, function($item, $key) use (&$total) {
            $total[$key] = isset($total[$key]) ? $item + $total[$key] : $item;
        });

        $total['mape'] = 100/$bulan*$total['mape_at_ft'];
        $total['mse'] = round($total['mse_at_ft']/$bulan);
        $total['mad'] = $total['at_ft']/$bulan;

        for ($i = 1;$i < count($new_total); $i++) {
            array_push($new_total[$i], $new_harga[$i]);
        };

        $data['title'] = 'Peramalan';
        
        $last = array_pop($new_total);
        $last[0] = 0;
        array_push($new_total, $last);

        $new_total[1]['at'] = 0;
        $new_total[1]['bt'] = 0;
        $new_total[1]['ct'] = 0;
        $send_data['tahun'] = $tahun;
        $send_data['data_bulanan'] = $new_total;
        $send_data['total'] = $total;
        $send_data['title'] = 'Peramalan';
        

        $prediksi = new PrediksiModel();

        $initDate = end($fetchData);
        $initHarga = end($send_data['data_bulanan']);
        $prevDate = $initDate['tanggal'];
        $tanggal_prediksi = date('Y-m-d', strtotime('+1 month', strtotime($prevDate)));
        $harga_prediksi = $initHarga['forecast'];
        $id_penjualan = $initDate['id'];
        $new_alpha = $alpha * 10;

        $checkIf = $prediksi->where('id_penjualan', $id_penjualan)->where('alpha', $new_alpha)->find();
        $validate = current($checkIf);


        // return dd($validate);
        if ($validate) {
            $session = session();
            $session->setFlashdata('error_simpan', 'Peramalan untuk alpha ' . $alpha . ' pada bulan ini sudah dilakukan!');
            return redirect()->to(base_url('prediksi'));
        }

        $prediksi->save([
            'id_penjualan' => $id_penjualan,
            'harga_prediksi' => $harga_prediksi,
            'tanggal_prediksi' => $tanggal_prediksi,
            'alpha' => $new_alpha
        ]);

        $session = session();
        $session->setFlashdata('success_simpan', 'Data Peramalan Berhasil Disimpan');
        return redirect()->to(base_url('prediksi'));
    }

    public function lihat()
    {
        $query = new PenjualanModel();

        // Alpha
        $alpha = (float) $this->request->getVar('alpha');

        if ($alpha == 0) {
            $session = session();
            $session->setFlashData('error', 'Pilih Alpha!');
            return redirect()->to(base_url('prediksi'));
        }

        // Get the dates
        $tahun = '2021';
        $bulan = 12;
        
        // Query
        $fetchData = $query
            ->select('*')
            ->findAll();
        
        $data = [
            ['st1' => $fetchData[0]['harga_jual'],
            'st2' => $fetchData[0]['harga_jual'],
            'st3' => $fetchData[0]['harga_jual'],
            'at_ft' => 0]
        ];


        // calculate st1, st2, st3, at, bt, ct for each months.
        for ($i=1; $i <= count($fetchData); $i++) { 
            $data[$i]['st1'] = $alpha * $fetchData[$i - 1]['harga_jual'] + (1 - $alpha) * $data[$i - 1]['st1'];
            $data[$i]['st2'] = $alpha * $data[$i]['st1'] + (1 - $alpha) * $data[$i - 1]['st2'];
            $data[$i]['st3'] = $alpha * $data[$i]['st2'] + (1 - $alpha) * $data[$i - 1]['st3'];
            $data[$i]['at'] = 3 * $data[$i]['st1'] - 3 * $data[$i]['st2'] + $data[$i]['st3'];
            $data[$i]['bt'] = $alpha / (2 * (1 - $alpha) ** 2) * ((6 - 5 * $alpha) * $data[$i]['st1'] - (10 - 8 * $alpha) * $data[$i]['st2'] + (4 - 3 * $alpha) * $data[$i]['st3']);
            $data[$i]['ct'] = ($alpha ** 2 / (1 - $alpha) ** 2) * ($data[$i]['st1'] - 2 * $data[$i]['st2'] + $data[$i]['st3']);
            $data[$i+1]['forecast'] = ($data[$i]['at']) + ($data[$i]['bt'] * 1) + (0.5 * $data[$i]['ct'] * 1);
            $data[$i+1]['st1'] = 0;
            $data[$i+1]['st2'] = 0;
            $data[$i+1]['st3'] = 0;
            $data[$i+1]['at'] = 0;
            $data[$i+1]['bt'] = 0;
            $data[$i+1]['ct'] = 0;
        }

        // calculate forecast
        $data[1]['forecast'] = $fetchData[0]['harga_jual'];

        // price for at-ft
        $new_harga = [];
        for ($i=0; $i < count($fetchData); $i++) { 
            array_push($new_harga, $fetchData[$i]['harga_jual']);
        }

        
        // calculate at-ft, absolute at-ft
        for ($i=0; $i < count($new_harga); $i++) { 
            $data[$i + 1]['at_ft'] = round($new_harga[$i] - $data[$i + 1]['forecast']);
            $data[$i + 1]['abs_at_ft'] = abs($data[$i + 1]['at_ft']);
            $data[$i + 1]['mse_at_ft'] = abs($data[$i + 1]['at_ft'] * $data[$i + 1]['abs_at_ft']);
            $data[$i + 1]['mape_at_ft'] = abs(($new_harga[$i] - $data[$i + 1]['forecast'])/$new_harga[$i]);
        }

        $new_total = [];
        for ($i=1; $i < count($data); $i++) {
            array_push($new_total, $data[$i]);
        }
        $new_total = array_combine(range(1, count($new_total)), array_values($new_total));
        $new_harga = array_combine(range(1, count($new_harga)), array_values($new_harga));

        $total = [];

        array_walk_recursive($new_total, function($item, $key) use (&$total) {
            $total[$key] = isset($total[$key]) ? $item + $total[$key] : $item;
        });

        $total['mape'] = 100/$bulan*$total['mape_at_ft'];
        $total['mse'] = round($total['mse_at_ft']/$bulan);
        $total['mad'] = $total['at_ft']/$bulan;

        for ($i = 1;$i < count($new_total); $i++) {
            array_push($new_total[$i], $new_harga[$i]);
        };

        $data['title'] = 'Peramalan';
        
        $last = array_pop($new_total);
        $last[0] = 0;
        array_push($new_total, $last);

        $new_total[1]['at'] = 0;
        $new_total[1]['bt'] = 0;
        $new_total[1]['ct'] = 0;
        $send_data['tahun'] = $tahun;
        $send_data['data_bulanan'] = $new_total;
        $send_data['total'] = $total;
        $send_data['title'] = 'Peramalan';

        return view('pages/prediksi/hasil', $send_data);
    }

    public function index_grafik()
    {
        $data['title'] = 'Grafik';
        return view('pages/prediksi/grafik/index', $data);
    }

    public function show_grafik()
    {
        $query = new PenjualanModel();

        // Alpha
        $alpha = (float) $this->request->getVar('alpha');

        if ($alpha == 0) {
            $session = session();
            $session->setFlashData('error', 'Pilih Alpha!');
            return redirect()->to(base_url('grafik'));
        }

        // Get the dates
        $tahun = '2021';
        $bulan = 12;
        
        // Query
        $fetchData = $query
            ->select('*')
            ->findAll();
        
        $data = [
            ['st1' => $fetchData[0]['harga_jual'],
            'st2' => $fetchData[0]['harga_jual'],
            'st3' => $fetchData[0]['harga_jual'],
            'at_ft' => 0]
        ];


        // calculate st1, st2, st3, at, bt, ct for each months.
        for ($i=1; $i <= count($fetchData); $i++) { 
            $data[$i]['st1'] = $alpha * $fetchData[$i - 1]['harga_jual'] + (1 - $alpha) * $data[$i - 1]['st1'];
            $data[$i]['st2'] = $alpha * $data[$i]['st1'] + (1 - $alpha) * $data[$i - 1]['st2'];
            $data[$i]['st3'] = $alpha * $data[$i]['st2'] + (1 - $alpha) * $data[$i - 1]['st3'];
            $data[$i]['at'] = 3 * $data[$i]['st1'] - 3 * $data[$i]['st2'] + $data[$i]['st3'];
            $data[$i]['bt'] = $alpha / (2 * (1 - $alpha) ** 2) * ((6 - 5 * $alpha) * $data[$i]['st1'] - (10 - 8 * $alpha) * $data[$i]['st2'] + (4 - 3 * $alpha) * $data[$i]['st3']);
            $data[$i]['ct'] = ($alpha ** 2 / (1 - $alpha) ** 2) * ($data[$i]['st1'] - 2 * $data[$i]['st2'] + $data[$i]['st3']);
            $data[$i+1]['forecast'] = ($data[$i]['at']) + ($data[$i]['bt'] * 1) + (0.5 * $data[$i]['ct'] * 1);
            $data[$i+1]['st1'] = 0;
            $data[$i+1]['st2'] = 0;
            $data[$i+1]['st3'] = 0;
            $data[$i+1]['at'] = 0;
            $data[$i+1]['bt'] = 0;
            $data[$i+1]['ct'] = 0;
        }

        // calculate forecast
        $data[1]['forecast'] = $fetchData[0]['harga_jual'];

        // price for at-ft
        $new_harga = [];
        for ($i=0; $i < count($fetchData); $i++) { 
            array_push($new_harga, $fetchData[$i]['harga_jual']);
        }

        
        // calculate at-ft, absolute at-ft
        for ($i=0; $i < count($new_harga); $i++) { 
            $data[$i + 1]['at_ft'] = round($new_harga[$i] - $data[$i + 1]['forecast']);
            $data[$i + 1]['abs_at_ft'] = abs($data[$i + 1]['at_ft']);
            $data[$i + 1]['mse_at_ft'] = abs($data[$i + 1]['at_ft'] * $data[$i + 1]['abs_at_ft']);
            $data[$i + 1]['mape_at_ft'] = abs(($new_harga[$i] - $data[$i + 1]['forecast'])/$new_harga[$i]);
        }

        $new_total = [];
        for ($i=1; $i < count($data); $i++) {
            array_push($new_total, $data[$i]);
        }
        $new_total = array_combine(range(1, count($new_total)), array_values($new_total));
        $new_harga = array_combine(range(1, count($new_harga)), array_values($new_harga));

        $total = [];

        array_walk_recursive($new_total, function($item, $key) use (&$total) {
            $total[$key] = isset($total[$key]) ? $item + $total[$key] : $item;
        });

        $total['mape'] = 100/$bulan*$total['mape_at_ft'];
        $total['mse'] = round($total['mse_at_ft']/$bulan);
        $total['mad'] = $total['at_ft']/$bulan;

        for ($i = 1;$i < count($new_total); $i++) {
            array_push($new_total[$i], $new_harga[$i]);
        };

        $data['title'] = 'Peramalan';
        
        $last = array_pop($new_total);
        $last[0] = 0;
        array_push($new_total, $last);

        $new_total[1]['at'] = 0;
        $new_total[1]['bt'] = 0;
        $new_total[1]['ct'] = 0;
        $send_data['tahun'] = $tahun;
        $send_data['data_bulanan'] = $new_total;
        $send_data['total'] = $total;
        $send_data['title'] = 'Grafik';

        // return dd($send_data);
        $dates = $query
        ->select('tanggal')
        ->findAll();

        $data['title'] = 'Grafik';
        $data['grafik'] = $send_data['data_bulanan'];
        $data['alpha'] = $alpha;
        $data['dates'] = $dates;


        // return dd($data['grafik']);

        return view('pages/prediksi/grafik/grafik', $data);
    }
}

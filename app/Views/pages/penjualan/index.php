<?= $this->extend('layouts/main') ?>

<?= $this->section('header') ?>
<div class="col-sm-12">
    <h3 class="mt-3 text-center">Menu Data Penjualan Ayam</h3>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <?php if (!empty(session()->getFlashdata('success'))) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <div class="">
        <a class="btn btn-primary" href="<?= site_url('/penjualan/tambah') ?>">Tambah Data</a>
    </div>
    <table class="table m-3">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Jenis</th>
                <th scope="col">Harga Jual</th>
                <th scope="col">Tanggal Penjualan</th>
                <th scope="col">Stok</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($penjualan as $data) : ?>
                <tr>
                    <th scope="row"><?= $data['id'] ?></th>
                    <td><?= $data['jenis'] ?></td>
                    <td>Rp. <?= $data['harga_jual'] ?></td>
                    <td><?= $data['tanggal'] ?></td>
                    <td><?= $data['bibit_terjual'] ?></td>
                    <td><a class="btn btn-sm btn-warning" href="<?= site_url('/penjualan/edit/' . $data['id']) ?>">Edit</a> | <a class="btn btn-sm btn-danger" onclick="confirm('Yakin ingin menghapus?')" href="<?= site_url('/penjualan/hapus/' . $data['id']) ?>">Delete</a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
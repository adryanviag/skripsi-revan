<?= $this->extend('layouts/main') ?>

<?= $this->section('header') ?>
<div class="col-sm-12">
    <h3 class="mt-3 text-center">Data Bibit Ayam</h3>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <form action="<?= site_url('/data-ayam/tambah') ?>" method="POST">
        <?= csrf_field() ?>
        <?php if (!empty(session()->getFlashdata('error'))) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Form Tidak Boleh Kosong!
            </div>
        <?php endif; ?>
        <div class="card mb-3">
            <div class="card-header">
                Tambah Data Bibit Ayam
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input name="jenis" type="text" class="form-control" id="floatingInputGrid" placeholder="Jenis">
                            <label for="floatingInputGrid">Jenis</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input name="tanggal" type="date" class="form-control" id="floatingInputGrid">
                            <label for="floatingInputGrid">Tanggal</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input name="jml_stok" type="number" class="form-control" id="floatingInputGrid" placeholder="Stok">
                            <label for="floatingInputGrid">Stok</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md">
                        <button class="btn btn-primary" type="submit">Tambah Data</button>
                        <a class="btn btn-danger" href="<?= site_url('/data-ayam') ?>">Batal</a>
                    </div>
                </div>
            </div>
            <img style="width:100%;height:450px;" src="<?= site_url('/img/IMG_3666.jpeg') ?>" class="card-img-bottom" alt="...">
        </div>


    </form>
</div>
<?= $this->endSection() ?>
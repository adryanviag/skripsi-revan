<?= $this->extend('layouts/main') ?>

<?= $this->section('header') ?>
<div class="col-sm-12">
    <h3 class="mt-3 text-center">Peramalan Harga</h3>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (!empty(session()->getFlashdata('error_simpan'))) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error_simpan'); ?>
    </div>
<?php endif; ?>
<?php if (!empty(session()->getFlashdata('success_simpan'))) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success_simpan'); ?>
    </div>
<?php endif; ?>
<div class="card mb-3">
    <div class="card-header">
        Simpan Data Peramalan
    </div>
    <div class="card-body">
        <form method="POST" action="<?= site_url('/prediksi/hitung') ?>">
            <?= csrf_field() ?>
            <div class="row g-2">
                <div class="col-md">
                    <select class="form-select" name="alpha" aria-label="Default select example">
                        <option disabled selected>Pilih Alpha</option>
                        <option value="0.1">0.1</option>
                        <option value="0.2">0.2</option>
                        <option value="0.3">0.3</option>
                        <option value="0.4">0.4</option>
                        <option value="0.5">0.5</option>
                        <option value="0.6">0.6</option>
                        <option value="0.7">0.7</option>
                        <option value="0.8">0.8</option>
                        <option value="0.9">0.9</option>
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md">
                    <button class="btn btn-primary" type="submit">Simpan Data</button>
                    
                    <a class="btn btn-danger" href="<?= site_url('/') ?>">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php if (!empty(session()->getFlashdata('error'))) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>
<?php if (!empty(session()->getFlashdata('success'))) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>
<div class="card mb-3">
    <div class="card-header">
        Lihat Hasil Peramalan
    </div>
    <div class="card-body">
        <form method="POST" action="<?= site_url('/prediksi/lihat') ?>">
            <?= csrf_field() ?>
            <div class="row g-2">
                <div class="col-md">
                    <select class="form-select" name="alpha" aria-label="Default select example">
                        <option disabled selected>Pilih Alpha</option>
                        <option value="0.1">0.1</option>
                        <option value="0.2">0.2</option>
                        <option value="0.3">0.3</option>
                        <option value="0.4">0.4</option>
                        <option value="0.5">0.5</option>
                        <option value="0.6">0.6</option>
                        <option value="0.7">0.7</option>
                        <option value="0.8">0.8</option>
                        <option value="0.9">0.9</option>
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md">
                    <button class="btn btn-primary" type="submit">Lihat Hasil</button>
                    
                    <a class="btn btn-danger" href="<?= site_url('/') ?>">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    $('#dropdownYear').each(function() {

        var year = (new Date()).getFullYear();
        var current = year;
        year = year - 1;
        for (var i = 0; i < 3; i++) {
            $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
        }

    })
</script>

<?= $this->endSection() ?>
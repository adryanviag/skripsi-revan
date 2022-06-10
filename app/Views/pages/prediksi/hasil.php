<?= $this->extend('layouts/main') ?>

<?= $this->section('header') ?>
<div class="col-sm-12">
    <h3 class="mt-3 text-center">Peramalan Harga</h3>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card mb-3">
    <div class="card-header">
        Hasil Peramalan
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Tahun</th>
                    <th scope="col">Bulan</th>
                    <th scope="col">Harga Jual</th>
                    <th scope="col">S't</th>
                    <th scope="col">S''t</th>
                    <th scope="col">S'''t</th>
                    <th scope="col">At</th>
                    <th scope="col">Bt</th>
                    <th scope="col">Ct</th>
                    <th scope="col">Forecast</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_bulanan as $data => $val) : ?>
                    <tr>
                        <?php if ($data > 12) { ?>
                            <th scope="row"><?= $tahun + 1 ?></th>
                            <td><?= $data - 12 ?></td>
                        <?php } else { ?>
                            <th scope="row"><?= $tahun ?></th>
                            <td><?= $data ?></td>
                        <?php } ?>
                        <td><?= $val[0] ?></td>
                        <td><?= $val['st1'] ?></td>
                        <td><?= $val['st2'] ?></td>
                        <td><?= $val['st3'] ?></td>
                        <td><?= $val['at'] ?></td>
                        <td><?= $val['bt'] ?></td>
                        <td><?= $val['ct'] ?></td>
                        <td><?= $val['forecast'] ?></td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <td colspan="10"></td>
                </tr>
                <tr>
                    <td colspan="9"></td>
                    <th>MAPE</th>
                </tr>
                <tr>
                    <td colspan="9"></td>
                    <td><?= $total['mape'] ?> %</td>
                </tr>
            </tbody>
        </table>
        <a href="/prediksi" class="btn btn-primary">Kembali</a>
    </div>
</div>
<?= $this->endSection() ?>
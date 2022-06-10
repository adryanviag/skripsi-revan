<?= $this->extend('layouts/main') ?>

<?= $this->section('header') ?>
<div class="col-sm-12">
    <h3 class="mt-3 text-center">Grafik Peramalan Harga</h3>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <canvas id="myChart" width="100" height="60"></canvas>
    <a href="/grafik" class="btn btn-primary">Kembali</a>
</div>

<script>
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['2021-01', '2021-02', '2021-03', '2021-04', '2021-05', '2021-06', '2021-07', '2021-08', '2021-09', '2021-10', '2021-11', '2021-12', '2022-01', '2022-02', '2022-03', '2022-04', '2022-05', '2022-06'],
            datasets: [{
                label: 'Grafik Peramalan Harga dengan alpha <?= $alpha; ?>',
                data: [<?php foreach($grafik as $key => $value) { echo '"' . $value['forecast'] . '", '; } ?>],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
<?= $this->endSection() ?>
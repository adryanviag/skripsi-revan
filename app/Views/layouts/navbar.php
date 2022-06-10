<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link <?php if ($title === 'Dashboard') {
                              echo 'active';
                            }  ?>" aria-current="page" href="/">

          Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if ($title === 'Data Bibit Ayam') {
                              echo 'active';
                            }  ?>" href="<?= site_url('data-ayam') ?>">

          Data Bibit Ayam
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if ($title === 'Data Penjualan Ayam') {
                              echo 'active';
                            }  ?>" href="<?= site_url('penjualan') ?>">
          <span data-feather="shopping-cart"></span>
          Data Penjualan Ayam
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if ($title === 'Peramalan') {
                              echo 'active';
                            }  ?>" href="<?= site_url('prediksi') ?>">

          Peramalan
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if ($title === 'Grafik') {
                              echo 'active';
                            }  ?>" href="<?= site_url('grafik') ?>" href="/grafik">
          <span data-feather="bar-chart-2"></span>
          Grafik Peramalan
        </a>
      </li>
    </ul>
  </div>
</nav>
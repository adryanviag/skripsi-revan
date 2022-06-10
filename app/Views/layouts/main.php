<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/navbar') ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <?= $this->renderSection('header') ?>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

</main>

<?= $this->include('layouts/footer') ?>
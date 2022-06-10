<?= $this->extend('layouts/main') ?>

<?= $this->section('header') ?>
<div class="col-sm-12">
    <h3 class="mt-3 text-center">SELAMAT DATANG</h3>
    <h6 class="text-center">Di Sistem Informasi Peramalan Harga Jual Ayam Buras Agung Farm</h6>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div id="googleMap" style="width: 500px; height: 500px; margin-left: 20 rem"></div>
    <div id="carouselExampleIndicators" class="carousel slide m-4" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img style="width:100%;height:500px;" src="<?= site_url('/img/IMG_3666.jpeg') ?>" class="d-block" alt="...">
            </div>
            <div class="carousel-item">
                <img style="width:100%;height:500px;" src="<?= site_url('/img/IMG_3668.jpeg') ?>" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img style="width:100%;height:500px;" src="<?= site_url('/img/IMG_3684.jpeg') ?>" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img style="width:100%;height:500px;" src="<?= site_url('/img/IMG_3698.jpeg') ?>" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<script>
    function loadMap() {
        var center = {
            lat: 0.4435557695699461,
            lng: 101.41294268369924
        };

        var mapProp = {
            center: new google.maps.LatLng(center),
            zoom: 18,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
        const marker = new google.maps.Marker({
            position: center,
            map: map,
        });
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1oZt3zQJPzmzRf4hnGYPpdRjUNVUy 
  BaY&callback=loadMap&v=weekly" async></script>
<?= $this->endSection() ?>
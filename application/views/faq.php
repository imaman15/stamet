<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- meta SEO -->
    <meta name="description" content="Sistem Layanan Informasi dan Jasa Meteorologi | Stasiun Meteorologi Kelas I  Maritim Serang">
    <meta name="keywords" content="Informasi Cuaca, Layanan Informasi, Layanan Jasa, Layanan Informasi dan Jasa, Meteorologi, Informasi Meteorologi, Jasa Meteorologi">
    <meta name="author" content="Stasiun Meteorologi Klas I Maritim Serang">
    <!-- favicon -->
    <link rel="shortcut icon" href="<?= base_url('') ?>assets/img/favicon.ico" type="image/x-icon">

    <title>
        <?php
        $var = ($title) ? $title . " | " : "";
        echo $var . "Sistem Informasi Pelayanan Jasa Meteorologi";
        ?>
    </title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets') ?>/img/favicon.ico" type="image/x-icon">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/vendor/bootstrap/css/bootstrap.min.css">
    <!-- My Css -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/my-css.css">

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets') ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets'); ?>/vendor/jquery/jquery.min.js"></script>

</head>

<body>
    <div class="container" style="margin-top: 6%;">
        <div class="card my-5 card-signin">
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="<?= base_url('assets') ?>/img/bmkg.png" alt="BMKG" class="img-fluid img-thumbnail">
                    <h5>STAMET KELAS I MARITIM SERANG</h5>
                    <h1 class="subtitle">Sistem Informasi Pelayanan Jasa Meteorologi</h1>
                </div>

                <!-- <h2 class="text-center font-weight-light">FAQ</h2> -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $url ?>" class="btn btn-sm btn-dark">Kembali</a></li>
                        <li class="breadcrumb-item active my-auto" aria-current="page">FAQS</li>
                    </ol>
                </nav>

                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    1. Apa itu Sistem Informasi Layanan dan Jasa Meteorologi?
                                </button>
                            </h2>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    2. Apa yang bisa didapatkan pengguna dari Website Layanan Data Online?
                                </button>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
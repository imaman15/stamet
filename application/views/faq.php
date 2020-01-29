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
    <?php
    // header("X-XSS-Protection: 0");
    ?>
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
                    <?php
                    $no = 0;
                    foreach ($faqs as $f) :
                        $no++;
                    ?>
                        <div class="card">
                            <div class="card-header" id="heading<?= $no ?>">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?= $no ?>" aria-expanded="<?= ($no == 1) ? "true" : null; ?>" aria-controls="collapse<?= $no ?>">
                                        <?= $no ?>. <?= $f['faqs_questions'] ?>?
                                    </button>
                                </h2>
                            </div>

                            <div id="collapse<?= $no ?>" class="collapse <?= ($no == 1) ? "show" : null; ?>" aria-labelledby="heading<?= $no ?>" data-parent="#accordionExample">
                                <div class="card-body">
                                    <?= $f['faqs_answers'] ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script text="text/javascript">
        $('.card-body img').addClass('img-responsive img-thumbnail');
        $('.card-body iframe').addClass('embed-responsive-item');
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- meta SEO -->
    <meta name="description" content="<?= META_DESCRIPTION ?>">
    <meta name="keywords" content="<?= META_KEYWORDS ?>">
    <meta name="author" content="<?= META_AUTHOR ?>">
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

    <?php echo $this->recaptcha->getScriptTag(); // javascript recaptcha 
    ?>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets'); ?>/vendor/jquery/jquery.min.js"></script>
</head>

<body class="mt-4">
    <?= $content; ?>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets'); ?>/js/sb-admin-2.min.js"></script>

</body>

</html>
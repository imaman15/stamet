<!DOCTYPE html>
<html lang="en">

<head>
    <?= $head ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="<?= base_url() ?>assets/img/bmkg.png" alt="BMKG" class="img-fluid border-0 img-thumbnail rounded-circle" width="52">
                </div>
                <div class="sidebar-brand-text ml-2">
                    <div class="font-weight-bolder mb-n1" style="font-size:24px; letter-spacing: 5px;">STAMET</div>
                    <div class="text-capitalize font-weight-normal" style="font-size:11px">Kelas I Maritim Serang</div>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link hvr-wobble-horizontal" href="<?= site_url() ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Beranda</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Data Meteorologi
            </div>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link hvr-wobble-horizontal" href="#">
                    <i class="fas fa-fw fa-smog"></i>
                    <span>Data Harian</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link hvr-wobble-horizontal" id="link" href="#">
                    <i class="fas fa-fw fa-poo-storm"></i>
                    <span>Data Ekstrem</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link hvr-wobble-horizontal" href="#">
                    <i class="fas fa-fw fa-mountain"></i>
                    <span>Data Gempa Bumi</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link hvr-wobble-horizontal" href="#">
                    <i class="fas fa-fw fa-money-bill-wave"></i>
                    <span>Data Berbayar</span></a>
            </li>

            <!-- Heading -->
            <div class="sidebar-heading">
                Informasi
            </div>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link hvr-wobble-horizontal" href="#">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Konsultasi Data</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link hvr-wobble-horizontal" href="#">
                    <i class="fa fa-fw fa-question-circle"></i>
                    <span>FAQ</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <span class="ml-auto d-none d-lg-inline text-gray-800 font-weight-bold text-lg"> Sistem Informasi Pelayanan Jasa Meteorologi </span>
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle hvr-wobble-horizontal" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="mr-2 img-profile rounded-circle" src="<?= base_url('assets/img/profil/') . $user->photo; ?>">
                                <span class="d-none d-lg-inline text-gray-600 small"><?php secho(ucfirst($user->first_name . " " . $user->last_name)) ?></span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= site_url(UA_EDITPROFILE) ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Edit Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= site_url(UA_CHANGEPASSWORD) ?>">
                                    <i class="fas fa-fw fa-key mr-2 text-gray-400"></i>
                                    Ganti Kata Sandi
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Keluar
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <?= $content; ?>

            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; SIPJAMET <?= cr() ?> </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" di bawah ini jika Anda ingin mengakhiri sesi Anda saat ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= site_url(UA_LOGOUT) ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?= $jsbody; ?>

</body>

</html>
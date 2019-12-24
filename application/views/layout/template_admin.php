<!DOCTYPE html>
<html lang="en">

<head>
    <?= $head ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="<?= base_url() ?>assets/img/bmkg.png" alt="BMKG" class="img-fluid border-0 img-thumbnail rounded-circle" width="52">
                </div>
                <div class="sidebar-brand-text mx-3">
                    <div>STAMET</div>
                    <div class="small text-capitalize">Kelas I Serang</div>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link hvr-wobble-horizontal" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Pelayanan
            </div>

            <!-- Nav Item - Data/Informasi -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#dataInformasi" aria-expanded="true" aria-controls="dataInformasi">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Data / Informasi</span>
                </a>
                <div id="dataInformasi" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Data / Informasi :</h6>
                        <a class="collapse-item hvr-wobble-horizontal" href="#">Form Permintaan</a>
                        <a class="collapse-item hvr-wobble-horizontal" href="#">Konfirmasi Permintaan</a>
                        <a class="collapse-item hvr-wobble-horizontal" href="#">Cek Pemabayaran</a>
                        <a class="collapse-item hvr-wobble-horizontal" href="#">Berkas Pengantar</a>
                        <a class="collapse-item hvr-wobble-horizontal" href="#">Berkas Data/Informasi</a>
                        <a class="collapse-item hvr-wobble-horizontal" href="#">Riwayat Permintaan</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link hvr-wobble-horizontal" href="#">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Konsultasi Data</span></a>
            </li>

            <!-- Nav Item - Data/Informasi -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#kunjungan" aria-expanded="true" aria-controls="kunjungan">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Kunjungan</span>
                </a>
                <div id="kunjungan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Kunjungan :</h6>
                        <a class="collapse-item hvr-wobble-horizontal" href="#">Konfirmasi Kunjungan</a>
                        <a class="collapse-item hvr-wobble-horizontal" href="#">Jadwal Kunjungan</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Hubungan Pengguna
            </div>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link hvr-wobble-horizontal" href="#">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Survei Pelanggan</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link hvr-wobble-horizontal" href="#">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Kritik & Saran</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link hvr-wobble-horizontal" href="#">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Komplain</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link hvr-wobble-horizontal" href="#">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Pesan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Manajemen
            </div>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link hvr-wobble-horizontal" href="#">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Data Anggota</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link hvr-wobble-horizontal" href="#">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Data Pegawai</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link hvr-wobble-horizontal" href="#">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Data Jenis Permintaan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Heading -->
            <div class="sidebar-heading">
                Pengaturan
            </div>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link hvr-wobble-horizontal" href="#">
                    <i class="fa fa-fw fa-question-circle"></i>
                    <span>Pengaturan</span></a>
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
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle hvr-wobble-horizontal" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle hvr-wobble-horizontal" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Imam</span>
                                <img class="img-profile rounded-circle" src="<?= base_url('assets/img/profil/default.png') ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item hvr-wobble-horizontal" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Akun Saya
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item hvr-wobble-horizontal" href="#" data-toggle="modal" data-target="#logoutModal">
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
                        <span>Copyright &copy; SIPJAMET <?= date('Y') ?></span>
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
                    <a class="btn btn-primary" href="<?= base_url(UA_LOGOUT) ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?= $jsbody; ?>

</body>

</html>
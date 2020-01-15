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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url(UE_ADMIN) ?>">
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
            <li class="nav-item <?= ($this->uri->uri_string() ==  UE_ADMIN) ? "active" : NULL; ?>">
                <a class="nav-link hvr-wobble-horizontal" href="<?= site_url(UE_ADMIN) ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <?php if (dAdmin()->level == 1 || dAdmin()->level == 3) : ?>

                <!-- Heading -->
                <div class="sidebar-heading">
                    Pelayanan
                </div>

                <!-- Nav Item - Data/Informasi -->
                <!-- Nav Item - Tables -->
                <li class="nav-item <?= ($this->uri->uri_string() == UE_TRANSACTION) ? "active" : NULL; ?>">
                    <a class="nav-link hvr-wobble-horizontal" href="<?= site_url(UE_TRANSACTION) ?>">
                        <i class="fas fa-fw fa-clipboard-list"></i>
                        <span>Transaksi Data</span></a>
                </li>

                <!-- Nav Item - Tables -->
                <li class="nav-item <?= ($this->uri->uri_string() == UE_SCHEDULE) ? "active" : NULL; ?>">
                    <a class="nav-link hvr-wobble-horizontal" href="<?= site_url(UE_SCHEDULE) ?>">
                        <i class="fas fa-fw far fa-handshake"></i>
                        <span>Jadwal Pertemuan</span></a>
                </li>

                <!-- Nav Item - Tables -->
                <li class="nav-item <?= ($this->uri->uri_string() == UE_REQTYPE) ? "active" : NULL; ?>">
                    <a class="nav-link hvr-wobble-horizontal" href="<?= site_url(UE_REQTYPE) ?>">
                        <i class="fas fa-fw fa-th-list"></i>
                        <span>Jenis Permintaan</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

            <?php endif; ?>

            <?php if (dAdmin()->level == 1 || dAdmin()->level == 2) : ?>
                <!-- Heading -->
                <div class="sidebar-heading">
                    Hubungan Pengguna
                </div>

                <!-- Nav Item - Tables -->
                <li class="nav-item <?= ($this->uri->uri_string() == UE_RATINGS) ? "active" : NULL; ?>">
                    <a class="nav-link hvr-wobble-horizontal" href="<?= site_url(UE_RATINGS) ?>">
                        <i class="fas fa-fw fa-star"></i>
                        <span>Survei Pelanggan</span></a>
                </li>

                <li class="nav-item <?= ($this->uri->uri_string() == UE_CANDS) ? "active" : NULL; ?>">
                    <a class="nav-link hvr-wobble-horizontal" href="<?= site_url(UE_CANDS) ?>">
                        <i class="fas fa-fw fa-comment-alt"></i>
                        <span>Kritik & Saran</span></a>
                </li>

                <li class="nav-item <?= ($this->uri->uri_string() == UE_COMPLAINT) ? "active" : NULL; ?>">
                    <a class="nav-link hvr-wobble-horizontal" href="<?= site_url(UE_COMPLAINT) ?>">
                        <i class="fas fa-fw fa-comment-slash"></i>
                        <span>Komplain</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

            <?php endif; ?>

            <?php if (dAdmin()->level == 1) : ?>

                <!-- Heading -->
                <div class="sidebar-heading">
                    Manajemen
                </div>

                <!-- Nav Item - Tables -->
                <li class="nav-item <?= ($this->uri->uri_string() == UE_APPLICANT) ? "active" : NULL; ?>">
                    <a class="nav-link hvr-wobble-horizontal" href="<?= site_url(UE_APPLICANT) ?>">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Data Pengguna</span></a>
                </li>

                <!-- Nav Item - Tables -->
                <li class="nav-item <?= ($this->uri->uri_string() == UE_EMPLOYEE) ? "active" : NULL; ?>">
                    <a class="nav-link hvr-wobble-horizontal" href="<?= site_url(UE_EMPLOYEE) ?>">
                        <i class="fas fa-fw fa-user-tie"></i>
                        <span>Data Pegawai</span></a>
                </li>

                <!-- Nav Item - Tables -->
                <li class="nav-item <?= ($this->uri->uri_string() == UE_JOBCAT) ? "active" : NULL; ?>">
                    <a class="nav-link hvr-wobble-horizontal" href="<?= site_url(UE_JOBCAT) ?>">
                        <i class="fas fa-fw fa-chalkboard-teacher"></i>
                        <span>Kategori Pekerjaan</span></a>
                </li>

                <!-- Nav Item - Tables -->
                <li class="nav-item <?= ($this->uri->uri_string() == UE_POSITION) ? "active" : NULL; ?>">
                    <a class="nav-link hvr-wobble-horizontal" href="<?= site_url(UE_POSITION) ?>">
                        <i class="fas fa-fw fa-briefcase"></i>
                        <span>Data Jabatan</span></a>
                </li>

                <!-- Nav Item - Tables -->
                <li class="nav-item <?= ($this->uri->uri_string() == UE_MANAGEFAQ) ? "active" : NULL; ?>">
                    <a class="nav-link hvr-wobble-horizontal" href="<?= site_url(UE_MANAGEFAQ) ?>">
                        <i class="fas fa-fw fa-question-circle"></i>
                        <span>FAQ</span></a>
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
                        <span>Email</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link hvr-wobble-horizontal" href="#">
                        <i class="fa fa-fw fa-question-circle"></i>
                        <span>Rekening</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

            <?php endif; ?>

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

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle hvr-wobble-horizontal" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="mr-2 img-profile rounded-circle" src="<?= base_url('assets/img/profil/') . dAdmin()->photo; ?>">
                                <span class="d-none d-lg-inline text-gray-600 small"><?php secho(ucfirst(dAdmin()->first_name . " " . dAdmin()->last_name)) ?></span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= site_url(UE_EDITPROFILE) ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Edit Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= site_url(UE_CHANGEPASSWORD) ?>">
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
                        <span>Copyright &copy; SIPJAMET <?= cr() ?></span>
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
                    <a class="btn btn-primary" href="<?= base_url(UE_LOGOUT) ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?= $jsbody; ?>

</body>

</html>
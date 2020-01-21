<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <?= $this->session->flashdata('message');
  ?>

  <!-- Content Row -->
  <div class="row animated zoomIn fast">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengguna</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $countApplicant ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pegawai</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $countEmployee ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user-tie fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Transaksi</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Transaksi Selesai</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Row -->


  <!-- Profile -->
  <div class="row animated zoomIn fast">

    <!-- User Data -->
    <div class="col-xl-4 col-lg-5">
      <div class="card shadow mb-3 ">
        <img src="<?= base_url('assets/img/bg-profil.png') ?>" class="card-img-top profil" alt="...">
        <div class="card-body text-center">
          <img src="<?= base_url('assets/img/profil/' . $user->photo) ?>" class="card-img img-thumbnail rounded-circle foto-profil" alt="...">
          <h4 class="card-title text-primary font-weight-bold mt-3"><?php secho(ucfirst($user->first_name . ' ' . $user->last_name)) ?></h4>
          <ul class="fa-ul text-left">
            <li class="mb-2">
              <span class="fa-li text-primary"><i class="far fa-clock"></i></span>
              Anggota sejak <?= timeIDN(date('Y-m-d', $user->date_created)) ?>
            </li>
            <li class="mb-2">
              <span class="fa-li text-primary"><i class="fas fa-id-badge"></i></span>
              <?php secho(ucfirst($user->csidn)) ?>
            </li>
            <li class="mb-2">
              <span class="fa-li text-primary"><i class="fas fa-home"></i></span>
              <?php secho(ucfirst($user->address)) ?>
            </li>
            <li class="mb-2">
              <span class="fa-li text-primary"><i class="fas fa-envelope"></i></span>
              <?php secho($user->email) ?>
            </li>
            <li class="mb-2">
              <span class="fa-li text-primary"><i class="fas fa-phone"></i></span>
              <?php secho($user->phone) ?>
            </li>
            <li class="mb-2">
              <span class="fa-li text-primary"><i class="fas fa-briefcase"></i></span>
              <?php secho(ucfirst($user->pos_name)) ?>
            <li class="mb-2">
              <span class="fa-li text-primary"><i class="fas fa-user-lock"></i></span>
              <?php secho(level($user->level)) ?>
            </li>
            </li>
          </ul>
        </div>
        <div class="card-footer text-muted mt-n2 small">
          Terakhir di perbarui : <?= timeInfo($user->date_update) ?>
        </div>
      </div>
    </div>

    <!-- Additional Information -->
    <div class="col-xl-8 col-lg-7">

      <div class="card shadow text-center mb-4">
        <div class="card-header">
          Transaksi Data Hari ini
        </div>
        <div class="card-body">
          <h5 class="card-title">Special title treatment</h5>
          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        </div>
        <div class="card-footer text-muted">
          <a href="#" class="btn btn-primary">Lihat Transaksi</a>
        </div>
      </div>

      <div class="card shadow text-center mb-4">
        <div class="card-header">
          Jadwal Pertemuan Hari ini
        </div>
        <div class="card-body">
          <h5 class="card-title">Special title treatment</h5>
          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        </div>
        <div class="card-footer text-muted">
          <a href="#" class="btn btn-primary">jadwal Pertemuan</a>
        </div>
      </div>

    </div>

    <!-- End of Profile -->
  </div>


</div>
<!-- /.container-fluid -->
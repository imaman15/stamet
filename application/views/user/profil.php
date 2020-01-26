<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <?= $this->session->flashdata('message');
  ?>

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
              <span class="fa-li text-primary"><i class="fas fa-address-card"></i></span>
              <?php secho(ucfirst($user->nin)) ?>
            </li>
            <li class="mb-2">
              <span class="fa-li text-primary"><i class="fas fa-home"></i></span>
              <?php secho(ucfirst($user->address)) ?>
            </li>
            <li class="mb-2">
              <span class="fa-li text-primary"><i class="fas fa-envelope"></i></span>
              <?php secho(ucfirst($user->email)) ?>
            </li>
            <li class="mb-2">
              <span class="fa-li text-primary"><i class="fas fa-phone"></i></span>
              <?php secho(ucfirst($user->phone)) ?>
            </li>
            <li class="mb-2">
              <span class="fa-li text-primary"><i class="fas fa-briefcase"></i></span>
              <?php secho(ucfirst($user->jobcat)) ?>
            <li class="mb-2">
              <span class="fa-li text-primary"><i class="fas fa-building"></i></span>
              <?php secho(ucfirst($user->institute)) ?>
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
          Status Transaksi
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-inverse" width="100%" cellspacing="0">
              <thead class="thead-inverse">
                <tr>
                  <th>Kode </th>
                  <th>Tanggal Transaksi</th>
                  <th>Petugas Layanan</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($transaction as $d) { ?>
                  <tr>
                    <td><?= $d->trans_code ?></td>
                    <td><?= DateTime($d->date_created) ?></td>
                    <td class="text-left">
                      <?php
                      if (isset($d->emp_name) && isset($d->emp_posname)) {
                        echo $d->emp_name . " - " . $d->emp_posname;
                      }
                      ?>
                    </td>
                    <td>

                      <a target="_blank" href="<?= site_url(UA_TRANSACTIONDETAIL . '/' . $d->trans_code) ?>">
                        <?= statusTrans($d->trans_status, 'transaction') ?>
                      </a>
                    </td>
                  </tr>
                <?php }; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="card shadow text-center mb-4">
        <div class="card-header">
          Status Jadwal Pertemuan
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-inverse" width="100%" cellspacing="0">
              <thead class="thead-inverse">
                <tr>
                  <th>Kode </th>
                  <th>Tanggal Bertemu</th>
                  <th>Penanggung jawab</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($schedule as $d) { ?>
                  <tr>
                    <td><?= $d->sch_code ?></td>
                    <td><?= DateTime($d->sch_date) ?></td>
                    <td class="text-left">
                      <?= $d->responsible_person ?>
                    </td>
                    <td>
                      <?= statusSch($d->sch_status, 'applicant', ['beranda' => 1]) ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- <div class="card-footer text-muted">
          <a href="#" class="btn btn-primary">jadwal Pertemuan</a>
        </div> -->
      </div>
    </div>

    <!-- End of Profile -->
  </div>

  <!-- Information -->
  <div class="row">

    <!-- Enf of Information -->
  </div>

</div>
<!-- /.container-fluid -->
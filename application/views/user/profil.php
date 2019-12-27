<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <?= $this->session->flashdata('message');
  ?>

  <div class="alert alert-success animated zoomIn fast" role="alert">
    <h4 class="alert-heading">Selamat Datang <b><?php secho(ucfirst($user->first_name . " " . $user->last_name)) ?></b></h4>
    <hr>
    <p class="mb-0">Silahkan Lengkapi Profil Anda</p>
  </div>
  <div class="card shadow mb-3 animated zoomIn fast" style="max-width: 540px;">
    <div class="row no-gutters">
      <div class="col-md-4 p-2 ">
        <img src="<?= base_url('assets/img/profil/') . $user->photo; ?>" class="card-img rounded-circle" alt="Imam Agustian Nugraha">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title"><?php secho(ucfirst($user->first_name)) ?></h5>
          <p class="card-text"><?php secho($user->email) ?></p>
          <p class="card-text"><small class="text-muted">Anggota sejak <?= date('d F Y', $user->date_created);  ?></small></p>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->
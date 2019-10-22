<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Selamat Datang <b><?= ucfirst($user->first_name . " " . $user->last_name) ?></b></h4>
    <hr>
    <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
  </div>
  <div class="card shadow mb-3" style="max-width: 540px;">
    <div class="row no-gutters">
      <div class="col-md-4 p-2">
        <img src="<?= base_url('assets/img/profil/default.png'); ?>" class="card-img" alt="Imam Agustian Nugraha">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title"><?= $user->first_name ?></h5>
          <p class="card-text">imamagustiannugraha@ymail.com</p>
          <p class="card-text"><small class="text-muted">Anggota sejak <?= date('d F Y', 1560151031);  ?></small></p>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->
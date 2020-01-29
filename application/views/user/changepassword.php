<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-center text-gray-800 col-lg-10 offset-lg-1"><?= $title; ?></h1>

    <div class="col-lg-9 offset-lg-1">
        <?= $this->session->flashdata('message');
        ?>
        <div class="card shadow mb-3 animated zoomIn fast">
            <div class="card-body">

                <?= form_open(UA_CHANGEPASSWORD); ?>
                <div class="form-group">
                    <label for="currentPassword">Kata Sandi Saat ini</label>
                    <input type="password" class="form-control <?= form_error('currentPassword') ? 'is-invalid' : null ?>" name="currentPassword" id="currentPassword" placeholder="Masukkan Kata Sandi Saat ini">
                    <?= form_error('currentPassword') ?>
                </div>
                <div class="form-group">
                    <label for="password">Kata Sandi Baru</label>
                    <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : null ?>" name="password" id="password" placeholder="Masukkan Kata Sandi Baru" aria-describedby="passwordHelpBlock">
                    <small id="passwordHelpBlock" class="form-text text-muted">(Kata sandi minimal 6 karakter dan berisi kombinasi dari huruf kecil, huruf besar dan angka )</small>
                    <?= form_error('password') ?>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" class="form-control <?= form_error('confirmPassword') ? 'is-invalid' : null ?>" name="confirmPassword" id="confirmPassword" placeholder=" Masukkan Konfirmasi Kata Sandi Baru">
                    <?= form_error('confirmPassword') ?>
                </div>
                <div class="form-group">
                    <div class="col-md-4 offset-md-4">
                        <button type="submit" class="btn btn-primary btn-block">Atur Ulang Kata Sandi</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
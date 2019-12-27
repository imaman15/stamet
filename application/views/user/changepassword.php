<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow mb-3 animated zoomIn fast">
        <div class="card-body row">
            <div class="col-lg-6">
                <?= $this->session->flashdata('message');
                ?>
                <?= form_open(UA_CHANGEPASSWORD); ?>
                <div class="form-group">
                    <label for="currentPassword">Kata Sandi Lama</label>
                    <input type="password" class="form-control <?= form_error('currentPassword') ? 'is-invalid' : null ?>" name="currentPassword" id="currentPassword" placeholder="Masukkan Kata Sandi Lama">
                    <?= form_error('currentPassword') ?>
                </div>
                <div class="form-group">
                    <label for="password">Kata Sandi Baru</label>
                    <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : null ?>" name="password" id="password" placeholder="Masukkan Kata Sandi Baru" aria-describedby="passwordHelpBlock">
                    <small id="passwordHelpBlock" class="form-text text-muted">(Kata sandi minimal 6 karakter dan berisi kombinasi dari huruf kecil, huruf besar, angka dan simbol !@#$%^&*()\-_=+{};:,<.>§~ )</small>
                    <?= form_error('password') ?>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" class="form-control <?= form_error('confirmPassword') ? 'is-invalid' : null ?>" name="confirmPassword" id="confirmPassword" placeholder=" Masukkan Konfirmasi Kata Sandi Baru">
                    <?= form_error('confirmPassword') ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Ganti Kata Sandi</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
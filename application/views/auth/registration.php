<div class="container">
    <div class="row">
        <div class="col-lg-12 col-xl-10 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="<?= base_url('assets') ?>/img/bmkg.png" alt="BMKG" class="img-fluid img-thumbnail">
                        <h5>STAMET KELAS I MARITIM SERANG</h5>
                        <h1 class="subtitle">Sistem Informasi Pelayanan Jasa Meteorologi</h1>
                    </div>

                    <?= $this->session->flashdata('message');
                    ?>

                    <?=
                        form_open(UA_REGISTRATION, 'class="form-signin"');
                    ?>
                    <!-- set_value untuk menyimpan inputan sebelumnya, jadi ketika ada kesalahan pengguna tidak perlu input ulang -->
                    <div class="row">
                        <div class="col-lg-6 col-md-12 border-right border-left">
                            <div class="bg-light p-2 bg-4">

                                <div class="form-label-group">
                                    <input type="text" id="first_name" name="first_name" class="form-control <?= form_error('first_name') ? 'is-invalid' : null ?>" placeholder="Nama Depan" value="<?= set_value('first_name') ?>" autofocus>
                                    <label for="first_name">Nama Depan</label>
                                    <?= form_error('first_name'); ?>
                                </div>
                                <div class="form-label-group">
                                    <input type="text" id="last_name" name="last_name" class="form-control <?= form_error('last_name') ? 'is-invalid' : null ?>" placeholder="Nama Belakang" value="<?= set_value('last_name') ?>">
                                    <label for="last_name">Nama Belakang</label>
                                    <small class="pl-3 font-weight-light d-block text-muted">(Jika tidak memiliki nama belakang kosongkan saja)</small>
                                    <?= form_error('last_name'); ?>
                                </div>

                            </div>

                            <div class="p-2 bg-4">

                                <div class="form-label-group">
                                    <input type="text" onkeypress="return numberOnly(event)" maxlength="16" id="nin" name="nin" class="form-control <?= form_error('nin') ? 'is-invalid' : null ?>" placeholder="No. Identitas (KTP)" value="<?= set_value('nin') ?>">
                                    <label for="nin">No. Identitas (KTP)</label>
                                    <?= form_error('nin'); ?>
                                </div>

                                <div class="form-label-group">
                                    <textarea class="form-control <?= form_error('address') ? 'is-invalid' : null ?>" name="address" id="address" rows=" 3" placeholder="Alamat Lengkap"><?= set_value('address') ?></textarea>
                                    <label for="address">Alamat Lengkap</label>
                                    <small class="pl-3 font-weight-light d-block text-muted"> (Alamat harus lengkap sesuai dengan No. Identitas/KTP) </small>
                                    <?= form_error('address'); ?>
                                </div>

                                <div class="form-label-group">
                                    <input type="number" id="phone" name="phone" class="form-control <?= form_error('phone') ? 'is-invalid' : null ?>" placeholder="No. Handphone" value="<?= set_value('phone') ?>">
                                    <label for="phone">No. Handphone</label>
                                    <small class="pl-3 font-weight-light d-block text-muted"> (Pastikan nomor handpone anda aktif dan gunakan nomor yang sudah terdaftar di whatsapp jika ada.) </small>
                                    <?= form_error('phone') ?>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6 col-md-12 border-left border-right">
                            <div class="p-2 bg-4">
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text bs-4" for="job_category">Kategori Pekerjaan</label>
                                    </div>
                                    <select class="custom-select bs-4 <?= form_error('job_category') ? 'is-invalid' : null ?>" id="job_category" name="job_category" style="height: 50px">
                                        <option value="">Pilih...</option>
                                        <?php foreach ($user->result() as $u) : ?>
                                            <option value="<?= $u->jobcat_id; ?>" <?= (set_value("job_category") == $u->jobcat_id) ? "selected" : null; ?>><?= $u->jobcat ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group">
                                        <?= form_error('job_category') ?>
                                    </div>
                                </div>

                                <div class="form-label-group">
                                    <input type="text" id="institute" name="institute" class="form-control <?= form_error('institute') ? 'is-invalid' : null ?>" placeholder="Nama Instansi" value="<?= set_value('institute') ?>">
                                    <label for="institute">Nama Instansi</label>
                                    <small class="pl-3 font-weight-light d-block text-muted">(Nama Instansi / Nama Perusahaan / Nama Sekolah / Nama Universitas)</small>
                                    <?= form_error('institute') ?>
                                </div>

                                <div class="form-label-group">
                                    <input type="email" id="email" name="email" class="form-control <?= form_error('email') ? 'is-invalid' : null ?>" placeholder="Email" value="<?= set_value('email') ?>">
                                    <label for="email">Email</label>
                                    <small class="pl-3 font-weight-light d-block text-muted"> ( Pastikan email Anda aktif. Kami akan mengirimkan email untuk mengaktifkan akun Anda.) </small>
                                    <?= form_error('email') ?>
                                </div>

                            </div>

                            <div class="bg-light p-2 bg-4">

                                <div class="form-label-group">
                                    <input type="password" id="password" name="password" class="form-control <?= form_error('password') ? 'is-invalid' : null ?>" placeholder="Kata Sandi">
                                    <label for="password">Kata Sandi</label>
                                    <small class="pl-3 font-weight-light d-block text-muted">(Kata sandi minimal 6 karakter dan berisi kombinasi dari huruf kecil, huruf besar dan angka)</small>
                                    <?= form_error('password') ?>
                                </div>
                                <div class="form-label-group">
                                    <input type="password" id="confirmPassword" name="confirmPassword" class="form-control <?= form_error('confirmPassword') ? 'is-invalid' : null ?>" placeholder="Konfrimasi Kata Sandi">
                                    <label for="confirmPassword">Konfirmasi Kata Sandi</label>
                                    <?= form_error('confirmPassword') ?>
                                </div>

                            </div>

                        </div>

                        <div class="form-group mx-auto my-3">
                            <div class="alert alert-info bg-4">
                                Untuk mendukung manajemen pengguna layanan Data Online BMKG dalam rangka meningkatkan layanan, pendaftar harus memberikan informasi data diri secara benar dan memperbarui data diri ketika terdapat perubahan. <br>
                                Informasi pendaftar bersifat rahasia sehingga harus dilindungi dan hanya boleh dimanfaatkan untuk peningkatan layanan Data Online. <br><br>
                                Khusus untuk tujuan penelitian, pengguna harus menyertakan referensi data yang didapatkan dari Data Online.
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkme" name="checkme" required>
                                <label class="form-check-label" for="checkme">
                                    Saya telah membaca dan menyetujui ketentuan Pendaftaran Akun Data Online
                                </label>
                            </div>
                            <div class="form-group mt-3">
                                <?php echo $captcha // tampilkan recaptcha 
                                ?>
                                <?= form_error('g-recaptcha-response') ?>
                            </div>
                        </div>

                        <button class="btn btn-lg btn-primary text-uppercase btn-block mx-lg-5" type="submit" id="btnsubmit" disabled>Daftar</button>
                    </div>

                    <div class="text-center mt-2">
                        <a class="small" href="<?= site_url(UA_LOGIN) ?>">Sudah punya akun ? Masuk</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="<?= site_url(UA_FORGOTPASSWORD) ?>">Lupa Password ?</a>
                    </div>
                    <?=
                        form_close();
                    ?>

                    <hr class="my-3">
                    <div class="text-center small blue">
                        <a href="<?= site_url(FAQ); ?>">FAQ</a>
                        |
                        <a href="<?= site_url(CHECKSTATUS); ?>">Cek Status</a>
                    </div>

                    <!-- Footer -->
                    <footer class="sticky-footer bg-white">
                        <div class="container">
                            <div class="copyright text-center small">
                                <span>Copyright &copy; SIPJAMET <?= cr() ?> </span>
                            </div>
                        </div>
                    </footer>
                    <!-- End of Footer -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#checkme').click(function() {
        if ($(this).is(':checked')) {
            $('#btnsubmit').removeAttr('disabled');
        } else {
            $('#btnsubmit').attr('disabled', 'disabled');
        }
    });
</script>

<script>
    function numberOnly(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))

            return false;
        return true;
    }
</script>
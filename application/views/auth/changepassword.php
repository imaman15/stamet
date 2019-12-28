<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="<?= base_url('assets') ?>/img/bmkg.png" alt="BMKG" class="img-fluid img-thumbnail">
                        <h5>STAMET KELAS I MARITIM SERANG</h5>
                        <h1 class="subtitle">Sistem Informasi Pelayanan Jasa Meteorologi</h1>
                        <span class="text-center font-weight-normal"> Atur Ulang kata sandi Anda untuk :</span>
                        <span class="text-center font-weight-light"><?= $this->session->userdata('reset_email'); ?></span>
                    </div>

                    <?= $this->session->flashdata('message');
                    ?>

                    <?= form_open(site_url('auth/changepassword'), 'class="form-signin"'); ?>

                    <div class="form-label-group">
                        <input type="password" name="password" id="password" class="form-control" value="<?= set_value('password') ?>" placeholder="Masukkan Kata Sandi Baru" required autofocus>
                        <label for="password">Masukkan Kata Sandi Baru</label>
                        <small class="pl-3 font-weight-light d-block text-muted">(Kata sandi minimal 6 karakter dan berisi kombinasi dari huruf kecil, huruf besar, angka dan simbol !@#$%^&*()\-_=+{};:,<.>§~ )</small>
                        <?= form_error('password') ?>
                    </div>
                    <div class="form-label-group">
                        <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" value="<?= set_value('confirmPassword') ?>" placeholder="Masukkan Kata Sandi">
                        <label for="confirmPassword">Konfirmasi Kata Sandi</label>
                        <?= form_error('confirmPassword') ?>
                    </div>

                    <div class="form-group mt-3">
                        <?=
                            $captcha // tampilkan recaptcha
                        ?>
                        <?=
                            form_error('g-recaptcha-response')
                        ?>
                    </div>

                    <button class="btn btn-primary btn-block text-uppercase" type="submit">Atur Ulang Kata Sandi</button>
                    <?=
                        form_close();
                    ?>
                    <hr class="my-3">
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
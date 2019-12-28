<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="<?= base_url('assets') ?>/img/bmkg.png" alt="BMKG" class="img-fluid img-thumbnail">
                        <h5>STAMET KELAS I MARITIM SERANG</h5>
                        <h1 class="subtitle">Sistem Informasi Pelayanan Jasa Meteorologi</h1>
                        <span class="text-center font-weight-normal"> Masukkan alamat email yang dulu Anda daftarkan. Kami akan mengirimi tautan untuk mereset kata sandi anda melalui email.</span>
                    </div>

                    <?= $this->session->flashdata('message');
                    ?>

                    <?= form_open(UA_FORGOTPASSWORD, 'class="form-signin"'); ?>

                    <div class="form-label-group">
                        <input type="email" name="email" id="email" class="form-control" value="<?= set_value('email') ?>" placeholder="Email" required autofocus>
                        <label for="email">Email</label>
                        <?= form_error('email') ?>
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

                    <div class="text-center small mt-2">
                        <a href="<?= site_url(UA_LOGIN) ?>">Kembali untuk Masuk</a>
                    </div>

                    <hr class="my-3">

                    <div class="text-center small blue">
                        <a href="<?= site_url(UA_FAQ) ?>">FAQ</a>
                        |
                        <a href="<?= site_url(UA_CHECKSTATUS) ?>">Cek Status</a>
                    </div>

                    <?=
                        form_close();
                    ?>

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
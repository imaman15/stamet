<div class="container">
    <div class="row">
        <div class="col-lg-5 mx-auto">
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
                        form_open(UA_LOGIN, 'class="form-signin"');
                    ?>
                    <div class="form-label-group">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" autofocus value="<?= set_value('email') ?>">
                        <label for="email">Email</label>
                        <?= form_error('email') ?>
                    </div>

                    <div class="form-label-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Kata Sandi">
                        <label for="password">Kata Sandi</label>
                        <?= form_error('password') ?>
                    </div>

                    <!-- <div class="form-group mt-3">
                        <?=
                            $captcha // tampilkan recaptcha
                        ?>
                        <?=
                            form_error('g-recaptcha-response')
                        ?>
                    </div> -->

                    <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Masuk</button>

                    <div class="text-center small mt-2">
                        <a href="<?= site_url(UA_FORGOTPASSWORD) ?>">Lupa Password ?</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="<?= site_url(UA_REGISTRATION) ?>">Belum punya akun ? Daftar</a>
                    </div>

                    <hr class="my-3">

                    <div class="text-center small blue">
                        <a href="<?= site_url(FAQ) ?>">FAQ</a>
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
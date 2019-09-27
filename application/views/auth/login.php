<div class="container">
    <div class="row">
        <div class="col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="<?= base_url('assets') ?>/img/bmkg.png" alt="BMKG" class="img-fluid img-thumbnail">
                        <h5>STAMET KELAS I SERANG</h5>
                        <h1 class="subtitle">Sistem Informasi Pelayanan Jasa Meteorologi</h1>
                    </div>

                    <?= $this->session->flashdata('message');
                    ?>

                    <form class="form-signin" action="<?= base_url('layanan/auth') ?>" method="POST">
                        <div class="form-label-group">
                            <input type="text" id="email" name="email" class="form-control" placeholder="Email" value="<?= set_value('email') ?>">
                            <label for="email">Email</label>
                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>

                        <div class="form-label-group">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Kata Sandi">
                            <label for="password">Kata Sandi</label>
                            <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>

                        <!-- <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="customCheck5">
                                <label class="custom-control-label" for="customCheck1">Ingat Kata Sandi</label>
                            </div> -->

                        <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Masuk</button>

                        <div class="text-center small mt-2">
                            <a href="<?= base_url('resetpassword') ?>">Lupa Password ?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="<?= base_url('registration') ?>">Belum punya akun ? Daftar</a>
                        </div>

                        <hr class="my-3">

                        <div class="text-center small blue">
                            <a href="#">FAQ</a>
                            |
                            <a href="#">Cek Status</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
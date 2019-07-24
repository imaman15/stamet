<div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img src="<?= base_url('assets') ?>/img/bmkg.png"
                                alt="BMKG" class="img-fluid img-thumbnail">
                            <h1 class="subtitle">Stasiun Meteorologi Kelas I Serang</h1>
                        </div>

                        <form class="form-signin" action="<?= base_url('layanan/auth/registration') ?>" method="POST">
                        <!-- set_value untuk menyimpan inputan sebelumnya, jadi ketika ada kesalahan pengguna tidak perlu input ulang -->
                            <div class="form-label-group">
                                <input type="text" id="name" name="name"  class="form-control" placeholder="Nama Lengkap"
                                value="<?= set_value('name') ?>">
                                <label for="name">Nama Lengkap</label>
                                <?= form_error('name','<small class="text-danger pl-3">','</small>') ?>
                            </div>

                            <div class="form-label-group">
                                <input type="text" id="email" name="email"  class="form-control" placeholder="Email"
                                value="<?= set_value('email') ?>"
                                >
                                <label for="email">Email</label>
                                <?= form_error('email','<small class="text-danger pl-3">','</small>') ?>
                            </div>

                            <div class="form-label-group">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Kata Sandi"
                                >
                                <label for="password">Kata Sandi</label>
                                <?= form_error('password','<small class="text-danger pl-3">','</small>') ?>
                            </div>

                            <div class="form-label-group">
                                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control"
                                    placeholder="Konfrimasi Kata Sandi">
                                <label for="confirmPassword">Konfirmasi Kata Sandi</label>
                            </div>
                            
                            <!-- <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">Saya membaca dan menyetujui
                                    <a href="#">Ketentuan Pengguna</a></label>
                            </div> -->

                            <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Daftar</button>

                            <div class="row mt-2 mb-3">
                                <div class="col-12">
                                    <a href="<?= base_url('layanan/auth')?>" class="btn btn-outline-danger btn-block">Sudah punya akun ? Masuk</a>
                                </div>
                            </div>

                            <hr class="my-4">

                            <a href="faq.html"
                                class="btn btn-lg btn-information btn-outline-dark btn-block text-uppercase">FAQ <i class="fas fa-question-circle mr-2"></i>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
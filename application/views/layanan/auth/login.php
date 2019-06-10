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

                        <?= $this->session->flashdata('message');
                         ?>

                        <form class="form-signin" action="proses.php" method="POST">
                            <div class="form-label-group">
                                <input type="text" id="email" name="email" class="form-control"
                                    placeholder="Email"
                                    required autofocus>
                                <label for="email">Email</label>
                            </div>

                            <div class="form-label-group">
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Kata Sandi"
                                    required>
                                <label for="password">Kata Sandi</label>
                            </div>
                            
                            <!-- <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="customCheck5">
                                <label class="custom-control-label" for="customCheck1">Ingat Kata Sandi</label>
                            </div> -->

                            <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Masuk</button>

                            <div class="row mt-2 mb-3">
                                <div class="col-xl-6 col-lg-5 mb-2">
                                    <a href="<?= base_url('layanan/auth/registration') ?>" class="btn btn-outline-danger btn-block">Daftar</a>
                                </div>
                                <div class="col-xl-6 col-lg-7">
                                    <a href="forgot-password.html" class="btn btn-outline-danger btn-block"> Lupa Kata Sandi?</a>
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
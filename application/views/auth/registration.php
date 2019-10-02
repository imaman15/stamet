<div class="container">
    <div class="row">
        <div class="col-lg-12 col-xl-10 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="<?= base_url('assets') ?>/img/bmkg.png" alt="BMKG" class="img-fluid img-thumbnail">
                        <h5>STAMET KELAS I SERANG</h5>
                        <h1 class="subtitle">Sistem Informasi Pelayanan Jasa Meteorologi</h1>
                    </div>

                    <form class="form-signin" action="<?= base_url('layanan/auth/registration') ?>" method="POST">
                        <!-- set_value untuk menyimpan inputan sebelumnya, jadi ketika ada kesalahan pengguna tidak perlu input ulang -->
                        <div class="row">
                            <div class="col-lg-6 col-md-12 border-right border-left p-2 bg04">
                                <div class="bg-light p-2 mb-3 bg-4">

                                    <div class="form-label-group">
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Nama Depan" value="<?= set_value('name') ?>">
                                        <label for="name">Nama Depan</label>
                                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <div class="form-label-group">
                                        <input type="text" id="name2" name="name2" class="form-control" placeholder="Nama Belakang" value="<?= set_value('name2') ?>">
                                        <label for="name2">Nama Belakang</label>
                                        <?= form_error('name2', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <div class="form-label-group note4 noteb">
                                        <small class="pl-2 d-block text-muted">(Jika tidak memiliki nama belakang kosongkan saja)</small>
                                    </div>
                                </div>

                                <div class="p-2 bg-4">

                                    <div class="form-label-group">
                                        <input type="number" id="nik" name="nik" class="form-control" placeholder="No. Identitas (KTP)" value="<?= set_value('nik') ?>">
                                        <label for="nik">No. Identitas (KTP)</label>
                                        <?= form_error('nik', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>

                                    <div class="form-label-group">
                                        <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Alamat Lengkap"></textarea>
                                        <label for="alamat">Alamat Lengkap</label>
                                    </div>

                                    <div class="form-label-group note4">
                                        <small class="pl-3 d-block text-muted"> (Alamat Harus Lengkap) </small>
                                    </div>

                                    <div class="form-label-group">
                                        <input type="number" id="nohp" name="nohp" class="form-control" placeholder="No. Handphone" value="<?= set_value('nohp') ?>">
                                        <label for="nohp">No. Handphone</label>
                                        <?= form_error('nohp', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>

                                    <div class="form-label-group note4">
                                        <small class="pl-3 d-block text-muted"> (No. handphone harus diawali dengan kode area negara, contoh: 62xxxxxxxxxxx) </small>
                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-6 col-md-12 border-left border-right">
                                <div class="p-2 bg-4">

                                    <div class="input-group mb-3 ">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text bs-4" for="inputGroupSelect01">Pendidikan</label>
                                        </div>
                                        <select class="custom-select bs-4" id="inputGroupSelect01" style="height: 50px">
                                            <option selected>Pilih...</option>
                                            <option value="1">Doktor (S3)</option>
                                            <option value="2">Pascasarjana (S2)</option>
                                            <option value="3">Sarjana (S1)</option>
                                            <option value="4">SMA</option>
                                        </select>
                                    </div>

                                    <div class="input-group mb-3 ">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text bs-4" for="inputGroupSelect02">Kategori Pekerjaan</label>
                                        </div>
                                        <select class="custom-select bs-4" id="inputGroupSelect02" style="height: 50px">
                                            <option selected>Pilih...</option>
                                            <option value="1">BUMN</option>
                                            <option value="2">Instansi pemerintah</option>
                                            <option value="3">Mahasiswa</option>
                                            <option value="4">SMA</option>
                                            <option value="5">Peneliti</option>
                                            <option value="6">Swasta</option>
                                        </select>
                                    </div>

                                    <div class="form-label-group">
                                        <input type="text" id="instansi" name="instansi" class="form-control" placeholder="Nama Instansi" value="<?= set_value('instansi') ?>">
                                        <label for="instansi">Nama Instansi</label>
                                        <?= form_error('instansi', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>

                                </div>

                                <div class="bg-light p-2 bg-4">
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
                                    <div class="form-label-group">
                                        <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Konfrimasi Kata Sandi">
                                        <label for="confirmPassword">Konfirmasi Kata Sandi</label>
                                    </div>
                                    <div class="form-label-group note4 noteb">
                                        <small class="pl-2 d-block text-muted">(Kata sandi minimal 6 karakter dan berisi kombinasi dari huruf kecil, huruf besar, dan simbol)</small>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group p-2 my-3">
                                <div class="alert alert-info bg-4">
                                    Untuk mendukung manajemen pengguna layanan Data Online BMKG dalam rangka meningkatkan layanan, pendaftar harus memberikan informasi data diri secara benar dan memperbarui data diri ketika terdapat perubahan. <br>
                                    Informasi pendaftar bersifat rahasia sehingga harus dilindungi dan hanya boleh dimanfaatkan untuk peningkatan layanan Data Online. <br><br>
                                    Khusus untuk tujuan penelitian, pengguna harus menyertakan referensi data yang didapatkan dari Data Online.
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="invalidCheck2">
                                    <label class="form-check-label" for="invalidCheck2">
                                        Saya telah membaca dan menyetujui ketentuan Pendaftaran Akun Data Online
                                    </label>
                                </div>
                            </div>

                            <button class="btn btn-lg btn-primary text-uppercase btn-block mx-lg-5" type="submit">Daftar</button>
                        </div>

                        <div class="text-center small mt-2">
                            <a href="<?= base_url('resetpassword') ?>">Lupa Password ?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="<?= base_url('login') ?>">Sudah punya akun ? Masuk</a>
                        </div>
                    </form>

                    <hr class="my-3">

                    <div class="text-center small blue">
                        <a href="#">FAQ</a>
                        |
                        <a href="#">Cek Status</a>
                    </div>

                    <!-- Footer -->
                    <footer class="sticky-footer bg-white">
                        <div class="container">
                            <div class="copyright text-center small">
                                <span>Copyright &copy; SIPJAMET <?= date('Y') ?></span>
                            </div>
                        </div>
                    </footer>
                    <!-- End of Footer -->
                </div>
            </div>
        </div>
    </div>
</div>
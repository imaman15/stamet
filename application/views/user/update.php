<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow mb-3 animated zoomIn fast">
        <div class="card-body row">
            <div class="col-lg-8">
                <?= $this->session->flashdata('message');
                ?>
                <?= form_open_multipart('edit-profil'); ?>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php secho($user->email) ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="first_name" class="col-sm-3 col-form-label">Nama Depan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Nama Depan" value="<?php secho(ucfirst($user->first_name)) ?>">
                        <?= form_error('first_name'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="last_name" class="col-sm-3 col-form-label">Nama Belakang</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Nama Belakang" aria-describedby="lastnameHelpBlock" value="<?php secho(ucfirst($user->last_name)) ?>">
                        <small id="lastnameHelpBlock" class="form-text text-muted">
                            Jika tidak memiliki nama belakang kosongkan saja.
                        </small>
                        <?= form_error('last_name'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nin" class="col-sm-3 col-form-label">No. Identitas (KTP)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nin" onkeypress="return numberOnly(event)" maxlength="16" id="nin" placeholder="No. Identitas (KTP)" value="<?php secho($user->nin) ?>" readonly>
                        <?= form_error('nin'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-3 col-form-label">Alamat Lengkap</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="Alamat Lengkap" aria-describedby="addressHelpBlock"><?php secho($user->address) ?></textarea>
                        <small id="addressHelpBlock" class="form-text text-muted">
                            Alamat harus lengkap sesuai dengan No. Identitas/KTP.
                        </small>
                        <?= form_error('address'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-sm-3 col-form-label">No. Handphone</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="No. Handphone" aria-describedby="phoneHelpBlock" value="<?= $user->phone ?>">
                        <small id="phoneHelpBlock" class="form-text text-muted">
                            Pastikan nomor handpone anda aktif dan gunakan nomor yang sudah terdaftar di whatsapp jika ada.
                        </small>
                        <?= form_error('phone') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="education" class="col-sm-3 col-form-label">Pendidikan</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="education" id="education">
                            <?php $education = set_value("education") ? set_value("education") : $user->education ?>
                            <option value="">Pilih...</option>
                            <option value="1" <?= ($education == 1) ? "selected" : null; ?>>Doktor (S3)</option>
                            <option value="2" <?= ($education == 2) ? "selected" : null; ?>>Pascasarjana (S2)</option>
                            <option value="3" <?= ($education == 3) ? "selected" : null; ?>>Sarjana (S1)</option>
                            <option value="4" <?= ($education == 4) ? "selected" : null; ?>>SMA</option>
                        </select>
                        <?= form_error('education') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="job_category" class="col-sm-3 col-form-label">Kategori Pekerjaan</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="job_category" id="job_category">
                            <?php $job_category = set_value("job_category") ? set_value("job_category") : $user->job_category ?>
                            <option value="">Pilih...</option>
                            <option value="1" <?= ($job_category == 1) ? "selected" : null; ?>>BUMN</option>
                            <option value="2" <?= ($job_category == 2) ? "selected" : null; ?>>Instansi pemerintah</option>
                            <option value="3" <?= ($job_category == 3) ? "selected" : null; ?>>Mahasiswa</option>
                            <option value="4" <?= ($job_category == 4) ? "selected" : null; ?>>SMA</option>
                            <option value="5" <?= ($job_category == 5) ? "selected" : null; ?>>Peneliti</option>
                            <option value="6" <?= ($job_category == 6) ? "selected" : null; ?>>Swasta</option>
                        </select>
                        <?= form_error('job_category') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="institute" class="col-sm-3 col-form-label">Nama Instansi</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="institute" id="institute" placeholder="Nama Instansi" aria-describedby="instituteHelpBlock" value="<?php secho($user->institute) ?>">
                        <small id="instituteHelpBlock" class="form-text text-muted">
                            Nama Instansi / Nama Perusahaan / Nama Sekolah / Nama Universitas.
                        </small>
                        <?= form_error('institute') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">Foto Profil</div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="<?= base_url('assets/img/profil/default.jpg') ?>" alt="" class="img-thumbnail">
                            </div>
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="photo" id="photo">
                                    <label class="custom-file-label" for="photo">Pilih Foto</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row justify-content-end">
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </div>

                <?= form_close(); ?>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
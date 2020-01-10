<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-center text-gray-800 col-lg-10 offset-lg-1"><?= $title; ?></h1>

    <div class="col-lg-10 offset-lg-1">
        <div class="card shadow mb-3 animated zoomIn fast">
            <div class="card-body">
                <?= $this->session->flashdata('message');
                ?>
                <?= form_open_multipart('edit-profil'); ?>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : null ?>" name="email" id="email" placeholder="Email" value="<?php secho($user->email) ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="first_name" class="col-sm-3 col-form-label">Nama Depan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= form_error('first_name') ? 'is-invalid' : null ?>" name="first_name" id="first_name" placeholder="Nama Depan" value="<?php secho(ucfirst($user->first_name)) ?>">
                        <?= form_error('first_name'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="last_name" class="col-sm-3 col-form-label">Nama Belakang</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= form_error('last_name') ? 'is-invalid' : null ?>" name="last_name" id="last_name" placeholder="Nama Belakang" aria-describedby="lastnameHelpBlock" value="<?php secho(ucfirst($user->last_name)) ?>">
                        <small id="lastnameHelpBlock" class="form-text text-muted">
                            Jika tidak memiliki nama belakang kosongkan saja.
                        </small>
                        <?= form_error('last_name'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nin" class="col-sm-3 col-form-label">No. Identitas (KTP)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= form_error('nin') ? 'is-invalid' : null ?>" name="nin" onkeypress="return numberOnly(event)" maxlength="16" id="nin" placeholder="No. Identitas (KTP)" value="<?php secho($user->nin) ?>" readonly>
                        <?= form_error('nin'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-3 col-form-label">Alamat Lengkap</label>
                    <div class="col-sm-9">
                        <textarea class="form-control <?= form_error('address') ? 'is-invalid' : null ?>" name="address" id="address" rows="3" placeholder="Alamat Lengkap" aria-describedby="addressHelpBlock"><?php secho($user->address) ?></textarea>
                        <small id="addressHelpBlock" class="form-text text-muted">
                            Alamat harus lengkap sesuai dengan No. Identitas/KTP.
                        </small>
                        <?= form_error('address'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-sm-3 col-form-label">No. Handphone</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= form_error('phone') ? 'is-invalid' : null ?>" name="phone" id="phone" placeholder="No. Handphone" aria-describedby="phoneHelpBlock" value="<?= $user->phone ?>">
                        <small id="phoneHelpBlock" class="form-text text-muted">
                            Pastikan nomor handpone anda aktif dan gunakan nomor yang sudah terdaftar di whatsapp jika ada.
                        </small>
                        <?= form_error('phone') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="job_category" class="col-sm-3 col-form-label">Kategori Pekerjaan</label>
                    <div class="col-sm-9">
                        <select class="form-control <?= form_error('job_category') ? 'is-invalid' : null ?>" name="job_category" id="job_category">
                            <?php $job_category = set_value("job_category") ? set_value("job_category") : $user->job_category;
                            ?>
                            <option value="">Pilih...</option>
                            <?php foreach ($jobcategory->result() as $jc) : ?>
                                <option value="<?= $jc->jobcat_id; ?>" <?= ($job_category == $jc->jobcat_id) ? "selected" : null; ?>><?= $jc->jobcat ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('job_category') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="institute" class="col-sm-3 col-form-label">Nama Instansi</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= form_error('institute') ? 'is-invalid' : null ?>" name="institute" id="institute" placeholder="Nama Instansi" aria-describedby="instituteHelpBlock" value="<?php secho($user->institute) ?>">
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
                                <img src="<?= base_url('assets/img/profil/') . $user->photo ?>" alt="" class="img-thumbnail">
                            </div>
                            <div class="col-sm-9 my-sm-auto mt-2">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input clearfix" name="photo" id="photo">
                                    <label class="custom-file-label overflow-hidden" for="photo">Pilih Foto</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 offset-md-4">
                        <button type="submit" class="btn btn-primary btn-block">Edit</button>
                    </div>
                </div>

                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
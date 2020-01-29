<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-center text-gray-800 col-lg-10 offset-lg-1"><?= $title; ?></h1>

    <div class="col-lg-10 offset-lg-1">
        <?= $this->session->flashdata('message');
        ?>
        <div class="card shadow mb-3 animated zoomIn fast">
            <div class="card-body">

                <?= form_open_multipart(UE_EDITPROFILE); ?>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : null ?>" name="email" id="email" placeholder="Email" value="<?php secho($user->email) ?>">
                        <?= form_error('email'); ?>
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
                    <label for="csidn" class="col-sm-3 col-form-label">No. Identitas Pegawai (NIP)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= form_error('csidn') ? 'is-invalid' : null ?>" name="csidn" onkeypress="return numberOnly(event)" maxlength="18" id="csidn" placeholder="No. Identitas Pegawai (NIP)" value="<?php secho($user->csidn) ?>">
                        <?= form_error('csidn'); ?>
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

                <?php if (dAdmin()->level == 1) : ?>

                    <div class="form-group row">
                        <label for="position_name" class="col-sm-3 col-form-label">Jabatan</label>
                        <div class="col-sm-9">
                            <select class="form-control <?= form_error('position_name') ? 'is-invalid' : null ?>" name="position_name" id="position_name">
                                <?php $pos = set_value("position_name") ? set_value("position_name") : $user->position_name;
                                ?>
                                <option value="">Pilih...</option>
                                <?php foreach ($position->result() as $p) : ?>
                                    <option value="<?= $p->pos_id; ?>" <?= ($pos == $p->pos_id) ? "selected" : null; ?>><?= $p->pos_name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('position') ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="level" class="col-sm-3 col-form-label">Level</label>
                        <div class="col-sm-9">
                            <select class="form-control <?= form_error('level') ? 'is-invalid' : null ?>" name="level" id="level">
                                <?php $level = set_value("level") ? set_value("level") : $user->level;
                                ?>
                                <option value="">Pilih...</option>
                                <?= dataLevel($level) ?>
                            </select>
                            <?= form_error('level') ?>
                        </div>
                    </div>

                <?php endif; ?>

                <div class="form-group row">
                    <div class="col-sm-3">Foto Profil</div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="<?= base_url('assets/img/profil/') . $user->photo ?>" alt="" class="img-thumbnail rounded-circle profil-admin">
                            </div>
                            <div class="col-sm-9 my-sm-auto mt-2">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input clearfix" name="photo" id="photo">
                                    <label class="custom-file-label overflow-hidden" for="photo">Pilih Foto</label>
                                    <div id="rempho" class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" class="custom-control-input" id="remove_photo" value="<?= $user->photo ?>" name="remove_photo">
                                        <label class="custom-control-label" for="remove_photo">Hapus foto saat menyimpan</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 offset-md-4 mt-4">
                        <button type="submit" class="btn btn-primary btn-block">Edit</button>
                    </div>
                </div>

                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<!-- /.container-fluid -->
<script type="text/javascript">
    var foto = '<?= $user->photo ?>';
    $(document).ready(function() {
        $('#rempho').show();
        if (foto == "default.jpg") {
            $('#rempho').hide();
        }

    });
</script>
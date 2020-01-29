<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-center text-gray-800 col-lg-10 offset-lg-1"><?= $title; ?></h1>

    <div class="col-lg-10 offset-lg-1">
        <?= $this->session->flashdata('message');
        ?>
        <div class="card shadow mb-3 animated zoomIn fast">
            <div class="card-body">
                <?= form_open(UE_CONFIGURATION); ?>
                <div class="form-group row">
                    <label for="bank_name" class="col-sm-3 col-form-label">Bank</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= form_error('bank_name') ? 'is-invalid' : null ?>" name="bank_name" id="bank_name" placeholder="Bank" value="<?php secho(ucfirst($conf->bank_name)) ?>">
                        <div class="mb-1 mt-2">
                            <?= form_error('bank_name'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="account_number" class="col-sm-3 col-form-label">No. Rekening</label>
                    <div class="col-sm-9">
                        <input type="text" onkeypress="return numberOnly(event)" class="form-control <?= form_error('account_number') ? 'is-invalid' : null ?>" name="account_number" id="account_number" placeholder="Nomor Rekening" value="<?= $conf->account_number ?>">
                        <div class="mb-1 mt-2">
                            <?= form_error('account_number'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="account_name" class="col-sm-3 col-form-label">Atas Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= form_error('account_name') ? 'is-invalid' : null ?>" name="account_name" id="account_name" placeholder="Nama Pemilik" value="<?php secho(ucfirst($conf->account_name)) ?>">
                        <div class="mb-1 mt-2">
                            <?= form_error('account_name'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email_reply" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email_reply" class="form-control <?= form_error('email_reply') ? 'is-invalid' : null ?>" name="email_reply" id="email_reply" placeholder="Balasan Email" value="<?php secho($conf->email_reply) ?>">
                        <div class="mb-1 mt-2">
                            <?= form_error('email_reply'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 offset-md-4 mt-4">
                        <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                    </div>
                </div>

                <?= form_close(); ?>
            </div>
            <div class="card-footer text-muted mt-n2 small">
                Terakhir di perbarui : <?= timeInfo($conf->date_update) ?>
            </div>
        </div>
    </div>
</div>

<!-- /.container-fluid -->
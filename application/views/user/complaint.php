<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?= $this->session->flashdata('message');
    ?>

    <div class="col-lg-10 offset-lg-1">
        <div class="card shadow mb-3 animated zoomIn fast">
            <div class="card-body">
                <?= $this->session->flashdata('message');
                ?>
                <?= form_open_multipart(UA_TRANSACTION); ?>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : null ?>" name="email" id="email" placeholder="Email" value="<?php secho("email") ?>" readonly>
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
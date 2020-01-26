<!-- Summernote -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/vendor/summernote/summernote-bs4.min.css'; ?>">
<!-- End of Summernote -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-center text-gray-800"><?= $title; ?></h1>

    <div class="col-12">
        <?= $this->session->flashdata('message');
        ?>
        <div class="card shadow mb-3 animated zoomIn fast">
            <div class="card-body">

                <?= form_open(UA_SCHEDULE); ?>
                <input type="hidden" name="sch_code" value="<?= codeRandom('SC') ?>">
                <div class="form-group row">
                    <label for="apply_name" class="col-sm-3 col-form-label text-left text-sm-right">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= form_error('apply_name') ? 'is-invalid' : null ?>" name="apply_name" id="apply_name" placeholder="apply_name" value="<?= $user->first_name . " " . $user->last_name ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="apply_email" class="col-sm-3 col-form-label text-left text-sm-right">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control <?= form_error('apply_email') ? 'is-invalid' : null ?>" name="apply_email" id="apply_email" placeholder="apply_email" value="<?= $user->email ?>" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-sm-3 col-form-label text-left text-sm-right">No. Handphone</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= form_error('phone') ? 'is-invalid' : null ?>" name="phone" id="phone" placeholder="No. Handphone" aria-describedby="phoneHelpBlock" value="<?= $user->phone ?>" readonly>
                        <?= form_error('phone') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sch_title" class="col-sm-3 col-form-label text-left text-sm-right">Judul</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= form_error('sch_title') ? 'is-invalid' : null ?>" name="sch_title" id="sch_title" placeholder="Judul atau Perihal" value="<?= set_value('sch_title') ?>">
                        <div class="mb-1 mt-2">
                            <?= form_error('sch_title') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sch_type" class="col-sm-3 col-form-label text-left text-sm-right">Jenis Pertemuan</label>
                    <div class="col-sm-9">
                        <select class="form-control <?= form_error('sch_type') ? 'is-invalid' : null ?>" name="sch_type" id="sch_type">
                            <option value="">Pilih...</option>
                            <option value="Kunjungan Sekolah" <?= form_error('sch_type') ? 'selected' : null ?>>Kunjungan Sekolah</option>
                            <option value="Konsultasi Data" <?= form_error('sch_type') ? 'selected' : null ?>>Konsultasi Data</option>
                        </select>
                        <div class="mb-1 mt-2">
                            <?= form_error('sch_type') ?>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sch_date" class="col-sm-3 col-form-label text-left text-sm-right">Tanggal Pertemuan</label>
                    <div class="col-sm-9">
                        <input type="datetime-local" class="form-control <?= form_error('sch_date') ? 'is-invalid' : null ?>" name="sch_date" id="sch_date" placeholder="Tanggal Pertemuan" value="<?= set_value('sch_date') ?>">
                        <div class="mb-1 mt-2">
                            <?= form_error('sch_date') ?>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sch_message" class="col-sm-3 col-form-label text-left text-sm-right">Pesan</label>
                    <div class="col-sm-9">
                        <textarea class="form-control is-invalid" name="sch_message" id="sch_message" placeholder="Pesan"><?= set_value('sch_message') ?></textarea>
                        <?php if (!form_error('sch_message')) : ?>
                            <div class="alert alert-warning py-1 mt-2 px-4" role="alert">
                                <div class="row align-items-center">
                                    <i class="fas fa-fw fa-exclamation-circle fa-1x mx-auto mx-sm-1"></i>
                                    <small class="ml-1"> Catatan : Jika ingin menghapus gambar silahkan klik gambar lalu pilih tombol "Hapus Gambar"</small>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="mb-1 mt-2">
                            <?= form_error('sch_message'); ?>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-4 offset-md-4 mt-4">
                        <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                    </div>
                </div>

                <!-- <?= form_close(); ?> -->
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script type="text/javascript" src="<?php echo base_url() . 'assets/vendor/summernote/summernote-bs4.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/vendor/summernote/lang/summernote-id-ID.min.js'; ?>"></script>

<script type="text/javascript">
    // var url = "<?= site_url(UA_SCHEHISTORY) ?>";
    // $('#btn-send').click(function() {
    //     window.location.replace(url);
    // });
    $(document).ready(function() {
        $("input").change(function() {
            $(this).removeClass('is-invalid');
        });
        $("textarea").change(function() {
            $(this).removeClass('is-invalid');
        });
        $("select").change(function() {
            $(this).removeClass('is-invalid');
        });
        $(".invalid-feedback").change(function() {
            $(this).empty();
        });

        $('#sch_message').summernote({
            dialogsInBody: true,
            minHeight: 400,
            placeholder: 'Silahkan jelaskan keperluan Anda secara detail pada kolom ini',
            lang: 'id-ID', // default: 'en-US'
            callbacks: {
                onImageUpload: function(image) {
                    uploadImage(image[0]);
                },
                onMediaDelete: function(target) {
                    deleteImage(target[0].src);
                }
            },
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline']],
                ['font', ['clear', 'fontsize']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['fullscreen']],
                ['help', ['help']]
            ],
        });

        function uploadImage(image) {
            var data = new FormData();
            data.append("image", image);
            $.ajax({
                url: "<?php echo site_url('schedule/upload_image') ?>",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(url) {
                    $('#sch_message').summernote("insertImage", url);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function deleteImage(src) {
            $.ajax({
                data: {
                    src: src
                },
                type: "POST",
                url: "<?php echo site_url('schedule/delete_image') ?>",
                cache: false,
                success: function(response) {
                    console.log(response);
                }
            });
        }

    });
</script>
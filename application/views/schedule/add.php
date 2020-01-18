<!-- Summernote -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/vendor/summernote/summernote-bs4.min.css'; ?>">
<!-- End of Summernote -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-center text-gray-800"><?= $title; ?></h1>

    <?= $this->session->flashdata('message');
    ?>

    <div class="col-12">
        <div class="card shadow mb-3 animated zoomIn fast">
            <div class="card-body">

                <!-- <?= form_open_multipart('transaction/save'); ?> -->
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
                    <label for="type_meeting" class="col-sm-3 col-form-label text-left text-sm-right">Jenis Pertemuan</label>
                    <div class="col-sm-9">
                        <select class="form-control <?= form_error('type_meeting') ? 'is-invalid' : null ?>" name="type_meeting" id="type_meeting">
                            <?php $type_meeting = set_value("type_meeting") ? set_value("type_meeting") : $user->type_meeting;
                            ?>
                            <option value="">Pilih...</option>
                            <option value="kunjungan">Kunjungan Sekolah</option>
                            <option value="konsultasi">Konsultasi Data</option>
                        </select>
                        <?= form_error('type_meeting') ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="apply_email" class="col-sm-3 col-form-label text-left text-sm-right">Tanggal Pertemuan</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control <?= form_error('apply_email') ? 'is-invalid' : null ?>" name="apply_email" id="apply_email" placeholder="apply_email" value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="apply_message" class="col-sm-3 col-form-label text-left text-sm-right">Pesan</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="apply_message" id="apply_message" placeholder="Alamat Lengkap"><?= set_value('apply_message') ?></textarea>
                        <?= form_error('apply_message'); ?>
                        <div class="alert alert-warning py-1 mt-2 px-4" role="alert">
                            <div class="row align-items-center">
                                <i class="fas fa-fw fa-exclamation-circle fa-1x mx-auto mx-sm-1"></i>
                                <small class="ml-1"> Catatan : Jika ingin menghapus gambar silahkan klik gambar lalu pilih tombol "Hapus Gambar"</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row mt-n3">
                    <label for="apply_email" class="col-sm-3 col-form-label text-left text-sm-right">Upload Berkas</label>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="apply_file" name="apply_file">
                            <label class="custom-file-label overflow-hidden" for="apply_file">Pilih Berkas</label>
                        </div>
                        <small id="apply_messageHelpBlock" class="form-text text-muted">
                            Upload berkas persyaratan dalam format dokumen (pdf atau word).
                        </small>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-4 offset-md-4 mt-4">
                        <button id="btn-send" type="submit" class="btn btn-primary btn-block">Kirim permintaan</button>
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
    var url = "<?= site_url(UA_SCHEHISTORY) ?>";
    $('#btn-send').click(function() {
        window.location.replace(url);
    });
    $(document).ready(function() {
        $('#apply_message').summernote({
            dialogsInBody: true,
            minHeight: 400,
            placeholder: 'Silahkan jelaskan keperluannya apa secara detail pada kolom ini',
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
                    $('#apply_message').summernote("insertImage", url);
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
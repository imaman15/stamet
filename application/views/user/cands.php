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

        <div class="alert alert-success d-none" role="alert"><strong>Terima Kasih! </strong>sudah mengisi form kritik dan saran. kami akan selalu memperbaiki pelayanan kami.</div>

        <div class="card shadow mb-3 animated zoomIn fast">
            <div class="card-body">
                <?= $this->session->flashdata('message');
                ?>

                <!-- <?= form_open(UA_CANDS); ?> -->
                <div class="form-group row">
                    <label for="apply_name" class="col-sm-2 col-form-label text-left text-sm-right">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= form_error('apply_name') ? 'is-invalid' : null ?>" name="apply_name" id="apply_name" placeholder="apply_name" value="<?= $user->first_name . " " . $user->last_name ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="apply_email" class="col-sm-2 col-form-label text-left text-sm-right">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control <?= form_error('apply_email') ? 'is-invalid' : null ?>" name="apply_email" id="apply_email" placeholder="apply_email" value="<?= $user->email ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-sm-2 col-form-label text-left text-sm-right">No. Handphone</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= form_error('phone') ? 'is-invalid' : null ?>" name="phone" id="phone" placeholder="No. Handphone" aria-describedby="phoneHelpBlock" value="<?= $user->phone ?>" readonly>
                        <?= form_error('phone') ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="apply_message" class="col-sm-2 col-form-label text-left text-sm-right">Kritik dan Saran</label>
                    <div class="col-sm-10">
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

                <div class="form-group">
                    <div class="col-md-4 offset-md-4 mt-4">
                        <button id="btn-send" type="submit" class="btn btn-primary btn-block">Kirim</button>
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
    $('#btn-send').click(function() {
        $(".alert-success").removeClass('d-none');
        // close the message after seconds
        $('.alert-success').delay(500).show(10, function() {
            $(this).delay(5000).hide(10, function() {
                $(this).addClass('d-none');
            });
        });
    });


    $(document).ready(function() {
        $('#apply_message').summernote({
            dialogsInBody: true,
            minHeight: 400,
            placeholder: 'Mohon untuk mengisi formulir kritik dan saran di kolom ini mengenai aspek apa yang harus kami perbaiki kedepannya. Terimakasih.',
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
                url: "<?php echo site_url('cands/upload_image') ?>",
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
                url: "<?php echo site_url('cands/delete_image') ?>",
                cache: false,
                success: function(response) {
                    console.log(response);
                }
            });
        }

    });
</script>
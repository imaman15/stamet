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
        <nav class="d-print-none" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url(UE_MANAGEFAQ) ?>">Frequently Asked Questions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah FAQS</li>
            </ol>
        </nav>
        <div class="card shadow mb-3 animated zoomIn fast">
            <div class="card-body">

                <?= form_open(UE_MANAGEFAQ . UE_ADD); ?>
                <div class="form-group">
                    <label for="">Judul Pertanyaan</label>
                    <input type="text" class="form-control <?= form_error('faqs_questions') ? 'is-invalid' : null ?>" value="<?= set_value('faqs_questions') ?>" name="faqs_questions" id="faqs_questions" placeholder="Judul Pertanyaan">
                    <div class="mb-1 mt-2">
                        <?= form_error('faqs_questions') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Jawaban Pertanyaan</label>
                    <textarea class="form-control" name="faqs_answers" id="faqs_answers" placeholder="Pesan"><?= set_value('faqs_answers') ?></textarea>
                    <?php if (!form_error('faqs_answers')) : ?>
                        <div class="alert alert-warning py-1 mt-2 px-4" role="alert">
                            <div class="row align-items-center">
                                <i class="fas fa-fw fa-exclamation-circle fa-1x mx-auto mx-sm-1"></i>
                                <small class="ml-1"> Catatan : Jika ingin menghapus gambar silahkan klik gambar lalu pilih tombol "Hapus Gambar"</small>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="mb-1 mt-2">
                        <?= form_error('faqs_answers'); ?>
                    </div>
                </div>
                <div class="custom-control custom-checkbox my-1 mr-sm-2">
                    <input type="checkbox" class="custom-control-input" name="status" id="status" value="1" checked>
                    <label class="custom-control-label" for="status">Publish</label>
                </div>
                <div class="form-group">
                    <div class="col-md-4 offset-md-4 mt-4">
                        <button type="submit" class="btn btn-primary btn-block">Simpan</button>
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

        $('#faqs_answers').summernote({
            dialogsInBody: true,
            minHeight: 400,
            placeholder: 'Jawaban dari pertanyaan',
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
                ['insert', ['link', 'picture', 'hr', 'video']],
                ['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
        });

        function uploadImage(image) {
            var data = new FormData();
            data.append("image", image);
            $.ajax({
                url: "<?php echo site_url('employee/faqs/upload_image') ?>",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(url) {
                    $('#faqs_answers').summernote("insertImage", url);
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
                url: "<?php echo site_url('employee/faqs/delete_image') ?>",
                cache: false,
                success: function(response) {
                    console.log(response);
                }
            });
        }

    });
</script>
<!-- Summernote -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/vendor/summernote/summernote-bs4.min.css'; ?>">
<!-- End of Summernote -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="col-12">
        <?= $this->session->flashdata('message');
        ?>

        <div class="alert alert-success" role="alert"><strong>Selamat! </strong>pesan Anda sudah terkirim. Untuk melihat status/balasan komplain silahakn klik menu "Riwayat Komplain"</div>

        <div class="card shadow mb-3 animated zoomIn fast">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="formComplaint" data-toggle="tab" href="#complainttab1" role="tab" aria-controls="complainttab1" aria-selected="true">Form Komplain</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="historyComplaint" data-toggle="tab" href="#complainttab2" role="tab" aria-controls="complainttab2" aria-selected="false">Riwayat Komplain</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="container-fluid tab-pane fade show active" id="complainttab1" role="tabpanel" aria-labelledby="formComplaint">
                        <h4 class="text-center my-4">Form Komplain Pelanggan</h4>
                        <!-- <?= form_open_multipart('transaction/save'); ?> -->
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
                            <label for="apply_name" class="col-sm-2 col-form-label text-left text-sm-right">Judul</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control <?= form_error('apply_name') ? 'is-invalid' : null ?>" name="apply_name" id="apply_name" placeholder="Perihal Komplain" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="apply_message" class="col-sm-2 col-form-label text-left text-sm-right">Pesan Komplain</label>
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
                        <!-- <?= form_close() ?> -->
                    </div>

                    <div class="container tab-pane fade" id="complainttab2" role="tabpanel" aria-labelledby="historyComplaint">

                        <h4 class="text-center my-4">Riwayat Komplain Pelanggan</h4>
                        <div class="table-responsive my-4">
                            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="10px">#</th>
                                        <th>Kode Komplain</th>
                                        <th>Perihal Komplain</th>
                                        <th width="90px">Pesan Komplain</th>
                                        <th width="98px">Balasan Pesan</th>
                                        <th>Status</th>
                                        <th>Tanggal Komplain</th>
                                    </tr>

                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>C19012020123</td>
                                        <td>Data tidak sesuai dengan yang di upload</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-dark btn-icon-split btn-sm align-items-center" onclick="message()">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-envelope py-3 py-sm-1"></i>
                                                </span>
                                                <small class="text">Lihat Pesan</small>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-secondary btn-icon-split btn-sm align-items-center" onclick="reply()">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-reply py-3 py-sm-1"></i>
                                                </span>
                                                <small class="text">Lihat Balasan</small>
                                            </button>
                                        </td>
                                        <td>Sudah Dibalas</td>
                                        <td>19-01-2020</td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>C23012020124</td>
                                        <td>Data ada yang kurang</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-dark btn-icon-split btn-sm align-items-center" onclick="message()">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-envelope py-3 py-sm-1"></i>
                                                </span>
                                                <small class="text">Lihat Pesan</small>
                                            </button>
                                        </td>
                                        <td class="text-center">(belum di balas)</td>
                                        <td>Menunggu Balasan</td>
                                        <td>23-01-2020</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script type="text/javascript" src="<?php echo base_url() . 'assets/vendor/summernote/summernote-bs4.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/vendor/summernote/lang/summernote-id-ID.min.js'; ?>"></script>

<script type="text/javascript">
    function message() {
        $('#complaint').modal('show');
        $('.modal-title').text('Pesan Anda');
        $('.modal-body').text('Kenapa data saya bisa tidak sesuai ? saya lampirkan gambar di bawah ini.');
    };

    function reply() {
        $('#complaint').modal('show');
        $('.modal-title').text('Balasan Pesan Anda');
        $('.modal-body').text('Mohon maaf sebelumnya, akan saya kirimkan ulang');
    };
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

<!-- Modal -->
<div class="modal fade" id="complaint" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Body
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save</button> -->
            </div>
        </div>
    </div>
</div>
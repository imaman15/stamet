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
            <div class="card-header py-3 text-sm-right text-center">
                <button type="button" class="btn btn-primary btn-icon-split btn-sm align-items-center" onclick="view()">
                    <span class="icon text-white-50 py-3 py-sm-1">
                        <i class="fas fa-th-list "></i>
                    </span>
                    <span class="text">Lihat Jenis Permintaan</span>
                </button>
            </div>
            <div class="card-body">
                <?= form_open_multipart(UA_TRANSACTION) ?>
                <input type="hidden" name="trans_code" value="<?= codeRandom('TC') ?>">

                <div class="form-group row">
                    <label for="apply_name" class="col-sm-2 col-form-label text-left text-sm-right">Nama Pemohon</label>
                    <div class="col-sm-10">
                        <input type="apply_name" class="form-control" name="apply_name" id="apply_name" placeholder="apply_name" value="<?= $user->first_name . " " . $user->last_name ?>" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="apply_institute" class="col-sm-2 col-form-label text-left text-sm-right">Nama Instansi</label>
                    <div class="col-sm-10">
                        <input type="apply_institute" class="form-control" name="apply_institute" id="apply_institute" placeholder="apply_institute" value="<?= $user->institute ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="apply_email" class="col-sm-2 col-form-label text-left text-sm-right">Email Pemohon</label>
                    <div class="col-sm-10">
                        <input type="apply_email" class="form-control" name="apply_email" id="apply_email" placeholder="apply_email" value="<?= $user->email ?>" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="trans_message" class="col-sm-2 col-form-label text-left text-sm-right">Pesan</label>
                    <div class="col-sm-10">
                        <textarea class="form-control is-invalid" name="trans_message" id="trans_message" placeholder="Alamat Lengkap"><?= set_value('trans_message') ?></textarea>
                        <?php if (!form_error('trans_message')) : ?>
                            <div class="alert alert-warning py-1 mt-2 px-4" role="alert">
                                <div class="row align-items-center">
                                    <i class="fas fa-fw fa-exclamation-circle fa-1x mx-auto mx-sm-1"></i>
                                    <small class="ml-1"> Catatan : Jika ingin menghapus gambar silahkan klik gambar lalu pilih tombol "Hapus Gambar"</small>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="mb-1 mt-2">
                            <?= form_error('trans_message'); ?>
                        </div>

                    </div>
                </div>

                <div class="form-group row mt-n2">
                    <label for="doc_storage" class="col-sm-2 col-form-label text-left text-sm-right">Upload Berkas</label>
                    <div class="col-sm-10">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="doc_storage" name="doc_storage">
                            <label class="custom-file-label overflow-hidden" for="doc_storage">Pilih Berkas</label>
                        </div>
                        <small id="apply_messageHelpBlock" class="form-text text-muted">
                            Upload surat pengantar dalam format dokumen (pdf atau word) jika ada.
                        </small>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-4 offset-md-4 mt-4">
                        <button id="btn-send" type="submit" class="btn btn-primary btn-block">Kirim permintaan</button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script type="text/javascript" src="<?php echo base_url() . 'assets/vendor/summernote/summernote-bs4.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/vendor/summernote/lang/summernote-id-ID.min.js'; ?>"></script>

<script type="text/javascript">
    // var url = "<?= site_url(UA_TRANSHISTORY) ?>";
    // $('#btn-send').click(function() {
    //     window.location.replace(url);
    // });
    $(document).ready(function() {
        $('#trans_message').summernote({
            dialogsInBody: true,
            minHeight: 400,
            placeholder: 'Sebutkan di kolom ini jenis permintaan apa yang di inginkan, tujuan penggunaan data, wilayah dan waktunya secara detail. <br> jika belum mengetahui jenis permintaan apa saja yang tersedia silahakan klik tombol "Lihat jenis permintaan" di atas atau bisa datang langsung ke kantor untuk konsultasi dengan mengisi jadwal pertemuan terlebih dahulu di menu "Form Jadwal Pertemuan" yang berada di samping kiri',
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
                // ['fontname', ['fontname']],
                // ['color', ['color']],
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
                url: "<?php echo site_url('transaction/upload_image') ?>",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(url) {
                    $('#trans_message').summernote("insertImage", url);
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
                url: "<?php echo site_url('transaction/delete_image') ?>",
                cache: false,
                success: function(response) {
                    console.log(response);
                }
            });
        }

    });

    // Detail Data
    function view() {
        $('#transactionForm').modal('show'); // show bootstrap modal
        $('#viewData').show();
        $('#btnClose').text('Tutup');
    }
</script>

<!-- Modal Add/Update -->
<div class="modal fade" id="transactionForm" tabindex="-1" role="dialog" aria-labelledby="transactionFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bolder">Lihat Jenis Permintaan</h4>
                <br>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <div class="text-center text-uppercase">
                    <h4 class="font-weight-bolder">Jenis Informasi dan Tarif</h4>
                    <p>Sesuai Pemerintah Republik Indonesia Nomor 47 Tahun 2018</p>
                </div>
                <ol class="ml-n4 mt-4">
                    <?php
                    foreach ($type as $t) :
                    ?>
                        <li><?= $t['description']; ?>

                            <?php
                            $subtype = $this->subtype_model->groupData($t['type_id']);
                            if ($subtype->num_rows() > 0) :
                            ?>
                                <div class="table-responsive mt-2">
                                    <table class="table table-striped " width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Jenis Informasi</th>
                                                <th>Satuan</th>
                                                <th>Tarif</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // if (is_array($data)) :
                                            foreach ($subtype->result_array() as $st) :
                                            ?>
                                                <tr>
                                                    <td><?= $st['sub_description']; ?></td>
                                                    <td><?= $st['unit']; ?></td>
                                                    <td><?= rupiah($st['rates']); ?></td>
                                                </tr>

                                            <?php
                                            endforeach;
                                            // endif;
                                            ?>

                                            <!-- <tr class="odd">
                                            <td valign="top" colspan="3" class="dataTables_empty">
                                                (tidak ada data yang tersedia pada tabel ini)
                                            </td>
                                        </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                            <?php else : ?>
                                <div class="text-center my-2 text-gray-500">(tidak ada data yang tersedia)</div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
            <div class="modal-footer">
                <button id="btnClose" type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>

        </div>
    </div>
</div>
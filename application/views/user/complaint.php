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
        <div id="success_message">
        </div>
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
                        <?= form_open(UA_COMPLAINT, 'id="form"'); ?>
                        <div class="form-group row">
                            <label for="apply_name" class="col-sm-2 col-form-label text-left text-sm-right">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="apply_name" id="apply_name" placeholder="apply_name" value="<?= $user->first_name . " " . $user->last_name ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="apply_email" class="col-sm-2 col-form-label text-left text-sm-right">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="apply_email" id="apply_email" placeholder="apply_email" value="<?= $user->email ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label text-left text-sm-right">No. Handphone</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="No. Handphone" aria-describedby="phoneHelpBlock" value="<?= $user->phone ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="comp_title" class="col-sm-2 col-form-label text-left text-sm-right">Judul</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="comp_title" id="comp_title" placeholder="Judul atau Perihal">
                                <div class="mb-1 mt-2">
                                    <span id="title_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="comp_message" class="col-sm-2 col-form-label text-left text-sm-right">Pesan</label>
                            <div class="col-sm-10">
                                <textarea class="form-control is-invalid" name="comp_message" id="comp_message" placeholder="Pesan"></textarea>
                                <div class="alert alert-warning py-1 mt-2 px-4" role="alert">
                                    <div class="row align-items-center">
                                        <i class="fas fa-fw fa-exclamation-circle fa-1x mx-auto mx-sm-1"></i>
                                        <small class="ml-1"> Catatan : Jika ingin menghapus gambar silahkan klik gambar lalu pilih tombol "Hapus Gambar"</small>
                                    </div>
                                </div>
                                <div class="mb-1 mt-2">
                                    <span id="message_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 offset-md-4 mt-4">
                                <button id="btn-send" type="submit" class="btn btn-primary btn-block">Kirim</button>
                            </div>
                        </div>
                        <?= form_close() ?>
                    </div>

                    <div class="container tab-pane fade" id="complainttab2" role="tabpanel" aria-labelledby="historyComplaint">

                        <h4 class="text-center my-4">Riwayat Komplain Pelanggan</h4>
                        <div class="table-responsive my-4">
                            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="10px">#</th>
                                        <th>Kode Komplain</th>
                                        <th>Tanggal Komplain</th>
                                        <th>Perihal Komplain</th>
                                        <th width="50px">Pesan</th>
                                        <th>Status</th>
                                        <th>Diperbarui</th>
                                    </tr>

                                <tbody>

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
    var method;

    function message(id) {
        $('#complaint').modal('show');
        $('.modal-title').text('Pesan Anda');
        method = 'applicant';
        compData(id);
    };

    function reply(id) {
        $('#complaint').modal('show');
        $('.modal-title').text('Balasan Pesan Anda');
        method = 'employee';
        compData(id);
    };

    function compData(id) {
        $.ajax({
            url: "<?php echo site_url('complaint/message') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    if (method == 'applicant') {
                        $('.modal-body').html(data.comp_message);
                    } else if (method == 'employee') {
                        $('.modal-body').html('<p>Petugas : </p><p class="mt-n3">' + data.employee + '</p>' + data.reply_message);
                    } else {
                        $('.modal-body').text('-');
                    };
                    $('.modal-body img').addClass('img-responsive img-thumbnail');

                } else {
                    $('#sch_type').html('-');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#success_message').html('<div class="alert alert-danger animated zoomIn fast" role="alert">Kesalahan mendapatkan data dari ajax.</div>');
                // close the message after seconds
                $('.alert-danger').delay(1000).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).remove();
                    });
                });
                $('#schedule').modal('hide');
            }
        });
    };

    $(document).ready(function() {

        //datatables
        table = $('#dataTable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('complaint/list') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [-3, -2, -1, 0],
                "className": 'text-center',
                "orderable": false, //set not orderable
            }],

        });

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax 
        };

        $('#form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url(); ?>complaint/add",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#btn-send').attr('disabled', 'disabled');
                },
                success: function(data) {
                    if (data.error) {
                        if (data.title_error != '') {
                            $('#title_error').html(data.title_error);
                            $('#comp_title').addClass('is-invalid');
                        } else {
                            $('#title_error').html('');
                            $('#comp_title').removeClass('is-invalid');
                        }
                        if (data.message_error != '') {
                            $('#message_error').html(data.message_error);
                            $('#comp_message').addClass('is-invalid');
                        } else {
                            $('#message_error').html('');
                            $('#comp_message').removeClass('is-invalid');
                        }
                    }
                    if (data.success) {
                        $('#success_message').html(data.success);
                        $('#title_error').html('');
                        $('#comp_title').removeClass('is-invalid').html('');
                        $('#message_error').html('');
                        $('#comp_message').removeClass('is-invalid').html('');
                        $('.note-editable').html('');
                        $('#form')[0].reset();
                        reload_table();
                        $('.alert-success').delay(1000).show(10, function() {
                            $(this).delay(3000).hide(10, function() {
                                $(this).remove();
                            });
                        });
                    } else {
                        $('#success_message').html(data.danger);
                        $('#title_error').html('');
                        $('#comp_title').removeClass('is-invalid').html('');
                        $('#message_error').html('');
                        $('#comp_message').removeClass('is-invalid').html('');
                        $('.note-editable').html('');
                        $('#form')[0].reset();
                        reload_table();
                        $('.alert-danger').delay(1000).show(10, function() {
                            $(this).delay(3000).hide(10, function() {
                                $(this).remove();
                            });
                        });
                    }
                    $('#btn-send').attr('disabled', false);
                }
            })
        });

        $("input").change(function() {
            $(this).removeClass('is-invalid');
        });
        $("textarea").change(function() {
            $(this).removeClass('is-invalid');
        });
        $("select").change(function() {
            $(this).removeClass('is-invalid');
        });

        $('#comp_message').summernote({
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
                url: "<?php echo site_url('complaint/upload_image') ?>",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(url) {
                    $('#comp_message').summernote("insertImage", url);
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
                url: "<?php echo site_url('complaint/delete_image') ?>",
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
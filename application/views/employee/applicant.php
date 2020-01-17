<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div id="the-message"></div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 animated zoomIn fast">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" onclick="add_applicant()">
                Tambah Pengguna
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th width="10px">#</thwi>
                            <th>No. Identitas Penduduk</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Diperbarui</th>
                            <th width="98px">Aksi</th>
                        </tr>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url(); ?>';
    $(document).ready(function() {
        //datatables
        table = $('#dataTable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('employee/applicant/list') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [-1, 0],
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-1, 0],
                    "className": 'text-center',
                }
            ],

        });
        // $.fn.dataTable.ext.errMode = 'throw';

        //set input/textarea/select event when change value, remove class error and remove text help block 
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
            $(this).empty()
        });

    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    // var pusher = new Pusher('a96aa6ae29173426fb71', {
    //     cluster: 'ap1',
    //     forceTLS: true
    // });

    // var channel = pusher.subscribe('my-channel');
    // channel.bind('my-event', function(data) {
    //     if (data.message === 'success') {
    //         reload_table()
    //     }
    // });
    // ========================================================

    // Tambah Data
    function add_applicant() {
        save_method = 'add';
        $('#form').show();
        $('#form_photo').hide();
        $('#form')[0].reset(); // reset form on modals
        $('#btnSave').show();
        $('#btnClose').text('Batal');
        $('.form-control').removeClass('is-invalid'); // clear error class
        $('.invalid-feedback').empty(); // clear error string
        $('#rempho').empty();
        $('#applicantForm').modal('show'); // show bootstrap modal
        $('#applicantFormLabel').text('Tambah Data'); // Set Title to Bootstrap modal title
        $('#respassword').hide();
        $('#viewData').hide();
    }

    // Edit Data
    function edit_applicant(id) {
        save_method = 'update';
        $('#form').show();
        $('#form_photo').show();
        $('#form')[0].reset(); // reset form on modals
        $('.form-control').removeClass('is-invalid'); // clear error class
        $('.invalid-feedback').empty(); // clear error string
        $('#rempho').empty();
        $('#btnSave').show();
        $('#btnClose').text('Batal');
        $('#respassword').show();
        $('#viewData').hide();
        $('#password_success').empty();

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('employee/applicant/view') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="applicant_id"]').val(data.applicant_id);
                $('[name="first_name"]').val(data.first_name);
                $('[name="last_name"]').val(data.last_name);
                $('[name="nin"]').val(data.nin);
                $('[name="job_category"]').val(data.job_category);
                $('[name="institute"]').val(data.institute);
                $('[name="address"]').val(data.address);
                $('[name="phone"]').val(data.phone);
                $('[name="email"]').val(data.email);
                $('#resetpass').attr('onclick', 'resetpassword(' + data.applicant_id + ')');
                $('#applicantForm').modal('show'); // show bootstrap modal when complete loaded
                $('#applicantFormLabel').text('Edit Data'); // Set title to Bootstrap modal title
                $('#rempho').show();

                if (data.photo) {
                    $('#photo-preview').html('<img src="' + base_url + 'assets/img/profil/' + data.photo + '" class="img-thumbnail rounded-circle profil-admin">'); // show photo
                    if (data.photo != 'default.jpg') {
                        $('#rempho').html('<input type="checkbox" class="custom-control-input" id="remove_photo" value="' + data.photo + '" name="remove_photo"><label class="custom-control-label" for="remove_photo">Hapus foto saat menyimpan</label>'); // remove photo
                    }
                    $('.custom-file-label').text('Ganti Foto'); // label photo upload
                } else {
                    $('.custom-file-label').text('Pilih Foto'); // label photo upload
                    $('#photo-preview').text('(Tidak ada foto)');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert">Kesalahan mendapatkan data dari ajax.</div>');
                // close the message after seconds
                $('.alert-danger').delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).remove();
                    });
                });
                $('#applicantForm').modal('hide');
            }
        });
    }

    // Detail Data
    function view_applicant(id) {
        $('#applicantForm').modal('show'); // show bootstrap modal
        $('#viewData').show();
        $('#applicantFormLabel').text('Detail Data'); // Set Title to Bootstrap modal title
        $('#btnSave').hide();
        $('#btnClose').text('Tutup');
        $('#form').hide();

        $.ajax({
            url: "<?php echo site_url('employee/applicant/view') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                if (data.photo != "default.jpg") {
                    $('#view_photo').attr("href", base_url + "assets/img/profil/" + data.photo);
                    $('#view_photo').attr("target", "_blank");
                } else {
                    $('#view_photo').removeAttr("href");
                    $('#view_photo').removeAttr("target");
                }
                $('#view_photo').html('<img src="' + base_url + 'assets/img/profil/' + data.photo + '" class="img-thumbnail rounded-circle profil-admin mb-3" alt="' + data.first_name + '">');
                $('#view_fullname').text(data.first_name + ' ' + data.last_name);
                $('#view_nin').text(data.nin);
                $('#view_job_category').text(data.jobcat);
                $('#view_institute').text(data.institute);
                $('#view_address').text(data.address);
                $('#view_phone').text(data.phone);
                $('#view_email').text(data.email);
                $('#view_is_active').text(data.is_active);
                $('#view_date_created').text(data.date_created);
                $('#view_date_update').text(data.date_update);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert">Kesalahan mendapatkan data dari ajax.</div>');
                // close the message after seconds
                $('.alert-danger').delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).remove();
                    });
                });
                $('#applicantForm').modal('hide');
            }
        });
    }

    //resetpassword
    function resetpassword(id) {
        $('#resetpass').text('Proses...'); //change button text
        $('#resetpass').attr('disabled', true); //set button disable 
        // ajax delete data to database
        $.ajax({
            url: "<?php echo site_url('employee/applicant/resetpassword') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('#password_message').show().addClass('text-success').text('Kata sandi baru berhasil di kirim ke email!');
                // close the message after seconds
                $('#password_message').delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).removeClass('text-success');
                        $(this).empty();
                    });
                });
                $('#resetpass').text('Atur ulang kata sandi'); //change button text
                $('#resetpass').attr('disabled', false); //set button disable 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#password_message').show().addClass('text-danger').text('Kata sandi baru gagal di kirim ke email!');
                // close the message after seconds
                $('#password_message').delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).removeClass('text-danger');
                        $(this).empty();
                    });
                });
                $('#resetpass').text('Atur ulang kata sandi'); //change button text
                $('#resetpass').attr('disabled', false); //set button disable 
            }
        });
    }

    //Tambah Data
    function save() {
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;
        var act_success;
        var act_danger;

        if (save_method == 'add') {
            url = "<?php echo site_url('employee/applicant/add') ?>";
            act_success = "ditambahkan";
            act_danger = "menambah";
        } else {
            url = "<?php echo site_url('employee/applicant/update') ?>";
            act_success = "diedit";
            act_danger = "mengedit";
        }

        // ajax adding data to database
        var formData = new FormData($('#form')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#applicantForm').modal('hide');
                    $('#the-message').html('<div class="alert alert-success animated zoomIn fast" role="alert"><strong>Selamat! </strong> Data Pengguna berhasil ' + act_success + '.</div>');
                    // close the message after seconds
                    $('.alert-success').delay(500).show(10, function() {
                        $(this).delay(3000).hide(10, function() {
                            $(this).remove();
                        });
                    });
                    reload_table();
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('#' + data.inputerror[i]).addClass('is-invalid');
                        $('#' + data.inputerror[i] + '_error').text(data.error_string[i]);
                    }
                }

                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 


            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#applicantForm').modal('hide');
                $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert"><strong>Maaf!</strong> Anda gagal ' + act_danger + ' Data Pengguna.</div>');
                // close the message after seconds
                $('.alert-danger').delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).remove();
                    });
                });
                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            }
        });

    }

    function delete_applicant(id) {
        $('#deleteData').modal('show'); // show bootstrap modal
        $('#btn-delete').click(function() {
            // ajax delete data to database
            $.ajax({
                url: "<?php echo site_url('employee/applicant/delete') ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    //if success reload ajax table
                    $('#the-message').html('<div class="alert alert-success animated zoomIn fast" role="alert"><strong>Selamat! </strong> Data Pengguna berhasil dihapus.</div>');
                    // close the message after seconds
                    $('.alert-success').delay(500).show(10, function() {
                        $(this).delay(3000).hide(10, function() {
                            $(this).remove();
                        });
                    });
                    $('#deleteData').modal('hide');
                    $('#modal_form').modal('hide');
                    reload_table();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert"><strong>Maaf!</strong> Anda gagal menghapus data Pengguna.</div>');
                    // close the message after seconds
                    $('.alert-danger').delay(500).show(10, function() {
                        $(this).delay(3000).hide(10, function() {
                            $(this).remove();
                        });
                    });
                    $('#deleteData').modal('hide');
                }
            });
        });

    }
</script>
<!-- Modal Add/Update -->
<div class="modal fade" id="applicantForm" tabindex="-1" role="dialog" aria-labelledby="applicantFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bolder" id="applicantFormLabel">Data Pegawai</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <div class="text-break" id="viewData">
                    <div class="mx-auto text-center">
                        <a id="view_photo" target="_blank">
                        </a>
                        <h4 class="text-primary font-weight-bold" id="view_fullname">Imam Agustian Nugraha</h4>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="nin" class="col-sm-5 col-form-label text-sm-right font-weight-bold">Nomor Identitas (KTP)</label>
                        <div class="col-sm-7 text-primary text-lg my-auto" id="view_nin">
                            Nomor Identitas (KTP)
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="job_category" class="col-sm-5 col-form-label text-sm-right font-weight-bold">Kategori Pekerjaan</label>
                        <div class="col-sm-7 text-primary text-lg my-auto" id="view_job_category">
                            Kategori Pekerjaan
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="institute" class="col-sm-5 col-form-label text-sm-right font-weight-bold">Nama Instansi</label>
                        <div class="col-sm-7 text-primary text-lg my-auto" id="view_institute">
                            Nama Instansi
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="address" class="col-sm-5 col-form-label text-sm-right font-weight-bold">Alamat Lengkap</label>
                        <div class="col-sm-7 text-primary text-lg my-auto" id="view_address">
                            Alamat Lengkap
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-5 col-form-label text-sm-right font-weight-bold">No. Handphone</label>
                        <div class="col-sm-7 text-primary text-lg my-auto" id="view_phone">
                            No. Handphone
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="email" class="col-sm-5 col-form-label text-sm-right font-weight-bold">Email</label>
                        <div class="col-sm-7 text-primary text-lg my-auto" id="view_email">
                            Email
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="is_active" class="col-sm-5 col-form-label text-sm-right font-weight-bold">Status Akun</label>
                        <div class="col-sm-7 text-primary text-lg my-auto" id="view_is_active">
                            --
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="level" class="col-sm-5 col-form-label text-sm-right font-weight-bold">Tanggal Pembuatan Akun</label>
                        <div class="col-sm-7 text-primary text-lg my-auto" id="view_date_created">
                            00 Januari 0000
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="level" class="col-sm-5 col-form-label text-sm-right font-weight-bold">Terakhir diperbarui</label>
                        <div class="col-sm-7 text-primary text-lg my-auto" id="view_date_update">
                            00-00-0000 00:00:00
                        </div>
                    </div>
                    <!-- <hr>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary btn-info">Edit Data</button>
                        <button type="button" class="btn btn-primary btn-danger">Hapus Data</button>
                    </div> -->
                </div>

                <form action="#" id="form">
                    <input type="hidden" name="applicant_id" />
                    <div class="form-group row">
                        <label for="first_name" class="col-sm-3 col-form-label text-sm-right font-weight-bold">Nama Depan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Nama Depan" value="">
                            <div id="first_name_error" class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="last_name" class="col-sm-3 col-form-label text-sm-right font-weight-bold">Nama Belakang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Nama Belakang" aria-describedby="lastnameHelpBlock" value="">
                            <small id="lastnameHelpBlock" class="form-text text-muted">
                                Jika tidak memiliki nama belakang kosongkan saja.
                            </small>
                            <div id="last_name_error" class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nin" class="col-sm-3 col-form-label text-sm-right font-weight-bold">Nomor Identitas (KTP)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nin" onkeypress="return numberOnly(event)" maxlength="16" id="nin" placeholder="No. Identitas Pegawai (NIP)" value="">
                            <div id="nin_error" class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="job_category" class="col-sm-3 col-form-label text-sm-right font-weight-bold">Kategori Pekerjaan</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="job_category" id="job_category">
                                <option value="">Pilih...</option>
                                <?php foreach ($jobcat->result() as $jc) : ?>
                                    <option value="<?= $jc->jobcat_id; ?>"><?= $jc->jobcat; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="job_category_error" class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="institute" class="col-sm-3 col-form-label text-sm-right font-weight-bold">Nama Instansi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="institute" id="institute" placeholder="Nama Instansi" aria-describedby="instituteHelpBlock" value="">
                            <small id="instituteHelpBlock" class="form-text text-muted">
                                Nama Instansi / Nama Perusahaan / Nama Sekolah / Nama Universitas
                            </small>
                            <div id="institute_error" class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-sm-3 col-form-label text-sm-right font-weight-bold">Alamat Lengkap</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="address" id="address" rows="3" placeholder="Alamat Lengkap" aria-describedby="addressHelpBlock"></textarea>
                            <small id="addressHelpBlock" class="form-text text-muted">
                                Alamat harus lengkap sesuai dengan No. Identitas/KTP.
                            </small>
                            <div id="address_error" class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-3 col-form-label text-sm-right font-weight-bold">No. Handphone</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="No. Handphone" aria-describedby="phoneHelpBlock" value="">
                            <small id="phoneHelpBlock" class="form-text text-muted">
                                Pastikan nomor handpone anda aktif dan gunakan nomor yang sudah terdaftar di whatsapp jika ada.
                            </small>
                            <div id="phone_error" class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label text-sm-right font-weight-bold">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="" aria-describedby="emailHelpBlock">
                            <small id="emailHelpBlock" class="form-text text-muted">
                                Pastikan email Anda aktif. Kami akan mengirimkan email untuk mengaktifkan akun Anda.
                            </small>
                            <div id="email_error" class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="respassword">
                        <label for="password" class="col-sm-3 col-form-label text-sm-right font-weight-bold">Password</label>
                        <div class="col-sm-9 my-auto">
                            <button id="resetpass" type="button" class="btn btn-primary btn-sm">Atur ulang kata sandi</button>
                            <small id="password_message" class="ml-sm-1 my-2 d-block d-sm-inline"></small>
                        </div>
                    </div>
                    <div class="form-group row" id="form_photo">
                        <div class="col-sm-3 text-sm-right font-weight-bold">Foto Profil</div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3" id="photo-preview">
                                </div>
                                <div class="col-sm-9">
                                    <div class="custom-file">
                                        <input type="file" name="photo" id="photo" hidden>
                                        <div id="rempho" class="custom-control custom-checkbox mt-1">
                                        </div>
                                        <div id="photo_error" class="invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnClose" type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button id="btnSave" onclick="save()" type="button" class="btn btn-primary">Simpan</button>
            </div>

        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteData" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Anda yakin menghapus data ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Data yang dihapus tidak akan bisa dikembalikan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button id="btn-delete" type="button" class="btn btn-primary">Hapus</button>
            </div>
        </div>
    </div>
</div>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div id="the-message"></div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 animated zoomIn fast">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" onclick="add_pos()">
                Tambah Jabatan
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th width="18px">#</th>
                            <th>Nama Jabatan</th>
                            <th>Keterangan</th>
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
                "url": "<?php echo site_url('employee/position/list') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [-1, 0],
                "className": 'text-center',
                "orderable": false, //set not orderable
            }],
            "oLanguage": {
                "sInfo": "Total _TOTAL_ data, menampilkan data (_START_ sampai _END_)",
                "sInfoFiltered": " - filtering from _MAX_ records",
                "sSearch": "Pencarian :",
                "sInfoEmpty": "Belum ada data untuk saat ini",
                "sLengthMenu": "Menampilkan _MENU_",
                "oPaginate": {
                    "sPrevious": "Sebelumnya",
                    "sNext": "Selanjutnya"
                },
                "sZeroRecords": "Tidak ada data"
            }
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
    function add_pos() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('#btnSave').show();
        $('#btnClose').text('Batal');
        $('.form-control').removeClass('is-invalid'); // clear error class
        $('.invalid-feedback').empty(); // clear error string
        $('#posForm').modal('show'); // show bootstrap modal
        $('#posFormLabel').text('Tambah Data'); // Set Title to Bootstrap modal title
    }

    // Edit Data
    function edit_pos(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-control').removeClass('is-invalid'); // clear error class
        $('.invalid-feedback').empty(); // clear error string
        $('#btnSave').show();
        $('#btnClose').text('Batal');

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('employee/position/view') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="pos_id"]').val(data.pos_id);
                $('[name="pos_name"]').val(data.pos_name);
                $('[name="pos_information"]').val(data.pos_information);
                $('#posForm').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert">Kesalahan mendapatkan data dari ajax.</div>');
                // close the message after seconds
                $('.alert-danger').delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).remove();
                    });
                });
                $('#posForm').modal('hide');
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
            url = "<?php echo site_url('employee/position/add') ?>";
            act_success = "ditambahkan";
            act_danger = "menambah";
        } else {
            url = "<?php echo site_url('employee/position/update') ?>";
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
                    $('#posForm').modal('hide');
                    $('#the-message').html('<div class="alert alert-success animated zoomIn fast" role="alert"><strong>Selamat! </strong> Data Jabatan berhasil ' + act_success + '.</div>');
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
                $('#posForm').modal('hide');
                $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert"><strong>Maaf!</strong> Anda gagal ' + act_danger + ' Data Jabatan.</div>');
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

    function delete_pos(id) {
        $('#deleteData').modal('show'); // show bootstrap modal
        $('#btn-delete').hide();
        $.ajax({
            url: "<?php echo site_url('employee/position/viewdelete') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                if (data.status) {
                    $('#mesDelete').text(data.message);
                    $('#btn-delete').show();
                    $('#btn-delete').click(function() {
                        deleteBtn(id);
                    });
                } else {
                    $('#mesDelete').text(data.message);
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
                $('#deleteData').modal('hide');
            }
        });
    };

    function deleteBtn(id) {
        // ajax delete data to database
        $.ajax({
            url: "<?php echo site_url('employee/position/delete') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                //if success reload ajax table
                $('#the-message').html('<div class="alert alert-success animated zoomIn fast" role="alert"><strong>Selamat! </strong> Data berhasil dihapus.</div>');
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
                $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert"><strong>Maaf!</strong> Anda gagal menghapus Data.</div>');
                // close the message after seconds
                $('.alert-danger').delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).remove();
                    });
                });
                $('#deleteData').modal('hide');
            }
        });
    }
</script>
<!-- Modal Add/Update -->
<div class="modal fade" id="posForm" tabindex="-1" role="dialog" aria-labelledby="posFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bolder" id="posFormLabel">Data Jabatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form">
                    <input type="hidden" name="pos_id" />
                    <div class="form-group row">
                        <label for="pos" class="col-sm-3 col-form-label text-sm-right font-weight-bold">Nama Jabatan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="pos_name" id="pos_name" placeholder="Nama Jabatan" value="">
                            <div id="pos_name_error" class="invalid-feedback">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pos_information" class="col-sm-3 col-form-label text-sm-right font-weight-bold">Keterangan</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="pos_information" id="pos_information" rows="3" placeholder="Keterangan" aria-describedby="pos_informationHelpBlock"></textarea>
                            <div id="pos_information_error" class="invalid-feedback">
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
            <div class="modal-body" id="mesDelete">
                Data yang dihapus tidak akan bisa dikembalikan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button id="btn-delete" type="button" class="btn btn-primary">Hapus</button>
            </div>
        </div>
    </div>
</div>
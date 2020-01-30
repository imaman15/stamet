<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?= $this->session->flashdata('message');
    ?>
    <div id="the-message"></div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 animated zoomIn fast">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" onclick="add_schedule()">
                Ajukan Pertemuan
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th width="10px">#</th>
                            <th>Kode Jadwal</th>
                            <th>Jenis Pertemuan</th>
                            <th width="85px">Tanggal Pertemuan</th>
                            <th>Penanggung jawab</th>
                            <th>Status</th>
                            <th width="7%" class="text-break">Pesan</th>
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
    var url = "<?= site_url(UA_SCHEDULE) ?>";

    function add_schedule() {
        window.location.replace(url);
    };

    var table;
    var method;
    $(document).ready(function() {
        //datatables
        table = $('#dataTable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('schedule/list') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [-3, -2, -1, 0],
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
        // $("input").change(function() {
        //     $(this).removeClass('is-invalid');
        // });
        // $("textarea").change(function() {
        //     $(this).removeClass('is-invalid');
        // });
        // $("select").change(function() {
        //     $(this).removeClass('is-invalid');
        // });
        // $(".invalid-feedback").change(function() {
        //     $(this).empty();
        // });
        // $("#photo").change(function() {
        //     $('#photo_error').empty();
        // });

    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    };

    function cancel(id) {
        $('#btnDelete').show();
        $('#viewData').hide();
        $('#schedule').modal('show');
        $('.modal-title').text('Batalkan Jadwal Pertemuan');
        $('#action').show().html('Anda yakin untuk membatalkan pertemuan dengan kode  ' + id + ' ? <br> Silahkan klik simpan untuk merubah status');
        $('.modal-dialog').removeClass('modal-lg');

        $('#btnDelete').click(function() {
            // ajax delete data to database
            $.ajax({
                url: "<?php echo site_url('schedule/cancel') ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    //if success reload ajax table
                    $('#the-message').html('<div class="alert alert-success animated zoomIn fast" role="alert">Pertemuan dengan kode ' + id + ' berhasil di batalkan</div>');
                    // close the message after seconds
                    $('.alert-success').delay(500).show(10, function() {
                        $(this).delay(3000).hide(10, function() {
                            $(this).remove();
                        });
                    });
                    $('#schedule').modal('hide');
                    reload_table();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert"><strong>Maaf!</strong> Pertemuan dengan kode ' + id + ' gagal di batalkan.</div>');
                    // close the message after seconds
                    $('.alert-danger').delay(500).show(10, function() {
                        $(this).delay(3000).hide(10, function() {
                            $(this).remove();
                        });
                    });
                    $('#schedule').modal('hide');
                }
            });
        });
    };

    function message(id) {
        method = 'applicant';
        $('#viewData').show();
        $('#btnDelete').hide();
        $('.modal-dialog').addClass('modal-lg');
        $('#schedule').modal('show');
        $('#labelName').text('Nama Pemohon');
        $('#labelMessage').text('Pesan Anda');
        $('.modal-title').text('Pesan Anda');
        $('#action').hide();
        schData(id);
    };

    function reply(id) {
        method = 'employee';
        $('#btnDelete').hide();
        $('#viewData').show();
        $('.modal-dialog').addClass('modal-lg');
        $('#schedule').modal('show');
        $('#labelName').text('Nama Petugas');
        $('#labelMessage').text('Balasan Pesan Anda');
        $('.modal-title').text('Balasan Pesan Anda');
        $('#action').hide();
        schData(id);
    };

    function schData(id) {
        $.ajax({
            url: "<?php echo site_url('schedule/schMessage') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    $('#sch_type').text(data.sch_type);
                    $('#sch_title').text(data.sch_title);
                    $('#date_created').text(data.date_created)
                    $('#date_update').text(data.date_update);

                    if (method == 'applicant') {
                        $('#viewName').text(data.applicant);
                        $('#message').html(data.sch_message);
                    } else if (method == 'employee') {
                        if (data.sch_reply && data.employee) {
                            $('#message').html(data.sch_reply);
                            $('#viewName').text(data.employee);
                        } else {
                            $('#message').html('-');
                            $('#viewName').text('-');
                        };

                    } else {
                        $('#viewName').text('-');
                        $('#message').html('-');
                    };
                    $('#message img').addClass('img-responsive img-thumbnail');

                } else {
                    $('#sch_type').text('-');
                    $('#sch_title').text('-');
                    $('#viewName').text('-');
                    $('#date_created').text('-');
                    $('#date_update').text('-');
                    $('#message').text('-');
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
                $('#schedule').modal('hide');
            }
        });
    };
</script>

<!-- Modal -->
<div class="modal fade" id="schedule" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="action"></div>
            <div class="modal-body text-break" id="viewData">
                <div class="mx-auto text-center">
                    <h4 class="text-primary font-weight-bold" id="sch_type">Konsultasi Data</h4>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="sch_title" class="col-sm-4 col-form-label text-sm-right font-weight-bold">Judul / Perihal</label>
                    <div class="col-sm-8 text-primary text-lg my-auto" id="sch_title">
                        Konsultasi data untuk pembangunan Hotel di Jakarta
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="nama" id="labelName" class="col-sm-4 col-form-label text-sm-right font-weight-bold">Nama Pemohon</label>
                    <div class="col-sm-8 text-primary text-lg my-auto" id="viewName">
                        -
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="date_created" class="col-sm-4 col-form-label text-sm-right font-weight-bold">Tanggal Dibuat</label>
                    <div class="col-sm-8 text-primary text-lg my-auto" id="date_created">
                        19 November 2020
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="date_update" class="col-sm-4 col-form-label text-sm-right font-weight-bold">Terakhir Diperbarui</label>
                    <div class="col-sm-8 text-primary text-lg my-auto" id="date_update">
                        19-01-2020 09:07:10
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="message" id="labelMessage" class=" col-form-label text-center col-12 font-weight-bold">Pesan Anda</label>
                    <div class="text-break" id="message">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia, nobis, dignissimos voluptas alias nemo voluptatem corrupti aspernatur itaque commodi neque animi non odio illum nulla mollitia dolor. Maxime, dignissimos perferendis.
                    </div>
                </div>
                <!-- <hr>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary btn-info">Edit Data</button>
                        <button type="button" class="btn btn-primary btn-danger">Hapus Data</button>
                    </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btnDelete" type="button" class="btn btn-danger">Batalkan</button>
            </div>
        </div>
    </div>
</div>
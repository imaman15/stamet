<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div id="the-message"></div>
    <?= $this->session->flashdata('message');
    ?>
    <!-- DataTales Example -->
    <div class="card shadow mb-4 animated zoomIn fast">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th width="10px">#</th>
                            <th>Kode</th>
                            <th>Jadwal Pertemuan</th>
                            <th>Pemohon</th>
                            <th>Penanggung Jawab (PJ)</th>
                            <th>Status</th>
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
    $(document).ready(function() {

        //datatables
        table = $('#dataTable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('employee/schedule/list') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [0],
                "className": 'text-center',
                "orderable": false, //set not orderable
            }, {
                "targets": [-1, 2, 3, 4],
                "className": 'text-center',
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


    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    };

    function message(id) {
        $('#schedulemess').modal('show');
        $('#schedulemess .modal-title').text('Pesan Anda');
        method = 'applicant';
        schData(id);
    };

    function reply(id) {
        $('#schedulemess').modal('show');
        $('#schedulemess .modal-title').text('Balasan Pesan Anda');
        method = 'employee';
        schData(id);
    };

    function update(id) {
        window.location.replace('<?= site_url(UE_SCHEDULE) ?>/pesan/' + id);
    };

    function schData(id) {
        $.ajax({
            url: "<?php echo site_url('employee/schedule/message') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    if (method == 'applicant') {
                        $('#schedulemess .modal-body').html(data.sch_message);
                    } else if (method == 'employee') {
                        $('#schedulemess .modal-body').html('<p>Petugas : </p><p class="mt-n3">' + data.employee + '</p>' + data.sch_reply);
                    } else {
                        $('#schedulemess .modal-body').text('-');
                    };
                    $('#schedulemess .modal-body img').addClass('img-responsive img-thumbnail');

                } else {
                    $('#schedulemess .modal-body').html('-');
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

    function confirm(id) {
        $('#updateId').modal('show');
        $('#updateId .modal-title').html('Konfirmasi <br>' + id);
        $('#form').hide();
        $('#btnChange').hide();
        $('#confirmText').show();
        $('#confirmText').text('Anda akan menjadi Penanggung Jawab Pertemuan ini jika mengonfirmasinya.');
        $('#btnConfirm').show();
        $('#btnConfirm').click(function() {
            // ajax delete data to database
            $.ajax({
                url: "<?php echo site_url('employee/schedule/confirm') ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    //if success reload ajax table
                    $('#the-message').html('<div class="alert alert-success animated zoomIn fast" role="alert">Pertemuan dengan kode ' + id + ' sudah di konfirmasi</div>');
                    // close the message after seconds
                    $('.alert-success').delay(500).show(10, function() {
                        $(this).delay(3000).hide(10, function() {
                            $(this).remove();
                        });
                    });
                    $('#updateId').modal('hide');
                    reload_table();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert"><strong>Maaf!</strong> Pertemuan dengan kode ' + id + ' gagal di konfirmasi.</div>');
                    // close the message after seconds
                    $('.alert-danger').delay(500).show(10, function() {
                        $(this).delay(3000).hide(10, function() {
                            $(this).remove();
                        });
                    });
                    $('#updateId').modal('hide');
                }
            });
        });
    }

    function status(id) {
        $('#updateId').modal('show');
        $('#updateId .modal-title').html('Ganti Status <br>' + id);
        $('#form').show();
        $('#btnChange').show();
        $('#confirmText').hide();
        $('#btnConfirm').hide();
        $('#btnChange').click(function() {
            // ajax delete data to database
            var formData = new FormData($('#form')[0]);
            $.ajax({
                url: "<?php echo site_url('employee/schedule/status') ?>/" + id,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data) {
                    //if success reload ajax table
                    $('#the-message').html('<div class="alert alert-success animated zoomIn fast" role="alert">Status berhasil diperbarui</div>');
                    // close the message after seconds
                    $('.alert-success').delay(500).show(10, function() {
                        $(this).delay(3000).hide(10, function() {
                            $(this).remove();
                        });
                    });
                    $('#updateId').modal('hide');
                    reload_table();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert"><strong>Maaf!</strong> Status gagal diperbarui.</div>');
                    // close the message after seconds
                    $('.alert-danger').delay(500).show(10, function() {
                        $(this).delay(3000).hide(10, function() {
                            $(this).remove();
                        });
                    });
                    $('#updateId').modal('hide');
                }
            });
        });
    };
</script>

<!-- Modal -->
<div class="modal fade" id="schedulemess" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="updateId" tabindex="-1" role="dialog" aria-labelledby="updateTitleId" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="form">
                    <div class="form-group">
                        <select class="form-control" name="status" id="status">
                            <option value="2">Berlangsung</option>
                            <option value="3">Selesai</option>
                            <option id="cancel" value="4">Dibatalkan</option>
                        </select>
                    </div>
                </form>
                <div id="confirmText"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btnChange" class="btn btn-primary">Simpan</button>
                <button type="button" id="btnConfirm" class="btn btn-primary">Konfirmasi</button>
            </div>
        </div>
    </div>
</div>
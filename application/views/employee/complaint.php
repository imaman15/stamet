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
                        <tr>
                            <th width="10px">#</th>
                            <th>Komplain</th>
                            <th>Perihal Komplain</th>
                            <th>Pemohon</th>
                            <th>Petugas</th>
                            <th>Status</th>
                        </tr>
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
    var method;

    $(document).ready(function() {

        //datatables
        table = $('#dataTable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('employee/complaint/list') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [0],
                "className": 'text-center',
                "orderable": false, //set not orderable
            }, {
                "targets": [-1, 3, 4],
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
        $('#complaint').modal('show');
        $('#complaint .modal-title').text('Pesan Anda');
        method = 'applicant';
        compData(id);
    };

    function reply(id) {
        $('#complaint').modal('show');
        $('#complaint .modal-title').text('Balasan Pesan Anda');
        method = 'employee';
        compData(id);
    };

    function compData(id) {
        $.ajax({
            url: "<?php echo site_url('employee/complaint/message') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    if (method == 'applicant') {
                        $('#complaint .modal-body').html(data.comp_message);
                    } else if (method == 'employee') {
                        $('#complaint .modal-body').html('<p>Petugas : </p><p class="mt-n3">' + data.employee + '</p>' + data.reply_message);
                    } else {
                        $('#complaint .modal-body').text('-');
                    };
                    $('#complaint .modal-body img').addClass('img-responsive img-thumbnail');

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

    function update(id) {
        window.location.replace('<?= site_url(UE_COMPLAINT) ?>/pesan/' + id);
    };

    function status(id) {
        $('#updateId').modal('show');
        $('#updateId .modal-title').text('Ganti Status Komplain');
        $('#btnChange').click(function() {
            // ajax delete data to database
            var formData = new FormData($('#form')[0]);
            $.ajax({
                url: "<?php echo site_url('employee/complaint/status') ?>/" + id,
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
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                            <option value="tertunda">Tertunda</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btnChange" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
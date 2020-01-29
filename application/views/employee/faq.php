<!-- Summernote -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/vendor/summernote/summernote-bs4.min.css'; ?>">
<!-- End of Summernote -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div id="the-message"></div>
    <?= $this->session->flashdata('message');
    ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 animated zoomIn fast">
        <div class="card-header py-3">
            <div class="row justify-content-between">
                <div class="col-md-4 col-12 text-sm-left text-center">
                    <button type="button" class="btn btn-primary" onclick="add_faqs()">
                        Tambah FAQS
                    </button>
                </div>
                <div class="col-md-4 text-sm-right text-center text-break col-12 mt-sm-0 mt-2">
                    <button type="button" class="btn btn-primary btn-icon-split btn" onclick="view()">
                        <span class="icon text-white-50">
                            <i class="fas fa-question"></i>
                        </span>
                        <span class="text">Lihat Tampilan FAQS</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th width="5%">#</th>
                            <th>Judul Pertanyaan</th>
                            <th>Jawaban</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Diperbarui</th>
                            <th width="7%" class="text-break">Aksi</th>
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
    function view() {
        window.location.replace('<?= site_url(FAQ) ?>');
    }

    function add_faqs() {
        window.location.replace('<?= site_url(UE_MANAGEFAQ . UE_ADD) ?>');
    }

    function edit_faqs(id) {
        window.location.replace('<?= site_url(UE_MANAGEFAQ . UE_UPDATE) ?>/' + id);
    }

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
                "url": "<?php echo site_url('employee/faqs/list') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [-1, 0],
                "className": 'text-center',
                "orderable": false, //set not orderable
            }, {
                "targets": [2],
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

    function view_faqs(id) {
        $('#viewId').modal('show');
        $.ajax({
            url: "<?php echo site_url('employee/faqs/view') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#viewId .modal-title').text(data.faqs_questions);
                $('#viewId .modal-body').html(data.faqs_answers);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert">Kesalahan mendapatkan data dari ajax.</div>');
                // close the message after seconds
                $('.alert-danger').delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).remove();
                    });
                });
                $('#viewId').modal('hide');
            }
        });
    }

    function delete_faqs(id) {
        $('#deleteData').modal('show'); // show bootstrap modal
        // ajax delete data to database
        $('#btn-delete').click(function() {
            $.ajax({
                url: "<?php echo site_url('employee/faqs/delete') ?>/" + id,
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
                    reload_table();
                }
            });
        });
    }
</script>

<!-- Modal Lihat FAQS-->
<div class="modal fade" id="viewId" tabindex="-1" role="dialog" aria-labelledby="viewTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Jawaban Dari Pertanyaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                -
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteData" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Anda yakin ingin menghapus data ini?</h5>
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
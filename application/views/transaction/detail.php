<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-center text-gray-800"><?= $title; ?></h1>

    <div class="col-12">
        <?= $this->session->flashdata('message');
        ?>
        <nav class="d-print-none" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url(UA_TRANSHISTORY) ?>">Riwayat Transaksi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Transaksi</li>
            </ol>
        </nav>
        <div class="card shadow mb-4 animated zoomIn fast">
            <div class="card-body">
                <!-- <button type="button" onclick="printContent('print')" class="btn rounded btn-sm btn-primary d-print-none mb-2 mt-n2 float-right">Cetak</button> -->

                <div class="d-print-flex" id="print">
                    <h4 class="d-none d-print-block text-center">Sistem Informasi Pelayanan Jasa Meteorologi</h4>

                    <table class="table table-bordered">
                        <tr>
                            <th width="20%">Kode Transaksi </th>
                            <th><?= $trans->trans_code; ?></th>
                        </tr>
                        <tr>
                            <td>Tanggal Transaksi</td>
                            <td><?= DateTime($trans->date_created); ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Informasi</td>
                            <td>
                                <?php
                                if ((in_array($trans->trans_status, [2, 3, 4])) && (in_array($trans->payment_status, [3, 0])) && $trans->trans_request) {
                                    echo $trans->trans_request;
                                } else if ((in_array($trans->payment_status, [2, 1, 4, 5])) && (in_array($trans->trans_status, [1, 5])) && $trans->subtype_id) {
                                    echo $request;
                                } else {
                                    echo "-";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Tarif - Satuan</td>
                            <td>
                                <?php
                                if ((in_array($trans->trans_status, [2, 3, 4])) && (in_array($trans->payment_status, [3, 0])) && $trans->trans_rates && $trans->emp_posname) {
                                    echo rupiah($trans->trans_rates) . " - " .  $trans->emp_posname;
                                } else if ((in_array($trans->payment_status, [2, 1, 4, 5])) && (in_array($trans->trans_status, [1, 5])) && $trans->subtype_id) {
                                    echo $rates;
                                } else {
                                    echo "-";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td>
                                <?php
                                if ($trans->trans_unit) {
                                    echo $trans->trans_unit;
                                } else {
                                    echo "-";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>
                                <?php
                                if ($trans->trans_sum) {
                                    echo rupiah($trans->trans_sum);
                                } else {
                                    echo "-";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Status Transaksi</td>
                            <td>
                                <?php
                                if ($trans->trans_status) {
                                    echo statusTrans($trans->trans_status, 'transaction');
                                } else {
                                    echo "-";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Petugas Layanan</td>
                            <td>
                                <?php
                                if ((in_array($trans->trans_status, [2, 3, 4])) && (in_array($trans->payment_status, [3, 0])) && $trans->emp_name && $trans->emp_posname) {
                                    echo $trans->emp_name . " - " .  $trans->emp_posname;
                                } else if ((in_array($trans->payment_status, [2, 1, 4, 5])) && (in_array($trans->trans_status, [1, 5])) && $trans->emp_id) {
                                    echo $emp_name . " - " . $emp_posname;
                                } else {
                                    echo "-";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr class="text-center d-print-none">
                            <td colspan="2">
                                <button type="button" class="btn btn-secondary btn-sm rounded" onclick="applicantNote()">Lihat Catatan Anda</button>
                                <?php if ($trans->trans_information) : ?>
                                    <button type="button" class="btn btn-dark btn-sm rounded" onclick="employeeNote()">Lihat Catatan Petugas</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card-footer mt-n4">
                <button type="button" class="btn btn-primary rounded btn-sm my-3" onclick="addDocument()">Tambah Dokumen</button>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nama Berkas</th>
                                <th>Uploader</th>
                                <th>Tanggal & Waktu</th>
                                <th>Keterangan</th>
                                <th width="60px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-muted small">
                Terakhir di perbarui : <?= timeInfo($user->date_update) ?>
            </div>
        </div>

    </div>

</div>


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
                "url": "<?php echo site_url('transaction/docList/') ?>" + "<?= $trans->trans_id; ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [-1, 0],
                "className": 'text-center',
                "orderable": false, //set not orderable
            }],

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
            $(this).empty();
        });
        $("#photo").change(function() {
            $('#photo_error').empty();
        });

    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    // Tambah Data
    function addDocument() {
        save_method = 'add';
        $('#documentModal #form')[0].reset(); // reset form on modals
        $('#documentModal .form-control').removeClass('is-invalid'); // clear error class
        $('#documentModal .invalid-feedback').empty(); // clear error string
        $('#documentModal').modal('show');
    }



    function printContent(el) {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }

    function applicantNote() {
        $('#note').modal('show');
        $('#note .modal-title').text('Catatan Anda');
        var message = '<?= $trans->trans_message; ?>'
        if (message) {
            $('#note .modal-body').html(message);
            $('#note .modal-body img').addClass('img-responsive img-thumbnail');
        } else {
            $('#note .modal-body').text('-');
        }
    };

    function employeeNote() {
        $('#note').modal('show');
        $('#note .modal-title').text('Catatan Petugas');
        var information = '<?= $trans->trans_information; ?>'
        if (information) {
            $('#note .modal-body').html(information);
            $('#note .modal-body img').addClass('img-responsive img-thumbnail');
        } else {
            $('#note .modal-body').text('-');
        }
    };
</script>

<!-- Modal -->

<!-- Modal -->
<div class="modal fade" id="documentModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Dokumen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form">
                <div class="modal-body" id="confirm">
                    <div class="text-center text-break mb-4" id="paybefore">
                    </div>

                    <input type="hidden" name="trans_id" id="trans_id" />
                    <div class="form-group">
                        <label for="doc_name">Nama Berkas</label>
                        <input type="text" name="doc_name" id="doc_name" class="form-control" placeholder="" aria-describedby="doc_name">
                        <small id="doc_name_help" class="text-muted">Misal : Bank Central Asia (BCA)</small>
                        <div id="doc_name_error" class="invalid-feedback">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="doc_information">Keterangan</label>
                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="Alamat Lengkap" aria-describedby="addressHelpBlock"></textarea>
                        <small id="doc_information_help" class="text-muted">Misal : Bank Central Asia (BCA)</small>
                        <div id="doc_information_error" class="invalid-feedback">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file" class=" col-form-label">Upload Berkas</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file">
                            <label id='file_label' class="custom-file-label overflow-hidden" for="file">Pilih Berkas</label>
                        </div>
                        <small id="file_help" class="form-text text-muted">
                            Upload berkas dalam format dokumen (pdf atau word) jika ada.
                        </small>
                        <div id="file_error" class="small" style="color:#e74a3b;">
                        </div>
                    </div>
                    <div class="form-group text-center" id="preview">
                        <div class="col-form-label font-weight-bold">Bukti Bayar Sebelumnya</div>
                        <img id="pay_img" class="img-fluid rounded w-75" alt="Bukti Bayar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="btnSave" onclick="save()" type="button" class="btn btn-primary">Kirim</button>
                    <button id="btnDelete" type="button" class="btn btn-danger">Batalkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="note" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
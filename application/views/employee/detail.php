<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap-select/') ?>css/bootstrap-select.min.css">


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-center text-gray-800"><?= $title; ?></h1>

    <div class="col-12">
        <?= $this->session->flashdata('message');
        ?>
        <div id="the-message"></div>
        <nav class="d-print-none" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url(UE_TRANSACTION) ?>">Riwayat Transaksi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Transaksi</li>
            </ol>
        </nav>
        <div class="card shadow mb-4 animated zoomIn fast">
            <div class="card-body">
                <!-- <button type="button" onclick="printContent('print')" class="btn rounded btn-sm btn-primary d-print-none mb-2 mt-n2 float-right">Cetak</button> -->

                <div class="d-print-flex" id="print">
                    <h4 class="d-none d-print-block text-center">Sistem Informasi Pelayanan Jasa Meteorologi</h4>
                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <tr>
                                <th width="20%">Kode Transaksi </th>
                                <th id="trans_code">-</th>
                            </tr>
                            <tr>
                                <td>Kode Penyimpanan File </td>
                                <td id="transcode_storage">-</td>
                            </tr>
                            <tr>
                                <td>Tanggal Transaksi</td>
                                <td id="date_created">-</td>
                            </tr>
                            <tr>
                                <td>Identitas Pemohon</td>
                                <td id="apply">-</td>
                            </tr>
                            <tr>
                                <td>Jenis Informasi</td>
                                <td id="trans_request">-</td>
                            </tr>
                            <tr>
                                <td>Tarif - Satuan</td>
                                <td id="trans_rates">-</td>
                            </tr>
                            <tr>
                                <td>Jumlah</td>
                                <td id="trans_amount">-</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td id="trans_sum">-</td>
                            </tr>
                            <tr>
                                <td>Status Pembayaran</td>
                                <td id="payment_status">-</td>
                            </tr>
                            <tr>
                                <td>Status Transaksi</td>
                                <td id="trans_status">-</td>
                            </tr>
                            <tr>
                                <td>Petugas Layanan</td>
                                <td id="employ"></td>
                            </tr>
                            <tr class="text-center d-print-none">
                                <td colspan="2">
                                    <button type="button" class="btn btn-primary btn-sm rounded mb-1 mb-sm-0" onclick="confirmTrans()">Konfirmasi Transaksi</button>
                                    <button type="button" class="btn btn-primary btn-sm rounded mb-1 mb-sm-0" onclick="editConfirmTrans()">Edit Transaksi</button>
                                    <button type="button" class="btn btn-secondary btn-sm rounded mb-1 mb-sm-0" onclick="applicantNote()">Lihat Catatan Anda</button>
                                    <button type="button" class="btn btn-dark btn-sm rounded mb-1 mb-sm-0" onclick="employeeNote()">Lihat Catatan Petugas</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-footer mt-n4">
                <div id="mesDocument"></div>
                <?php //if (in_array($trans->trans_status, [2, 3])) : 
                ?>
                <button type="button" class="btn btn-primary rounded btn-sm my-3" onclick="addDocument()">Tambah Dokumen</button>
                <?php //endif; 
                ?>
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
                Terakhir di perbarui : <?= timeInfo($trans->date_update) ?>
            </div>
        </div>

    </div>

</div>


<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url(); ?>';
    $(document).ready(function() {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
            $('.selectpicker').selectpicker('mobile');
        }

        dataTrans();
        //datatables
        table = $('#dataTable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('employee/transaction/docList/') ?>" + "<?= $trans->trans_id; ?>",
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
            $(this).empty();
        });
        $("#doc_storage").change(function() {
            $('#doc_storage_error').empty();
        });


    });

    function reload_table() {
        table.ajax.reload(null, false);
        dataTrans();
    }

    function dataTrans() {
        $.ajax({
            url: "<?php echo site_url('employee/transaction/detailajax/') . $trans->trans_code ?>",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    $('#trans_code').text(data.trans_code);
                    $('#transcode_storage').text(data.transcode_storage);
                    $('#date_created').text(data.date_created);
                    $('#apply').html(data.apply);
                    $('#trans_request').html(data.trans_request);
                    $('#trans_rates').text(data.trans_rates);
                    $('#trans_amount').text(data.trans_amount);
                    $('#trans_sum').text(data.trans_sum);
                    $('#payment_status').html(data.payment_status);
                    $('#trans_status').html(data.trans_status);
                    $('#employ').html(data.employ);
                } else {
                    $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert">Data Transaksi anda tidak ada.</div>');
                    // close the message after seconds
                    $('.alert-danger').delay(500).show(10, function() {
                        $(this).delay(3000).hide(10, function() {
                            $(this).remove();
                        });
                    });
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
            }
        });
    }

    // Tambah Data
    function addDocument() {
        save_method = 'add';
        $('#documentModal #form')[0].reset(); // reset form on modals
        $('#documentModal .form-control').removeClass('is-invalid'); // clear error class
        $('#documentModal .invalid-feedback').empty(); // clear error string
        $('#doc_storage').removeClass('is-invalid'); // clear error class
        $('#doc_storage_label').text('Pilih Berkas');
        $('#doc_storage_error').empty();

        $('#documentModal').modal('show');

    }

    //Tambah Data
    function save() {
        $('#btnSave').text('Mengirim...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url = "<?php echo site_url('employee/document/docapply') ?>";

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
                    $('#documentModal').modal('hide');
                    $('#mesDocument').html('<div class="alert alert-success animated zoomIn fast" role="alert">Dokumen berhasil ditambahkan.</div>');
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

                $('#btnSave').text('Kirim'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#documentModal').modal('hide');
                $('#mesDocument').html('<div class="alert alert-danger animated zoomIn fast" role="alert"><strong>Maaf!</strong> Dokumen anda gagal di tambahkan</div>');
                reload_table();
                // close the message after seconds
                $('.alert-danger').delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).remove();
                    });
                });
                $('#btnSave').text('Kirim'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    };

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

    function confirmTrans() {
        $('#confirmTrans').modal('show');
        $('#formConfirm')[0].reset();
        $('.form-control').removeClass('is-invalid'); // clear error class
        $('.invalid-feedback').empty();
        $('#confirmTrans .modal-title').text('Konfirmasi Transaksi <?= $trans->trans_code ?>');
        $('#request').show();
        $('#trareq').selectpicker('refresh')
        reload_table();
    };

    function editConfirmTrans(id) {
        $('#formConfirm')[0].reset();
        $('#confirmTrans').modal('show');
        $('.form-control').removeClass('is-invalid'); // clear error class
        $('.invalid-feedback').empty();
        $('#confirmTrans .modal-title').text('Edit Konfirmasi Transaksi <?= $trans->trans_code ?>');
    };

    function saveTrans() {
        $('#btnTrans').text('Mengirim...'); //change button text
        $('#btnTrans').attr('disabled', true); //set button disable 
        var url = "<?php echo site_url('employee/transaction/addConfirmTrans') ?>";

        // ajax adding data to database
        var formData = new FormData($('#formConfirm')[0]);
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
                    $('#confirmTrans').modal('hide');
                    $('#the-message').html('<div class="alert alert-success animated zoomIn fast" role="alert">Transaksi <?= $trans->trans_code ?> berhasil di kirim.</div>');
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

                $('#btnTrans').text('Simpan'); //change button text
                $('#btnTrans').attr('disabled', false); //set button enable 

            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#confirmTrans').modal('hide');
                reload_table();
                $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert"><strong>Maaf!</strong> Transaksi <?= $trans->trans_code ?> gagal di kirim.</div>');
                // close the message after seconds
                $('.alert-danger').delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).remove();
                    });
                });
                $('#btnTrans').text('Simpan'); //change button text
                $('#btnTrans').attr('disabled', false); //set button enable 
            }
        });

    };
</script>

<!-- Latest compiled and minified JavaScript -->
<script src="<?= base_url('assets/vendor/bootstrap-select/') ?>js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="<?= base_url('assets/vendor/bootstrap-select/') ?>js/i18n/defaults-id_ID.min.js"></script>

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
                <div class="modal-body">
                    <input type="hidden" name="trans_id" id="trans_id" value="<?= $trans->trans_id ?>" />
                    <div class="form-group">
                        <label for="doc_name">Nama Berkas</label>
                        <input type="text" name="doc_name" id="doc_name" class="form-control" placeholder="" aria-describedby="doc_name">
                        <div class="invalid-feedback">Example invalid feedback text</div>
                        <div id="doc_name_error" class="invalid-feedback">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="doc_information">Keterangan</label>
                        <textarea class="form-control" name="doc_information" id="doc_information" rows="3" placeholder="Keterangan" aria-describedby="doc_informationHelpBlock"></textarea>
                        <div id="doc_information_error" class="invalid-feedback">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="doc_storage" class=" col-form-label">Upload Berkas</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="doc_storage" name="doc_storage">
                            <label id='doc_storage_label' class="custom-file-label overflow-hidden" for="doc_storage">Pilih Berkas</label>
                        </div>
                        <small id="doc_storage_help" class="form-text text-muted">
                            Upload berkas dalam format dokumen. (pdf atau word)
                        </small>
                        <div id="doc_storage_error" class="small" style="color:#e74a3b;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="btnSave" onclick="save()" type="button" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="note" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Catatan</h5>
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
<div class="modal fade" id="confirmTrans" tabindex="-1" role="dialog" aria-labelledby="modelTitleconfirmTrans" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Transaksi <?= $trans->trans_code ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="formConfirm">
                    <input type="hidden" value="<?= $trans->trans_code ?>" name="trans_code" id="trans_code" />
                    <div class="custom-control custom-checkbox my-1 mr-sm-2">
                        <input type="checkbox" class="custom-control-input" name="checkData" id="checkData" value="6">
                        <label class="custom-control-label" for="checkData">Data Tidak Tersedia</label>
                    </div>
                    <hr>
                    <div id="request">
                        <div class="form-group">
                            <label class="font-weight-bolder text-primary" for="trareq">Jenis Permintaan</label>
                            <select data-header="Pilih Jenis Permintaan" class="form-control selectpicker show-tick" data-live-search="true" name="trareq" id="trareq" required>
                                <option>Pilih...</option>
                                <?php
                                foreach ($type as $t) :
                                ?>
                                    <optgroup label="<?= $t['description'] ?>">
                                        <?php
                                        $subtype = $this->subtype_model->groupData($t['type_id']);
                                        if ($subtype->num_rows() > 0) :
                                        ?>
                                            <?php foreach ($subtype->result_array() as $st) : ?>
                                                <option value="<?= $st['subtype_id'] ?>" data-subtext="<?= rupiah($st['rates']); ?>"><?= $st['sub_description']; ?></option>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <option>-</option>
                                        <?php endif; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                            <div id="trareq_error" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bolder text-primary" for="trans_rates">Tarif</label>
                            <input type="number" class="form-control" name="trans_rates" id="trans_rates" placeholder="Tarif" readonly>
                            <div id="trans_rates_error" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bolder text-primary" for="trans_amount">Jumlah</label>
                            <div class="form-inline">
                                <input type="number" min="1" value="1" class="form-control" name="trans_amount" id="trans_amount" placeholder="Jumlah" aria-describedby="amountHelpInline" required>
                                <small id="amountHelpInline" class="text-muted ml-2"> - </small>
                            </div>
                            <div id="trans_amount_error" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox my-1 mr-sm-2">
                            <input type="checkbox" class="custom-control-input" name="payStatus" id="payStatus" value="0" required>
                            <label class="custom-control-label" for="payStatus">Non Tarif</label>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bolder text-primary" for="trans_sum">Total</label>
                            <input type="number" class="form-control" name="trans_sum" id="trans_sum" placeholder="Total" value="0" required readonly>
                            <div id="trans_sum_error" class="invalid-feedback">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="btnTrans" onclick="saveTrans()" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var sum, amount, rates;
    var nontarif = 1;

    $('select#trareq').on('change', function() {
        alert(this.value);
    });

    function countTrans() {
        rates = $("#trans_rates").val();
        amount = $("#trans_amount").val();
        sum = (rates * amount) * nontarif; //a kali b
        $("#trans_sum").val(sum);
    }

    $('#checkData').click(function() {
        if ($(this).is(':checked')) {
            $('#request').hide();
        } else {
            $('#request').show();
        }
    });

    $('#payStatus').click(function() {
        if ($(this).is(':checked')) {
            nontarif = 0;
            countTrans()
        } else {
            nontarif = 1;
            countTrans()
        }
    });
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div id="the-message"></div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 animated zoomIn fast">
        <div class="card-header py-3">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">Lihat Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="new-tab" data-toggle="tab" href="#new" role="tab" aria-controls="new" aria-selected="false">Transaksi Baru <span class="badge badge-danger"><?= $new; ?></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pay-tab" data-toggle="tab" href="#pay" role="tab" aria-controls="pay" aria-selected="false">Konfirmasi Pembayaran <span class="badge badge-danger"><?= $pay; ?></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="process-tab" data-toggle="tab" href="#process" role="tab" aria-controls="process" aria-selected="false">Transaksi Diproses <span class="badge badge-danger"><?= $process; ?></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="done-tab" data-toggle="tab" href="#done" role="tab" aria-controls="done" aria-selected="false">Transaksi Selesai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="cancel-tab" data-toggle="tab" href="#cancel" role="tab" aria-controls="cancel" aria-selected="false">Transaksi Dibatalkan</a>
                </li>
            </ul>
        </div>
        <div class="card-body">

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataAll" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">#</th>
                                    <th>Kode Transaksi</th>
                                    <th>Pemohon</th>
                                    <th>Kode Penyimpanan</th>
                                    <th>Tanggal</th>
                                    <th width="7%" class="text-break">Aksi</th>
                                </tr>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="new" role="tabpanel" aria-labelledby="new-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataNew" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">#</th>
                                    <th>Kode Transaksi</th>
                                    <th>Pemohon</th>
                                    <th>Kode Penyimpanan</th>
                                    <th>Tanggal</th>
                                    <th width="7%" class="text-break">Aksi</th>
                                </tr>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="pay" role="tabpanel" aria-labelledby="pay-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataPay" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">#</th>
                                    <th>Kode Transaksi</th>
                                    <th>Pemohon</th>
                                    <th>Kode Penyimpanan</th>
                                    <th>Tanggal</th>
                                    <th width="7%" class="text-break">Aksi</th>
                                </tr>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="process" role="tabpanel" aria-labelledby="process-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataProcess" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">#</th>
                                    <th>Kode Transaksi</th>
                                    <th>Pemohon</th>
                                    <th>Kode Penyimpanan</th>
                                    <th>Tanggal</th>
                                    <th width="7%" class="text-break">Aksi</th>
                                </tr>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="done" role="tabpanel" aria-labelledby="done-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataDone" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">#</th>
                                    <th>Kode Transaksi</th>
                                    <th>Pemohon</th>
                                    <th>Kode Penyimpanan</th>
                                    <th>Tanggal</th>
                                    <th width="7%" class="text-break">Aksi</th>
                                </tr>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="cancel" role="tabpanel" aria-labelledby="cancel-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataCancel" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">#</th>
                                    <th>Kode Transaksi</th>
                                    <th>Pemohon</th>
                                    <th>Kode Penyimpanan</th>
                                    <th>Tanggal</th>
                                    <th width="7%" class="text-break">Aksi</th>
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
<!-- /.container-fluid -->

<script type="text/javascript">
    var allData, newData, payData, processData, doneData, cancelData;
    var base_url = '<?php echo base_url(); ?>';
    $(document).ready(function() {
        //datatables

        allData = tableTrans('dataAll', '');
        newData = tableTrans('dataNew', '/new');
        payData = tableTrans('dataPay', '/pay');
        processData = tableTrans('dataProcess', '/process');
        doneData = tableTrans('dataDone', '/done');
        cancelData = tableTrans('dataCancel', '/cancel');
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

    function tableTrans(tab, url) {
        $('#' + tab).DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('employee/transaction/listall') ?>" + url,
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [-2, -1, 0],
                "className": 'text-center',
                "orderable": false, //set not orderable
            }, {
                "targets": [3],
                "className": 'text-center'
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
    };

    function reload_table() {
        allData.ajax.reload(null, false);
        newData.ajax.reload(null, false);
        payData.ajax.reload(null, false);
        processData.ajax.reload(null, false);
        doneData.ajax.reload(null, false);
        cancelData.ajax.reload(null, false);
    };

    function view(id) {
        var url = "<?php echo site_url(UE_TRANSACTIONDETAIL) ?>/" + id;
        window.location.replace(url);
    };

    function cancel(id) {
        $('#transactionModal').modal('show');
        $('.modal-title').text('Batalkan Transaksi');
        $('#cancel').show();
        $('#btnDelete').show();
        $('#confirm').hide();
        $('#view').hide();
        $('#cancel').text('Anda yakin untuk membatalkan transaksi ' + id + ' ?');
        $('#btnSave').hide();

        $('#btnDelete').click(function() {
            // ajax delete data to database
            $.ajax({
                url: "<?php echo site_url('employee/transaction/canceltransaction') ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    //if success reload ajax table
                    $('#the-message').html('<div class="alert alert-success animated zoomIn fast" role="alert">Transaksi ' + id + ' berhasil di batalkan</div>');
                    // close the message after seconds
                    $('.alert-success').delay(500).show(10, function() {
                        $(this).delay(3000).hide(10, function() {
                            $(this).remove();
                        });
                    });
                    $('#transactionModal').modal('hide');
                    reload_table();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert"><strong>Maaf!</strong> Transaksi ' + id + ' gagal di batalkan.</div>');
                    // close the message after seconds
                    $('.alert-danger').delay(500).show(10, function() {
                        $(this).delay(3000).hide(10, function() {
                            $(this).remove();
                        });
                    });
                    reload_table();
                    $('#transactionModal').modal('hide');
                }
            });
        });
    };

    function addTransStor(id) {
        $('#tranStor').modal('show');
        $('#btnTranStor').attr('onclick', 'saveTranStor()');
        $('#inputTranStor').val($('#' + id).text());
        $('#trans_code').val(id);
    }

    function saveTranStor() {
        var formData = new FormData($('#formTranStor')[0]);
        $.ajax({
            url: "<?php echo site_url('employee/transaction/saveTranStor') ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#tranStor').modal('hide');
                    $('#the-message').html('<div class="alert alert-success animated zoomIn fast" role="alert">Kode Penyimpanan berhasil di perbarui.</div>');
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

            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#tranStor').modal('hide');
                reload_table();
                $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert"><strong>Maaf!</strong> Kode Penyimpanan gagal di perbarui.</div>');
                // close the message after seconds
                $('.alert-danger').delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).remove();
                    });
                });
            }
        });
    };
</script>

<!-- Modal -->
<div class="modal fade" id="tranStor" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kode Penyimpanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formTranStor">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="trans_code" id="trans_code">
                        <input type="text" class="form-control" name="inputTranStor" id="inputTranStor" placeholder="Kode Penyimpanan">
                        <div id="inputTranStor_error" class="invalid-feedback">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" id="btnTranStor" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="cancel">
                Anda yakin untuk membatalkan transaksi 20012020XYZADWL ? <br> Silahkan klik simpan untuk merubah status
            </div>

            <div class="modal-body text-break" id="view">
                <div class="form-group row">
                    <label for="view_payment_to" class="col-sm-4 col-form-label text-sm-right font-weight-bold">Pembayaran ke Rekening</label>
                    <div class="col-sm-8 my-auto" id="view_payment_to">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="view_payment_date" class="col-sm-4 col-form-label text-sm-right font-weight-bold">Tanggal Bayar</label>
                    <div class="col-sm-8 my-auto" id="view_payment_date">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="view_payment_bank" class="col-sm-4 col-form-label text-sm-right font-weight-bold">Nama Bank</label>
                    <div class="col-sm-8 my-auto" id="view_payment_bank">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="view_payment_number" class="col-sm-4 col-form-label text-sm-right font-weight-bold">No. Rekening</label>
                    <div class="col-sm-8 my-auto" id="view_payment_number">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="view_payment_from" class="col-sm-4 col-form-label text-sm-right font-weight-bold">Atas Nama</label>
                    <div class="col-sm-8 my-auto" id="view_payment_from">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="view_payment_amount" class="col-sm-4 col-form-label text-sm-right font-weight-bold">Jumlah Bayar</label>
                    <div class="col-sm-8 my-auto" id="view_payment_amount">
                    </div>
                </div>
                <hr>
                <div class="form-group text-center">
                    <div class="col-form-label font-weight-bold">Bukti Bayar</div>
                    <img id="payment_img" class="img-fluid rounded w-75" alt="Bukti Bayar">
                </div>
            </div>

            <form action="#" id="form">
                <div class="modal-body" id="confirm">
                    <div class="text-center text-break mb-4" id="paybefore">
                    </div>

                    <input type="hidden" name="trans_code" id="trans_code" />
                    <input type="hidden" name="payment_to" id="payment_to" />
                    <div class="form-group">
                        <label for="payment_date">Tanggal Bayar</label>
                        <input type="datetime-local" name="payment_date" id="payment_date" class="form-control" placeholder="">
                        <div id="payment_date_error" class="invalid-feedback">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="payment_bank">Nama Bank</label>
                        <input type="text" name="payment_bank" id="payment_bank" class="form-control" placeholder="" aria-describedby="payment_bank">
                        <small id="payment_bank_help" class="text-muted">Misal : Bank Central Asia (BCA)</small>
                        <div id="payment_bank_error" class="invalid-feedback">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="payment_number">No. Rekening</label>
                        <input type="text" onkeypress="return numberOnly(event)" name="payment_number" id="payment_number" class="form-control" placeholder="" aria-describedby="payment_number_help">
                        <small id="payment_number_help" class="text-muted">Misal : 123456789</small>
                        <div id="payment_number_error" class="invalid-feedback">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="payment_from">Atas Nama</label>
                        <input type="text" name="payment_from" id="payment_from" class="form-control" placeholder="" aria-describedby="payment_from_help">
                        <small id="payment_from_help" class="text-muted">Misal : Imam Agustian Nugraha</small>
                        <div id="payment_from_error" class="invalid-feedback">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="payment_amount">Jumlah Bayar</label>
                        <input type="number" name="payment_amount" id="payment_amount" class="form-control">
                        <div id="payment_amount_error" class="invalid-feedback">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="photo" class=" col-form-label">Upload Bukti Bayar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="photo" name="photo">
                            <label id='photo_label' class="custom-file-label overflow-hidden" for="photo">Pilih Berkas</label>
                        </div>
                        <small id="photo_help" class="form-text text-muted">
                            Upload bukti bayar dalam format jpg / png / gif.
                        </small>
                        <div id="photo_error" class="small" style="color:#e74a3b;">
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
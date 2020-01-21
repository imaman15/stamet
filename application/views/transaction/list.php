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
            <button type="button" class="btn btn-primary" onclick="add_transaction()">
                Ajukan Permintaan Data
            </button>
        </div>
        <div class="card-body">
            <?php
            // header("X-XSS-Protection: 0");
            // echo $contents;
            ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th width="5%">#</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Status Bayar</th>
                            <th>Status Transaksi</th>
                            <th width="7%" class="text-break">Aksi</th>
                        </tr>

                    <tbody>
                        <tr id="field">
                            <td>1.</td>
                            <td>20012020XYZADWL</td>
                            <td>20-01-2020</td>
                            <td>Prakiraan Musim Hujan</td>
                            <td class="text-center">
                                <span id="status">Belum Bayar</span>
                                <hr class="my-0">
                                <a id="btn-payment" href="javascript:void(0)" onclick="confirm()" class="badge badge-secondary p-1 m-1">Konfirmasi Bayar</a>
                            </td>
                            <td class="text-center">
                                <button type="button" title="Detail Transaksi" class="btn btn-info btn-circle btn-sm mb-1" onclick="view('20012020XYZADWL')"><i class="fas fa-search-plus"></i></button>
                                <button type="button" title="Batalkan Transaksi" class="btn btn-danger btn-circle btn-sm mb-1" onclick="cancel()"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
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
                "url": "<?php echo site_url('transaction/list') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [-3, -2, -1, 0],
                    "className": 'text-center',
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-3, -2, -1, 0],
                    "className": 'text-center',
                    "orderable": false, //set not orderable
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
            $(this).empty();
        });
        $("#photo").change(function() {
            $('#photo_error').empty();
        });



    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    function add_transaction() {
        window.location.replace("<?= site_url(UA_TRANSACTION) ?>");
    };

    function view(id) {
        var url = "<?php echo site_url(UA_TRANSACTIONDETAIL) ?>/" + id;
        window.location.replace(url);
    };

    function confirm(id) {
        save_method = 'addPayment';
        $('#form')[0].reset();
        $('.form-control').removeClass('is-invalid'); // clear error class
        $('#photo').removeClass('is-invalid'); // clear error class
        $('#photo_label').text('Pilih Berkas');
        $('#photo_error').empty(); // clear error class
        $('.invalid-feedback').empty();
        $('#transactionModal').modal('show');
        $('.modal-title').text('Konfirmasi Pembayaran');
        $('#cancel').hide();
        $('#confirm').show();
        $('#view').hide();
        $('#btnSave').show();

        $.ajax({
            url: "<?php echo site_url('transaction/viewbeforepay') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                // var now = data.payment_date;
                // var day = ("0" + now.getDate()).slice(-2);
                // var month = ("0" + (now.getMonth() + 1)).slice(-2);
                // var today = now.getFullYear() + "-" + (month) + "-" + (day);

                // ('yyyy-MM-ddThh:mm');

                if (data.status == 1) {
                    $('#paybefore').html('<b>' + data.payment_to + '</b>');
                    $('#trans_code').val(id);
                    $('#preview').show();
                    var urlimg = '<?= base_url("assets/img/img-bukti/") ?>' + data.payment_img;
                    $('#pay_img').attr('src', urlimg);

                    $('#payment_to').val(data.payment_to);
                    $('#payment_date').val(data.convertDate);
                    $('#payment_bank').val(data.payment_bank);
                    $('#payment_number').val(data.payment_number);
                    $('#payment_from').val(data.payment_from);
                    $('#payment_amount').val(data.payment_amount);
                } else if (data.status == 2) {
                    $('#preview').hide();
                    $('#paybefore').html('<p>Silahkan Lakukan Pembayaran ke Rekening berikut ini : </p><h6><b>' + data.payfrom_bank_name + '</b></h6> <h6><b>' + data.payfrom_account_number + '</b></h6><h6> <b>' + data.payfrom_account_name + '</b></h6> <h6><b>Total : ' + data.sum + '</b></h6>');
                    $('#trans_code').val(id);
                    $('#payment_amount').val(data.payfrom_sum);
                    $('#payment_from').val(data.name);
                    $('#payment_to').val(data.payfrom_bank_name + ' - ' + data.payfrom_account_number + ' A/N ' + data.payfrom_account_name);
                } else {
                    $('#paybefore').html("---");
                    $('#payment_amount').val("");
                    $('#payment_from').val("");
                    $('#preview').hide();
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
                $('#transactionModal').modal('hide');
            }
        });
    };

    function received(id) {
        reload_table();
        $('#btnSave').hide();
        $('#transactionModal').modal('show');
        $('.modal-title').text('Pembayaran Diterima');
        $('#cancel').hide();
        $('#confirm').hide();
        $('#view').show();

        $.ajax({
            url: "<?php echo site_url('transaction/viewpay') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                if (data.status) {
                    $('#view_payment_to').text(data.payment_to);
                    $('#view_payment_date').text(data.payment_dateConvert);
                    $('#view_payment_bank').text(data.payment_bank);
                    $('#view_payment_number').text(data.payment_number);
                    $('#view_payment_from').text(data.payment_from);
                    $('#view_payment_amount').text(data.payment_amountConvert);
                    $('#payment_img').attr('src', '<?= base_url("assets/img/img-bukti/") ?>' + data.payment_img);
                } else {
                    $('#view_payment_to').text("-");
                    $('#view_payment_date').text("-");
                    $('#view_payment_bank').text("-");
                    $('#view_payment_number').text("-");
                    $('#view_payment_from').text("-");
                    $('#view_payment_amount').text("-");
                    $('#payment_img').attr('src', '#');
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
                $('#transactionModal').modal('hide');
            }
        });
    };

    //Tambah Data
    function save() {
        $('#btnSave').text('Mengirim...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;

        if (save_method == 'addPayment') {
            url = "<?php echo site_url('transaction/addpayment') ?>";
        } else {
            url = "<?php echo site_url('transaction/updatepayment') ?>";
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
                    $('#transactionModal').modal('hide');
                    $('#the-message').html('<div class="alert alert-success animated zoomIn fast" role="alert">Konfirmasi pembayaran berhasil dikirim.</div>');
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
                $('#transactionModal').modal('hide');
                $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert"><strong>Maaf!</strong> Konfirmasi pembayaran Anda gagal di kirim.</div>');
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

    function cancel() {
        $('#btn-save').show();
        $('#transactionModal').modal('show');
        $('.modal-title').text('Batalkan Transaksi');
        $('#cancel').show();
        $('#confirm').hide();
        $('#view').hide();
        $('#btn-save').click(function() {
            $('#transactionModal').modal('hide');
            $('#field').addClass('odd').html('<td valign="top" colspan="6" class="dataTables_empty">Data tidak tersedia</td>');
        });
    };
</script>


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
                </div>
            </form>
        </div>
    </div>
</div>
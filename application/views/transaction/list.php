<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?= $this->session->flashdata('message');
    ?>

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
                            <th width="10px" rowspan="1">#</th>
                            <th rowspan="1">Kode Transaksi</th>
                            <th rowspan="1">Tanggal</th>
                            <th rowspan="1">Jenis Informasi</th>
                            <th rowspan="1">Status Bayar</th>
                            <th rowspan="1">Aksi</th>
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
                                <button type="button" title="Detail Transaksi" class="btn btn-info btn-circle btn-sm mb-1" onclick="view()"><i class="fas fa-search-plus"></i></button>
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
    function add_transaction() {
        window.location.replace("<?= site_url(UA_TRANSACTION) ?>");
    };

    function view() {
        window.location.replace("<?= site_url(UA_TRANSACTION) ?>");
    };

    function confirm() {
        $('#btn-save').show();
        $('#transactionModal').modal('show');
        $('.modal-title').text('Konfirmasi Pembayaran');
        $('#cancel').hide();
        $('#confirm').show();
        $('#view').hide();
        $('#btn-save').click(function() {
            $('#transactionModal').modal('hide');
            $('#status').text('Pembayaran Diterima');
            $('#btn-payment').addClass('badge-dark').removeClass('badge-secondary').text('Lihat Pembayaran').attr('onclick', 'received()');
        });
    };

    function received() {
        $('#btn-save').hide();
        $('#transactionModal').modal('show');
        $('.modal-title').text('Pembayaran Diterima');
        $('#cancel').hide();
        $('#view').hide();

        $('#confirm').show();

        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);
        $('#datePayment').val(today).attr('readonly', 'readonly');

        $('#bankName').val('BCA').attr('readonly', 'readonly');
        $('#bankNumber').val('123456789').attr('readonly', 'readonly');
        $('#yourName').val('Imam Agustian Nugraha').attr('readonly', 'readonly');
        $('#amount').attr('readonly', 'readonly');
        $('#proofPayment').addClass('text-center form-group').html('Bukti Bayar <br> <img src = "<?= base_url("assets/img/bukti-bayar.jpg") ?>"class = "img-fluid rounded w-75" alt = "Bukti Bayar" > ');
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
            <div class="modal-body" id="confirm">
                <div class="text-center text-break mb-4">
                    Silahkan Lakukan Pembayaran ke Rekening berikut ini :

                    <h6><b>BCA</b></h6>
                    <h6><b>123456789</b></h6>
                    <h6><b>Imam Agustian Nugraha</b></h6>
                </div>

                <div class="form-group">
                    <label for="">Tanggal Bayar</label>
                    <input type="date" name="" id="datePayment" class="form-control" placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">Nama Bank</label>
                    <input type="text" name="" id="bankName" class="form-control" placeholder="" aria-describedby="helpId">
                    <small id="helpId" class="text-muted">Misal : Bank BCA</small>
                </div>
                <div class="form-group">
                    <label for="">No. Rekening</label>
                    <input type="text" name="" id="bankNumber" class="form-control" placeholder="" aria-describedby="helpId">
                    <small id="helpId" class="text-muted">Misal : 123456789</small>
                </div>
                <div class="form-group">
                    <label for="">Atas Nama</label>
                    <input type="text" name="" id="yourName" class="form-control" placeholder="" aria-describedby="helpId">
                    <small id="helpId" class="text-muted">Misal : Imam Agustian Nugraha</small>
                </div>
                <div class="form-group">
                    <label for="">Jumlah Bayar</label>
                    <input type="numbe" name="" id="amount" class="form-control" value="Rp. 50.000" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group" id="proofPayment">
                    <label for="apply_email" class=" col-form-label">Upload Bukti Bayar</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="apply_file" name="apply_file">
                        <label class="custom-file-label overflow-hidden" for="apply_file">Pilih Berkas</label>
                    </div>
                    <small id="apply_messageHelpBlock" class="form-text text-muted">
                        Upload bukti bayar dalam format jpg / png / gif.
                    </small>
                </div>

            </div>
            <div class="modal-body" id="view">
                Body
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btn-save" type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
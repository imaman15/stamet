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

                                if ((in_array($trans->trans_status, [2, 3, 4])) && (in_array($trans->payment_status, [3, 6])) && $trans->trans_request) {
                                    echo $trans->trans_request;
                                } else if ((in_array($trans->payment_status, [2, 1, 4])) && ($trans->trans_status == 1) && $trans->subtype_id) {
                                    echo $request;
                                } else {
                                    echo "-";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>Rp. 50.000</td>
                        </tr>
                        <tr>
                            <td>Status Transaksi</td>
                            <td>
                                <span class="badge badge-pill badge-success">Selesai</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Petugas Layanan</td>
                            <td>
                                Danindra L - Staf Datin
                            </td>
                        </tr>
                        <tr class="text-center d-print-none">
                            <td colspan="2">
                                <button type="button" class="btn btn-secondary btn-sm rounded" onclick="applicantNote()">Lihat Catatan Anda</button>
                                <button type="button" class="btn btn-dark btn-sm rounded" onclick="employeeNote()">Lihat Catatan Petugas</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card-footer mt-n4">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nama Berkas</th>
                                <th>Uploader</th>
                                <th>Tanggal & Waktu</th>
                                <th>Keterangan</th>
                                <th width="60px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Berkas Persyaratan</td>
                                <td>Pemohon</td>
                                <td>20-01-2020 08:00:00</td>
                                <td>-</td>
                                <td class="text-center">
                                    <button type="button" title="Download Berkas" class="btn btn-success btn-circle btn-sm mb-1" onclick="download()"><i class="fas fa-download"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td> Data Prakiraan Musim Hujan</td>
                                <td>Annisa Rahma - Staf Datin</td>
                                <td>20-01-2020 08:00:00</td>
                                <td>-</td>
                                <td class="text-center">
                                    <button type="button" title="Download Berkas" class="btn btn-success btn-circle btn-sm mb-1" onclick="download()"><i class="fas fa-download"></i></button>
                                </td>
                            </tr>
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
    function printContent(el) {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }

    function applicantNote() {
        $('#note').modal('show');
        $('.modal-title').text('Catatan Anda');
        $('.modal-body').text('Lorem ipsum, dolor sit amet consectetur adipisicing elit. Distinctio eos, consequatur numquam sint aut labore maiores vel sequi ducimus amet fuga beatae necessitatibus quos veniam aliquam blanditiis ea placeat molestias!. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Distinctio eos, consequatur numquam sint aut labore maiores vel sequi ducimus amet fuga beatae necessitatibus quos veniam aliquam blanditiis ea placeat molestias!');
    };

    function employeeNote() {
        $('#note').modal('show');
        $('.modal-title').text('Catatan Petugas');
        $('.modal-body').text('Lorem ipsum, dolor sit amet consectetur adipisicing elit. Distinctio eos, consequatur numquam sint aut labore maiores vel sequi ducimus amet fuga beatae necessitatibus quos veniam aliquam blanditiis ea placeat molestias!.');
    };
</script>

<!-- Modal -->

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
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?= $this->session->flashdata('message');
    ?>

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
                            <th width="50px">Pesan</th>
                        </tr>

                    <tbody>
                        <tr>
                            <td>1.</td>
                            <td>SCH19012020XYZ</td>
                            <td>Konsultasi Data</td>
                            <td>20-02-2020</td>
                            <td>
                                <b>Nama : </b>Danindra L
                                <br>
                                <b>NIP : </b>234456123616136161
                                <br>
                                <b>No. HP</b> : +6290671813158
                            </td>
                            <td id="status" class="text-center">
                                Berlangsung
                                <hr class="my-0">
                                <a href="javascript:void(0)" onclick="cancel()" class="badge badge-danger p-1 m-1">Batalkan</a>
                            </td>
                            <td class="text-center">
                                <button type="button" title="Pesan Anda" class="btn btn-dark btn-circle btn-sm mb-1" onclick="message()"><i class="fas fa-envelope"></i></button>
                                <button type="button" title="Balasan Pesan Anda" class="btn btn-secondary btn-circle btn-sm mb-1" onclick="reply()"><i class="fas fa-reply"></i></button>
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
    var url = "<?= site_url(UA_SCHEDULE) ?>";

    function add_schedule() {
        window.location.replace(url);
    };

    function cancel() {
        $('#btn-save').show();
        $('#viewData').hide();
        $('#schedule').modal('show');
        $('.modal-title').text('Batalkan Jadwal Pertemuan');
        $('#action').show().html('Anda yakin untuk membatalkan pertemuan ini ? <br> Silahkan klik simpan untuk merubah status');
        $('.modal-dialog').removeClass('modal-lg');

        $('#btn-save').click(function() {
            $('#schedule').modal('hide');
            $('#status').text('Dibatalkan');
        });
    };

    function message() {
        $('#btn-save').hide();
        $('.modal-dialog').addClass('modal-lg');
        $('#schedule').modal('show');
        $('#labelName').text('Nama Pemohon');
        $('#viewName').text('Imam Agustian Nugraha');
        $('#labelMessage').text('Pesan Anda');
        $('.modal-title').text('Pesan Anda');
        $('#action').hide();
    };

    function reply() {
        $('#btn-save').hide();
        $('.modal-dialog').addClass('modal-lg');
        $('#schedule').modal('show');
        $('#labelName').text('Nama Petugas');
        $('#viewName').text('Danindra');
        $('#labelMessage').text('Balasan Pesan Anda');
        $('.modal-title').text('Balasan Pesan Anda');
        $('#action').hide();
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
                    <h4 class="text-primary font-weight-bold" id="view_fullname">Konsultasi Data</h4>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="nin" class="col-sm-4 col-form-label text-sm-right font-weight-bold">Perihal</label>
                    <div class="col-sm-8 text-primary text-lg my-auto" id="view_nin">
                        Konsultasi data untuk pembangunan Hotel di Jakarta
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="nama" id="labelName" class="col-sm-4 col-form-label text-sm-right font-weight-bold">Nama Pemohon</label>
                    <div class="col-sm-8 text-primary text-lg my-auto" id="viewName">
                        Imam Agustian Nugraha
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="institute" class="col-sm-4 col-form-label text-sm-right font-weight-bold">Tanggal Dibuat</label>
                    <div class="col-sm-8 text-primary text-lg my-auto" id="view_institute">
                        19 November 2020
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="address" class="col-sm-4 col-form-label text-sm-right font-weight-bold">Terakhir Diperbarui</label>
                    <div class="col-sm-8 text-primary text-lg my-auto" id="view_address">
                        19-01-2020 09:07:10
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="job_category" id="labelMessage" class=" col-form-label text-center col-12 font-weight-bold">Pesan Anda</label>
                    <div class="text-break" id="view_job_category">
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
                <button id="btn-save" type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
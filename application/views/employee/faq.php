<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div id="the-message"></div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 animated zoomIn fast">
        <div class="card-header py-3">
            <div class="row justify-content-between">
                <div class="col-md-4 col-12 text-sm-left text-center">
                    <button type="button" class="btn btn-primary" onclick="add_type()">
                        Tambah Kategori
                    </button>
                </div>
                <div class="col-md-4 text-sm-right text-center text-break col-12 mt-sm-0 mt-2">
                    <button type="button" class="btn btn-primary btn-icon-split btn" onclick="view()">
                        <span class="icon text-white-50">
                            <i class="fas fa-th-list"></i>
                        </span>
                        <span class="text">Lihat Jenis Permintaan</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th width="18px">#</th>
                            <th>No. Identitas Pegawai</th>
                            <th>Nama Pegawai</th>
                            <th>Jabatan</th>
                            <th>Level</th>
                            <th>Diperbarui</th>
                            <th width="98px">Aksi</th>
                        </tr>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
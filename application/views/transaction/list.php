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
                            <th>#</th>
                            <th>No. Identitas Pegawai</th>
                            <th>Nama Pegawai</th>
                            <th>Jabatan</th>
                            <th>Level</th>
                            <th>Diperbarui</th>
                            <th>Aksi</th>
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
    var url = "<?= site_url(UA_TRANSACTION) ?>";

    function add_transaction() {
        window.location.replace(url);
    }
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div id="the-message"></div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 animated zoomIn fast">
        <div class="card-header py-3">
            <form action="#" class="form-inline">
                <div class="form-group">
                    <input placeholder="Pilih Tanggal Awal" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" name="startDate" id="startDate">
                </div>
                <span class="mx-2">s.d.</span>
                <div class="form-group">
                    <input placeholder="Pilih Tanggal Akhir" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" name="endDate" id="endDate">
                </div>
                <button name="search" id="search" type="button" class="btn btn-primary mx-2">Filter</button>
                <button type="button" id="print" class="btn btn-secondary">Print</button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th width="18px">NO</th>
                            <th>TANGGAL</th>
                            <th>PEMOHON</th>
                            <th>JENIS PERMINTAAN</th>
                            <th>TARIF</th>
                        </tr>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script type="text/javascript">
    $(document).ready(function() {


        fetch_data('no');

        function fetch_data(is_date_search, start_date = '', end_date = '') {
            table = $('#dataTable').DataTable({

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.

                // Load data for the table's content from an Ajax source
                "ajax": {
                    url: "<?php echo site_url('employee/report/list/rates') ?>",
                    type: "POST",
                    data: {
                        is_date_search: is_date_search,
                        start_date: start_date,
                        end_date: end_date
                    },
                },

                //Set column definition initialisation properties.
                "columnDefs": [{
                    "targets": [0],
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
        }

        $('#search').click(function() {
            var start_date = $('#startDate').val();
            var end_date = $('#endDate').val();
            if (start_date != '' && end_date != '') {
                $('#dataTable').DataTable().destroy();
                fetch_data('yes', start_date, end_date);
            } else {
                alert("Kedua Tanggal Harus Di isi");
            }
        });

        $('#print').click(function() {
            var start_date = $('#startDate').val();
            var end_date = $('#endDate').val();

            var date;
            if (start_date != '' && end_date != '') {
                date = start_date + '/' + end_date;
            } else {
                date = '';
            }
            window.open('<?= site_url('employee/report/printTransRate/') ?>' + date, '_blank');
        });

    });
</script>
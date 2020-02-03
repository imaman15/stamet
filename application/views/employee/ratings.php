<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 animated zoomIn fast">
        <div class="card-header py-3">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="resAll-tab" data-toggle="tab" href="#resAll" role="tab" aria-controls="resAll" aria-selected="true">Grafik</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="resQue-tab" data-toggle="tab" href="#resQue" role="tab" aria-controls="resQue" aria-selected="false">Hasil Pertanyaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="cands-tab" data-toggle="tab" href="#cands" role="tab" aria-controls="cands" aria-selected="false">Kritik & Saran</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="resAll" role="tabpanel" aria-labelledby="resAll-tab">
                    <div class="col-12 text-center">
                        <h4 class="font-weight-bold text-primary">Grafik Hasil Survey</h4>
                    </div>
                    <div class="chart-bar col-12">
                        <canvas id="myBarChart"></canvas>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th class="align-middle">Data</th>
                                    <th>Jawaban A <br> <small>(Sangat Baik)<small></th>
                                    <th>Jawaban B <br> <small>(Baik)<small></th>
                                    <th>Jawaban C <br> <small>(Cukup)<small></th>
                                    <th>Jawaban D <br> <small>(Buruk)<small></th>
                                    <th>Jawaban E <br> <small>(Sangat Buruk)<small></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Jumlah Jawaban</td>
                                    <td><?= sResults()["number"]["A"] ?></td>
                                    <td><?= sResults()["number"]["B"] ?></td>
                                    <td><?= sResults()["number"]["C"] ?></td>
                                    <td><?= sResults()["number"]["D"] ?></td>
                                    <td><?= sResults()["number"]["E"] ?></td>
                                </tr>
                                <tr>
                                    <td>Presentase</td>
                                    <td><?= sResults()["persen"]["A"] . '%' ?></td>
                                    <td><?= sResults()["persen"]["B"] . '%' ?></td>
                                    <td><?= sResults()["persen"]["C"] . '%' ?></td>
                                    <td><?= sResults()["persen"]["D"] . '%' ?></td>
                                    <td><?= sResults()["persen"]["E"] . '%' ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="resQue" role="tabpanel" aria-labelledby="resQue-tab">
                    <div class="table-responsive col-12">
                        <h4 class="font-weight-bold text-primary text-center">Hasil Pertanyaan</h4>
                        <table class="table table-bordered table-striped" id="dataQue" width="100%" cellspacing="0">
                            <thead class="text-center table-dark">
                                <tr>
                                    <th class="align-middle" width="18px">#</th>
                                    <th class="align-middle">Pertanyaan</th>
                                    <th>Jawaban A <br> <small>(Sangat Baik)<small></th>
                                    <th>Jawaban B <br> <small>(Baik)<small></th>
                                    <th>Jawaban C <br> <small>(Cukup)<small></th>
                                    <th>Jawaban D <br> <small>(Buruk)<small></th>
                                    <th>Jawaban E <br> <small>(Sangat Buruk)<small></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $questions = $this->questions_model->getData()->result();
                                foreach ($questions as $que) :
                                    $amount = $this->answer_model->amount($que->ratque_id)->result();
                                    foreach ($amount as $ant) :
                                ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $que->description ?></td>
                                            <td class="text-center"><?= $ant->A ?></td>
                                            <td class="text-center"><?= $ant->B ?></td>
                                            <td class="text-center"><?= $ant->C ?></td>
                                            <td class="text-center"><?= $ant->D ?></td>
                                            <td class="text-center"><?= $ant->E ?></td>
                                        </tr>
                                <?php
                                    endforeach;
                                    $no++;
                                endforeach; ?>
                            </tbody>
                            <tfoot class="text-center bg-light">
                                <?php
                                $total = $this->answer_model->total()->row();
                                ?>
                                <tr>
                                    <th colspan="2">Total</th>
                                    <th><?= $total->A ?></th>
                                    <th><?= $total->B ?></th>
                                    <th><?= $total->C ?></th>
                                    <th><?= $total->D ?></th>
                                    <th><?= $total->E ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="cands" role="tabpanel" aria-labelledby="cands-tab">
                    <div id="the-message"></div>
                    <div class="table-responsive col-12">
                        <h4 class="font-weight-bold text-primary text-center">Kritik dan Saran</h4>
                        <table class="table table-bordered table-striped" id="dataCands" width="100%" cellspacing="0">
                            <thead class="text-center table-dark">
                                <tr>
                                    <th class="align-middle" width="18px">#</th>
                                    <th class="align-middle">Identitas Pemohon</th>
                                    <th class="align-middle">Kritik & Saran</th>
                                    <th class="align-middle">Tanggal Isi Survey</th>
                                    <th class="align-middle">Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script src="<?= base_url('assets'); ?>/vendor/chart.js/Chart.min.js"></script>
<!-- <script src="<?= base_url('assets'); ?>/js/survey.js"></script> -->

<script type="text/javascript">
    var tableCands;
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        // Bar Chart Example
        var ctx = document.getElementById("myBarChart").getContext('2d');
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(sResults()['alpha']) ?>,
                datasets: [{
                    label: "Persentase",
                    backgroundColor: "#4e73df",
                    hoverBackgroundColor: "#2e59d9",
                    borderColor: "#4e73df",
                    data: [
                        <?php echo json_encode(sResults()["persen"]["A"]) ?>,
                        <?php echo json_encode(sResults()["persen"]["B"]) ?>,
                        <?php echo json_encode(sResults()["persen"]["C"]) ?>,
                        <?php echo json_encode(sResults()["persen"]["D"]) ?>,
                        <?php echo json_encode(sResults()["persen"]["E"]) ?>
                    ],
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 16
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 5
                        },
                        maxBarThickness: 50,
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            padding: 5,
                            // Include a dollar sign in the ticks
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ' + tooltipItem.yLabel + '%';
                        }
                    }
                },
            }
        });

        //===============================================================

        $('#dataQue').DataTable({
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
            },
            // bSort: false,
            "columnDefs": [{
                "targets": 0,
                "className": 'text-center',
                "orderable": false,
            }]
        });
        tableCands = $('#dataCands').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('employee/ratings/listcands') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [0],
                    "className": 'text-center',
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-1],
                    "className": 'text-center'
                }
            ],
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
    });

    function reload_table() {
        tableCands.ajax.reload(null, false); //reload datatable ajax 
    }

    function status(id) {
        var formData = new FormData($('#form')[0]);
        $.ajax({
            url: "<?php echo site_url('employee/ratings/statusCands') ?>/" + id,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                //if success reload ajax table
                $('#the-message').html('<div class="alert alert-success animated zoomIn fast" role="alert">Status berhasil diperbarui</div>');
                // close the message after seconds
                $('.alert-success').delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).remove();
                    });
                });
                reload_table();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#the-message').html('<div class="alert alert-danger animated zoomIn fast" role="alert"><strong>Maaf!</strong> Status gagal diperbarui.</div>');
                // close the message after seconds
                $('.alert-danger').delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).remove();
                    });
                });
                reload_table();
            }
        });
    };
</script>
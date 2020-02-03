<!-- Summernote -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/vendor/summernote/summernote-bs4.min.css'; ?>">
<!-- End of Summernote -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-center text-gray-800"><?= $title; ?></h1>

    <div class="col-12">
        <?= $this->session->flashdata('message');
        ?>
        <?php
        if (date('m-Y', strtotime($this->cands_model->lastAnswer()->date_created)) == date('m-Y')) :
        ?>
            <div class="alert alert-info text-center" role="alert">
                Anda sudah mengisi survey Bulan ini <br>
                Tanggal pengisian survey terakhir :
                <?= timeIDN(date('Y-m-d')) ?>
            </div>
        <?php else : ?>
            <div class="card shadow mb-3 animated zoomIn fast">
                <?= form_open(UA_RATINGS); ?>
                <div class="card-header">
                    <div class="form-group row">
                        <label for="applicant_name" class="col-sm-2 col-form-label text-left text-sm-right">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= form_error('applicant_name') ? 'is-invalid' : null ?>" name="applicant_name" id="applicant_name" placeholder="Nama" value="<?= $user->first_name . " " . $user->last_name ?>" readonly>
                        </div>
                        <?= form_error('applicant_name') ?>
                    </div>
                    <div class="form-group row">
                        <label for="applicant_email" class="col-sm-2 col-form-label text-left text-sm-right">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control <?= form_error('applicant_email') ? 'is-invalid' : null ?>" name="applicant_email" id="applicant_email" placeholder="Email" value="<?= $user->email ?>" readonly>
                            <?= form_error('applicant_email') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="applicant_phone" class="col-sm-2 col-form-label text-left text-sm-right">No. Handphone</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= form_error('applicant_phone') ? 'is-invalid' : null ?>" name="applicant_phone" id="applicant_phone" placeholder="No. Handphone" value="<?= $user->phone ?>" readonly>
                            <?= form_error('applicant_phone') ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-secondary text-center text-xs py-2" role="alert">
                        <b>Mohon kesediaan Anda untuk memberikan
                            penilaian dan masukan kepada kami, dimana hal ini sangat bermanfaat
                            untuk meningkatkan kualitas layanan kami.<br>
                        </b><i>Silahkan diisi dengan mengklik option radio
                            serta keterangan sesuai dengan penilaian Anda
                            pada kolom yang telah disediakan</i>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr class="text-center">
                                    <th rowspan="2" class="align-middle">No.</th>
                                    <th rowspan="2" class="align-middle">Deskripsi</th>
                                    <th colspan="5">Kualitas</th>
                                </tr>
                                <tr class="text-center">
                                    <th class="align-top">A <br> <small>(Sangat Baik)</small></th>
                                    <th class="align-top">B <br> <small>(Baik)</small></th>
                                    <th class="align-top">C <br> <small>(Cukup)</small></th>
                                    <th class="align-top">D <br> <small>(Buruk)</small></th>
                                    <th class="align-top">E <br> <small>(Sangat Buruk)</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($question as $d) :
                                ?>
                                    <tr>
                                        <td><?= $i ?>.</td>
                                        <td>
                                            <?= $d['description'] ?>
                                            <?= form_error('answer' . $i . $d['ratque_id']) ?>
                                        </td>
                                        <td class="text-center align-middle"><input value="A" type="radio" name="answer<?= $i . $d['ratque_id'] ?>" <?= (set_value('answer' . $i . $d['ratque_id']) == "A") ? "checked" : NULL; ?>></td>
                                        <td class="text-center align-middle"><input value="B" type="radio" name="answer<?= $i . $d['ratque_id'] ?>" <?= (set_value('answer' . $i . $d['ratque_id']) == "B") ? "checked" : NULL; ?>></td>
                                        <td class="text-center align-middle"><input value="C" type="radio" name="answer<?= $i . $d['ratque_id'] ?>" <?= (set_value('answer' . $i . $d['ratque_id']) == "C") ? "checked" : NULL; ?>></td>
                                        <td class="text-center align-middle"><input value="D" type="radio" name="answer<?= $i . $d['ratque_id'] ?>" <?= (set_value('answer' . $i . $d['ratque_id']) == "D") ? "checked" : NULL; ?>></td>
                                        <td class="text-center align-middle"><input value="E" type="radio" name="answer<?= $i . $d['ratque_id'] ?>" <?= (set_value('answer' . $i . $d['ratque_id']) == "E") ? "checked" : NULL; ?>></td>
                                    </tr>
                                <?php
                                    $i++;
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <label for="">Kritik & saran</label>
                        <textarea class="form-control" name="cands_message" id="cands_message" placeholder="Tulis Kritik dan Saran..." rows="4"><?= set_value('cands_message') ?></textarea>
                    </div>

                    <div class="card-footer">
                        <div class="form-group">
                            <div class="col-md-4 offset-md-4 mt-4">
                                <button id="btn-send" type="submit" class="btn btn-primary btn-block">Kirim</button>
                            </div>
                        </div>
                    </div>

                    <?= form_close(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>
<!-- /.container-fluid -->

<script type="text/javascript" src="<?php echo base_url() . 'assets/vendor/summernote/summernote-bs4.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/vendor/summernote/lang/summernote-id-ID.min.js'; ?>"></script>

<script type="text/javascript">
    $('#btn-send').click(function() {
        $(".alert-success").removeClass('d-none');
        // close the message after seconds
        $('.alert-success').delay(500).show(10, function() {
            $(this).delay(5000).hide(10, function() {
                $(this).addClass('d-none');
            });
        });
    });


    $(document).ready(function() {
        $('#apply_message').summernote({
            dialogsInBody: true,
            minHeight: 400,
            placeholder: 'Mohon untuk mengisi formulir kritik dan saran di kolom ini mengenai aspek apa yang harus kami perbaiki kedepannya. Terimakasih.',
            lang: 'id-ID', // default: 'en-US'
            callbacks: {
                onImageUpload: function(image) {
                    uploadImage(image[0]);
                },
                onMediaDelete: function(target) {
                    deleteImage(target[0].src);
                }
            },
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline']],
                ['font', ['clear', 'fontsize']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['fullscreen']],
                ['help', ['help']]
            ],
        });

        function uploadImage(image) {
            var data = new FormData();
            data.append("image", image);
            $.ajax({
                url: "<?php echo site_url('cands/upload_image') ?>",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(url) {
                    $('#apply_message').summernote("insertImage", url);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function deleteImage(src) {
            $.ajax({
                data: {
                    src: src
                },
                type: "POST",
                url: "<?php echo site_url('cands/delete_image') ?>",
                cache: false,
                success: function(response) {
                    console.log(response);
                }
            });
        }

    });
</script>
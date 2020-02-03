<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LAPORAN PERMINTAAN PELAYANAN JASA METEOROLOGI - STASIUN METEOROLOGI KELAS I MARITIM SERANG</title>
    <link rel="stylesheet" media="print" href="<?= base_url('assets/css/') ?>print.css">
    <style>
        @page {
            size: A4
        }

        h1 {
            font-weight: normal;
            font-size: 12pt;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th {
            padding: 8px 8px;
            border: 1px solid #000000;
            text-align: center;
            font-size: 10pt;
        }

        .table td {
            padding: 3px 3px;
            border: 1px solid #000000;
            font-size: 10pt;
        }

        .text-center {
            text-align: center;
        }

        .signature {
            margin-top: 15px;
            margin-left: 60px;
            margin-right: 30px;
        }

        .tright {
            padding-left: 90px;
        }

        .signature td {
            font-size: 10pt;
        }
    </style>
</head>

<body class="A4">
    <section class="sheet padding-10mm">
        <h1 style="margin-bottom: -7px;">LAPORAN PERMINTAAN PELAYANAN JASA METEOROLOGI</h1>
        <h1>STASIUN METEOROLOGI KELAS I MARITIM SERANG</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>TANGGAL</th>
                    <th>PEMOHON</th>
                    <th>JENIS PERMINTAAN</th>
                    <?php if ($for == "rates") : ?>
                        <th>TARIF</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($trans->result() as $t) : ?>
                    <tr>
                        <td class="text-center" width="20"><?= $no ?></td>
                        <td><?= date('d-M-Y', strtotime($t->date_created)) ?></td>
                        <td><?= $t->apply_name . '<br>' . $t->apply_institute ?></td>
                        <td style="list-style:none"><?= $t->trans_code . '<br>' . $t->trans_request ?></td>
                        <?php if ($for == "rates") : ?>
                            <td><?= rupiah($t->trans_sum); ?></td>
                        <?php endif; ?>
                    </tr>
                <?php
                    $no++;
                endforeach; ?>
            </tbody>
        </table>
        <table class="signature" width="100%">
            <tr>
                <td>Mengetahui,</td>
                <td class="tright">Pelayanan Jasa</td>
            </tr>
            <tr>
                <td>Kepala Seksi Data dan Informasi</td>
            </tr>
            <tr>
                <td style="color:white">.</td>
                <td style="color:white">.</td>
            </tr>
            <tr>
                <td style="color:white">.</td>
                <td style="color:white">.</td>
            </tr>
            <tr>
                <td style="color:white">.</td>
                <td style="color:white">.</td>
            </tr>
            <tr>
                <td>Tarjono, S.Pd, S.Si</td>
                <td class="tright">Dian Herdianingsih, SP</td>
            </tr>
            <tr>
                <td>NIP. 197011121992021001</td>
                <td class="tright">NIP. 197205271993012001</td>
            </tr>
        </table>
</body>

</html>
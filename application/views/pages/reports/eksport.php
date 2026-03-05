<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    /* ===== Corporate Professional Reset ===== */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: "Helvetica", Arial, sans-serif;
        font-size: 10pt;
        color: #2c3e50;
        line-height: 1.5;
        background: #fff;
    }

    /* ===== Layout Helpers ===== */
    .clearfix::after { content: ""; display: table; clear: both; }

    /* ===== Header Section ===== */
    .header { 
        padding-bottom: 20px; 
        border-bottom: 2px solid #1a4731; 
        margin-bottom: 30px; 
    }
    .header-left { float: left; width: 60%; }
    .header-right { float: right; width: 40%; text-align: right; }
    
    .institution-name { 
        font-size: 14pt; 
        font-weight: bold; 
        color: #1a4731; 
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 2px;
    }
    .document-title { 
        font-size: 18pt; 
        font-weight: 300; 
        color: #333; 
        margin-top: 5px;
    }
    .meta-info { font-size: 9pt; color: #7f8c8d; margin-top: 5px; }

    /* ===== KPIs / Summary Cards ===== */
    .summary-container { margin-bottom: 30px; }
    .summary-card {
        float: left;
        width: 23%;
        margin-right: 2%;
        padding: 12px 0;
        border-top: 1px solid #eee;
    }
    .summary-card .label { 
        font-size: 8pt; 
        color: #95a5a6; 
        text-transform: uppercase; 
        margin-bottom: 5px; 
        display: block;
    }
    .summary-card .value { 
        font-size: 16pt; 
        font-weight: bold; 
        color: #2c3e50; 
    }
    .summary-card.highlight .value { color: #d4a42a; }

    /* ===== Content Sections ===== */
    .section-header { 
        margin-top: 10px;
        margin-bottom: 15px;
        padding-left: 10px;
        border-left: 4px solid #1a4731;
    }
    .section-title { 
        font-size: 11pt; 
        font-weight: bold; 
        color: #1a4731; 
        text-transform: uppercase;
    }

    /* ===== Professional Table Styling ===== */
    table { 
        width: 100%; 
        border-collapse: collapse; 
        margin-bottom: 25px;
        table-layout: fixed;
    }
    thead th {
        text-align: left;
        padding: 12px 10px;
        font-size: 8.5pt;
        font-weight: bold;
        color: #7f8c8d;
        border-bottom: 2px solid #eee;
        text-transform: uppercase;
    }
    tbody td {
        padding: 12px 10px;
        border-bottom: 1px solid #f9f9f9;
        font-size: 9.5pt;
        color: #34495e;
        vertical-align: middle;
    }
    
    /* Alternating row color */
    tbody tr:nth-child(even) { background-color: #fcfcfc; }
    
    /* Ranking specific */
    .rank-circle {
        background: #f0f0f0;
        color: #333;
        width: 25px;
        height: 25px;
        line-height: 25px;
        text-align: center;
        border-radius: 50%;
        font-weight: bold;
        font-size: 8pt;
    }
    .top-rank { background: #1a4731; color: #fff; }

    /* ===== Badges (Modern Pill Style) ===== */
    .badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 7.5pt;
        font-weight: bold;
        text-transform: uppercase;
    }
    .bs { background: #e6f4ea; color: #1e7e34; } /* Sangat Bersih */
    .bp { background: #e8f0fe; color: #1967d2; } /* Bersih */
    .bw { background: #fff4e5; color: #a66100; } /* Cukup */
    .bd { background: #fce8e6; color: #c5221f; } /* Kurang */
    .bx { background: #f1f3f4; color: #5f6368; } /* N/A */

    /* ===== Footer ===== */
    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        font-size: 8pt;
        color: #bdc3c7;
        padding: 20px 0;
        border-top: 1px solid #eee;
    }
</style>
</head>
<body>

<?php
if (!function_exists('predikat_class')) {
    function predikat_class($avg, $jumlah) {
        if ($jumlah == 0) return ['bx', 'No Data'];
        if ($avg >= 80)   return ['bs', 'Sangat Bersih'];
        if ($avg >= 60)   return ['bp', 'Bersih'];
        if ($avg >= 40)   return ['bw', 'Cukup'];
        return ['bd', 'Kurang'];
    }
}
?>

<div class="header clearfix">
    <div class="header-left">
        <div class="institution-name">SMP Islam Al-Hadi</div>
        <div class="document-title">Laporan Penilaian Kebersihan</div>
        <div class="meta-info">Sistem Informasi Kebersihan & Manajemen Fasilitas</div>
    </div>
    <div class="header-right">
        <div style="font-size: 12pt; font-weight: bold; color: #2c3e50;"><?= htmlspecialchars($nama_bulan . ' ' . $tahun) ?></div>
        <div class="meta-info">Dicetak: <?= date('d M Y, H:i') ?></div>
    </div>
</div>

<div class="summary-container clearfix">
    <div class="summary-card">
        <span class="label">Unit Dinilai</span>
        <div class="value"><?= isset($summary->total_kelas_dinilai) ? (int)$summary->total_kelas_dinilai : 0 ?> Kelas</div>
    </div>
    <div class="summary-card">
        <span class="label">Total Inspeksi</span>
        <div class="value"><?= isset($summary->total_penilaian) ? (int)$summary->total_penilaian : 0 ?> Log</div>
    </div>
    <div class="summary-card">
        <span class="label">Rerata Skor</span>
        <div class="value"><?= isset($summary->rata_rata_keseluruhan) ? htmlspecialchars($summary->rata_rata_keseluruhan) : '0' ?></div>
    </div>
    <div class="summary-card highlight">
        <span class="label">Performa Terbaik</span>
        <div class="value"><?= $terbersih ? htmlspecialchars($terbersih->class_name) : '-' ?></div>
    </div>
</div>

<div class="section-header">
    <div class="section-title">Rekapitulasi Kinerja Kelas</div>
</div>
<table>
    <thead>
        <tr>
            <th style="width: 5%;">#</th>
            <th style="width: 35%;">Identitas Kelas</th>
            <th style="width: 15%; text-align: center;">Frekuensi</th>
            <th style="width: 15%; text-align: center;">Rata-rata</th>
            <th style="width: 15%; text-align: center;">Skor Max</th>
            <th style="width: 15%; text-align: center;">Status</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($rekap)): $no = 1; foreach ($rekap as $row):
        [$p, $l] = predikat_class((float)$row->rata_rata, $row->jumlah_penilaian);
    ?>
        <tr>
            <td style="color: #bdc3c7;"><?= $no++ ?></td>
            <td style="font-weight: bold; color: #1a4731;"><?= htmlspecialchars($row->class_name) ?></td>
            <td style="text-align: center;"><?= (int)$row->jumlah_penilaian ?>x</td>
            <td style="text-align: center; font-weight: bold;"><?= htmlspecialchars($row->rata_rata ?? '0') ?></td>
            <td style="text-align: center; color: #7f8c8d;"><?= htmlspecialchars($row->tertinggi ?? '0') ?></td>
            <td style="text-align: center;"><span class="badge <?= $p ?>"><?= $l ?></span></td>
        </tr>
    <?php endforeach; else: ?>
        <tr><td colspan="6" style="text-align: center; padding: 30px;">Data tidak ditemukan untuk periode ini.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<div class="section-header">
    <div class="section-title">Peringkat 5 Besar</div>
</div>
<table style="background: #fff;">
    <thead>
        <tr>
            <th style="width: 10%; text-align: center;">Rank</th>
            <th style="width: 60%;">Nama Kelas</th>
            <th style="width: 15%; text-align: center;">Skor Akhir</th>
            <th style="width: 15%; text-align: center;">Apresiasi</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($ranking)): $rank = 1; foreach (array_slice($ranking, 0, 5) as $row):
        $avg = (float)$row->rata_rata;
        [$p, $l] = predikat_class($avg, $row->jumlah_penilaian);
    ?>
        <tr>
            <td style="text-align: center;">
                <div class="rank-circle <?= $rank == 1 ? 'top-rank' : '' ?>"><?= $rank ?></div>
            </td>
            <td style="font-size: 11pt;"><?= htmlspecialchars($row->class_name) ?></td>
            <td style="text-align: center; font-weight: bold; font-size: 11pt; color: #1a4731;"><?= number_format($avg, 1) ?></td>
            <td style="text-align: center;"><span class="badge <?= $p ?>"><?= $l ?></span></td>
        </tr>
    <?php $rank++; endforeach; endif; ?>
    </tbody>
</table>

<div class="footer">
    <div style="float: left;">Dokumen ini dihasilkan secara otomatis oleh Sistem Manajemen Kebersihan Al-Hadi.</div>
    <div style="float: right;">Hal. {PAGENO}</div>
</div>

</body>
</html>

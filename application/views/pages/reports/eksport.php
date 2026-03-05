<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Kebersihan <?= $nama_bulan . ' ' . $tahun ?></title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: Arial, sans-serif;
        font-size: 11px;
        color: #1a1a1a;
        background: #fff;
    }

    /* ── Header ── */
    .header {
        background: linear-gradient(135deg, #0f2d1e 0%, #1a4731 100%);
        color: #fff;
        padding: 20px 25px;
        margin-bottom: 20px;
    }
    .header-inner {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .header h1 { font-size: 18px; margin-bottom: 4px; }
    .header p  { font-size: 11px; opacity: 0.85; margin: 0; }
    .header .badge-period {
        background: rgba(212,164,42,0.9);
        color: #fff;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    /* ── Summary Cards ── */
    .summary-grid {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        padding: 0 2px;
    }
    .summary-card {
        flex: 1;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px;
        text-align: center;
        border-top: 3px solid #1a4731;
    }
    .summary-card .val  { font-size: 22px; font-weight: bold; color: #1a4731; }
    .summary-card .lbl  { font-size: 10px; color: #666; margin-top: 2px; }

    /* ── Section Title ── */
    .section-title {
        font-size: 13px;
        font-weight: bold;
        color: #0f2d1e;
        border-left: 4px solid #b8912a;
        padding-left: 10px;
        margin: 18px 0 10px;
    }

    /* ── Table ── */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 18px;
    }
    thead tr {
        background: #1a4731;
        color: #fff;
    }
    thead th {
        padding: 7px 8px;
        text-align: center;
        font-size: 10px;
        font-weight: bold;
    }
    thead th.left { text-align: left; }
    tbody tr:nth-child(even) { background: #f5f9f5; }
    tbody tr:hover            { background: #e8f5ee; }
    tbody td {
        padding: 6px 8px;
        border-bottom: 1px solid #e8e8e8;
        font-size: 10px;
    }
    .text-center { text-align: center; }
    .text-right  { text-align: right; }

    /* ── Badge / Predikat ── */
    .badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 9px;
        font-weight: bold;
        color: #fff;
    }
    .badge-success   { background: #2d7a4f; }
    .badge-primary   { background: #1a4731; }
    .badge-warning   { background: #b8912a; }
    .badge-danger    { background: #c0392b; }
    .badge-secondary { background: #8592a3; }

    /* ── Ranking ── */
    .ranking-table td.rank  { font-size: 14px; text-align: center; width: 40px; }
    .ranking-table td.score { font-weight: bold; font-size: 13px; color: #1a4731; text-align: center; }

    /* ── Footer ── */
    .footer {
        margin-top: 25px;
        border-top: 1px solid #ccc;
        padding-top: 10px;
        display: flex;
        justify-content: space-between;
        font-size: 9px;
        color: #999;
    }

    /* ── Print Only ── */
    @media print {
        body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
        .no-print { display: none !important; }
        @page { size: A4 landscape; margin: 15mm; }
    }

    /* ── Screen Only (fallback tanpa mPDF) ── */
    @media screen {
        body { max-width: 1100px; margin: 20px auto; padding: 10px; }
        .print-btn {
            position: fixed; top: 20px; right: 20px;
            background: #1a4731; color: #fff;
            border: none; padding: 10px 20px; border-radius: 6px;
            cursor: pointer; font-size: 13px; z-index: 999;
        }
        .print-btn:hover { background: #0f2d1e; }
    }
</style>
</head>
<body>

<!-- Tombol Print (hanya muncul di browser, tidak di PDF mPDF) -->
<button class="print-btn no-print" onclick="window.print()">🖨️ Print / Save PDF</button>

<!-- ── HEADER ── -->
<div class="header">
    <div class="header-inner">
        <div>
            <h1>📋 Laporan Kebersihan Kelas</h1>
            <p>SMP Islam Al-Hadi — Rekap Penilaian Bulanan</p>
        </div>
        <div class="badge-period"><?= $nama_bulan . ' ' . $tahun ?></div>
    </div>
</div>

<?php
$bn = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
       7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
?>

<!-- ── SUMMARY CARDS ── -->
<div class="summary-grid">
    <div class="summary-card">
        <div class="val"><?= $summary->total_kelas_dinilai ?? 0 ?></div>
        <div class="lbl">Kelas Dinilai</div>
    </div>
    <div class="summary-card">
        <div class="val"><?= $summary->total_penilaian ?? 0 ?></div>
        <div class="lbl">Total Penilaian</div>
    </div>
    <div class="summary-card">
        <div class="val"><?= $summary->rata_rata_keseluruhan ?? '-' ?></div>
        <div class="lbl">Rata-rata Poin</div>
    </div>
    <div class="summary-card">
        <div class="val"><?= $summary->poin_tertinggi ?? '-' ?></div>
        <div class="lbl">Poin Tertinggi</div>
    </div>
    <div class="summary-card" style="border-top-color:#b8912a">
        <div class="val" style="font-size:14px;color:#b8912a">
            <?= $terbersih ? htmlspecialchars($terbersih->class_name) : '-' ?>
        </div>
        <div class="lbl">🏆 Kelas Terbersih</div>
    </div>
</div>

<!-- ── REKAP NILAI PER KELAS ── -->
<div class="section-title">Rekap Nilai Kebersihan — <?= $nama_bulan . ' ' . $tahun ?></div>
<table>
    <thead>
        <tr>
            <th style="width:35px">No</th>
            <th class="left">Nama Kelas</th>
            <th>Jml Penilaian</th>
            <th>Rata-rata</th>
            <th>Tertinggi</th>
            <th>Terendah</th>
            <th>Predikat</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($rekap)): $no = 1; foreach ($rekap as $row):
            $avg = (float)$row->rata_rata;
            if ($row->jumlah_penilaian == 0)    { $p='secondary'; $l='Belum Ada Data'; }
            elseif ($avg >= 80)                 { $p='success';   $l='Sangat Bersih'; }
            elseif ($avg >= 60)                 { $p='primary';   $l='Bersih'; }
            elseif ($avg >= 40)                 { $p='warning';   $l='Cukup'; }
            else                                { $p='danger';    $l='Kurang'; }
        ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><strong><?= htmlspecialchars($row->class_name) ?></strong></td>
            <td class="text-center"><?= $row->jumlah_penilaian ?> kali</td>
            <td class="text-center"><strong><?= $row->rata_rata ?? '-' ?></strong></td>
            <td class="text-center" style="color:#2d7a4f;font-weight:bold"><?= $row->tertinggi ?? '-' ?></td>
            <td class="text-center" style="color:#c0392b;font-weight:bold"><?= $row->terendah ?? '-' ?></td>
            <td class="text-center"><span class="badge badge-<?= $p ?>"><?= $l ?></span></td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="7" class="text-center" style="padding:20px;color:#999">Tidak ada data penilaian untuk bulan ini.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- ── RANKING ── -->
<div class="section-title">Ranking Kebersihan Kelas — <?= $nama_bulan . ' ' . $tahun ?></div>
<table class="ranking-table">
    <thead>
        <tr>
            <th style="width:50px">Rank</th>
            <th class="left">Nama Kelas</th>
            <th>Jml Penilaian</th>
            <th>Rata-rata Poin</th>
            <th>Predikat</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($ranking)): $rank = 1; foreach ($ranking as $row):
            $avg = (float)$row->rata_rata;
            if ($row->jumlah_penilaian == 0) { $p='secondary'; $l='Belum Ada Data'; $score='-'; }
            elseif ($avg >= 80) { $p='success'; $l='Sangat Bersih'; $score=number_format($avg,1); }
            elseif ($avg >= 60) { $p='primary'; $l='Bersih'; $score=number_format($avg,1); }
            elseif ($avg >= 40) { $p='warning'; $l='Cukup'; $score=number_format($avg,1); }
            else { $p='danger'; $l='Kurang'; $score=number_format($avg,1); }

            if ($rank==1) $medal='🥇';
            elseif ($rank==2) $medal='🥈';
            elseif ($rank==3) $medal='🥉';
            else $medal = '#'.$rank;
        ?>
        <tr>
            <td class="rank"><?= $medal ?></td>
            <td><strong><?= htmlspecialchars($row->class_name) ?></strong></td>
            <td class="text-center"><?= $row->jumlah_penilaian ?> kali</td>
            <td class="score"><?= $score ?></td>
            <td class="text-center"><span class="badge badge-<?= $p ?>"><?= $l ?></span></td>
        </tr>
        <?php $rank++; endforeach; else: ?>
        <tr><td colspan="5" class="text-center" style="padding:20px;color:#999">Tidak ada data ranking.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- ── DETAIL PENILAIAN HARIAN ── -->
<?php if (!empty($detail)): ?>
<div class="section-title">Detail Penilaian Harian — <?= $nama_bulan . ' ' . $tahun ?></div>
<table>
    <thead>
        <tr>
            <th style="width:35px">No</th>
            <th class="left">Kelas</th>
            <th>Tanggal</th>
            <th>Hari</th>
            <th>Total Poin</th>
            <th>Predikat</th>
            <th class="left">Dinilai Oleh</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($detail as $row):
            if ($row->total_point >= 80)     { $p='success'; $l='Sangat Bersih'; }
            elseif ($row->total_point >= 60) { $p='primary'; $l='Bersih'; }
            elseif ($row->total_point >= 40) { $p='warning'; $l='Cukup'; }
            else                             { $p='danger';  $l='Kurang'; }
        ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= htmlspecialchars($row->class_name) ?></td>
            <td class="text-center"><?= date('d M Y', strtotime($row->assessment_date)) ?></td>
            <td class="text-center"><?= date('l', strtotime($row->assessment_date)) ?></td>
            <td class="text-center"><strong><?= $row->total_point ?></strong></td>
            <td class="text-center"><span class="badge badge-<?= $p ?>"><?= $l ?></span></td>
            <td><?= htmlspecialchars($row->admin_name) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<!-- ── FOOTER ── -->
<div class="footer">
    <span>SMP Islam Al-Hadi — Sistem Penilaian Kebersihan Kelas</span>
    <span>Dicetak: <?= date('d M Y H:i') ?></span>
</div>

</body>
</html>

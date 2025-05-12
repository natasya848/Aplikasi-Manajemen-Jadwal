<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid black; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h3>Laporan Keuangan Manajemen Jadwal dan Keuangan Influencer</h3>
    <p>Periode: <?= date('d-m-Y', strtotime($start)) ?> s/d <?= date('d-m-Y', strtotime($end)) ?></p>
    
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($laporan as $row): ?>
            <tr>
                <td><?= date('d-m-Y', strtotime($row->tanggal)) ?></td>
                <td><?= $row->jenis ?></td>
                <td><?= $row->kategori ?></td>
                <td><?= $row->deskripsi ?></td>
                <td>Rp <?= number_format($row->jumlah, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
        <table>
            <tr>
                <th>Total Pemasukan</th>
                <td>Rp <?= number_format($totalPemasukan, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <th>Total Pengeluaran</th>
                <td>Rp <?= number_format($totalPengeluaran, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <th>Saldo Akhir</th>
                <td>Rp <?= number_format($saldoAkhir, 0, ',', '.') ?></td>
            </tr>
        </table>
    </body>
</html>

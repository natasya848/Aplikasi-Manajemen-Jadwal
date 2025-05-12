<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Jadwal Aktivitas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
        h2, p { text-align: center; margin: 0; padding: 4px; }
    </style>
</head>
<body>
    <h2>Laporan Jadwal Aktivitas Konten Influencer</h2>
    <p>Periode: <?= date('d-m-Y', strtotime($start)) ?> s/d <?= date('d-m-Y', strtotime($end)) ?></p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Jam</th>
                <th>Judul Konten</th>
                <th>Deadline</th>
                <th>Status Jadwal</th>
                <th>Status Konten</th>
                <th>Platform</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jadwal as $j) : ?>
            <tr>
                <td><?= date('d-m-Y', strtotime($j->tanggal)) ?></td>
                <td><?= $j->nama_produk ?></td>
                <td><?= $j->jam ?></td>
                <td><?= $j->judul ?? '-' ?></td>
                <td><?= $j->deadline ?? '-' ?></td>
                <td><?= $j->status_jadwal ?></td>
                <td><?= $j->status_konten ?? '-' ?></td>
                <td><?= $j->platform ?? '-' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

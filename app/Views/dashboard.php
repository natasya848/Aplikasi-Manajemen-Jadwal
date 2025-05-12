<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

    <style>
        body {
            background: linear-gradient(to right, #f7e9dc, #fceacb, #cdeae1);
            font-family: 'Nunito', sans-serif;
            color: #444;
        }

        .card.pastel-glass {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 25px;
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease-in-out;
        }

        .card.pastel-glass:hover {
            transform: translateY(-5px);
        }

        .section-title {
            font-weight: 700;
            color: #3e8e7e;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .list-group-item {
            background-color: rgba(255, 255, 255, 0.85);
            border: none;
            border-radius: 12px;
            margin-bottom: 10px;
            padding: 12px 20px;
            font-size: 0.95rem;
            transition: background-color 0.3s;
        }

        .list-group-item:hover {
            background-color: #f0e6f6;
        }

        h3 {
            color: #674fa3;
        }
    </style>
</head>
    <body>
        <div class="container py-4">
            <h2 class="mb-4">Dashboard Manajer</h2>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card pastel-glass">
                        <div class="card-header bg-primary text-white">📅 Jadwal Hari Ini</div>
                            <div class="card-body" id="jadwalHariIni">
                                <ul class="list-group" id="list-jadwal">
                                <?php if (!empty($jadwalHariIni)) : ?>
                                    <?php foreach ($jadwalHariIni as $j) : ?>
                                    <li class="list-group-item">
                                        <?= $j['nama_produk'] ?> - <?= $j['jam'] ?>
                                    </li>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <li class="list-group-item text-muted">Tidak ada jadwal hari ini.</li>
                                <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                <div class="col-md-6">
                    <div class="card pastel-glass">
                        <div class="card-header bg-warning text-dark">🔔 Pengingat</div>
                            <div class="card-body" id="pengingat">
                                <ul class="list-group" id="list-pengingat">
                                <?php if (!empty($pengingatTerdekat)) : ?>
                                    <li class="list-group-item">
                                    <?= $pengingatTerdekat['nama_produk'] ?> - <?= date('H:i', strtotime($pengingatTerdekat['pengingat'])) ?>
                                    </li>
                                <?php else : ?>
                                    <li class="list-group-item text-muted">Tidak ada pengingat.</li>
                                <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card pastel-glass">
                            <div class="card-header bg-success text-white">📋 Konten Aktif</div>
                                <div class="card-body">
                                    <ul class="list-group" id="kontenList">
                                    <?php if (!empty($kontenAktif)) : ?>
                                        <?php foreach ($kontenAktif as $k) : ?>
                                        <li class="list-group-item">
                                            <?= $k['judul'] ?> - <?= $k['status'] ?>
                                        </li>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <li class="list-group-item text-muted">Tidak ada konten aktif.</li>
                                    <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    <div class="col-md-6">
                        <div class="card pastel-glass">
                            <div class="card-header bg-danger text-white">⏰ Deadline Terdekat</div>
                                <div class="card-body">
                                <ul class="list-group" id="deadlineList">
                                <?php if (!empty($kontenAktif)) : ?>
                                    <?php foreach ($kontenAktif as $k) : ?>
                                    <li class="list-group-item">
                                        <?= $k['judul'] ?> - Deadline: <?= date('d M Y', strtotime($k['deadline'])) ?>
                                    </li>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <li class="list-group-item text-muted">Tidak ada deadline terdekat.</li>
                                <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card pastel-glass">
                            <div class="card-header bg-info text-white">📝 To-Do List</div>
                                <div class="card-body">
                                    <ul class="list-group" id="todoList">
                                    <?php if (!empty($todoPrioritas)) : ?>
                                        <?php foreach ($todoPrioritas as $t) : ?>
                                        <li class="list-group-item">
                                            <?= $t->kegiatan ?> - <?= $t->status ?>
                                        </li>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <li class="list-group-item text-muted">Tidak ada tugas prioritas.</li>
                                    <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    <div class="col-md-6">
                        <div class="card pastel-glass">
                            <div class="card-header bg-dark text-white">💵 Rekap Keuangan</div>
                                <div class="card-body">
                                    <ul class="list-group" id="rekapList">
                                        <li class="list-group-item">Pemasukkan: Rp<?= number_format($rekapKeuangan['pemasukkan'] ?? 0, 0, ',', '.') ?></li>
                                        <li class="list-group-item">Pengeluaran: Rp<?= number_format($rekapKeuangan['pengeluaran'] ?? 0, 0, ',', '.') ?></li>
                                        <li class="list-group-item fw-bold">Saldo: Rp<?= number_format(($rekapKeuangan['pemasukkan'] ?? 0) - ($rekapKeuangan['pengeluaran'] ?? 0), 0, ',', '.') ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    </body>
</html>

<?= $this->endSection(); ?>

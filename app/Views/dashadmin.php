<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<style>
    body {
        background: linear-gradient(to right, #f7e9dc, #fceacb, #cdeae1);
        font-family: 'Nunito', sans-serif;
        color: #444;
    }

    .dashboard-title {
        font-weight: 800;
        color: #2f4f4f;
        font-size: 1.8rem;
        margin-bottom: 30px;
    }

    .section-subtitle {
        font-weight: 600;
        font-size: 1.1rem;
        color: #3e8e7e;
        margin-bottom: 15px;
    }

    .card.pastel-glass {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        border: none;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    }

    .card.pastel-glass:hover {
        transform: translateY(-4px);
    }

    .stat-card h5 {
        font-weight: 600;
        font-size: 1rem;
        color: #555;
        margin-bottom: 8px;
    }

    .stat-card h3 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #674fa3;
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

    @media (max-width: 768px) {
        .dashboard-title {
            font-size: 1.4rem;
        }

        .stat-card h3 {
            font-size: 1.4rem;
        }
    }
</style>

<div class="container mt-5">
    <h3 class="dashboard-title"><i class="fas fa-user-cog me-2"></i>Dashboard Admin</h3>

    <div class="text-end">
        <div id="google_translate_element"></div>
    </div>

    <h5 class="section-subtitle">📊 Statistik</h5>
    <div class="row g-4 mb-5">
        <div class="col-md-3 col-sm-6">
            <div class="card pastel-glass stat-card text-center py-4">
                <div class="card-body">
                    <h5>👤 User</h5>
                    <h3><?= $totalUser ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card pastel-glass stat-card text-center py-4">
                <div class="card-body">
                    <h5>📋 Konten</h5>
                    <h3><?= $totalKonten ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card pastel-glass stat-card text-center py-4">
                <div class="card-body">
                    <h5>📝 To-Do</h5>
                    <h3><?= $totalTodo ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card pastel-glass stat-card text-center py-4">
                <div class="card-body">
                    <h5>💵 Saldo</h5>
                    <h3>Rp<?= number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') ?></h3>
                </div>
            </div>
        </div>
    </div>

    <h5 class="section-subtitle">🕒 Aktivitas Terakhir</h5>
    <div class="row">
        <div class="col-md-12">
            <div class="card pastel-glass mb-5">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php if (!empty($aktivitasTerakhir)): ?>
                            <?php foreach ($aktivitasTerakhir as $aktivitas): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= $aktivitas->aktivitas ?>
                                    <small class="text-muted"><?= date('d M Y, H:i', strtotime($aktivitas->waktu)) ?></small>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item">Belum ada aktivitas</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>


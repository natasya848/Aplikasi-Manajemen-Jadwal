<style>
    .welcome-bubble {
        display: inline-block;
        background-color: #e2f5f0;
        color: #3e8e7e;
        font-family: 'Nunito', cursive;
        font-size: 1rem;
        padding: 10px 25px;
        border-radius: 30px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        animation: popIn 0.5s ease;
    }

    .welcome-bubble::before {
        content: "🗓️ ";
        font-size: 1.2rem;
    }

    @keyframes popIn {
        from {
            transform: scale(0.85);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .app-header {
        background: linear-gradient(to right, #f7e9dc, #fceacb, #cdeae1);
        border-bottom: 2px solid #d8e3dd;
    }
</style>

<header class="app-header d-flex justify-content-between align-items-center px-4 py-3">
    <div>
        <?php if (!empty($showWelcome) && $showWelcome): ?>
            <span class="welcome-bubble">
                Selamat datang, <?= session()->get('nama_user') ?>!
            </span>
        <?php endif; ?>
    </div>
    <div>
        <?php
            $hariMap = [
                'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
            ];
            $bulanMap = [
                'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
                'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli',
                'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober',
                'November' => 'November', 'December' => 'Desember'
            ];
            $hari = $hariMap[date('l')];
            $bulan = $bulanMap[date('F')];
            $tanggalLengkap = $hari . ', ' . date('d') . ' ' . $bulan . ' ' . date('Y');
        ?>
        <span class="text-muted fw-semibold">
            🗓️ <?= $tanggalLengkap ?>
        </span>
    </div>
</header>


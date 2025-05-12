<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<style>
    body {
        background: linear-gradient(to right, #f7e9dc, #fceacb, #cdeae1);
        color: #333;
        font-family: 'Nunito', sans-serif;
    }

    .page-heading h3 {
        color: #4e4e4e !important;
    }

    .card {
        background: #ffffff;
        border: 1px solid #f3e5dc;
        border-radius: 16px;
        box-shadow: 0 6px 12px rgba(245, 211, 182, 0.25);
    }

    .card-header {
        background: #fef5ec;
        color: #5a5a5a;
        font-weight: bold;
        border-radius: 16px 16px 0 0;
    }

    label {
        color: #5e5e5e;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .form-control {
        background: #fefefe;
        border: 1px solid #f0dbc4;
        border-radius: 12px;
        padding: 12px 14px;
        color: #3e3e3e;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #f5c29c;
        box-shadow: 0 0 5px rgba(245, 194, 156, 0.5);
    }

    textarea.form-control {
        resize: vertical;
    }

    .text-subtitle {
        color: #777 !important;
    }

    .breadcrumb-item a {
        color: #a88f7c;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #c0a592;
    }
</style>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Konten</h3>
                <p class="text-subtitle text-muted">Form untuk mengedit konten.</p>
            </div>
        </div>
    </div>

<section class="section">
    <div class="card">
        <div class="card-body">
        <form action="<?= base_url('rekap/update_rekap') ?>" method="post">
            <input type="hidden" name="id_rekap" value="<?= $rekap['id_rekap'] ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= $rekap['tanggal'] ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Jenis</label>
                        <select name="jenis" class="form-control" required>
                            <option value="Pemasukan" <?= ($rekap['jenis'] == 'Pemasukan') ? 'selected' : '' ?>>Pemasukan</option>
                            <option value="Pengeluaran" <?= ($rekap['jenis'] == 'Pengeluaran') ? 'selected' : '' ?>>Pengeluaran</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="kategori">Kategori</label>
                        <select id="kategori" name="kategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Endorse" <?= ($rekap['kategori'] == 'Endorse') ? 'selected' : '' ?>>Endorse</option>
                            <option value="Transportasi" <?= ($rekap['kategori'] == 'Transportasi') ? 'selected' : '' ?>>Transportasi</option>
                            <option value="Makeup" <?= ($rekap['kategori'] == 'Makeup') ? 'selected' : '' ?>>Makeup</option>
                            <option value="Keperluan Pribadi" <?= ($rekap['kategori'] == 'Keperluan Pribadi') ? 'selected' : '' ?>>Keperluan Pribadi</option>
                            <option value="Makanan" <?= ($rekap['kategori'] == 'Makanan') ? 'selected' : '' ?>>Makanan</option>
                            <option value="Lainnya" <?= ($rekap['kategori'] == 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Jumlah</label>
                        <input type="text" id="jumlah" name="jumlah" class="form-control" 
                            value="Rp <?= number_format($rekap['jumlah'], 0, ',', '.') ?>" required>
                    </div>

                <script>
                document.getElementById('jumlah').addEventListener('input', function (e) {
                    let value = e.target.value.replace(/\D/g, ''); 
                    value = new Intl.NumberFormat('id-ID').format(value); 
                    e.target.value = value;
                });
                </script>


                    <div class="form-group mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"><?= $rekap['deskripsi'] ?></textarea>
                    </div>
                </div>
            </div>

                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
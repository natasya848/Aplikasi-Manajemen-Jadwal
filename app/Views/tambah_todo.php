<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
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
                <h3>Tambah To Do</h3>
                <p class="text-subtitle text-muted">Menambahkan kegiatan yang harus dilakukan.</p>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card p-4">
            <div class="card-body">
                <form action="<?= base_url('todo/tambah_todo') ?>" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="kegiatan" class="form-label">Kegiatan</label>
                                <textarea class="form-control" id="kegiatan" name="kegiatan" rows="3" required></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="Ide">Ide</option>
                                    <option value="Belum Mulai">Belum Mulai</option>
                                    <option value="Proses">Proses</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                            <label for="prioritas" class="form-label">Prioritas</label>
                            <select class="form-control" id="prioritas" name="prioritas" required>
                                <option value="Rendah">Rendah</option>
                                <option value="Sedang" selected>Sedang</option>
                                <option value="Tinggi">Tinggi</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="id_klien" class="form-label">Klien (Opsional)</label>
                            <select class="form-control" id="id_klien" name="id_klien">
                                <option value="">-- Pilih Klien --</option>
                                <?php foreach ($klien as $k): ?>
                                    <option value="<?= $k->id_klien ?>"><?= esc($k->nama_klien) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                    <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-check-circle"></i> Simpan</button>
                    <a href="<?= base_url('todo/tabel_todo') ?>" class="btn btn-danger mt-3"><i class="bi bi-x-circle"></i> Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>

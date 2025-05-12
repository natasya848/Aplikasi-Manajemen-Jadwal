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
                <h3>Tambah Konten</h3>
                <p class="text-subtitle text-muted">Form untuk menambahkan konten baru.</p>
            </div>
        </div>
    </div>

    <section class="section">
    <div class="card p-4">
        <div class="card-body">
            <form action="<?= base_url('konten/tambah_konten') ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="id_jadwal">Jadwal</label>
                        <select id="id_jadwal" name="id_jadwal" class="form-control" required>
                            <option value="">-- Pilih Jadwal --</option>
                            <?php foreach ($jadwal as $j): ?>
                                <option value="<?= $j->id_jadwal ?>" 
                                    data-namaproduk="<?= $j->nama_produk ?>" 
                                    data-tanggal="<?= $j->tanggal ?>">
                                    <?= $j->nama_produk ?> - <?= $j->nama_klien ?> - 
                                    <?= ($j->tanggal) ? date('d M Y', strtotime($j->tanggal)) : 'Tanggal belum ditentukan' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                        <script>
                            $(document).ready(function () {
                                $('#id_jadwal').select2({
                                    placeholder: "-- Pilih Jadwal --", 
                                    allowClear: true
                                });

                                $('#id_jadwal').on('change', function () {
                                    const selected = $(this).find('option:selected');
                                    const namaProduk = selected.data('namaproduk');
                                    const tanggal = selected.data('tanggal');

                                    if (namaProduk) {
                                        $('input[name="judul"]').val(namaProduk);
                                    }
                                    if (tanggal) {
                                        $('input[name="deadline"]').val(tanggal);
                                    }
                                });
                            });
                        </script>

                    <div class="form-group mb-3">
                        <label for="platform">Platform</label>
                        <select id="platform" name="platform[]" class="form-control" multiple required>
                            <?php foreach($platform as $p): ?>
                                <option value="<?= $p->id_plartform ?>"><?= esc($p->nama_plartform) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                        <script>
                            $(document).ready(function() {
                                $('#platform').select2({
                                    placeholder: "-- Pilih Platform --"
                                });
                            });
                        </script>

                    <div class="form-group mb-3">
                        <label>Status</label>
                        <select class="form-control" name="status" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Ide">Ide</option>
                            <option value="Proses">Proses</option>
                            <option value="Revisi">Revisi</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    </div>

                    <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Judul</label>
                        <input type="text" class="form-control" name="judul" required>
                    </div>


                    <div class="form-group mb-3">
                        <label>Deadline</label>
                        <input type="date" class="form-control" name="deadline" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Upload File (Opsional)</label>
                        <input type="file" class="form-control" name="url_file">
                    </div>
                </div>
            </div>

                <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-check-circle"></i> Simpan</button>
                <a href="<?= base_url('konten/tabel_konten') ?>" class="btn btn-danger mt-3"><i class="bi bi-x-circle"></i> Batal</a>
            </form>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<?= $this->endSection() ?>

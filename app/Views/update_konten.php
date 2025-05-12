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
        <form action="<?= base_url('konten/update_konten/' . $konten->id_konten) ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Judul Konten</label>
                        <input type="text" class="form-control" name="judul" id="judul" value="<?= $konten->judul ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Deadline</label>
                        <input type="date" class="form-control" name="deadline" id="deadline" value="<?= $konten->deadline ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="Ide" <?= $konten->status == 'Ide' ? 'selected' : '' ?>>Ide</option>
                            <option value="Proses" <?= $konten->status == 'Proses' ? 'selected' : '' ?>>Proses</option>
                            <option value="Revisi" <?= $konten->status == 'Revisi' ? 'selected' : '' ?>>Revisi</option>
                            <option value="Selesai" <?= $konten->status == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Dari Jadwal</label>
                        <select name="id_jadwal" id="id_jadwal" class="form-control" required>
                            <option value="">-- Pilih Jadwal --</option>
                            <?php foreach($jadwal as $j): ?>
                                <option 
                                    value="<?= $j->id_jadwal ?>" 
                                    data-namaproduk="<?= $j->nama_produk ?>" 
                                    data-tanggal="<?= $j->tanggal ?>"
                                    <?= $j->id_jadwal == $konten->id_jadwal ? 'selected' : '' ?>>
                                    <?= esc($j->nama_produk) ?> - <?= esc($j->nama_klien) ?> (<?= date('d M Y', strtotime($j->tanggal)) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?php $konten_platform = $konten_platform ?? []; ?>

                    <div class="form-group mb-3">
                        <label>Platform</label>
                        <select name="platform[]" id="platform" class="form-control" multiple required>
                            <?php foreach($platform as $p): ?>
                                <option value="<?= $p->id_plartform ?>" <?= in_array($p->id_plartform, $konten_platform) ? 'selected' : '' ?>>
                                    <?= esc($p->nama_plartform) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">*Bisa pilih lebih dari satu</small>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label>Upload File (Opsional)</label>
                        <input type="file" class="form-control" name="url_file">
                        <?php if (!empty($konten->url_file)): ?>
                            <small>File saat ini: <a href="<?= base_url('uploads/konten/' . $konten->url_file) ?>" target="_blank">Lihat</a></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <script>
            $(document).ready(function () {
                $('#id_jadwal').select2({
                    placeholder: "-- Pilih Jadwal --",
                    allowClear: true
                });

                $('#platform').select2({
                    placeholder: "-- Pilih Platform --"
                });

                $('#id_jadwal').on('change', function () {
                    const selected = $(this).find('option:selected');
                    const namaProduk = selected.data('namaproduk');
                    const tanggal = selected.data('tanggal');

                    if (namaProduk) {
                        $('#judul').val(namaProduk);
                    }
                    if (tanggal) {
                        $('#deadline').val(tanggal);
                    }
                });
            });
        </script>

                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </form>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<?= $this->endSection() ?>
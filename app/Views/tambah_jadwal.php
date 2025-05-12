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
                <h3>Tambah Jadwal</h3>
                <p class="text-subtitle text-muted">Form untuk menambahkan jadwal baru.</p>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card p-4">
            <div class="card-body">
                <form action="<?= base_url('jadwal/tambah_jadwal') ?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text" id="nama_produk" name="nama_produk" class="form-control" required >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="id_klien">Klien</label>
                            <select id="id_klien" name="id_klien" class="form-control" required>
                                <option value="">-- Pilih Klien --</option>
                                <?php foreach($klien as $k): ?>
                                    <option value="<?= $k->id_klien ?>">
                                        <?= esc($k->nama_klien) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <script>
                        $(document).ready(function() {
                            $('#id_klien').select2({
                                placeholder: "-- Pilih Klien --", 
                                allowClear: true,  
                            });
                        });
                    </script>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="jam">Jam</label>
                            <input type="time" id="jam" name="jam" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="Terjadwal" selected>Terjadwal</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Batal">Batal</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="pengingat">Pengingat</label>
                            <input type="datetime-local" id="pengingat" name="pengingat" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="catatan">Catatan</label>
                            <textarea id="catatan" name="catatan" rows="3" class="form-control" ></textarea>
                        </div>
                    </div>
                </div>

                    <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-check-circle"></i> Simpan</button>
                    <a href="<?= base_url('jadwal/tabel_jadwal') ?>" class="btn btn-danger mt-3"><i class="bi bi-x-circle"></i> Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<?= $this->endSection() ?>

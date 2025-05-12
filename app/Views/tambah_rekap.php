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
                <h3>Tambah Rekap Keuangan</h3>
                <p class="text-subtitle text-muted">Form untuk menambahkan rekap keuangan baru.</p>
            </div>
        </div>
    </div>

    <section class="section">
    <div class="card p-4">
        <div class="card-body">
            <form action="<?= base_url('rekap/tambah_rekap') ?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jenis">Jenis</label>
                            <select id="jenis" name="jenis" class="form-control" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Pemasukkan">Pemasukkan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kategori">Kategori</label>
                            <select id="kategori" name="kategori" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Endorse">Endorse</option>
                                <option value="Transportasi">Transportasi</option>
                                <option value="Makeup">Makeup</option>
                                <option value="Keperluan Pribadi">Keperluan Pribadi</option>
                                <option value="Makanan">Makanan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="jumlah">Jumlah (Rp)</label>
                            <input type="text" id="jumlah" name="jumlah" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-check-circle"></i> Simpan
                </button>
                <a href="<?= base_url('rekap/tabel_rekap') ?>" class="btn btn-danger me-2">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </form>
        </div>
    </div>
</section>

<script>
$(document).ready(function(){
    $('#jumlah').on('input', function() {
        let angka = $(this).val().replace(/[^\d]/g, ''); 
        if (angka) {
            let formatRupiah = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
            $(this).val(formatRupiah.replace('Rp', 'Rp ')); 
        } else {
            $(this).val('');
        }
    });
});
</script>

<?= $this->endSection() ?>

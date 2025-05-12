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
                <h3>Edit Deskripsi</h3>
                <p class="text-subtitle text-muted">Form untuk mengedit deskripsi histori.</p>
            </div>
        </div>
    </div>

<section class="section">
    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('histori/update_histori/' . $histori->id_histori) ?>" method="post">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="4" required><?= $histori->deskripsi ?></textarea>
                        </div>
                    </div>

                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
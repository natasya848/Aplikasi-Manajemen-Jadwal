<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<style>
    .table {
        background-color: #ffffff;  
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        overflow: hidden;
    }

    table.dataTable thead {
        background-color: #f9f9f9; 
    }

    table.dataTable thead th {
        color: #5e5e5e; 
        font-weight: 600;
        text-transform: none;
        padding: 12px;
        border-bottom: 2px solid #f0dbc4; 
    }

    table.dataTable tbody tr {
        transition: background 0.3s ease;
    }

    table.dataTable tbody tr:hover {
        background-color: #fef5ec !important; 
    }

    table.dataTable td {
        color: #3e3e3e;
        padding: 10px;
        vertical-align: middle;
        border-bottom: 1px solid #f2e5d7; 
    }
</style>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Rekap yang Dihapus</h3>
            </div>
        </div>
    </div>
    <section class="section">
    <div class="card p-3">
        <div class="card-body">
            <div class="table-responsive">
                <?php if (!empty($deleted_rekap)): ?>    
                    <table class="table table-striped" id="table14">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php $no = 1; foreach ($deleted_rekap as $value): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value->tanggal ?></td>
                            <td><?= $value->jenis ?></td>
                            <td><?= $value->kategori ?></td>
                            <td>Rp <?= number_format($value->jumlah, 0, ',', '.') ?></td>
                            <td><?= $value->deskripsi ?></td>
                            <td>
                                <div class="d-flex">
                                    <a href="<?= base_url('rekap/restore_rekap/' . $value->id_rekap) ?>" class="btn btn-success btn-sm me-2" 
                                    onclick="return confirm('Apakah Anda yakin ingin merestore rekap ini?')"><i class="fa fa-undo"></i></a>
                                    <a href="<?= base_url('rekap/hapus_rekap/' . $value->id_rekap) ?>" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?')"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>   
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center">Tidak ada rekap yang dihapus.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<div class="position-fixed bottom-3 end-3">
    <a href="<?= base_url('rekap/tabel_rekap') ?>" class="btn btn-secondary shadow">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#table14').DataTable({
            "paging": true,         
            "searching": true,      
            "info": true,           
            "lengthChange": true   
        });
    });
</script>
<?= $this->endSection() ?>
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

<script>
    function toggleFullText(id) {
        const desc = document.getElementById('desc-' + id);
        const link = document.getElementById('link-' + id);

        if (desc.style.display === 'none') {
            desc.style.display = 'block';
            link.innerText = 'Sembunyikan';
        } else {
            desc.style.display = 'none';
            link.innerText = 'Lihat Selengkapnya';
        }
    }
</script>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data To do yang Dihapus</h3>
            </div>
        </div>
    </div>
    <section class="section">
    <div class="card p-3">
        <div class="card-body">
            <div class="table-responsive">
                <?php if (!empty($deleted_todo)): ?>    
                    <table class="table table-striped" id="table16">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Status</th>
                            <th>Prioritas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php $no = 1; foreach ($deleted_todo as $value): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d/m/Y', strtotime($value->tanggal)) ?></td>
                            <td><?= esc($value->kegiatan) ?></td>
                            <td><?= esc($value->status) ?></td>
                            <td><?= esc($value->prioritas) ?></td>
                            <td><?= esc($value->status) ?>
                                <div class="d-flex">
                                    <a href="<?= base_url('todo/restore_todo/' . $value->id_todo) ?>" class="btn btn-success btn-sm me-2" 
                                    onclick="return confirm('Apakah Anda yakin ingin merestore todo ini?')"><i class="fa fa-undo"></i></a>
                                    <a href="<?= base_url('todo/hapus_todo/' . $value->id_todo) ?>" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?')"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>   
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center">Tidak ada todo yang dihapus.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<div class="position-fixed bottom-3 end-3">
    <a href="<?= base_url('todo/tabel_todo') ?>" class="btn btn-secondary shadow">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#table16').DataTable({
            "paging": true,         
            "searching": true,      
            "info": true,           
            "lengthChange": true   
        });
    });
</script>
<?= $this->endSection() ?>
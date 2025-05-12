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
                <h3>Data Konten yang Dihapus</h3>
            </div>
        </div>
    </div>
    <section class="section">
    <div class="card p-3">
        <div class="card-body">
            <div class="table-responsive">
                <?php if (!empty($deleted_konten)): ?>    
                    <table class="table table-striped" id="table12">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Platform</th>
                            <th>Deadline</th>
                            <th>Dari Jadwal</th>
                            <th>Status</th>
                            <th>File Url</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php $no = 1; foreach ($deleted_konten as $value): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value->judul ?></td>
                            <td><?= $value->plartform ?></td>
                            <td><?= $value->deadline ?></td>
                            <td><?= $value->nama_produk ?> - <?= $value->nama_klien ?></td>
                            <td>
                                <?php
                                $warna = '';
                                if ($value->status == 'Ide') {
                                    $warna = 'warning';
                                } elseif ($value->status == 'Selesai') {
                                    $warna = 'success';
                                } elseif ($value->status == 'Proses') {
                                    $warna = 'primary';
                                } elseif ($value->status == 'Revisi') {
                                    $warna = 'secondary';
                                }
                                ?>
                                <span class="badge bg-<?= $warna ?>"><?= $value->status ?></span>
                            </td>
                            <td>
                                <?php if ($value->url_file): ?>
                                    <a href="<?= base_url('uploads/konten/' . $value->url_file) ?>" target="_blank">Lihat File</a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="<?= base_url('konten/restore_konten/' . $value->id_konten) ?>" class="btn btn-success btn-sm me-2" 
                                    onclick="return confirm('Apakah Anda yakin ingin merestore konten ini?')"><i class="fa fa-undo"></i></a>
                                    <a href="<?= base_url('konten/hapus_konten/' . $value->id_konten) ?>" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?')"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>   
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center">Tidak ada konten yang dihapus.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<div class="position-fixed bottom-3 end-3">
    <a href="<?= base_url('konten/tabel_konten') ?>" class="btn btn-secondary shadow">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#table12').DataTable({
            "paging": true,         
            "searching": true,      
            "info": true,           
            "lengthChange": true   
        });
    });
</script>
<?= $this->endSection() ?>
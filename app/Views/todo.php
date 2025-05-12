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
                <h3>Data To Do</h3>
            </div>
        </div>

        <section class="section">
            <div class="card p-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex gap-2">
                        <a href="<?= base_url('todo/input_todo') ?>">
                            <button class="btn btn-info"><i class="bi bi-plus"></i> Tambah</button>
                        </a>

                        <?php if (session()->get('level') == 1): ?>
                        <a href="<?= base_url('todo/dihapus_todo') ?>">
                            <button class="btn btn-primary">Data To Do yang Dihapus</button>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <ul class="nav nav-tabs mb-3 ms-4">
                    <?php
                    $statusTabs = [
                        '' => 'Semua',
                        'Ide' => 'Ide',
                        'Belum Mulai' => 'Belum Mulai',
                        'Proses' => 'Proses',
                        'Selesai' => 'Selesai'
                    ];
                    foreach ($statusTabs as $key => $label): 
                    ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($status == $key) ? 'active' : '' ?>" 
                                href="<?= base_url('todo/tabel_todo?status=' . urlencode($key)) ?>">
                                <?= $label ?>
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>

                <div class="card-body">
                    <table class="table table-striped" id="table11">
                        <thead class="text-white">
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
                            <?php if (!empty($todo)): ?>
                                <?php $no = 1; foreach ($todo as $value): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= date('d/m/Y', strtotime($value->tanggal)) ?></td>
                                    <td><?= esc($value->kegiatan) ?></td>
                                    <td><?= esc($value->status) ?></td>
                                    <td><?= esc($value->prioritas) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <?php if ($value->status == 'Belum Mulai' || $value->status == 'Ide'): ?>
                                                <form action="<?= base_url('todo/updateStatus/' . $value->id_todo) ?>" method="post">
                                                    <input type="hidden" name="status" value="Proses">
                                                    <button type="submit" class="btn btn-warning btn-sm me-2">Proses</button>
                                                </form>
                                            <?php elseif ($value->status == 'Proses'): ?>
                                                <form action="<?= base_url('todo/updateStatus/' . $value->id_todo) ?>" method="post">
                                                    <input type="hidden" name="status" value="Selesai">
                                                    <button type="submit" class="btn btn-success btn-sm me-2">Selesaikan</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="badge bg-success me-2">Selesai</span>
                                            <?php endif; ?>

                                            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item text-danger" href="<?= base_url('todo/delete_todo/' . $value->id_todo) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus to do ini?')">
                                                        <i class="fa fa-trash me-1"></i> Hapus
                                                    </a>
                                                </li>
                                                <?php if (session()->get('level') == 1): ?>
                                                <li>
                                                    <a class="dropdown-item text-info" href="<?= base_url('todo/detail_todo/' . $value->id_todo) ?>">
                                                        <i class="fa fa-eye me-1"></i> Detail
                                                    </a>
                                                </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data to do.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
                
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#table11').DataTable({
            "paging": true,         
            "searching": true,      
            "info": true,           
            "lengthChange": true   
        });
    });
</script>
<?= $this->endSection() ?>


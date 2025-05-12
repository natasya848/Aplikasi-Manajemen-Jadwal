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

    .modal-content {
        border-radius: 10px;
        background-color: #fffaf7;
    }

    .modal-header {
        background-color: #f5d1b7;
        color: #734c3d;
    }

    .modal-body {
        font-size: 16px;
        color: #734c3d;
    }
</style>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Klien</h3>
            </div>
        </div>

    <section class="section">
        <div class="card p-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <a href="<?= base_url('klien/input_klien') ?>"><button class="btn btn-info"><i class="bi bi-plus"></i>Tambah</button></a>

                    <?php if (session()->get('level') == 1): ?>
                    <a href="<?= base_url('klien/dihapus_klien') ?>">
                        <button class="btn btn-primary">Data Klien yang Dihapus</button>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table3">
                    <thead class="text-white">
                        <tr>
                            <th>No</th>
                            <th>Nama Klien</th>
                            <th>Kontak</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($klien)): ?>
                        <?php $no = 1; foreach ($klien as $value): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value->nama_klien ?></td>
                            <td><?= $value->kontak ?></td>
                            <td>
                                <div id="desc-<?= $value->id_klien ?>" style="display: none;">
                                    <?= nl2br($value->catatan) ?> 
                                </div>
                                <a href="javascript:void(0);" id="link-<?= $value->id_klien ?>" onclick="openModal(<?= $value->id_klien ?>)">Lihat Selengkapnya</a>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item text-warning" href="<?= base_url('klien/edit_klien/' . $value->id_klien) ?>">
                                                <i class="fa fa-edit me-1"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="<?= base_url('klien/delete_klien/' . $value->id_klien) ?>" onclick="return 
                                                confirm('Apakah Anda yakin ingin menghapus klien ini?')">
                                                <i class="fa fa-trash me-1"></i> Hapus
                                            </a>
                                        </li>
                                        <?php if (session()->get('level') == 1): ?>
                                        <li>
                                            <a class="dropdown-item text-info" href="<?= base_url('klien/detail_klien/' . $value->id_klien) ?>">
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
                            <td colspan="8" class="text-center">Tidak ada data klien.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                    <div class="modal fade" id="catatanModal" tabindex="-1" aria-labelledby="catatanModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="catatanModalLabel">Catatan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-catatan"></p> 
                                </div>
                            </div>
                        </div>
                    </div>
                </table>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#table3').DataTable({
            "paging": true,         
            "searching": true,      
            "info": true,           
            "lengthChange": true   
        });
    });

    function openModal(id_klien) {
        var catatan = document.getElementById('desc-' + id_klien).innerHTML;

        document.getElementById('modal-catatan').innerHTML = catatan;

        var myModal = new bootstrap.Modal(document.getElementById('catatanModal'));
        myModal.show();
    }
</script>
<?= $this->endSection() ?>


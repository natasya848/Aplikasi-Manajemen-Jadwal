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
                <h3>Data Histori</h3>
            </div>
        </div>

    <section class="section">
        <div class="card p-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <?php if (session()->get('level') == 1): ?>
                <a href="<?= base_url('histori/dihapus_histori') ?>">
                    <button class="btn btn-primary">Data Histori yang Dihapus</button>
                </a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table10">
                    <thead class="text-white">
                        <tr>
                            <th>No</th>
                            <th>Nama Jadwal</th>
                            <th>Klien</th>
                            <th>Tanggal Kerja</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($histori)): ?>
                        <?php $no = 1; foreach ($histori as $value): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value->nama_produk ?></td>
                            <td><?= $value->nama_klien ?></td>
                            <td><?= $value->tanggal_kerja ?></td>
                            <td>
                                <div id="desc-<?= $value->id_histori ?>" style="display: none;">
                                    <?= nl2br($value->deskripsi) ?> 
                                </div>
                                <a href="javascript:void(0);" id="link-<?= $value->id_histori ?>" onclick="openModal(<?= $value->id_histori ?>)">Lihat Selengkapnya</a>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item text-warning" href="<?= base_url('histori/edit_histori/' . $value->id_histori) ?>">
                                                <i class="fa fa-edit me-1"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="<?= base_url('histori/delete_histori/' . $value->id_histori) ?>" onclick="return 
                                                confirm('Apakah Anda yakin ingin menghapus rekap ini?')">
                                                <i class="fa fa-trash me-1"></i> Hapus
                                            </a>
                                        </li>
                                        <?php if (session()->get('level') == 1): ?>
                                        <li>
                                            <a class="dropdown-item text-info" href="<?= base_url('histori/detail_histori/' . $value->id_histori) ?>">
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
                            <td colspan="8" class="text-center">Tidak ada data histori.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                    <div class="modal fade" id="catatanModal" tabindex="-1" aria-labelledby="catatanModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="catatanModalLabel">Deskripsi</h5>
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
        $('#table10').DataTable({
            "paging": true,         
            "searching": true,      
            "info": true,           
            "lengthChange": true   
        });
    });

    function openModal(id_histori) {
        var catatan = document.getElementById('desc-' + id_histori).innerHTML;

        document.getElementById('modal-catatan').innerHTML = catatan;

        var myModal = new bootstrap.Modal(document.getElementById('catatanModal'));
        myModal.show();
    }
</script>
<?= $this->endSection() ?>


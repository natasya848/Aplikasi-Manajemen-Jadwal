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
                <h3>Data Jadwal yang Dihapus</h3>
            </div>
        </div>
    </div>
    <section class="section">
    <div class="card p-3">
        <div class="card-body">
            <div class="table-responsive">
                <?php if (!empty($deleted_jadwal)): ?>    
                    <table class="table table-striped" id="table13">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Klien</th>
                            <th>Tanggal dan Jam</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Pengingat Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php $no = 1; foreach ($deleted_jadwal as $value): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value->nama_produk ?></td>
                            <td><?= $value->nama_klien ?></td>
                            <td><?= $value->tanggal ?> <?= $value->jam ?></td>
                            <td>
                                <?php
                                $warna = '';
                                if ($value->status == 'Terjadwal') {
                                    $warna = 'warning';
                                } elseif ($value->status == 'Selesai') {
                                    $warna = 'success';
                                } elseif ($value->status == 'Batal') {
                                    $warna = 'danger';
                                }
                                ?>
                                <span class="badge bg-<?= $warna ?>"><?= $value->status ?></span>
                            </td>
                            <td>
                                <div id="desc-<?= $value->id_jadwal ?>" style="display: none;">
                                    <?= nl2br($value->catatan) ?> 
                                </div>
                                <a href="javascript:void(0);" id="link-<?= $value->id_jadwal ?>" onclick="openModal(<?= $value->id_jadwal ?>)">Lihat Selengkapnya</a>
                            </td>
                            <td><?= $value->pengingat ?></td>
                            <td>
                                <div class="d-flex">
                                    <a href="<?= base_url('jadwal/restore_jadwal/' . $value->id_jadwal) ?>" class="btn btn-success btn-sm me-2" 
                                    onclick="return confirm('Apakah Anda yakin ingin merestore jadwal ini?')"><i class="fa fa-undo"></i></a>
                                    <a href="<?= base_url('jadwal/hapus_jadwal/' . $value->id_jadwal) ?>" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?')"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>   
                        </tr>
                        <?php endforeach; ?>
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
                <?php else: ?>
                    <p class="text-center">Tidak ada jadwal yang dihapus.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<div class="position-fixed bottom-3 end-3">
    <a href="<?= base_url('jadwal/tabel_jadwal') ?>" class="btn btn-secondary shadow">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#table13').DataTable({
            "paging": true,         
            "searching": true,      
            "info": true,           
            "lengthChange": true   
        });
    });

    function openModal(id_jadwal) {
        var catatan = document.getElementById('desc-' + id_jadwal).innerHTML;

        document.getElementById('modal-catatan').innerHTML = catatan;

        var myModal = new bootstrap.Modal(document.getElementById('catatanModal'));
        myModal.show();
    }
</script>
<?= $this->endSection() ?>
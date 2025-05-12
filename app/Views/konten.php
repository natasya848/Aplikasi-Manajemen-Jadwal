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
                <h3>Data Konten</h3>
            </div>
        </div>

    <section class="section">
        <div class="card p-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <a href="<?= base_url('konten/input_konten') ?>"><button class="btn btn-info"><i class="bi bi-plus"></i>Tambah</button></a>

                    <?php if (session()->get('level') == 1): ?>
                    <a href="<?= base_url('konten/dihapus_konten') ?>">
                        <button class="btn btn-primary">Data Konten yang Dihapus</button>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table5">
                <thead class="text-white">
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
                    <?php if (!empty($konten)): ?>
                        <?php $no = 1; foreach ($konten as $value): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($value->judul) ?></td>
                            <td><?= esc($value->plartform ?: '-') ?></td>
                            <td><?= date('d M Y', strtotime($value->deadline)) ?></td>
                            <td><?= esc($value->nama_produk) ?> - <?= esc($value->nama_klien) ?> - <?= date('d M Y', strtotime($value->tanggal)) ?></td>
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
                                <a href="<?= base_url('konten/updateStatusKonten/' . $value->id_konten) ?>" class="btn btn-success btn-sm me-2" onclick="return confirm('Apakah Anda yakin ingin menandai konten ini sebagai selesai?');"><i class="fa fa-check"></i></a>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item text-warning" href="<?= base_url('konten/edit_konten/' . $value->id_konten) ?>">
                                                <i class="fa fa-edit me-1"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="<?= base_url('konten/delete_konten/' . $value->id_konten) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus konten ini?')">
                                                <i class="fa fa-trash me-1"></i> Hapus
                                            </a>
                                        </li>
                                        <?php if (session()->get('level') == 1): ?>
                                        <li>
                                            <a class="dropdown-item text-info" href="<?= base_url('konten/detail_konten/' . $value->id_konten) ?>">
                                                <i class="fa fa-eye me-1"></i> Detail
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                </div>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data konten.</td>
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
        $('#table5').DataTable({
            "paging": true,         
            "searching": true,      
            "info": true,           
            "lengthChange": true   
        });
    });
</script>
<?= $this->endSection() ?>


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
                <h3>Data User</h3>
            </div>
        </div>

    <section class="section">
        <div class="card p-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <a href="<?= base_url('user/input_user') ?>"><button class="btn btn-info"><i class="bi bi-plus"></i>Tambah</button></a>
                
                    <?php if (session()->get('level') == 1): ?>
                    <a href="<?= base_url('user/dihapus_user') ?>">
                        <button class="btn btn-primary">Data User yang Dihapus</button>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead class="text-white">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($user)): ?>
                        <?php $no = 1; foreach ($user as $value): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <img src="<?= base_url('uploads/' . $value->foto) ?>" style="width: 100px; height: 100px; object-fit: cover;">
                            </td>
                            <td><?= $value->nama_user ?></td>
                            <td><?= $value->username ?></td>
                            <td><?= $value->email ?></td>
                            <td>
                               <?php 
                                   switch ($value->level) {
                                       case 1:
                                           echo '<span class="badge bg-danger">Super Admin</span>';
                                           break;
                                       case 2:
                                           echo '<span class="badge bg-info">Admin</span>';
                                           break;
                                       case 3:
                                           echo '<span class="badge bg-success">Manager</span>';
                                           break;
                                       default:
                                            echo '<span class="badge bg-secondary">Tidak Diketahui</span>';
                                           break;
                                   }
                               ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton<?= $value->id_user ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $value->id_user ?>">
                                        <li>
                                            <a class="dropdown-item text-warning" href="<?= base_url('user/edit_user/' . $value->id_user) ?>">
                                                <i class="fa fa-key me-1"></i> Reset Password
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="<?= base_url('user/delete_user/' . $value->id_user) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus rekap ini?')">
                                                <i class="fa fa-trash me-1"></i> Hapus
                                            </a>
                                        </li>
                                        <?php if (session()->get('level') == 1): ?>
                                        <li>
                                            <a class="dropdown-item text-info" href="<?= base_url('user/detail_user/' . $value->id_user) ?>">
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
                            <td colspan="8" class="text-center">Tidak ada data user.</td>
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
        $('#table1').DataTable({
            "paging": true,         
            "searching": true,      
            "info": true,           
            "lengthChange": true   
        });
    });
</script>
<?= $this->endSection() ?>


<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
    .card .card-header {
        background-color: #fcead0 !important; 
        color: #3e3e3e !important;
        font-weight: 600;
        border-bottom: 2px solid #e2d4c3;
    }

    .table {
        background-color: #fff;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #f2e5d7;
    }

    .table thead {
        background-color: #fffaf3; 
    }

    .table thead th {
        color: #5e5e5e;
        font-weight: 600;
        text-transform: none;
        padding: 12px 15px;
        border-bottom: 2px solid #f0dbc4;
    }

    .table tbody tr:nth-child(even) {
        background-color: #fef5ec;
    }

    .table tbody tr:hover {
        background-color: #f2e0d0; 
    }

    .table th,
    .table td {
        padding: 12px 15px;
        color: #3e3e3e;
        border: none;
        vertical-align: middle;
    }

    .btn-secondary {
        background-color: #f4a261;
        border-color: #f4a261;
        color: #fff;
    }

    .btn-secondary:hover {
        background-color: #e28b3d;
        border-color: #e28b3d;
    }
</style>

<div class="container">
  <div class="card">
    <div class="card-header text-center">
      <h4>Detail To Do</h4>
    </div>

        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Status</th>
                        <th>Prioritas</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Deleted At</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= esc($todo->tanggal) ?></td>
                        <td><?= esc($todo->kegiatan) ?></td>
                        <td><?= esc($todo->status) ?></td>
                        <td><?= esc($todo->prioritas) ?></td>
                        <td><?= esc($todo->created_at) ?></td>
                        <td><?= esc($todo->updated_at ?? '-') ?></td>
                        <td><?= esc($todo->deleted_at ?? '-') ?></td>
                    </tr>
                </tbody>
            </table>
            <a href="<?= base_url('todo/tabel_todo') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

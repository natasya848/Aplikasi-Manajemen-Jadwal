<?= $this->extend('layout') ?> 
<?= $this->section('content') ?>

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
                <h3>Data Riwayat Aktivitas</h3>
            </div>
    </div>

    <section class="section">
        <div class="card p-3">
            <div class="card-body">

            <?php $session = session(); ?>
            <?php if ($session->get('level') == 1): ?>
                <form method="get" action="<?= base_url('log/tabel_riwayat') ?>" class="d-flex align-items-center mb-3">
                    <label for="nama_user" class="me-2 fw-bold">Filter Nama User:</label>
                    <select name="id_user" id="nama_user" class="form-select w-auto me-2" onchange="this.form.submit()">
                        <option value="all">Semua User</option>
                        <?php foreach ($userList as $u): ?>
                            <option value="<?= $u['id_user'] ?>" <?= ($selectedUser == $u['id_user']) ? 'selected' : '' ?>>
                                <?= $u['nama_user'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            <?php endif; ?>


                <table class="table table-striped" id="table17">
					<thead class="text-white">
			                        <tr>
			                            <th>No</th>
			                            <th>ID User</th>
			                            <th>Nama User</th>
			                            <th>Username</th>
			                            <th>Aktivitas</th>
			                            <th>IP Address</th>
			                            <th>Waktu</th>
			                        </tr>
			                    </thead>
			                    <tbody id="log_table_body">
                                    <?php $no = 1; foreach ($logs as $log): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $log->id_user; ?></td>
                                            <td><?= $log->nama_user ?? 'User Tidak Diketahui'; ?></td>
                                            <td><?= $log->username ?? '-'; ?></td>
                                            <td><?= 'id_user=' . $log->id_user . ' ' . $log->aktivitas; ?></td>
                                            <td><?= $log->ip_address ?? 'Tidak Ada IP'; ?></td>
                                            <td><?= date('d-m-Y H:i:s', strtotime($log->waktu)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
			                </table>
			            </div>
			        </div>
			    </section>
			</div>
		</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    $(document).ready(function () {
        $('#filter_user').change(function () {
            const idUser = $(this).val();
            $.ajax({
                url: "<?= base_url('log/filter_ajax') ?>",
                method: "GET",
                data: { id_user: idUser },
                success: function (response) {
                    $('#log_table_body').html(response);
                },
                error: function () {
                    alert("Terjadi kesalahan saat mengambil data.");
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#table17').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "lengthChange": true
        });
    });
</script>
<?= $this->endSection() ?>

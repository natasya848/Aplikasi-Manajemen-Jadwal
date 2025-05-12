<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                <h3>Laporan Jadwal</h3>
            </div>
        </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
            <form id="filterForm" method="get" action="<?= base_url('laporan/jadwal') ?>" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label>Mulai Tanggal</label>
                        <input type="date" name="start_date" value="<?= $start ?>" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="end_date" value="<?= $end ?>" class="form-control">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">Filter</button>

                        <a id="pdfButton" target="_blank" class="btn btn-danger me-2">
                            <i class="fas fa-file-pdf"></i>
                        </a>

                        <a id="excelButton" target="_blank" class="btn btn-success me-2">
                            <i class="fas fa-file-excel"></i>
                        </a>
                    </div>
                </div>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Jam</th>
                        <th>Judul Konten</th>
                        <th>Deadline</th>
                        <th>Status Jadwal</th>
                        <th>Status Konten</th>
                        <th>Platform</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jadwal as $row): ?>
                        <tr>
                            <td><?= date('d-m-Y', strtotime($row->tanggal)) ?></td>
                            <td><?= $row->nama_produk ?></td>
                            <td><?= $row->jam ?></td>
                            <td><?= $row->judul ?? '-' ?></td>
                            <td><?= $row->deadline ?? '-' ?></td>
                            <td><?= $row->status_jadwal ?></td>
                            <td><?= $row->status_konten ?? '-' ?></td>
                            <td><?= $row->platform ?? '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
    $('#filterForm').on('submit', function(e){
        e.preventDefault(); 

        $.ajax({
            url: $(this).attr('action'),
            type: 'GET',
            data: $(this).serialize(),
            success: function(response){
                var newTbody = $(response).find('table tbody').html();
                $('table tbody').html(newTbody);

                var startDate = document.querySelector('input[name="start_date"]').value;
                var endDate = document.querySelector('input[name="end_date"]').value;

                document.getElementById('pdfButton').href = "<?= base_url('laporan/jadwalpdf') ?>" + 
                    "?start_date=" + startDate + "&end_date=" + endDate;
                    
                document.getElementById('excelButton').href = "<?= base_url('laporan/jadwalexcel') ?>" + 
                    "?start_date=" + startDate + "&end_date=" + endDate;
            },
            error: function(xhr){
                alert('Terjadi kesalahan saat memuat data!');
            }
        });
    });
</script>

<?= $this->endSection() ?>

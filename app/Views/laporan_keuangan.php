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
                <h3>Laporan Keuangan</h3>
            </div>
        </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
            <form id="filterForm" method="get" action="<?= base_url('laporan/keuangan') ?>" class="mb-4">
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
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($laporan as $row): ?>
                        <tr>
                            <td><?= date('d-m-Y', strtotime($row->tanggal)) ?></td>
                            <td><?= $row->jenis ?></td>
                            <td><?= $row->kategori ?></td>
                            <td><?= $row->deskripsi ?></td>
                            <td>Rp <?= number_format($row->jumlah, 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h5>Ringkasan</h5>
            <ul id="ringkasan">
                <li><strong>Total Pemasukan:</strong> Rp <?= number_format($summary['pemasukan'], 0, ',', '.') ?></li>
                <li><strong>Total Pengeluaran:</strong> Rp <?= number_format($summary['pengeluaran'], 0, ',', '.') ?></li>
                <li><strong>Saldo Akhir:</strong> Rp <?= number_format($summary['saldo'], 0, ',', '.') ?></li>
            </ul>
        </div>
    </div>
</section>

    <script>
        $(document).ready(function(){
            $('#filterForm').on('submit', function(e){
                e.preventDefault(); 

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'GET',
                    data: $(this).serialize(),
                    success: function(response){
                        var newTbody = $(response).find('table tbody').html();
                        $('table tbody').html(newTbody);

                        var newSummary = $(response).find('#ringkasan').html();
                        $('#ringkasan').html(newSummary);

                    },
                    error: function(xhr){
                        alert('Terjadi kesalahan saat memuat data!');
                    }
                });
            });
        });
    </script>

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

                    var newSummary = $(response).find('#ringkasan').html();
                    $('#ringkasan').html(newSummary);

                    var startDate = document.querySelector('input[name="start_date"]').value;
                    var endDate = document.querySelector('input[name="end_date"]').value;

                    document.getElementById('pdfButton').href = "<?= base_url('laporan/keuanganpdf') ?>" + 
                        "?start_date=" + startDate + "&end_date=" + endDate;
                        
                    document.getElementById('excelButton').href = "<?= base_url('laporan/keuanganexcel') ?>" + 
                        "?start_date=" + startDate + "&end_date=" + endDate;
                },
                error: function(xhr){
                    alert('Terjadi kesalahan saat memuat data!');
                }
            });
        });
    </script>


<?= $this->endSection() ?>

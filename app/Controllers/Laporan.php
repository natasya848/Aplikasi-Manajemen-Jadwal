<?php

namespace App\Controllers;

use App\Models\M_rekap;
use App\Models\M_jadwal;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Laporan extends BaseController
{  
    public function keuangan()
    {
        $this->logActivity("Mengakses Laporan Keuangan");

        $model = new \App\Models\M_rekap();

        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        $laporan = $model->getLaporan($startDate, $endDate);
        $summary = $model->getSummary($startDate, $endDate);

        $data = [
            'title'    => 'Laporan Keuangan',
            'laporan'  => $laporan,
            'summary'  => $summary,
            'start'    => $startDate,
            'end'      => $endDate,
        ];

        return view('laporan_keuangan', $data);
    }

    public function keuanganpdf()
    {
        $start = $this->request->getGet('start_date');
        $end   = $this->request->getGet('end_date');

        if (! $start || ! $end) {
            $start = date('Y-m-01');
            $end   = date('Y-m-t');
        }

        $this->logActivity("Mengunduh Laporan Keuangan PDF dari $start sampai $end");

        $rekapModel = new \App\Models\M_rekap();
        $laporan    = $rekapModel->getLaporan($start, $end);

        $totalPemasukan  = 0;
        $totalPengeluaran = 0;

        foreach ($laporan as $row) {
            $jumlah = (int) $row->jumlah;
            $jenis  = strtolower(trim($row->jenis));

            if (stripos($jenis, 'masuk') !== false) {
                $totalPemasukan += $jumlah;
            } elseif (stripos($jenis, 'pengeluar') !== false) {
                $totalPengeluaran += $jumlah;
            }
        }

        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        $dompdf = new \Dompdf\Dompdf();
        $html   = view('keuangan_pdf', [
            'laporan'          => $laporan,
            'start'            => $start,
            'end'              => $end,
            'totalPemasukan'   => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldoAkhir'       => $saldoAkhir,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Laporan_Keuangan.pdf', ['Attachment' => false]);
    }


    public function keuanganexcel()
    {
        $start = $this->request->getGet('start_date');
        $end = $this->request->getGet('end_date');

        $this->logActivity("Mengunduh Laporan Keuangan Excel dari $start sampai $end");

        $rekapModel = new \App\Models\M_rekap();
        $laporan = $rekapModel->getLaporan($start, $end);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $judul = 'Laporan Keuangan';
        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Tanggal');
        $sheet->setCellValue('C3', 'Jenis');
        $sheet->setCellValue('D3', 'Kategori');
        $sheet->setCellValue('E3', 'Deskripsi');
        $sheet->setCellValue('F3', 'Jumlah');

        $rowNumber = 4;
        $no = 1;
        $totalSemua = 0;
        $totalPemasukan = 0;
        $totalPengeluaran = 0;

        foreach ($laporan as $row) {
            $jumlah = (int)$row->jumlah;

            $jenis = strtolower(trim($row->jenis));

            if (strpos($jenis, 'masuk') !== false) {
                $totalPemasukan += $jumlah;
            } elseif (strpos($jenis, 'pengeluar') !== false) {
                $totalPengeluaran += $jumlah;
            }
            
            $sheet->setCellValue('A' . $rowNumber, $no++);
            $sheet->setCellValue('B' . $rowNumber, date('d-m-Y', strtotime($row->tanggal)));
            $sheet->setCellValue('C' . $rowNumber, $row->jenis);
            $sheet->setCellValue('D' . $rowNumber, $row->kategori);
            $sheet->setCellValue('E' . $rowNumber, $row->deskripsi);
            $sheet->setCellValue('F' . $rowNumber, $jumlah);
            $sheet->getStyle('F' . $rowNumber)->getNumberFormat()->setFormatCode('"Rp"#,##0');

            $totalSemua += $jumlah;
            $rowNumber++;
        }

        $sheet->setCellValue('E' . $rowNumber, 'Total');
        $sheet->setCellValue('F' . $rowNumber, $totalSemua);
        $sheet->getStyle('F' . $rowNumber)->getNumberFormat()->setFormatCode('"Rp"#,##0');
        $sheet->getStyle('E' . $rowNumber)->getFont()->setBold(true);
        $sheet->getStyle('F' . $rowNumber)->getFont()->setBold(true);

        $totalRow = $rowNumber;
        $rowNumber++;

        $sheet->setCellValue('E' . ($rowNumber + 1), 'Total Pemasukan');
        $sheet->setCellValue('F' . ($rowNumber + 1), $totalPemasukan);
        $sheet->setCellValue('E' . ($rowNumber + 2), 'Total Pengeluaran');
        $sheet->setCellValue('F' . ($rowNumber + 2), $totalPengeluaran);
        $sheet->setCellValue('E' . ($rowNumber + 3), 'Saldo Akhir');
        $sheet->setCellValue('F' . ($rowNumber + 3), $totalPemasukan - $totalPengeluaran);

        foreach (range($rowNumber + 1, $rowNumber + 3) as $i) {
            $sheet->getStyle('F' . $i)->getNumberFormat()->setFormatCode('"Rp"#,##0');
            $sheet->getStyle('E' . $i)->getFont()->setBold(true);
            $sheet->getStyle('F' . $i)->getFont()->setBold(true);
        }

        $sheet->getStyle('A3:F' . $totalRow)->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_Keuangan.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }

    public function jadwal()
    {
        $this->logActivity("Mengakses Laporan Jadwal");

        $model = new \App\Models\M_jadwal();
        $start = $this->request->getGet('start_date');
        $end   = $this->request->getGet('end_date');

        $laporan = $model->getLaporanJadwal($start, $end);

        $data = [
            'title'   => 'Laporan Jadwal Aktivitas',
            'jadwal'  => $laporan,
            'start'   => $start,
            'end'     => $end,
        ];

        return view('laporan_jadwal', $data);
    }

    public function jadwalpdf()
    {
        $start = $this->request->getGet('start_date');
        $end = $this->request->getGet('end_date');

        $this->logActivity("Mengunduh Laporan Jadwal PDF dari $start sampai $end");

        $model = new \App\Models\M_jadwal(); 
        $laporan = $model->getLaporanJadwal($start, $end);

        $data = [
            'jadwal' => $laporan,
            'start' => $start,
            'end' => $end,
        ];

        $html = view('jadwal_pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("Laporan_Jadwal" . date('Ymd') . ".pdf", ["Attachment" => false]);
    }

    public function jadwalexcel()
    {
        $start = $this->request->getGet('start_date');
        $end   = $this->request->getGet('end_date');

        $this->logActivity("Mengunduh Laporan Jadwal Excel dari $start sampai $end");

        $model   = new \App\Models\M_jadwal();
        $laporan = $model->getLaporanJadwal($start, $end);

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Laporan Jadwal Aktivitas');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')
            ->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $headers = ['Tanggal','Produk','Jam','Judul Konten','Deadline','Status Jadwal','Status Konten','Platform'];
        $col     = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '3', $header);
            $col++;
        }

        $row = 4;
        foreach ($laporan as $item) {
            $sheet->setCellValue('A' . $row, date('d-m-Y', strtotime($item->tanggal)));
            $sheet->setCellValue('B' . $row, $item->nama_produk);
            $sheet->setCellValue('C' . $row, $item->jam);
            $sheet->setCellValue('D' . $row, $item->judul ?? '-');
            $sheet->setCellValue('E' . $row, $item->deadline ?? '-');
            $sheet->setCellValue('F' . $row, $item->status_jadwal);
            $sheet->setCellValue('G' . $row, $item->status_konten ?? '-');
            $sheet->setCellValue('H' . $row, $item->platform ?? '-');
            $row++;
        }

        $lastRow = $row - 1;
        $sheet->getStyle("A3:H{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        foreach (range('A','H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer   = new Xlsx($spreadsheet);
        $filename = 'Laporan_Jadwal_' . date('Ymd') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

}
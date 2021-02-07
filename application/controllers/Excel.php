<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel extends CI_Controller
{

    public function index()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);

        $filename = 'simple';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function skp_rencana($id = null)
    {
        if (!$id) return redirect('/admin/skp_realisasi');

        $skp = $this->db->get_where('skp', ['id' => $id])->row_array();
        $kegiatan = $this->db->where('skp_id', $id)->get('skp_kegiatan')->result_array();

        $pejabat = $this->db->get_where('pegawai', ['id_pegawai' => $skp['atasan_id']])->row_array();
        $pegawai = $this->db->get_where('pegawai', ['id_pegawai' => $skp['pejabat_id']])->row_array();

        if (!$pejabat || !$pegawai) return redirect('admin/skp_rencana');

        $pejabat_ = $this->db->get_where('jabatan', ['id_jabatan' => $pejabat['id_jabatan']])->row_array();
        $pegawai_ = $this->db->get_where('jabatan', ['id_jabatan' => $pegawai['id_jabatan']])->row_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'FORMULIR SASARAN KERJA PEGAWAI')->mergeCells('A1:H1');
        $sheet->setCellValue('A2', 'PEGAWAI NEGERI SIPIL')->mergeCells('A2:H2');

        // style
        $headerStyle = [
            'font' => [
                'bold' => true
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $boldStyle = [
            'font' => [
                'bold' => true
            ],
        ];
        $borderAllStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $borderOutlineStyle = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $borderVerticalStyle = [
            'borders' => [
                'vertical' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],
            ],
        ];

        $sheet->getStyle('A1:H2')->applyFromArray($headerStyle);

        $sheet->setCellValue('A3', 'No.');
        $sheet->setCellValue('B3', 'I. Pejabat Penilai')->mergeCells('B3:C3');
        $sheet->setCellValue('D3', 'No.');
        $sheet->setCellValue('E3', 'II. Pegawai Negeri Sipil yang Dinilai')->mergeCells('E3:H3');

        $sheet->getStyle('A3:H3')->applyFromArray($borderAllStyle);
        $sheet->getStyle('A3:H3')->applyFromArray($boldStyle);

        $sheet->setCellValue('A4', '1');
        $sheet->setCellValue('A5', '2');
        $sheet->setCellValue('A6', '3');
        $sheet->setCellValue('A7', '4');

        $sheet->setCellValue('B4', 'Nama');
        $sheet->setCellValue('B5', 'NIP');
        $sheet->setCellValue('B6', 'Pangkat/Gol. Ruang');
        $sheet->setCellValue('B7', 'Jabatan');

        $sheet->setCellValue('C4', $pejabat['nama']);
        $sheet->setCellValue('C5', $pejabat['nip']);
        $sheet->setCellValue('C6', $pejabat_['golongan']);
        $sheet->setCellValue('C7', $pejabat_['nama_jabatan']);

        $sheet->setCellValue('D4', '1');
        $sheet->setCellValue('D5', '2');
        $sheet->setCellValue('D6', '3');
        $sheet->setCellValue('D7', '4');

        $sheet->setCellValue('E4', 'Nama')->mergeCells('E4:F4');
        $sheet->setCellValue('E5', 'NIP')->mergeCells('E5:F5');
        $sheet->setCellValue('E6', 'Pangkat/Gol. Ruang')->mergeCells('E6:F6');
        $sheet->setCellValue('E7', 'Jabatan')->mergeCells('E7:F7');

        $sheet->setCellValue('G4', $pegawai['nama'])->mergeCells('G4:H4');
        $sheet->setCellValue('G5', $pegawai['nip'])->mergeCells('G5:H5');
        $sheet->setCellValue('G6', $pegawai_['golongan'])->mergeCells('G6:H6');
        $sheet->setCellValue('G7', $pegawai_['nama_jabatan'])->mergeCells('G7:H7');

        $sheet->getStyle('A4:H7')->applyFromArray($borderVerticalStyle);

        $sheet->setCellValue('A8', 'No.')->mergeCells('A8:A9');
        $sheet->setCellValue('B8', 'III. Kegiatan Tugas Jabatan')->mergeCells('B8:C9');
        $sheet->setCellValue('D8', 'AK.')->mergeCells('D8:D9');
        $sheet->setCellValue('E8', 'III. Kegiatan Tugas Jabatan')->mergeCells('E8:H8');
        $sheet->setCellValue('E9', 'Kuant/Output');
        $sheet->setCellValue('F9', 'Kual/Mutu');
        $sheet->setCellValue('G9', 'Waktu');
        $sheet->setCellValue('H9', 'Biaya');

        $sheet->getStyle('A8:H9')->applyFromArray($borderAllStyle);
        $sheet->getStyle('A8:H9')->applyFromArray($boldStyle);
        $sheet->getStyle('A8:H9')->applyFromArray($headerStyle);

        $row = 10;
        $no = 0;
        $nilai = 0;
        foreach ($kegiatan as $item) {
            //
            $sheet->setCellValue("A$row", ++$no);
            $sheet->setCellValue("B$row", $item['kegiatan'])->mergeCells("B$row:C$row");
            $sheet->setCellValue("D$row", 0);
            $sheet->setCellValue("E$row", $item['qty_volume'] . " " . $item['qty_satuan']);
            $sheet->setCellValue("F$row", $item['kualitas']);
            $sheet->setCellValue("G$row", $item['wkt_lama'] . " " . $item['wkt_satuan']);
            $sheet->setCellValue("H$row", $item['biaya']);
            $row++;
        }
        $sheet->getStyle("A10:H" . ($row - 1))->applyFromArray($borderAllStyle);
        $row++;

        $sheet->setCellValue("F$row", "Banjarmasin, " . date('d F Y'));
        $row++;
        $row++;
        $sheet->setCellValue("B$row", 'Pejabat Penilai,');
        $sheet->setCellValue("F$row", 'Pegawai yang Dinilai,');

        $row += 2;
        $sheet->setCellValue("B$row", $pejabat['nama']);
        $sheet->setCellValue("F$row", $pegawai['nama']);
        $row++;
        $sheet->setCellValue("B$row", $pejabat['nip']);
        $sheet->setCellValue("F$row", $pegawai['nip']);


        $writer = new Xlsx($spreadsheet);

        $filename = 'Rencana SKP tahun ' . $skp['tahun'];

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function skp_realisasi($id = null)
    {
        if (!$id) return redirect('/admin/skp_realisasi');
        $skp = $this->db->get_where('skp', ['id' => $id])->row_array();
        $kegiatan = $this->db->where('skp_id', $id)->get('skp_kegiatan')->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'PENILAIAN CAPAIAN SASARAN KERJA')->mergeCells('A1:V1');
        $sheet->setCellValue('A2', 'PEGAWAI NEGERI SIPIL')->mergeCells('A2:V2');
        $sheet->setCellValue('A3', "Jangka Waktu Penilaian 02 Januari s.d/ 31 Desember " . $skp['tahun']);


        $sheet->setCellValue('A4', 'No.')->mergeCells('A4:A5');
        $sheet->setCellValue('B4', 'Kegiatan Tugas Jabatan')->mergeCells('B4:B5');
        $sheet->setCellValue('C4', 'AK')->mergeCells('C4:C5');
        $sheet->setCellValue('D4', 'TARGET')->mergeCells('D4:M4');
        $sheet->setCellValue('D5', 'Kuant/Output')->mergeCells('D5:F5');
        $sheet->setCellValue('G5', 'Kual/Mutu')->mergeCells('G5:H5');
        $sheet->setCellValue('I5', 'Waktu')->mergeCells('I5:K5');
        $sheet->setCellValue('L5', 'Biaya')->mergeCells('L5:M5');
        $sheet->setCellValue('N4', 'AK')->mergeCells('N4:N5');
        $sheet->setCellValue('O4', 'REALISASI')->mergeCells('O4:T4');
        $sheet->setCellValue('O5', 'Kuant/Output')->mergeCells('O5:P5');
        $sheet->setCellValue('Q5', 'Kual/Mutu');
        $sheet->setCellValue('R5', 'Waktu')->mergeCells('R5:S5');
        $sheet->setCellValue('T5', 'Biaya');
        $sheet->setCellValue('U4', 'PERHITUNGAN')->mergeCells('U4:U5');
        $sheet->setCellValue('V4', 'NILAI CAPAIAN SKPD')->mergeCells('V4:V5');

        // style
        $headerStyle = [
            'font' => [
                'bold' => true
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A1:V2')->applyFromArray($headerStyle);
        $sheet->getStyle('A4:V5')->applyFromArray($headerStyle);

        $row = 6;
        $no = 0;
        $nilai = 0;
        foreach ($kegiatan as $item) {
            $sheet->setCellValue('A' . $row, ++$no);
            $sheet->setCellValue('B' . $row, $item['kegiatan']);
            $sheet->setCellValue('C' . $row, '0');
            $sheet->setCellValue('D' . $row, $item['qty_volume'] . " " . $item['qty_satuan'])->mergeCells("D$row:F$row");
            $sheet->setCellValue('G' . $row, $item['kualitas'])->mergeCells("G$row:H$row");
            $sheet->setCellValue('I' . $row, $item['wkt_lama'] . " " . $item['wkt_satuan'])->mergeCells("I$row:K$row");
            $sheet->setCellValue('L' . $row, $item['biaya'])->mergeCells("L$row:M$row");
            $sheet->setCellValue('N' . $row, '0');
            $sheet->setCellValue('O' . $row, $item['qty_volume'] . " " . $item['qty_satuan'])->mergeCells("O$row:P$row");
            $sheet->setCellValue('Q' . $row, $item['kualitas']);
            $sheet->setCellValue('R' . $row, $item['wkt_lama'] . " " . $item['wkt_satuan'])->mergeCells("R$row:S$row");
            $sheet->setCellValue('T' . $row, $item['biaya']);
            $sheet->setCellValue('U' . $row, rand(50, 500));
            $sheet->setCellValue('V' . $row, $item['nilai'] ? $item['nilai'] : 0);
            $nilai += $item['nilai'];
            $row++;
        }
        $sheet->setCellValue('A' . $row, 'Nilai Capaian SKP')->mergeCells("A$row:U" . ($row + 1));
        $sheet->getStyle("A$row:U" . ($row + 1))->applyFromArray($headerStyle);

        $nilai /= $no;
        $sheet->setCellValue('V' . $row, $nilai);
        $row++;

        if ($nilai > 90) $ket = 'Sangat Baik';
        else if ($nilai > 75) $ket = 'Baik';
        else if ($nilai >= 50) $ket = 'Cukup';
        else $ket = 'Kurang Baik';

        $sheet->setCellValue('V' . $row, $ket);
        $sheet->getStyle("A4:V$row")->applyFromArray($borderStyle);


        $writer = new Xlsx($spreadsheet);

        $filename = 'Realisasi SKP tahun ' . $skp['tahun'];

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('Pdf');
    $this->load->model('M_admin');
  }

  public function barangKeluarManual()
  {

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // document informasi
    $pdf->SetCreator('Web Aplikasi Kegiatan');
    $pdf->SetTitle('Laporan Data Kegiatan');
    $pdf->SetSubject('Kegiatan Selesai');
    $id = $this->uri->segment(3);
    $tgl1 = $this->uri->segment(4);
    $tgl2 = $this->uri->segment(5);
    $tgl3 = $this->uri->segment(6);
    $ls   = array('id_transaksi' => $id, 'tanggal_keluar' => $tgl1 . '/' . $tgl2 . '/' . $tgl3);
    $data = $this->M_admin->get_data_tabel('tb_barang_keluar', $ls);

    //header Data
    $pdf->SetHeaderData('unsada.jpg', 20, 'Laporan Data', 'Kegiatan Diklat', array(203, 58, 44), array(0, 0, 0));
    $pdf->SetFooterData(array(255, 255, 255), array(255, 255, 255));


    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margin
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 10, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM - 5);

    //SET Scaling ImagickPixel
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //FONT Subsetting
    $pdf->setFontSubsetting(true);

    $pdf->SetFont('helvetica', '', 14, '', true);

    $pdf->AddPage('L');

    $html =
      '<div>
        <h1 align="center">Laporan Data Kegiatan Diklat
        </h1>
        
        <table border="1">
          <tr>
            <th style="width:40px" align="center">No</th>
            <th style="width:110px" align="center">ID Kegiatan</th>
            <th style="width:110px" align="center">Tanggal Masuk</th>
            <th style="width:110px" align="center">Tanggal Terlaksana</th>
            <th style="width:130px" align="center">PIC</th>
            <th style="width:140px" align="center">Nama Kegiatan</th>
            <th style="width:80px" align="center">Jenis Kegiatan</th>
            <th style="width:90px" align="center">Absensi</th>
            <th style="width:80px" align="center">Status</th>
            <th style="width:80px" align="center">Jumlah Peserta</th>
          </tr>';

    $no = 1;
    foreach ($data as $d) {
      $html .= '<tr>';
      $html .= '<td align="center">' . $no . '</td>';
      $html .= '<td align="center">' . $d->id_transaksi . '</td>';
      $html .= '<td align="center">' . $d->tanggal_masuk . '</td>';
      $html .= '<td align="center">' . $d->tanggal_keluar . '</td>';
      $html .= '<td align="center">' . $d->lokasi . '</td>';
      $html .= '<td align="center">' . $d->kode_barang . '</td>';
      $html .= '<td align="center">' . $d->jenis_kegiatan . '</td>';
      $html .= '<td align="center">' . $d->nama_barang . '</td>';
      $html .= '<td align="center">' . $d->satuan . '</td>';
      $html .= '<td align="center">' . $d->jumlah . '</td>';
      $html .= '</tr>';

      $no++;
    }

    $html .= '<tr>
                    <td style="height:180px"></td>
                    <td  style="height:180px"></td>
                    <td style="height:180px"></td>
                    <td style="height:180px"></td>
                    <td style="height:180px"></td>
                    <td style="height:180px"></td>
                    <td style="height:180px"></td>
                    <td style="height:180px"></td>
                    <td style="height:180px"></td>
                    <td style="height:180px"></td>
                 </tr>';



    $html .= '
            </table>
            <h6>Mengetahui</h6><br>
            <h6>Admin</h6>
          </div>';

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);

    $pdf->Output('Laporan Kegiatan.pdf', 'I');
  }

  public function barangKeluar()
  {
    $id = $this->uri->segment(3);
    $tgl1 = $this->uri->segment(4);
    $tgl2 = $this->uri->segment(5);
    $tgl3 = $this->uri->segment(6);
    $ls   = array('id_transaksi' => $id, 'tanggal_keluar' => $tgl1 . '/' . $tgl2 . '/' . $tgl3);
    $data = $this->M_admin->get_data('tb_barang_keluar', $ls);

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // document informasi
    $pdf->SetCreator('Web Kegiatan Diklat');
    $pdf->SetTitle('Laporan Data Kegiatan');
    $pdf->SetSubject('Data Kegiatan Diklat');

    //header Data
    $pdf->SetHeaderData('unsada.jpg', 30, 'Laporan Data Kegiatan', 'PT Pindad', array(203, 58, 44), array(0, 0, 0));
    $pdf->SetFooterData(array(255, 255, 255), array(255, 255, 255));


    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margin
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 10, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM - 5);

    //SET Scaling ImagickPixel
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //FONT Subsetting
    $pdf->setFontSubsetting(true);

    $pdf->SetFont('helvetica', '', 14, '', true);

    $pdf->AddPage('L');

    $html =
      '<div>
        <h1 align="center">Invoice Bukti Kegiatan</h1><br>
        <p>No Id Transaksi  : ' . $id . '</p>
        <p>Tanggal          : ' . $tgl1 . '/' . $tgl2 . '/' . $tgl3 . '</p>


        <table border="1">
          <tr>
            <th style="width:40px" align="center">No</th>
            <th style="width:110px" align="center">ID Transaksi</th>
            <th style="width:110px" align="center">Tanggal Masuk</th>
            <th style="width:110px" align="center">Tanggal Terlaksana</th>
            <th style="width:130px" align="center">PIC</th>
            <th style="width:140px" align="center">Nama Kegiatan</th>
            <th style="width:140px" align="center">Jenis Kegiatan</th>
            <th style="width:90px" align="center">Absensi</th>
            <th style="width:80px" align="center">Status</th>
            <th style="width:80px" align="center">Jumlah Peserta</th>
          </tr>';


    $no = 1;
    foreach ($data as $d) {
      $html .= '<tr>';
      $html .= '<td align="center">' . $no . '</td>';
      $html .= '<td align="center">' . $d->id_transaksi . '</td>';
      $html .= '<td align="center">' . $d->tanggal_masuk . '</td>';
      $html .= '<td align="center">' . $d->tanggal_keluar . '</td>';
      $html .= '<td align="center">' . $d->satuan . '</td>';
      $html .= '<td align="center">' . $d->kode_barang . '</td>';
      $html .= '<td align="center">' . $d->jenis_kegiatan . '</td>';
      $html .= '<td align="center">' . $d->nama_barang . '</td>';
      $html .= '<td align="center">' . $d->lokasi . '</td>';
      $html .= '<td align="center">' . $d->jumlah . '</td>';
      $html .= '</tr>';


      $no++;
    }


    $html .= '
            </table><br>
            <h6>Mengetahui</h6><br><br><br>
            <h6>Admin</h6>
          </div>';

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);

    $pdf->Output('Laporan Data Kegiatan.pdf', 'I');
  }
}

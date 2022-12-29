<?php
//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// Description : Example 048 for TCPDF class
//               HTML tables and table headers
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */

// Include the main TCPDF library (search for installation path).
// require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
if ($this->uri->segment(2)=="print_stok_hand") {
    $pdf->SetTitle('Penyata Stok Semasa');
  }else {
    $pdf->SetTitle('Penyata Kemasukan Stok');
  }

$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

$pdf->Image('logo/'.$logo['image_file'], 15, 18, 29, 29, 'PNG', 'http://www.tcpdf.org', '', false, 150, '', false, false, 1, false, false, false);

$pdf->SetFont('times', 'B', 29);

foreach ($maklumat as $key) { 
    $pdf->Text(45, 17, $key['nama']);
    $pdf->SetFont('helvetica', 'B', 10);
  
    if ($key['n_tambahan']) {
      $pdf->Text(45, 28, $key['n_tambahan']);
      $pdf->Text(45, 32, $key['alamat'].',');
      $pdf->Text(45, 36, $key['poskod'].' '.$key['bandar'] .', '.$key['state']);
      $pdf->Text(45, 40, 'Telefon : '.$key['telefon']);
      if ($this->uri->segment(2)=="print_stok_hand") {
        $pdf->Text(146, 33, 'PENYATA STOK SEMASA');
      }else {
        $pdf->Text(138, 33, 'PENYATA KEMASUKAN STOK');
      }
      
      $pdf->Text(45, 44, 'H/P : '.$key['hp']);
      $pdf->Text(76, 44, ','.$key['hp']);
    }else {
      $pdf->Text(45, 29, $key['alamat'].',');
      $pdf->Text(45, 33, $key['poskod'].' '.$key['bandar'] .', '.$key['state']);
      $pdf->Text(45, 37, 'Telefon : '.$key['telefon']);
      if ($this->uri->segment(2)=="print_stok_hand") {
        $pdf->Text(146, 33, 'PENYATA STOK SEMASA');
      }else {
        $pdf->Text(138, 33, 'PENYATA KEMASUKAN STOK');
      }
      $pdf->Text(45, 41, 'H/P : '.$key['hp']);
      $pdf->Text(76, 41, ','.$key['hp']);
    }
  }

$pdf->SetFont('helvetica', '', 10);
if ($date_min != null) {
    $pdf->Text(151, 38, date("d/m/Y", strtotime($date_min)) .' - '. date("d/m/Y", strtotime($date_max)));
}elseif ($date_month != null) {
    $pdf->Text(167, 38, 'Bulan '. $date_month .'-'. $date_year);
}
$pdf->Text(146.4, 42, 'Tarikh Dicetak : '.date('d-m-Y'));

$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------

$html = '

<br><br><br><br>
<table border="1" cellpadding="3">
<thead>
    <tr style="background-color:#F4F6F7;color:black;" align="center">
        <td width="100"><b>No.Siri</b></td>
        <td width="155"><b>Produk</b></td>
        <td width="80"><b>Harga Semasa</b></td>
        <td width="80"><b>Kod Jualan</b></td>
        <td width="60"><b>Berat (g)</b></td>
        <td width="60"><b>Mutu</b></td>
        <td width="90"><b>Tarikh</b></td>
    </tr>
</thead>
';
$price = 0;
if ($variants) {
  foreach($variants as $key) {
    $html .= '
    <tr align="center">
    <td width="100">'.$key['v_sn'].'</td>
    <td width="155">'.$key['product_name'].'</td>
    <td width="80">'. number_format($key['v_weight'] * $key['setup_price'], 2, '.', '') .'</td>
    <td width="80">'.$key['v_kod'].'</td>
    <td width="60">'.$key['v_weight'].'</td>
    <td width="60">'.$key['mutu'].'</td>
    <td width="90">'.date("d-m-Y", strtotime($key['insert_date'])).'<br>'.date("h:i a", strtotime($key['insert_date'])).'</td>
    </tr>
    ';

    $price = $price + number_format($key['v_weight'] * $key['setup_price'], 2, '.', '');
  }
}
$html .= '
</table>
<br><br><br>

<tr>
    <td width="100"><h3>Jumlah Barang</h3></td>
    <td width="185"><h3>: '. $count_total_item['total'] .'</h3></td>
    <td colspan="2" align="center">DICETAK OLEH :</td>
    <td colspan="2" align="center">DISEMAK OLEH :</td>
</tr>
<tr>
    <td width="100"><h3>Jumlah Berat</h3></td>
    <td width="185"><h3>: '. $count_weight['total'] .' g</h3></td>
    <td colspan="2"></td>
    
</tr>
<tr>
    <td width="100"><h3>Jumlah Harga</h3></td>
    <td width="185"><h3>: RM '. number_format($price, 2, '.', '') .'</h3></td>
    <td colspan="2" align="center">------------------------------------</td>
    <td colspan="2" align="center">------------------------------------</td>
</tr>
';
$pdf->writeHTML($html, true, false, false, false, '');

// <tr>
//     <td width="100"><h3>Jumlah Harga</h3></td>
//     <td width="185"><h3>: RM '. number_format($count_price['total'], 2, '.', '') .'</h3></td>
//     <td colspan="2" align="center">------------------------------------</td>
//     <td colspan="2" align="center">------------------------------------</td>
// </tr>
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('Penyata Kemasukan Stok.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
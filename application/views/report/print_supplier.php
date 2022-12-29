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
$pdf->SetTitle('Penyata Invoice Supplier');
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
    $pdf->Text(139, 33, 'PENYATA INVOICE SUPPLIER');
    $pdf->Text(45, 44, 'H/P : '.$key['hp']);
    $pdf->Text(76, 44, ','.$key['hp']);
  }else {
    $pdf->Text(45, 29, $key['alamat'].',');
    $pdf->Text(45, 33, $key['poskod'].' '.$key['bandar'] .', '.$key['state']);
    $pdf->Text(45, 37, 'Telefon : '.$key['telefon']);
    $pdf->Text(139, 33, 'PENYATA INVOICE SUPPLIER');
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
$pdf->Text(146.5, 42, 'Tarikh Dicetak : '.date('d-m-Y'));

$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------

$html = '

<br><br><br><br>
<table border="1" cellpadding="3">
<thead>
  <tr style="background-color:#F4F6F7;color:black;" align="center">
    <td width="110"><b>Invoice No.</b></td>
    <td width="180"><b>Supplier</b></td>
    <td width="85"><b>Berat</b></td>
    <td width="85"><b>Total Upah</b></td>
    <td width="85"><b>Total</b></td>
    <td width="95"><b>Tarikh</b></td>
  </tr>
</thead>
';
if ($supplier) {
  foreach($supplier as $key) {
    $html .= '
    <tr align="center">
      <td width="110">'.$key['inv_no'].'</td>
      <td width="180">'.$key['supplier'].'</td>
      <td width="85">'.$key['berat'].'</td>
      <td width="85">'. $key['total_upah'] .'</td>
      <td width="85">'. $key['total'] .'</td>
      <td width="95">'.date("d-m-Y", strtotime($key['tarikh'])).'</td>
    </tr>
    ';
  }
}
$html .= '
</table>
<br><br><br>

<tr>
  <td width="110"><h3>Jumlah Berat ( g ) </h3></td>
  <td width="175"><h3>: '. $berat_inv_supplier['total'] .'</h3></td>
  <td colspan="2" align="center">DISEMAK OLEH :</td>
  <td colspan="2" align="center">DISEMAK OLEH :</td>
</tr>
<tr>
  <td width="110"><h3>Total Upah ( RM ) </h3></td>
  <td width="175"><h3>: '. $upah_inv_supplier['total'] .'</h3></td>
  <td colspan="2"></td>
</tr>
<tr>
  <td width="110"><h3>Total ( RM ) </h3></td>
  <td width="175"><h3>: '. $total_inv_supplier['total'] .'</h3></td>
  <td colspan="2" align="center">------------------------------------</td>
  <td colspan="2" align="center">------------------------------------</td>
</tr>
';
$pdf->writeHTML($html, true, false, false, false, '');

// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('Penyata Invoice Supplier.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
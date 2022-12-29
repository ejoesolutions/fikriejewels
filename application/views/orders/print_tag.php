<?php
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
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
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
// require_once('tcpdf_include.php');

// create new PDF document
// create new PDF document
// $pdf = new TCPDF("P", "mm", array(20,40) , true, 'UTF-8', false);
$pdf = new TCPDF("P", "mm", array(30,70) , true, 'UTF-8', false);

//set margins
$pdf->SetMargins(0, PDF_MARGIN_TOP, 0.7);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

//set auto page breaks
$pdf->SetAutoPageBreak(false, 0);

//set image scale factor
$pdf->setImageScale(1);

//set some language-dependent strings
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// add a page
$pdf->AddPage();

$pdf->SetAutoPageBreak(FALSE, 0);

$style = array(
  // 'vpadding' => '1',
  // 'hpadding' => '1',
  'padding' => 2,
  'fgcolor' => array(0,0,0),
  'bgcolor' => false, //array(255,255,255)
  'module_width' => 1, // width of a single module in points
  'module_height' => 1, // height of a single module in points
);

$pdf->write2DBarcode($variant['v_sn'], 'QRCODE,L', 16.2, 47, 400, 400, $style, 'N');

// new style
// $style = array(
//   'border' => false,
//   'padding' => 2,
//   'fgcolor' => array(128,0,0),
//   'bgcolor' => false
// );

// // QRCODE,H : QR-CODE Best error correction
// $pdf->write2DBarcode('www.tcpdf.org', 'QRCODE,H', 16.2, 47, 400, 400, $style, 'N');
// $pdf->Text(140, 205, 'QRCODE H - NO PADDING');

$pdf->SetFont('helvetica', 'B', '5.4px', '', true);
$pdf->Text(15.5, 61.3, $variant['product_code']);
$pdf->Text(19.7, 63.3, substr($variant['v_sn'], -4));

$pdf->SetFont('helvetica', 'B', 4.6, '', true);
$pdf->Text(16.4, 65.6, $maklumat['sistem']);

// $pdf->Text(1, 32, '----------------------------------------------');

$pdf->SetFont('helvetica', 'B', 5, '', true);

$pdf->Text(1.4, 46, $variant['tag']);

$pdf->SetFont('helvetica', 'B', '6px', '', true);
$pdf->Text(1, 49, 'M:'.$variant['mutu']);
$pdf->Text(1, 51.3, 'B:'.$variant['v_weight'].'g');
$pdf->Text(1, 53.5, 'P:'.$variant['v_length']);
$pdf->Text(1, 55.7, 'L:'.$variant['v_width']);
$pdf->Text(1, 57.9, 'S:'.$variant['v_size']);
$pdf->Text(1, 60.1, 'Up:'.number_format($variant['v_margin_pay'],0,'.','') );
// $pdf->Text(1, 62.3, 'Sb:'.$variant['v_sb']);
$pdf->Text(1, 62.3, 'KJ:'.$variant['v_kod']);

// ---------------------------------------------------------
//Close and output PDF document
$pdf->IncludeJS("print();");
$pdf->Output('test.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

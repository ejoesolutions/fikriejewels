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
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 001');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

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

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

$style = array(
  'vpadding' => 'auto',
  'hpadding' => 'auto',
  'fgcolor' => array(0,0,0),
  'bgcolor' => false, //array(255,255,255)
  'module_width' => 2, // width of a single module in points
  'module_height' => 2, // height of a single module in points
);

$pdf->write2DBarcode('CCBK00000004', 'QRCODE,L', 70, 7, 120, 120, $style, 'N');
$pdf->SetFont('dejavusans', '', 50, '', true);
$pdf->Text(60, 120, 'CCBK00000004');

$pdf->SetFont('dejavusans', '', '47px', '', true);
$pdf->Text(72, 178, 'MyGold KB');

$pdf->SetFont('dejavusans', '', '48px', '', true);
$pdf->Text(28, 198, 'B : 3.39 g');
$pdf->Text(30, 216, 'P : -');
$pdf->Text(30, 232, 'L : -');
$pdf->Text(20, 249, 'Sz : 20');

$pdf->SetFont('dejavusans', '', '48px', '', true);
// $pdf->Text(110, 168, 'B : 3.39 g');
// $pdf->Text(110, 184, 'P : -');
$pdf->Text(112, 198, 'Sb : 1.246');
$pdf->Text(111, 216, 'Up : 200.00');
$pdf->Text(120, 232, 'M : 916');
// $pdf->Text(104, 217, 'Sz : 20');
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.

$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

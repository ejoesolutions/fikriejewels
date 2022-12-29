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
// $pdf = new TCPDF("L", "mm", array(20,40) , true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MyGold');
$pdf->SetTitle('Tag '.$variant['v_sn']);
$pdf->SetSubject('Tag');
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
// helvetica is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// $pdf->SetFont('helvetica', '', 55, '', true);
// $pdf->StartTransform();
// $pdf->Rotate(-90);
// $pdf->Cell(20,0,'This ',1,1,'L',10,'asd');
// $pdf->StopTransform();

$style = array(
  'vpadding' => 'auto',
  'hpadding' => '2',
  'fgcolor' => array(0,0,0),
  'bgcolor' => false, //array(255,255,255)
  'module_width' => 3, // width of a single module in points
  'module_height' => 3, // height of a single module in points
);

$pdf->write2DBarcode($variant['v_sn'], 'QRCODE,L', 25, -20, 200, 200, $style, 'N');

$pdf->SetFont('helvetica', '', 55, '', true);
$pdf->Text(44, 118, $variant['v_sn']);

$pdf->Text(0, 135, '----------------------------------------------------------');

$pdf->SetFont('helvetica', '', '47px', '', true);

foreach ($maklumat as $key) {
  $pdf->Text(55, 178, $key['tag_name']);
}

$pdf->SetFont('helvetica', '', '49px', '', true);
$pdf->Text(10, 198, ' B:'.$variant['v_weight'].'g');
$pdf->Text(10, 218, ' P:'.$variant['v_length']);
$pdf->Text(10, 236, ' L:'.$variant['v_width']);
$pdf->Text(10, 250, ' S:'.$variant['v_size']);

$pdf->SetFont('helvetica', '', '49px', '', true);
$pdf->Text(104, 198, ' M:'.$variant['mutu']);
$pdf->Text(95, 216, ' Up:'.$variant['v_margin_pay']);
$pdf->Text(96, 232, ' Sb:'.$variant['v_sb']);
$pdf->Text(103, 249, ' KJ:'.$variant['v_kod']);
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.

$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

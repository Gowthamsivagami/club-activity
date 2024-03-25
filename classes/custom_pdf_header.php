<?php

//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
class MYPDF extends TCPDF {
    private $settings;
    //Page header
    public function Header() {
        // Logo
        $image_file = PDF_HEADER_LOGO2;
        //Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
        $this->Image($image_file, 10, 5, 20, 20, LOGO_EXT, '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Ln();
        $this->Cell(0, 15, '' , 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 15, COMPANY_NAME , 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', 'B', 15);
        $this->Cell(0, 15, "Generated Payslip" , 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        
        $this->SetAlpha(.2);
        $this->Image(PDF_HEADER_LOGO2, 60, 30, 100, 100, LOGO_EXT, '', 'T', false, 300, '', false, false, 0, false, false, false);
        
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
<?php

require_once('tfpdf.php');
require_once('StoresDbTools.php');

class PDF extends tFPDF {

    function Header()
    {
        $this->Image('img/logo.jpg',10,6,30);
        $this->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
        $this->SetFont('DejaVu','',25);
        // Move to the right
        $this->Cell(70);
        // Title
        $this->Cell(30,10,'Raktár',0,0,'C');
        // Line break
        $this->Ln(40);
    }

    function Table($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(0,65,171);
        $this->SetTextColor(255);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('DejaVu','',12);
        // Header
        $w = array(30, 30, 30, 45, 30);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        foreach($data as $row)
        {
            $this->Cell($w[0],6,$row['name'],'LR',0,'C',$fill);
            $this->Cell($w[1],6,$row['shelves'],'LR',0,'C',$fill);
            $this->Cell($w[2],6,$row['shelf_lines'],'LR',0,'C',$fill);
            $this->Cell($w[3],6,$row['products_name'],'LR',0,'C',$fill);
            $this->Cell($w[4],6,number_format($row['quantity']),'LR',0,'C',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w),0,'','T');
    }

}

$pdf = new PDF();
$storesDbTools = new StoresDbTools();

$data = $storesDbTools->getAll();
$header = array('Raktár', 'Polc', 'Sor', 'Áru', 'Mennyiség');

$pdf->SetLeftMargin(23);
$pdf->AddPage();
$pdf->SetFont('DejaVu','',12);
$pdf->Table($header, $data);
$pdf->Output('F', 'PDF/raktar.pdf');

?>
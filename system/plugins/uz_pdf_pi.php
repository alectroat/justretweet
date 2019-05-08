<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    require('fpdf153/fpdf.php');


class PDF extends FPDF
{
//Load data
function LoadData()
{
    $data=array(
      array("cell","cell","cell","cell"),
      array("cell","cell","cell","cell"),
      array("cell","cell","cell","cell"),
      array("cell","cell","cell","cell")
    );
    return $data;
}

//Simple table
function BasicTable($header,$data)
{
    //Header
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    //Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

//Better table
function ImprovedTable($header,$data)
{
    //Column widths
    $w=array(40,35,40,45);
    //Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    //Data
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    //Closure line
    $this->Cell(array_sum($w),0,'','T');
}

//Colored table
function FancyTable($header,$data)
{
    //Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.2);
    $this->SetFont('','B');
    //Header
    $w=array(5,35,35,30,30,45,30,40,50,30);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
    //Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Data
    $fill=0;
    $serial=0;
    foreach($data as $row)
    {
        $serial++;
        $this->Cell($w[0],6,$serial,'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row['last_name'],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$row['first_name'],'LR',0,'R',$fill);
        $this->Cell($w[3],6,$row['phone1'],'LR',0,'R',$fill);
        $this->Cell($w[4],6,$row['phone2'],'LR',0,'R',$fill);
        $this->Cell($w[5],6,$row['email'],'LR',0,'R',$fill);
        $this->Cell($w[6],6,$row['date'],'LR',0,'R',$fill);
        $this->Cell($w[7],6,$row['name'],'LR',0,'R',$fill);        
        $this->Cell($w[8],6,$row['comment'],'LR',0,'R',$fill);
        $this->Cell($w[9],6,$row['other_programs'],'LR',0,'R',$fill);

//        $this->Cell($w[0],6,$serial,'LR',0,'L',$fill);
//        $this->Cell($w[1],6,$row['last_name'],'LR',0,'L',$fill);
//        $this->Cell($w[2],6,$row['first_name'],'LR',0,'R',$fill);
//        $this->Cell($w[3],6,$row['phone1'],'LR',0,'R',$fill);
//        $this->Cell($w[4],6,$row['phone2'],'LR',0,'R',$fill);
//        $this->Cell($w[5],6,$row['email'],'LR',0,'R',$fill);
//        $this->Cell($w[6],6,$row['date'],'LR',0,'R',$fill);
//        $this->Cell($w[7],6,$row['name'],'LR',0,'R',$fill);
//        $this->Cell($w[8],6,$row['comment'],'LR',0,'R',$fill);
//        $this->Cell($w[9],6,$row['other_programs'],'LR',0,'R',$fill);
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell(array_sum($w),0,'','T');
}
}
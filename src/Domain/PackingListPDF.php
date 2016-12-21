<?php

namespace PackingSheets\Domain;

class PackingListPDF extends \FPDF
{

	private $pl;
	private $logo;
	private $ref;

	// En-tête
	function Header()
	{
		$this->SetFont('Arial','B',14);
		$this->Cell(190, 5,'PACKING LIST','',0,'C',0);
		$this->Ln();
		$this->SetFont('Arial','',9);
		$this->Cell(190, 7,'PS '.$this->ref,'B',0,'C',0);
		$this->Ln();
		$this->Cell(190,5,'','B',0,'C',0);
		$this->Ln();
	}

	// Pied de page
	function Footer()
	{		
		$this->Cell(190, 20, 'Page '.$this->PageNo()." - ".'Printed on : '.date('Y-m-d'), '', 0, 'R', 0);
	}

	function Parts(){
		
		$cptParts = 1;
		$this->SetFillColor(205, 208, 209);
		
		foreach($this->pl->getParts() as $part){
			
			$this->SetFont('Arial','B',8);
			$this->Cell(190, 5, 'PART '.$cptParts,'TBLR',0,'L', 1);
			$this->Ln();
			$this->Cell(15);
			$this->Cell(25,5,'QUANTITY','LRTB',0,'C',1);
			$this->Cell(40,5,'PART NUMBER','LRTB',0,'C',1);
			$this->Cell(40,5,'PART SERIAL NUMBER','LRTB',0,'C',1);
			$this->Cell(40,5,'NOMENCLATURE','LRTB',0,'C',1);
			$this->Cell(30,5,'PRICE','LRTB',0,'C',1);
			
			$this->Ln();
			$cptParts++;
			$this->SetFont('Arial','',8);
			
			$this->Cell(15);
			$this->Cell(25,5,$part->getQuantity(),'LRTB',0,'C',0);
			$this->Cell(40,5,$part->getPartid()->getPn(),'LRTB',0,'C',0);
			$this->Cell(40,5,$part->getPartid()->getSerial(),'LRTB',0,'C',0);
			$this->Cell(40,5,($part->getPartid()->getHSCode() === null) ? "" : $part->getPartid()->getHSCode(),'LRTB',0,'C',0);
			$this->Cell(30,5,$part->getPartid()->getPrice(),'LRTB',0,'C',0);
			
			$this->Ln();
			$this->Ln();
		}

	}

	function build(){
		
		//Parts
		$this->Parts();
	}

	function setPl($pl){
		$this->pl = $pl;
	}

	function setLogo($logo){
		$this->logo = $_SERVER['DOCUMENT_ROOT'].'/img/'.$logo;
	}
	
	function setref($ref){
		$this->ref = $ref;
	}
}

